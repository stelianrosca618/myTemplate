@extends('user.layouts.master')

@section('title', __('Investment Plans'))

@php

$currency = base_currency();
$leadText = gss('iv_plan_pg_text', "Here is our several investment plans. You can invest daily, weekly or monthly and get higher returns in your investment.");
$leadTitle = gss('iv_plan_pg_title', "Choose your favourite plan and start earning now.");

@endphp

@section('content')
<div class="nk-content-body">
    <div class="nk-block-head text-center">
            <h2 class="nk-block-title fw-normal">{{ (gss('iv_plan_pg_heading')) ? __(gss('iv_plan_pg_heading')) : __('Investment Plans') }}</h2>
            @if ($leadText || $leadTitle)
            <div class="nk-block-des w-max-550px m-auto">
                @if ($leadText)
                <p class="lead">{{ __($leadText) }}</p>
                @endif
                @if ($leadTitle)
                <p><strong>{{ __($leadTitle) }}</strong></p>
                @endif
            </div>
            @endif
    </div>
    <div class="nk-ivp-apps">
        <div class="nk-ivp-plans row g-gs scheme-container justify-center">
            @foreach($plans as $ivp)
           
            <div class="col-md-6 col-lg-4">
                <div class="nk-ivp-card card card-bordered card-full">
                    <div class="card-inner-group">
                        <div class="card-inner">
                            <div class="nk-ivp-title card-title">
                                <h4 class="title">{{ data_get($ivp, 'name') }}</h4>
                                @if(sys_settings('iv_plan_desc_show') == 'yes')
                                <p class="sub-text">{{ data_get($ivp, 'desc') }}</p>
                                @endif
                            </div>
                            <div class="nk-ivp-summary card-text">
                                <div class="row">
                                  @if(data_get($ivp, 'type') != 'variable')
                                    <div class="col-6">
                                        <span class="lead-text"><span class="small text-dark">{{ data_get($ivp, 'rate_text') }}</span></span>
                                        <span class="sub-text">{{ __(':period Interest', [ 'period' => __(ucfirst(data_get($ivp, 'calc_period')))]) }}</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="lead-text"><span class="small text-dark">{{ data_get($ivp, 'term') }}</span></span>
                                        <span class="sub-text">{{ __('Term :type', ['type' => __(ucfirst(data_get($ivp, 'term_type')))]) }}</span>
                                    </div>
                                  @else
                                    <div class="col-12">
                                        <span class="lead-text"><span class="small text-dark">{{ data_get($ivp, 'rate_text') }}</span></span>
                                        <span class="sub-text">{{ __(':period Interest', [ 'period' => __(ucfirst(data_get($ivp, 'calc_period')))]) }}</span>
                                    </div>
                                  @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-inner">
                            <div class="card-text">
                                <ul class="nk-ivp-data">
                                    @if(data_get($ivp, 'is_fixed'))
                                    <li><span class="label">{{ __('Deposit Amount') }}</span> - <span class="data fw-medium text-dark">{{ money(data_get($ivp, 'amount'), $currency) }}</span></li>
                                    <li><span class="label">{{ __('Deposit Type') }}</span> - <span class="data">{{ __("Fixed") }}</span></li>
                                    @else
                                    <li><span class="label">{{ __('Min Deposit') }}</span> - <span class="data fw-medium text-dark">{{ money(data_get($ivp, 'amount'), $currency) }}</span></li>
                                    <li><span class="label">{{ __('Max Deposit') }}</span> - <span class="data">{{ data_get($ivp, 'maximum') ? money(data_get($ivp, 'maximum'), $currency) : __("Unlimited") }}</span></li>
                                    @endif
                                  
                                    @if(data_get($ivp, 'type') != 'variable')
                                      @if(sys_settings('iv_plan_terms_show') == 'yes')
                                      <li><span class="label">{{ __('Term Duration') }}</span> - <span class="data">{{ data_get($ivp, 'term_text_alter') }}</span></li>
                                      @endif
                                    @endif
                                    @if(sys_settings('iv_plan_payout_show') == 'yes')
                                      @if(data_get($ivp, 'type') != 'variable')
                                          <li><span class="label">{{ __('Payout Term') }}</span> - <span class="data">{{ __(Every 24 hours) }}</span></li>
                                      @else
                                          <li><span class="label">{{ __('Payout Term') }}</span> - <span class="data">{{ data_get($ivp, 'payout') == 'after_matured' ? __("After matured") : __("Term basis") }}</span></li>
                                      @endif
                                    @endif
                                    @if(sys_settings('iv_plan_capital_show') == 'yes')
                                    <li><span class="label">{{ __('Capital Return') }} <em class="icon ni ni-info text-soft nk-tooltip small" title="{{ __("The invested amount will be return at the end of term.") }}"></em></span> - <span class="data">@if(data_get($ivp, 'capital')) {{ __('End of Term') }} @else {{ __('Each Term') }} @endif</span></li>
                                    @endif
                                    @if(sys_settings('iv_plan_total_percent') == 'yes')
                                    <li><span class="label">{{ __('Total Return') }}</span> - <span class="data">{{ data_get($ivp,'total_return') }}%</span></li>
                                    @endif
                                </ul>
                                <div class="nk-ivp-action">
                                    <a class="btn btn-primary" href="{{ route('user.investment.invest', data_get($ivp, 'uid_code')) }}"><span>{{ __('Invest Now') }}</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            @endforeach
        </div>
    </div>
</div>
@endsection
