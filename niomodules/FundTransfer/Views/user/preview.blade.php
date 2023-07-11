<div class="nk-pps-apps">
    <div class="nk-pps-steps">
        <span class="step"></span>
        <span class="step active"></span>
        <span class="step"></span>
    </div>
    <div class="nk-pps-title text-center">
        <h3 class="title">{{ __('Send Confirmation') }}</h3>
        <p class="caption-text">{!! __('You are about to send :amount from your account.', [ 'amount' => '<strong class="text-dark">'.money($amount, base_currency()).'</strong>' ]) !!}</p>
        <p class="sub-text-sm">{{ __('Please review and confirm the information before sending funds.') }}</p>
    </div>
        <div class="nk-pps-data">
            <ul class="nk-olist">
                <li class="nk-olist-item">
                    <div class="label lead-text">{{ __('Send Amount') }}</div>
                    <div class="data"><span class="amount">{{ money($amount, base_currency()) }}</span></div>
                </li>

                <li class="nk-olist-item{{ (!empty($note)) ? ' is-grouped' : '' }}">
                    <div class="label lead-text">{{ __('Send To') }}</div>
                    <div class="data"><span class="pay-mail">{{ $receiver->email }}</span></div>
                </li>

                @if (!empty($note))
                <li class="nk-olist-item">
                    <div class="label">{{ __('Description') }}</div>
                    <div class="data fw-normal">{{ $note }}</div>
                </li>
                @endif

                <li class="nk-olist-item">
                    <div class="label lead-text">{{ __('Payment Type') }}</div>
                    <div class="data"><span class="method"><span>{{ __('Transfer Funds') }}</span></span></div>
                </li>
            </ul>
            <ul class="nk-olist">
                <li class="nk-olist-item nk-olist-item-final">
                    <div class="label lead-text">{{  __('Amount to Debit') }}</div>
                    <div class="data"><span class="amount">{{ money($amount, base_currency()) }}</span></div>
                </li>
            </ul>
        </div>
        <div class="nk-pps-field form-action text-center">
            <div class="nk-pps-action">
                <a href="javascript:void(0)" class="btn btn-lg btn-block btn-primary" data-url="{{ route('user.send-funds.confirm') }}" id="ft-confirm">
                    <span>{{ __('Confirm') }}</span>
                    <span class="spinner-border spinner-border-sm hide" role="status" aria-hidden="true"></span>
                </a>
            </div>
            <div class="nk-pps-action pt-3">
                <a href="{{ route('user.send-funds.show') }}" class="btn btn-outline-danger btn-trans">{{ __('Cancel') }}</a>
            </div>
        </div>
        <script type="text/javascript">
            $(document).on('click', '#ft-confirm', function (e) {
                e.preventDefault();
                let $self = $(this), url = $self.data('url'), data = {confirm: true};
                NioApp.Form.nextStep({btn: $self, container: '#ft-step-container'}, data, url);
            });
        </script>
</div>
