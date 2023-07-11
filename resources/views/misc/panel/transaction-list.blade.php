@php

use \App\Enums\TransactionCalcType;
use \App\Enums\TransactionStatus;

$base_currency = base_currency();

@endphp

<div class="nk-odr-item">
    <div class="nk-odr-col">
        <div class="nk-odr-info">
            @if(in_array('icon', sys_settings('tnx_list_opts', [])))
            <div class="nk-odr-badge">
                {!! tnx_type_icon($transaction, 'odr-icon') !!}
            </div>
            @endif
            <div class="nk-odr-data">
                <div class="nk-odr-label">
                    <strong class="ellipsis">
                        {{in_array('compact', sys_settings('tnx_list_opts', [])) ? (str_compact($transaction->customer->username)) : $transaction->customer->username }}
                    </strong>
                </div>
                <div class="nk-odr-meta date">
                    {{ ($transaction->status == TransactionStatus::COMPLETED) ? show_date($transaction->completed_at, true) : show_date($transaction->created_at, true) }}
                </div>
            </div>
        </div>
    </div>
    <div class="nk-odr-col nk-odr-col-amount">
        <div class="nk-odr-amount">
            <div class="number-md text-primary">
                {{ ($transaction->calc == TransactionCalcType::CREDIT) ? amount_z($transaction->tnx_amount, $transaction->tnx_currency, ['dp' => 'calc']) : amount_z($transaction->tnx_total, $transaction->tnx_currency, ['dp' => 'calc']) }} <span class="currency">{{ $transaction->tnx_currency }}
                </span>
            </div>
            @if(in_array('currency', sys_settings('tnx_list_opts', [])))
            <div class="number-sm"> {{ ($transaction->calc == TransactionCalcType::CREDIT) ? amount_z($transaction->amount, $base_currency, ['dp' => 'calc']): amount_z($transaction->total, $base_currency, ['dp' => 'calc']) }}
                <span class="currency">{{ $base_currency }}</span>
            </div>
            @endif
        </div>
    </div>
</div>