<?php


namespace App\Http\Controllers\User;

use App\Enums\TransactionType;
use App\Enums\TransactionStatus;
use App\Enums\PaymentMethodStatus;
use App\Enums\InvestmentStatus;

use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Models\IvInvest;
use App\Services\InvestormService;

use App\Http\Controllers\Controller;

class UserDashboardController extends Controller
{
    private $investment;

    public function __construct(InvestormService $investment)
    {
        $this->investment = $investment;
    }


    public function index()
    {


        $investments = IvInvest::where('user_id', auth()->user()->id)->where('status', InvestmentStatus::ACTIVE)->get();
        foreach ($investments as $invest) {
            //$this->profitCalculate($invest);
            if (in_array($invest->status, [InvestmentStatus::ACTIVE, InvestmentStatus::COMPLETED])) {
                $this->wrapInTransaction(function ($invest) {
                    $this->investment->processInvestmentProfit($invest);
                }, $invest);
            }
            
        }

        $paymentMethods = PaymentMethod::where('status', PaymentMethodStatus::ACTIVE)
            ->get()->keyBy('slug')->toArray();

        $recentTransactions = Transaction::with(['ledger'])
            ->whereIn('status', [TransactionStatus::ONHOLD, TransactionStatus::CONFIRMED, TransactionStatus::COMPLETED])
            ->whereNotIn('type', [TransactionType::REFERRAL])
            ->where('user_id', auth()->user()->id)
            ->orderBy('id', 'desc')
            ->limit(5)->get();

        return view('user.dashboard', compact('paymentMethods', 'recentTransactions'));
    }
}
