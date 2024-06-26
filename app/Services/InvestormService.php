<?php

namespace App\Services;

use App\Models\IvInvest;
use App\Enums\InterestPeriod;
use App\Enums\SchemeTermTypes;
use App\Enums\InvestmentStatus;
use App\Enums\SchemePayout;
use App\Services\Investment\IvSubscription;
use App\Services\Investment\IvPayoutProcess;
use App\Services\Investment\IvProfitCalculator;
use App\Services\Investment\IvInvestmentProcessor;

class InvestormService extends Service
{
    const MIN_APP_VER = '1.1.0';
    const SLUG = 'investment';
    const TERM_CONVERSION = [
            SchemeTermTypes::YEARS => [
                InterestPeriod::YEARLY => 1,
                InterestPeriod::MONTHLY => 12,
                InterestPeriod::WEEKLY => 52,
                InterestPeriod::DAILY => 365,
                InterestPeriod::HOURLY => 8760,
            ],
            SchemeTermTypes::MONTHS => [
                InterestPeriod::MONTHLY => 1,
                InterestPeriod::WEEKLY => 4,
                InterestPeriod::DAILY => 30,
                InterestPeriod::HOURLY => 720,
            ],
            SchemeTermTypes::WEEKS => [
                InterestPeriod::WEEKLY => 1,
                InterestPeriod::DAILY => 7,
                InterestPeriod::HOURLY => 168,
            ],
            SchemeTermTypes::DAYS => [
                InterestPeriod::DAILY => 1,
                InterestPeriod::HOURLY => 24,
            ],
            SchemeTermTypes::HOURS => [
                InterestPeriod::HOURLY => 1,
            ]
        ];

    const INTERVALS = [
        InterestPeriod::HOURLY => 1,
        InterestPeriod::DAILY => 24,
        InterestPeriod::WEEKLY => 168,
        InterestPeriod::MONTHLY => 720,
        InterestPeriod::YEARLY => 8760,
    ];

    private $ivProcessor;

    public function __construct()
    {
        $this->ivProcessor = new IvInvestmentProcessor();
    }

    public function updateInvestByScheme($scheme){
        $investments = IvInvest::Where('scheme_id', $scheme->id);
        foreach($investments in $invest){
            $invest->rate = $scheme->rate.'('.ucfirst($scheme->rate_type).')';
            $invest->scheme = $scheme->array();
            $invest->save();
        }
    }

    public function processSubscriptionDetails($input, $ivScheme, $investAmount): array
    {
        $investmentProcessor = new IvSubscription();
        return $investmentProcessor->setScheme($ivScheme)
            ->setUser(auth()->user())
            ->setInvestAmount($investAmount)
            ->setSource($input['source'])
            ->setCurrency($input['currency'])
            ->generateNewInvestmentDetails();
    }

    public function confirmSubscription($details): IvInvest
    {
        return $this->ivProcessor->setDetails($details)->processInvestment();
    }

    public function approveSubscription(IvInvest $invest, $remarks = null, $note = null)
    {
        return $this->ivProcessor->approveInvestment($invest, $remarks, $note);
    }

    public function processInvestmentProfit(IvInvest $invest)
    {
        if ($invest->status == InvestmentStatus::ACTIVE) {
            dd($invest->type)
            if($invest->type != 'variable'){
                $transactionProcessor = new IvProfitCalculator();
                $transactionProcessor->setInvest($invest)
                    ->calculateProfit();    
            }
        }
    }

    public function cancelSubscription(IvInvest $invest)
    {
        return $this->ivProcessor->cancelInvestment($invest);
    }

    public function cancelVariableInvestment(IvInvest $invest){

        return $this->ivProcessor->cancelRunningInvest($invest);
    }
  
    public function proceedPayout($user_id, $profits, $entry = null)
    {
        $payoutProcess = new IvPayoutProcess();
        $payoutProcess->setUser($user_id)
            ->setPayout($profits)
            ->payProfits($entry);
    }

    public function processCompleteInvestment(IvInvest $invest, $manual = false)
    {
        if ($manual || $this->hasValidPayout($invest)) {
            $payoutProcess = new IvPayoutProcess();
            $payoutProcess->setUser($invest->user_id)->completeInvest($invest);
        }
    }

    public function payoutFilter(IvInvest $invest)
    {
        if ($this->hasValidPayout($invest)) {
            $payout = data_get($invest, 'scheme.payout');

            if ($payout === SchemePayout::TERM_BASIS || ($payout === SchemePayout::AFTER_MATURED && $invest->remaining_term === 0)) {
                return $invest;
            }
        }
    }

    public function hasValidPayout(IvInvest $invest)
    {
        if (is_null(data_get($invest, 'scheme.type'))) {
            return true;
        }

        if (module_exist('ExtInvest', 'addon')) {
            return app('extinvest')->validatePayout($invest);
        }

        return false;
    }
}
