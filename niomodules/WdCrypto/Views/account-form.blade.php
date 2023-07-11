@php
    $userAccount = $userAccount ?? compact([]);
    $config = data_get($userAccount, 'config');
@endphp

<div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
        <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
        <div class="modal-body">
            <h4 class="title">{{ blank($userAccount) ? __('Add New Wallet') : __('Update Wallet') }}</h4>
            @if(blank($userAccount))
            <p>{{ __('Add your personal wallet to withdraw your funds.') }}</p>
            @else
            <p>{{ __('Update your personal wallet for future withdraw.') }}</p>
            @endif
            <div class="divider sm stretched"></div>
            <form action="{{ $action }}" method="POST" class="form">
                <div class="row gy-4">
                    <div class="col-12">
                        <div class="row gx-2">
                            @if(!blank($currencies))
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="cwm-wallet-name">{{ __('Wallet Name') }}</label>
                                    <div class="form-control-wrap">
                                        <select name="cwm-currency" class="form-select" id="cwm-wallet-name" data-ui="lg"{{ blank($userAccount) ? '' : ' disabled' }}>
                                            @if(count($currencies) > 1)
                                                @foreach($currencies as $currency)
                                                    <option value="{{ $currency }}"{{ ($currency==data_get($userAccount, 'config.currency', $default)) ? ' selected' : '' }}>{{ get_currency($currency, 'name') }}</option>
                                                @endforeach
                                            @else
                                                <option value="{{ $default }}">{{ $default }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-8">
                                <div class="form-group">
                                    <label class="form-label" for="cwm-wallet-address">{{ __('Wallet Address') }} <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" name="cwm-address" value="{{ data_get($userAccount, 'config.wallet') }}" class="form-control form-control-lg" id="cwm-wallet-address">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-note mt-2">{{ __('You will receive payment on this account in selected currency.') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label" for="cwm-account-label">{{ __('Label of account') }} <span>{{ __('(Optional)') }}</span></label>
                            <div class="form-control-wrap">
                                <input type="text" name="cwm-label" value="{{ data_get($userAccount, 'name') }}" class="form-control form-control-lg" id="cwm-account-label" placeholder="eg. Personal">
                            </div>
                            <div class="form-note">
                                {{ __('You can easily identify using this.') }} {{ (blank($userAccount)) ? __('The label will auto generate if you leave blank.') : '' }}<br>
                                {{ (isset($quickAdd) && $quickAdd) ? __('You can view or make changes the account info that saved in your Profile.') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        @csrf
                        @if (isset($quickAdd) && $quickAdd)
                            <input type="hidden" name="quick_added" value="yes">
                        @endif
                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                            <li>
                                <button type="button" class="btn btn-primary" id="svu-wd-account" data-redirect="{{ (isset($quickAdd) && $quickAdd) ? 'yes' : 'no' }}">
                                    <span class="spinner-border spinner-border-sm hide" role="status" aria-hidden="true"></span>
                                    <span>{{ blank($userAccount) ? __('Add Account') : __('Update Account') }}</span>
                                </button>
                            </li>
                            @if(!blank($userAccount))
                            <li>
                                <a href="javascript:void(0)" id="delete-wd-account" class="link link-btn link-danger" data-url="{{route('user.withdraw.account.wd-crypto-wallet.delete', ['id' => the_hash(data_get($userAccount, 'id', 0))])}}">{{ __('Delete') }}</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </form>
            <div class="divider md stretched"></div>
            <p class="small text-info mb-1">{{ __("Please ensure that you have provide correct address and you have access of that.") }}</p>
            <p class="small text-danger">{{ __("Caution: You will lose your funds if your wallet address is wrong or you don't have access.") }}</p>
        </div>
    </div>
</div>
