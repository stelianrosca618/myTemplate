@extends('admin.layouts.master')
@section('title', (__('Components'). ' / '. __("Fund Transfer")))

@section('has-content-sidebar', 'has-content-sidebar')

@section('content-sidebar')
    @include('admin.settings.content-sidebar')
@endsection

@section('content')
    <div class="nk-content-body">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">{{ __('Components') }} / {{ __("Fund Transfer") }}</h3>
                    <p>{{ __('Manage your Internal Fund Transfer settings.') }}</p>
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
        <div class="nk-block card card-bordered">
            <div class="card-inner">
                @if(is_demo())
                    <div class="alert alert-danger alert-dim mb-4">
                        {!! 'All the additional <span class="badge badge-pill badge-dark">Module</span> and <span class="badge badge-pill badge-danger">Add-ons</span> are NOT part of main product. Please feel free to <strong><a class="alert-link" href="'. the_link('softn' . 'io' .'.com' .'/'. 'contact'). '" target="_blank">contact us</a></strong> for more information or to get those.' !!}
                    </div>
                @endif
                <form action="{{ route('admin.settings.component.fund-transfer.update') }}" class="form-settings" method="POST">
                    <h5 class="title">
                        {{ __('Internal Fund Transfer / P2P') }}
                        <span class="meta ml-1">
                            <span class="badge badge-pill badge-xs badge-gray nk-tooltip"{!! (is_demo()) ? ' title="This module is NOT part of the main package."' : '' !!}>{{ __("Module") }}</span>
                        </span>
                        @if ($outdated)
                        <span class="meta ml-1">
                            <span class="badge badge-pill badge-dim badge-xs badge-danger tipinfo" title="v{{ $outdated }} Version Required">{{ __('Outdated') }}</span>
                        </span>
                        @endif
                    </h5>
                    <p>{{ __("Allow your users to send/transfer their funds to their friends internally.") }}
                    <div class="form-sets gy-3 wide-md">
                        <div class="row g-3 align-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label" for="allow-send-funds">{{ __('Allow Internal Transfer') }}</label>
                                    <span class="form-note">{{ __('Enable internal transfer feature for your user.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input{{ ($outdated) ? ' disabled' : '' }} class="switch-option-value" type="hidden" name="feature_enable" value="{{ sys_settings('transfer_feature_enable') ?? 'no' }}">
                                        <input{{ ($outdated) ? ' disabled' : '' }} id="allow-send-funds" type="checkbox" class="custom-control-input switch-option" 
                                            data-switch="yes"{{ (sys_settings('transfer_feature_enable', 'no') == 'yes') ? ' checked=""' : ''}}>
                                        <label for="allow-send-funds" class="custom-control-label">{{ __('Enable') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 align-start">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Minimum Transfer Amount') }}</label>
                                    <span class="form-note">{{ __('The minimum amount to transfer per transaction.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <div class="form-text-hint"><span>{{ base_currency() }}</span></div>
                                        <input type="number" class="form-control" name="minimum_amount" value="{{ sys_settings('transfer_minimum_amount', '0') }}" min="0">
                                    </div>
                                    <div class="form-note">{{ __("'0' consider as 0.01.") }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 align-start">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Maximum Transfer Amount') }}</label>
                                    <span class="form-note">{{ __('The maximum amount to transfer per transaction.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <div class="form-text-hint"><span>{{ base_currency() }}</span></div>
                                        <input type="number" class="form-control" name="maximum_amount" value="{{ sys_settings('transfer_maximum_amount', '0') }}" min="0">
                                    </div>
                                    <div class="form-note">{{ __("'0' consider as unlimited.") }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 align-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label" for="auto-approve">{{ __('Transfer Auto Approve') }}</label>
                                    <span class="form-note">{{ __('Enable auto approve feature for transfer transactions.') }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input{{ ($outdated) ? ' disabled' : '' }} class="switch-option-value" type="hidden" name="auto_approve" value="{{ sys_settings('transfer_auto_approve') ?? 'no' }}">
                                        <input{{ ($outdated) ? ' disabled' : '' }} id="auto-approve" type="checkbox" class="custom-control-input switch-option" 
                                            data-switch="yes"{{ (sys_settings('transfer_auto_approve', 'no') == 'yes') ? ' checked=""' : ''}}>
                                        <label for="auto-approve" class="custom-control-label">{{ __('Enable') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 align-start">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label">{{ __("Disable New Transfer Request") }}</label>
                                    <span class="form-note">{{ __("Temporarily disable transfer feature.") }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input class="switch-option-value" type="hidden" name="disable_request" value="{{ sys_settings('transfer_disable_request') ?? 'no' }}">
                                        <input id="transfer-disable" type="checkbox" class="custom-control-input switch-option" data-switch="yes"{{ (sys_settings('transfer_disable_request', 'no') == 'yes') ? ' checked=""' : ''}}>
                                        <label for="transfer-disable" class="custom-control-label">{{ __("Disable") }}</label>
                                    </div>
                                    <span class="form-note mt-1"><em class="text-danger">{{ __("Users unable to request for new transfer.") }}</em></span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 align-start">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label">{{ __("Display Notice to User") }}</label>
                                    <span class="form-note">{{ __("Add custom message to show on user-end.") }}</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="disable_title" value="{{ sys_settings('transfer_disable_title', 'Temporarily unavailable!') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <textarea class="form-control textarea-sm" name="disable_notice">{{ sys_settings('transfer_disable_notice') }}</textarea>
                                    </div>
                                    <div class="form-note">
                                        <span>{{ __("This message will display when user going to send their funds.") }}</span>
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
    </div>
@endsection
