@php
    use NioAddons\NioCron\Enums\ScheduleDelay;
    use NioAddons\NioCron\Enums\TransactionTimeout;

    $delayItems = config('modules.'.\NioAddons\NioCron\NioCron::SLUG.'.delays');
    $timeoutItems = config('modules.'.\NioAddons\NioCron\NioCron::SLUG.'.transactionTimeout');
    $refDelayItems = config('modules.'.\NioAddons\NioCron\NioCron::SLUG.'.referralDelays');
    $refApproveTimeItems = config('modules.'.\NioAddons\NioCron\NioCron::SLUG.'.referralApproveTime');

@endphp

@extends('admin.layouts.modules')
@section('title', __('Components') . ' / ' . __('NioCron'))

@section('content')
    <div class="nk-content-body">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">{{ __('Components') }} / {{ __("NioCron") }}</h3>
                    <p>{{ __('Manage cron jobs feature to automation on investment and profit calculation.') }}</p>
                </div>
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools gx-1">
                        <li class="d-lg-none">
                            <a href="#" class="btn btn-icon btn-trigger toggle" data-target="pageSidebar"><em class="icon ni ni-menu-right"></em></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @if(!$compatibility)
        <div class="nk-block card card-bordered">
            <div class="card-inner">
                <div class="alert alert-danger bg-white py-2 px-3">
                    <div class="alert-cta flex-wrap flex-md-nowrap g-2">
                        <div class="alert-text has-icon">
                            <em class="icon ni ni-swap-alt"></em>
                            <p><strong>{{ __("Important") }}:</strong> {{ __("Please upgrade your main application to latest version and try out.") }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="nk-block card card-bordered">
            <div class="card-inner">
                @if(is_demo())
                    <div class="alert alert-danger alert-dim mb-4">
                        {!! 'All the additional <span class="badge badge-pill badge-dark">Module</span> and <span class="badge badge-pill badge-danger">Add-ons</span> are NOT part of main product. Please feel free to <strong><a class="alert-link" href="'. the_link('softn' . 'io' .'.com' .'/'. 'contact'). '" target="_blank">contact us</a></strong> for more information or to get those.' !!}
                    </div>
                @endif

                <h5 class="title">
                    {{ __("Manage Cron Job") }} / {{ __("NioCron") }}
                    <span class="badge badge-pill badge-xs badge-danger ml-1 nk-tooltip"{!! (is_demo()) ? ' title="This addon is NOT part of the main package."' : '' !!}>{{ 'Addon' }}</span>
                    @if ($outdated)
                    <span class="meta ml-1">
                        <span class="badge badge-pill badge-dim badge-xs badge-danger tipinfo" title="v{{ $outdated }} Version Required">{{ __('Outdated') }}</span>
                    </span>
                    @endif
                </h5>
                <p>{{ __("Setup cron jobs for automating repetitive below tasks.") }}</p>

                <form class="form-settings" action="{{ route('admin.settings.component.cron.nio-cron.save') }}" method="POST">
                    <div class="form-sets gy-3 wide-md">
                        <div class="row g-3 align-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label" for="cron-feature-enable">{{ __('Enable Cron Job') }}</label>
                                    <span class="form-note">{{ __('Enable or disable the cron job processing service.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input class="switch-option-value" type="hidden" name="feature_enabled" value="{{ gss('cron_feature_enabled') ?? 'no' }}">
                                        <input id="cron-feature-enable" type="checkbox" class="custom-control-input switch-option"
                                               data-switch="yes"{{ (gss('cron_feature_enabled', 'no') == 'yes') ? ' checked=""' : ''}}>
                                        <label for="cron-feature-enable" class="custom-control-label">{{ __('Enable') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 align-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label" for="save-log">{{ __('Save Logs on Cron Run') }}</label>
                                    <span class="form-note">{{ __('Save the logs into application log file for debuging.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input class="switch-option-value" type="hidden" name="save_log" value="{{ gss('cron_save_log') ?? 'no' }}">
                                        <input id="save-log" type="checkbox" class="custom-control-input switch-option"
                                               data-switch="yes"{{ (gss('cron_save_log', 'no') == 'yes') ? ' checked=""' : ''}}>
                                        <label for="save-log" class="custom-control-label">{{ __('Enable') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-sets gy-3 wide-md">
                        <div class="row g-3 align-center">
                            <div class="col-md-12">
                                <div class="form-note mt-2 pl-2 border-left border-primary">
                                    <p><strong>{{ __('Caution:') }}</strong>
                                        <br>{!! __("Please add below cron configuration into your server, so server can runs this schedule command every minute.") !!}
                                        <br><code>* * * * * cd /path-to-your-project/core_invapp && php artisan schedule:run >> /dev/null 2>&1</code>
                                        <br>{!! __("You must change the <code>'path-to-your-project'</code> accordingly your server project path.") !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <div class="form-sets gy-3 wide-md">
                        <div class="row g-3 align-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label" for="sync-invested-plans">{{ __('Sync Invested Plans') }}</label>
                                    <span class="form-note">{{ __('Enable cron for the invested plan synchronization.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row gx-2">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-control-wrap w-max-250px">
                                                <select name="sync_invested_plans_delay" class="form-select">
                                                    @foreach ($delayItems as $key => $item)
                                                        <option value="{{ $key }}"{{ (gss('cron_sync_invested_plans_delay', ScheduleDelay::EVERY_HOUR) == $key) ? ' selected' : '' }}>{{ __($item) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-control-labeled">
                                                <input class="switch-option-value" type="hidden" name="sync_invested_plans" value="{{ gss('cron_sync_invested_plans') ?? 'no' }}">
                                                <input id="sync-invested-plans" type="checkbox" class="custom-control-input switch-option"
                                                       data-switch="yes"{{ (gss('cron_sync_invested_plans', 'no') == 'yes') ? ' checked=""' : ''}}>
                                                <label for="sync-invested-plans" class="custom-control-label">{{ __('Enable') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="form-sets gy-3 wide-md">
                        <div class="row g-3 align-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label" for="cron-profit-approval">{{ __('Approve the Profit') }}</label>
                                    <span class="form-note">{{ __('Enable cron for automatically paid the profits.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row gx-2">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-control-wrap w-max-250px">
                                                <select name="profit_approval_delay" class="form-select">
                                                    @foreach ($delayItems as $key => $item)
                                                        <option value="{{ $key }}"{{ (gss('cron_profit_approval_delay', ScheduleDelay::EVERY_HOUR) == $key) ? ' selected' : '' }}>{{ __($item) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-control-labeled">
                                                <input class="switch-option-value" type="hidden" name="profit_approval" value="{{ gss('cron_profit_approval') ?? 'no' }}">
                                                <input id="cron-profit-approval" type="checkbox" class="custom-control-input switch-option"
                                                       data-switch="yes"{{ (gss('cron_profit_approval', 'no') == 'yes') ? ' checked=""' : ''}}>
                                                <label for="cron-profit-approval" class="custom-control-label">{{ __('Enable') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="form-sets gy-3 wide-md">
                        <div class="row g-3 align-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label" for="cron-transfer-auto">{{ __('Complete Auto Transfers') }}</label>
                                    <span class="form-note">{{ __('Enable cron for completing auto balance transfer.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row gx-2">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-control-wrap w-max-250px">
                                                <select name="transfer_auto_delay" class="form-select">
                                                    @foreach ($delayItems as $key => $item)
                                                        <option value="{{ $key }}"{{ (gss('cron_transfer_auto_delay', ScheduleDelay::EVERY_THIRTY_MINUTE) == $key) ? ' selected' : '' }}>{{ __($item) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-control-labeled">
                                                <input class="switch-option-value" type="hidden" name="transfer_auto" value="{{ gss('cron_transfer_auto') ?? 'no' }}">
                                                <input id="cron-transfer-auto" type="checkbox" class="custom-control-input switch-option"
                                                       data-switch="yes"{{ (gss('cron_transfer_auto', 'no') == 'yes') ? ' checked=""' : ''}}>
                                                <label for="cron-transfer-auto" class="custom-control-label">{{ __('Enable') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="form-sets gy-3 wide-md">
                        <div class="row g-3 align-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label" for="cron-deposit-online-cancel">{{ __('Cancel Online Deposit Transactions') }}</label>
                                    <span class="form-note">{{ __('Enable cron for cancelling online deposit transactions.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row gx-2">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-control-wrap w-max-250px">
                                                <select name="deposit_cancel_online_timeout" class="form-select">
                                                    @foreach ($timeoutItems as $key => $item)
                                                        <option value="{{ $key }}"{{ (gss('cron_deposit_cancel_online_timeout', TransactionTimeout::AFTER_THREE_DAYS) == $key) ? ' selected' : '' }}>{{ __($item) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-control-labeled">
                                                <input class="switch-option-value" type="hidden" name="deposit_cancel_online" value="{{ gss('cron_deposit_cancel_online') ?? 'no' }}">
                                                <input id="cron-deposit-online-cancel" type="checkbox" class="custom-control-input switch-option" data-switch="yes"{{ (gss('cron_deposit_cancel_online', 'no') == 'yes') ? ' checked=""' : ''}}>
                                                <label for="cron-deposit-online-cancel" class="custom-control-label">{{ __('Enable') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="form-sets gy-3 wide-md">
                        <div class="row g-3 align-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label" for="cron-deposit-offline-cancel">{{ __('Cancel Offline Deposit Transactions') }}</label>
                                    <span class="form-note">{{ __('Enable cron for cancelling offline deposit transactions.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row gx-2">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-control-wrap w-max-250px">
                                                <select name="deposit_cancel_offline_timeout" class="form-select">
                                                    @foreach ($timeoutItems as $key => $item)
                                                        <option value="{{ $key }}"{{ (gss('cron_deposit_cancel_offline_timeout', TransactionTimeout::AFTER_SEVEN_DAYS) == $key) ? ' selected' : '' }}>{{ __($item) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-control-labeled">
                                                <input class="switch-option-value" type="hidden" name="deposit_cancel_offline" value="{{ gss('cron_deposit_cancel_offline') ?? 'no' }}">
                                                <input id="cron-deposit-offline-cancel" type="checkbox" class="custom-control-input switch-option"
                                                       data-switch="yes"{{ (gss('cron_deposit_cancel_offline', 'no') == 'yes') ? ' checked=""' : ''}}>
                                                <label for="cron-deposit-offline-cancel" class="custom-control-label">{{ __('Enable') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="form-sets gy-3 wide-md">
                        <div class="row g-3 align-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label" for="cron-referral-approval">{{ __('Approve Referral Transactions') }}</label>
                                    <span class="form-note">{{ __('Enable cron for automatically approve referral transactions.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row gx-2">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-control-wrap w-max-250px">
                                                <select name="referral_approval_delay" class="form-select">
                                                    @foreach ($refDelayItems as $key => $item)
                                                        <option value="{{ $key }}"{{ (gss('cron_referral_approval_delay', ScheduleDelay::EVERY_HOUR) == $key) ? ' selected' : '' }}>{{ __($item) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch custom-control-labeled">
                                                <input class="switch-option-value" type="hidden" name="referral_approval" value="{{ gss('cron_referral_approval') ?? 'no' }}">
                                                <input id="cron-referral-approval" type="checkbox" class="custom-control-input switch-option"
                                                       data-switch="yes"{{ (gss('cron_referral_approval', 'no') == 'yes') ? ' checked=""' : ''}}>
                                                <label for="cron-referral-approval" class="custom-control-label">{{ __('Enable') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-sets gy-3 wide-md">
                        <div class="row g-3 align-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Approve Signup Referral Bonuses') }}</label>
                                    <span class="form-note">{{ __('Set time for approving signup referral bonuses.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row gx-2">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-control-wrap w-max-250px">
                                                <select name="referral_signup_approval_time" class="form-select">
                                                    @foreach ($refApproveTimeItems as $key => $item)
                                                        <option value="{{ $key }}"{{ (gss('cron_referral_signup_approval_time', TransactionTimeout::AFTER_FIVE_DAYS) == $key) ? ' selected' : '' }}>{{ __($item) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-note">{{ __('Approval time delay') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-control-wrap w-max-120px">
                                                <input type="number" placeholder="2" class="form-control" name="referral_signup_approval_max" value="{{ gss('cron_referral_signup_approval_max', '') }}" min="2">
                                            </div>
                                            <div class="form-note">{{ __('Number') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-sets gy-3 wide-md">
                        <div class="row g-3 align-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Approve Deposit Referral Bonuses') }}</label>
                                    <span class="form-note">{{ __('Set time for approving deposit referral bonuses.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row gx-2">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-control-wrap w-max-250px">
                                                <select name="referral_deposit_approval_time" class="form-select">
                                                    @foreach ($refApproveTimeItems as $key => $item)
                                                        <option value="{{ $key }}"{{ (gss('cron_referral_deposit_approval_time', TransactionTimeout::AFTER_FIFTEEN_DAYS) == $key) ? ' selected' : '' }}>{{ __($item) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-note">{{ __('Approval time delay') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-control-wrap w-max-120px">
                                                <input type="number" placeholder="2" class="form-control" name="referral_deposit_approval_max" value="{{ gss('cron_referral_deposit_approval_max', '') }}" min="2">
                                            </div>
                                            <div class="form-note">{{ __('Number') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-sets gy-3 wide-md">
                        <div class="row g-3 align-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Approve Investment Referral Bonuses') }}</label>
                                    <span class="form-note">{{ __('Set time for approving investment referral bonuses.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="row gx-2">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-control-wrap w-max-250px">
                                                <select name="referral_investment_approval_time" class="form-select">
                                                    @foreach ($refApproveTimeItems as $key => $item)
                                                        <option value="{{ $key }}"{{ (gss('cron_referral_investment_approval_time', TransactionTimeout::AFTER_FIFTEEN_DAYS) == $key) ? ' selected' : '' }}>{{ __($item) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-note">{{ __('Approval time delay') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-control-wrap w-max-120px">
                                                <input type="number" placeholder="2" class="form-control" name="referral_investment_approval_max" value="{{ gss('cron_referral_investment_approval_max', '') }}" min="2">
                                            </div>
                                            <div class="form-note">{{ __('Number') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-sets gy-3 wide-md">
                        <div class="row g-3">
                            <div class="col-md-7 offset-lg-5">
                                <div class="form-group mt-2">
                                    @csrf
                                    <input type="hidden" name="form_type" value="cron-settings">
                                    <input type="hidden" name="form_prefix" value="cron">
                                    <button type="button" class="btn btn-primary submit-settings" disabled="">
                                        <span class="spinner-border spinner-border-sm hide" role="status" aria-hidden="true"></span>
                                        <span>{{ __('Update') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
@endsection
