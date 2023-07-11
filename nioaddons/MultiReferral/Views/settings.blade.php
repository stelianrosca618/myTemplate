@php
    use NioAddons\MultiReferral\Enums\InvBonusApplyTerm;
    
    $levels = \NioAddons\MultiReferral\MultiReferral::levels();
@endphp

<div class="divider"></div>
<form action="{{ route('admin.settings.global.referral.investment.save') }}" class="form-settings" method="POST">
    <h5 class="title">{{ __('Referral Commission on Investment') }}</h5>
    <div class="form-sets gy-3 wide-md">
        <div class="form-sets gy-3 wide-md">
            <div class="row g-3 align-center">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="form-label" for="investment-bonus-applied">{{ __('Bonus Applied on Users Account') }}</label>
                        <span class="form-note">{{ __('When bonus will apply on users account after user invests.') }}</span>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row gx-1 gy-1">
                        <div class="col-6 w-max-250px">
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <select class="form-select" name="investment_bonus_apply" id="investment-bonus-applied">
                                        <option value="instant"{{ (sys_settings('referral_investment_bonus_apply', InvBonusApplyTerm::INSTANT) == InvBonusApplyTerm::INSTANT) ? ' selected' : '' }}>{{ __("Pay Instant") }}</option>
                                        <option value="after_term_ends"{{ (sys_settings('referral_investment_bonus_apply', InvBonusApplyTerm::INSTANT) == InvBonusApplyTerm::AFTER_TERM_ENDS) ? ' selected' : '' }}>{{ __("Pay After Term Ends") }}</option>
                                        <option value="middle_of_term"{{ (sys_settings('referral_investment_bonus_apply', InvBonusApplyTerm::INSTANT) == InvBonusApplyTerm::MIDDLE_OF_TERM) ? ' selected' : '' }}>{{ __("Pay at Middle of Term") }}</option>
                                    </select>
                                </div>
                                <div class="form-note">{{ __('Applied bonus Time') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="divider"></div>

    <h5 class="title">{{ __('Referral Commission') }} <span class="text-primary small fs-14px ucap"> - {{ __('Who Refer') }}</span></h5>
    <div class="form-sets gy-3 wide-md">
        <div class="row g-3 align-center">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-label" for="lv1-investment-bonus-enable">{{ __('Allow on Successful Investment') }}</label>
                    <span class="form-note">{{ __('Allow commission on successful investment for referral signup.') }}</span>
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input class="switch-option-value" type="hidden" name="lv1" value="{{ sys_settings('referral_lv1') ?? 'no' }}">
                        <input id="lv1-investment-bonus-enable" type="checkbox" class="custom-control-input switch-option"
                                data-switch="yes"{{ (sys_settings('referral_lv1', 'no') == 'yes') ? ' checked=""' : ''}}>
                        <label for="lv1-investment-bonus-enable" class="custom-control-label">{{ __('Allowed') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 align-center">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-label" for="lv1-investment-bonus-allowed">{{ __('Bonus Allowed for Investment') }}</label>
                    <span class="form-note">{{ __('How many times bonus will apply on investment.') }}</span>
                </div>
            </div>
            <div class="col-md-7">
                <div class="row gx-1 gy-1">
                    <div class="col-6 w-max-250px">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <select class="form-select" name="investment_lv1_allow" id="lv1-investment-bonus-allowed">
                                    <option value="only"{{ (sys_settings('referral_investment_lv1_allow', 'only') == 'only') ? ' selected' : '' }}>{{ __("First Investment Only") }}</option>
                                    <option value="all"{{ (sys_settings('referral_investment_lv1_allow', 'only') == 'all') ? ' selected' : '' }}>{{ __("For All Investment") }}</option>
                                    <option value="number"{{ (sys_settings('referral_investment_lv1_allow', 'only') == 'number') ? ' selected' : '' }}>{{ __("Number of Investment") }}</option>
                                </select>
                            </div>
                            <div class="form-note">{{ __('Allowed Bonus') }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <div class="form-control-wrap w-max-100px">
                                <input type="number" placeholder="2" class="form-control" name="investment_lv1_max" value="{{ sys_settings('referral_investment_lv1_max', '') }}" min="2">
                            </div>
                            <div class="form-note">{{ __('Number') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 align-center">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-label" for="lv1-investment-bonus-amount">{{ __('Commission on Investment') }}</label>
                    <span class="form-note">{{ __('The amount will be received once investment completed.') }}</span>
                </div>
            </div>
            <div class="col-md-7">
                <div class="row gx-1 gy-1 w-max-250px">
                    <div class="col-6">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <input type="number" id="lv1-investment-bonus-amount" class="form-control" name="investment_lv1_amount" value="{{ sys_settings('referral_investment_lv1_amount', '0') }}" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <select class="form-select" name="investment_lv1_type">
                                <option value="percent"{{ (sys_settings('referral_investment_lv1_type', 'percent') == 'percent') ? ' selected' : '' }}>{{ __("Percent") }}</option>
                                <option value="fixed"{{ (sys_settings('referral_investment_lv1_type', 'percent') == 'fixed') ? ' selected' : '' }}>{{ __("Fixed (:base)", [ 'base' => base_currency() ]) }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-note">{{ __('Specify the commission amount to referer.') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="divider"></div>

    <h5 class="title">{{ __('Commission for User') }} <span class="text-primary small fs-14px ucap"> - {{ __('Who Joined') }}</span></h5>
    <div class="form-sets gy-3 wide-md">
        <div class="row g-3 align-center">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-label" for="lv0-investment-bonus-enable">{{ __('Allow on Successful Investment') }}</label>
                    <span class="form-note">{{ __('Allow commission on successful investment if joined via referral.') }}</span>
                </div>
            </div>
            <div class="col-md-7">
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input class="switch-option-value" type="hidden" name="lv0" value="{{ sys_settings('referral_lv0') ?? 'no' }}">
                        <input id="lv0-investment-bonus-enable" type="checkbox" class="custom-control-input switch-option"
                                data-switch="yes"{{ (sys_settings('referral_lv0', 'no') == 'yes') ? ' checked=""' : ''}}>
                        <label for="lv0-investment-bonus-enable" class="custom-control-label">{{ __('Allowed') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3 align-center">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-label" for="lv0-investment-bonus-allowed">{{ __('Bonus Allowed for Investment') }}</label>
                    <span class="form-note">{{ __('How many times bonus will apply on investment if joined.') }}</span>
                </div>
            </div>
            <div class="col-md-7">
                <div class="row gx-1 gy-1">
                    <div class="col-6 w-max-250px">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <select class="form-select" name="investment_lv0_allow" id="lv0-investment-bonus-allowed">
                                    <option value="only"{{ (sys_settings('referral_investment_lv0_allow', 'only') == 'only') ? ' selected' : '' }}>{{ __("First Investment Only") }}</option>
                                    <option value="all"{{ (sys_settings('referral_investment_lv0_allow', 'only') == 'all') ? ' selected' : '' }}>{{ __("For All Investment") }}</option>
                                    <option value="number"{{ (sys_settings('referral_investment_lv0_allow', 'only') == 'number') ? ' selected' : '' }}>{{ __("Number of Investment") }}</option>
                                </select>
                            </div>
                            <div class="form-note">{{ __('Allowed Bonus') }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <div class="form-control-wrap w-max-100px">
                                <input type="number" placeholder="2" class="form-control" name="investment_lv0_max" value="{{ sys_settings('referral_investment_lv0_max', '') }}" min="2">
                            </div>
                            <div class="form-note">{{ __('Number') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row g-3 align-center">
            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-label" for="lv0-investment-bonus-amount">{{ __('Commission on Investment') }}</label>
                    <span class="form-note">{{ __('User will receive the amount once investment completed.') }}</span>
                </div>
            </div>
            <div class="col-md-7">
                <div class="row gx-1 gy-1 w-max-250px">
                    <div class="col-6">
                        <div class="form-group">
                            <div class="form-control-wrap">
                                <input type="number" id="lv0-investment-bonus-amount" class="form-control" name="investment_lv0_amount" value="{{ sys_settings('referral_investment_lv0_amount', '0') }}" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <select class="form-select" name="investment_lv0_type">
                                <option value="percent"{{ (sys_settings('referral_investment_lv0_type', 'percent') == 'percent') ? ' selected' : '' }}>{{ __("Percent") }}</option>
                                <option value="fixed"{{ (sys_settings('referral_investment_lv0_type', 'percent') == 'fixed') ? ' selected' : '' }}>{{ __("Fixed (:base)", [ 'base' => base_currency() ]) }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-note">{{ __('Specify the commission amount to who joined.') }}</div>
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
                    <input type="hidden" name="form_type" value="referral-settings">
                    <button type="button" class="btn btn-primary submit-settings" disabled="">
                        <span class="spinner-border spinner-border-sm hide" role="status" aria-hidden="true"></span>
                        <span>{{ __('Update') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="divider"></div>
<h5 class="title">{{ __('Advance Settings') }} <span class="text-primary small fs-14px ucap"> - {{ __('Multi Level') }}</span></h5>
@if( $levels > 0)
    <form action="{{ route('admin.settings.global.referral.multi-referral.save') }}" class="form-settings" method="POST">
        @for($i = 1; $i<$levels; $i++)
            @php
                $counter = $i+1;
                $counterPadded = sprintf("%02d", $counter);
            @endphp
            <div class="form-sets gy-3 wide-md">
                <div class="row g-3 align-center">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label" for="enable-bonus-level-{{ $counterPadded }}">{{ __('Enable Bonus for Level :num', ['num' => '#'.$counterPadded]) }}</label>
                            <span class="form-note">{{ __('Enable the level of commission.', ['num' => '#'.$counterPadded]) }}</span>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input class="switch-option-value" type="hidden" name="lv{{ $counter  }}" value="{{ sys_settings('referral_lv'.$counter) ?? 'no' }}">
                                <input id="enable-bonus-level-{{ $counterPadded }}" type="checkbox" class="custom-control-input switch-option" data-switch="yes"{!! (sys_settings('referral_lv'.$counter, 'no') == 'yes') ? ' checked=""' : '' !!}>
                                <label for="enable-bonus-level-{{ $counterPadded }}" class="custom-control-label">{{ __('Allowed') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3 align-center">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label" for="bonus-allowed-level-{{ $counterPadded }}">{{ __('Deposit Bonus Allowed for Level :num', ['num' => '#'.$counterPadded]) }}</label>
                            <span class="form-note">{{ __('How many times bonus will apply on deposit.') }}</span>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row gx-1 gy-1">
                            <div class="col-6 w-max-250px">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <select class="form-select" name="deposit_lv{{ $counter }}_allow" id="bonus-allowed-level-{{ $counterPadded }}">
                                            <option value="only"{{ (sys_settings('referral_deposit_lv'.$counter.'_allow', 'only') == 'only') ? ' selected' : '' }}>{{ __("First Deposit Only") }}</option>
                                            <option value="all"{{ (sys_settings('referral_deposit_lv'.$counter.'_allow', 'only') == 'all') ? ' selected' : '' }}>{{ __("For All Deposit") }}</option>
                                            <option value="number"{{ (sys_settings('referral_deposit_lv'.$counter.'_allow', 'only') == 'number') ? ' selected' : '' }}>{{ __("Number of Deposit") }}</option>
                                        </select>
                                    </div>
                                    <div class="form-note">{{ __('Allowed Bonus') }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="form-control-wrap w-max-100px">
                                        <input type="number" placeholder="2" class="form-control" name="deposit_lv{{ $counter }}_max" value="{{ sys_settings('referral_deposit_lv'.$counter.'_max', '') }}" min="2">
                                    </div>
                                    <div class="form-note">{{ __('Number') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3 align-center">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label" for="bonus-level-{{ $counterPadded }}-amount">{{ __('Deposit Commission on Level :num', ['num' => '#'.$counterPadded]) }}</label>
                            <span class="form-note">{{ __('The amount will be received once deposit completed.') }}</span>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row gx-1 gy-1 w-max-250px">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <input type="number" id="bonus-level-{{ $counterPadded }}-amount" class="form-control" name="deposit_lv{{$counter}}_amount" value="{{ sys_settings('referral_deposit_lv'.$counter.'_amount', '0') }}" min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <select class="form-select" name="deposit_lv{{ $counter }}_type">
                                        <option value="percent"{{ (sys_settings('referral_deposit_lv'.$counter.'_type', 'percent') == 'percent') ? ' selected' : '' }}>{{ __("Percent") }}</option>
                                        <option value="fixed"{{ (sys_settings('referral_deposit_lv'.$counter.'_type', 'percent') == 'fixed') ? ' selected' : '' }}>{{ __("Fixed (:base)", [ 'base' => base_currency() ]) }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-note">{{ __('Specify the commission amount to referer.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row g-3 align-center">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label" for="inv-bonus-allowed-level-{{ $counterPadded }}">{{ __('Investment Bonus Allowed for Level :num', ['num' => '#'.$counterPadded]) }}</label>
                            <span class="form-note">{{ __('How many times bonus will apply on investment.') }}</span>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row gx-1 gy-1">
                            <div class="col-6 w-max-250px">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <select class="form-select" name="investment_lv{{ $counter }}_allow" id="inv-bonus-allowed-level-{{ $counterPadded }}">
                                            <option value="only"{{ (sys_settings('referral_investment_lv'.$counter.'_allow', 'only') == 'only') ? ' selected' : '' }}>{{ __("First Investment Only") }}</option>
                                            <option value="all"{{ (sys_settings('referral_investment_lv'.$counter.'_allow', 'only') == 'all') ? ' selected' : '' }}>{{ __("For All Investment") }}</option>
                                            <option value="number"{{ (sys_settings('referral_investment_lv'.$counter.'_allow', 'only') == 'number') ? ' selected' : '' }}>{{ __("Number of Investment") }}</option>
                                        </select>
                                    </div>
                                    <div class="form-note">{{ __('Allowed Bonus') }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="form-control-wrap w-max-100px">
                                        <input type="number" placeholder="2" class="form-control" name="investment_lv{{ $counter }}_max" value="{{ sys_settings('referral_investment_lv'.$counter.'_max', '') }}" min="2">
                                    </div>
                                    <div class="form-note">{{ __('Number') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3 align-center">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label" for="inv-bonus-level-{{ $counterPadded }}-amount">{{ __('Investment Commission on Level :num', ['num' => '#'.$counterPadded]) }}</label>
                            <span class="form-note">{{ __('The amount will be received once investment completed.') }}</span>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row gx-1 gy-1 w-max-250px">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="form-control-wrap">
                                        <input type="number" id="inv-bonus-level-{{ $counterPadded }}-amount" class="form-control" name="investment_lv{{$counter}}_amount" value="{{ sys_settings('referral_investment_lv'.$counter.'_amount', '0') }}" min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <select class="form-select" name="investment_lv{{ $counter }}_type">
                                        <option value="percent"{{ (sys_settings('referral_investment_lv'.$counter.'_type', 'percent') == 'percent') ? ' selected' : '' }}>{{ __("Percent") }}</option>
                                        <option value="fixed"{{ (sys_settings('referral_investment_lv'.$counter.'_type', 'percent') == 'fixed') ? ' selected' : '' }}>{{ __("Fixed (:base)", [ 'base' => base_currency() ]) }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-note">{{ __('Specify the commission amount to referer.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($i != $levels - 1)
                <div class="divider"></div>
            @endif
        @endfor
        <div class="form-sets gy-3 wide-md">
            <div class="row g-3">
                <div class="col-md-7 offset-lg-5">
                    <div class="form-group mt-2">
                        @csrf
                        <input type="hidden" name="form_prefix" value="referral">
                        <input type="hidden" name="form_type" value="referral-settings">
                        <button type="button" class="btn btn-primary submit-settings" disabled="">
                            <span class="spinner-border spinner-border-sm hide" role="status" aria-hidden="true"></span>
                            <span>{{ __('Update') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif
