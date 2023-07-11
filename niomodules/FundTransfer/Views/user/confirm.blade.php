<div class="nk-pps-apps">
    <div class="nk-pps-steps">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step active"></span>
    </div>
    <div class="nk-pps-result">
        <em class="icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
        <h3 class="title">{{ __('Funds Sent Successfully!') }}</h3>
        <div class="nk-pps-text md">
            <p class="caption-text">{!! __('You have successfully requested to send :amount to the account of :email.', [ 'amount' => '<strong class="text-dark">'.money($amount, base_currency()).'</strong>', 'email' => '<strong class="text-dark">'.$receiver->email.'</strong>' ]) !!}</p>
            <p class="sub-text">{{ __('We will notify you once payment successfully processed.') }}</p>
        </div>
        <div class="nk-pps-action">
            <ul class="btn-group-vertical align-center gy-3">
                <li><a href="{{ route('dashboard') }}" class="btn btn-lg btn-mw btn-primary">{{ __('Go to Dashboard') }}</a></li>
                <li><a href="{{ route('transaction.list') }}" class="link link-primary">{{ __('Check status in Transaction') }}</a></li>
            </ul>
        </div>
    </div>
</div>