<?php

namespace App\Updates;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrationVer2306140 implements UpdaterInterface
{
    const VERSION = 23061401;

    public function getVersion()
    {
        return self::VERSION;
    }

    public function handle()
    {
        $this->addNewSettings();
    }

    private function addNewSettings()
    {
        if (hss('tnx_list_show') == null) {
            upss('tnx_list_show', 'no');
        }

        if (hss('tnx_list_heading') == null) {
            upss('tnx_list_heading', 'Latest Transactions');
        }

        if (hss('tnx_list_text') == null) {
            upss('tnx_list_text', 'Here is latest transaction that our investor deposits and withdrawals.');
        }

        if (hss('tnx_deposit_title') == null) {
            upss('tnx_deposit_title', 'Deposit');
        }

        if (hss('tnx_withdraw_title') == null) {
            upss('tnx_withdraw_title', 'Withdraw');
        }

        if (hss('tnx_list_show_dp') == null) {
            upss('tnx_list_show_dp', 'yes');
        }

        if (hss('tnx_list_show_wd') == null) {
            upss('tnx_list_show_wd', 'yes');
        }

        if (hss('tnx_deposit_items') == null) {
            upss('tnx_deposit_items', '5');
        }

        if (hss('tnx_withdraw_items') == null) {
            upss('tnx_withdraw_items', '5');
        }
    }
}
