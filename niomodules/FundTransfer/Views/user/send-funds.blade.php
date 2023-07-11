@extends('user.layouts.master')

@section('title', __('Send Funds'))

@section('content')
    <div class="nk-content-body">
        <div class="page-dw wide-xs m-auto" id="ft-step-container">
            @if (!empty($errors) && is_array($errors))
                @include('user.transaction.error-state', $errors)
            @else
            <div class="nk-pps-apps">
                <div class="nk-pps-steps">
                    <span class="step active"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                </div>
                <div class="nk-pps-title text-center">
                    <h3 class="title">{{ __('Send Funds') }}</h3>
                    <p class="caption-text">{{ __('Transfer your funds to your friends and family.') }}</p>
                    <p class="sub-text-sm">{{ __('These are personal payments between you and the people you know.') }}</p>
                </div>
                <form class="nk-pps-form" action="{{ route('user.send-funds.preview') }}" method="POST" id="ft-data-frm">
                    @csrf
                    <div class="nk-pps-field form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="email">{{ __('Recipient Email') }}</label>
                        </div>
                        <div class="form-control-group">
                            <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="{{ __('Enter email address') }}" required>
                        </div>
                        <div class="form-note-group">
                            <span class="nk-pps-bal form-note-alt">{{ __('To whom you want to send funds.') }}</span>
                        </div>
                    </div>
                    <div class="nk-pps-field-set">
                        <div class="nk-pps-field-row row gy-gs">
                            <div class="nk-pps-field-col col-12">
                                <div class="nk-pps-field form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="amount">{{ __('Amount to Send') }}</label>
                                    </div>
                                    <div class="form-control-group">
                                        <div class="form-text-hint">
                                            <span class="overline-title">{{ base_currency() }}</span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" id="amount" name="amount" placeholder="0.00" required>
                                    </div>
                                    <div class="form-note-group">
                                        <span class="nk-pps-bal form-note-alt">
                                            <span>{!! __('Minimum: :amount :currency', ['amount' => send_money_amount('min'), 'currency' => base_currency() ]) !!}</span>
                                        </span>
                                        @if (!empty(send_money_amount('max')))
                                        <span class="nk-pps-bal form-note-alt">
                                            <span>{!! __('Maximum: :amount :currency', ['amount' => send_money_amount('max'), 'currency' => base_currency() ]) !!}</span>
                                        </span>  
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-pps-field form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="send-note">{{ __('Description') }} <small class="text-soft fw-normal">({{ __('Optional') }})</small></label>
                        </div>
                        <div class="form-control-group">
                            <input type="text" class="form-control form-control-lg" id="send-note" name="note">
                        </div>
                    </div>
                    <div class="nk-pps-field form-action text-center">
                        <div class="nk-pps-action">
                            <a href="#" class="btn btn-lg btn-block btn-primary pps-btn-action" id="ft-continue">
                                <span>{{ __('Click to Continue') }}</span>
                                <span class="spinner-border spinner-border-sm hide" role="status" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).on('click', '#ft-continue', function (e) {
        e.preventDefault();
        var $self = $(this), $form = $self.closest('form'), $email = $form.find('input[name=email]'), $amount = $form.find('input[name=amount]');
        let email = $email.val(), amount = parseFloat($amount.val()), proceed = true, notice = '';
        if(!(email) || !(amount)) {
            proceed = false;
        }
        if(proceed === true) {
            let url = $form.attr('action'), data = $form.serialize();
            NioApp.Form.nextStep({btn: $self, container: '#ft-step-container'}, data, url);
        } else {
            if (!(email)) {
                $email.addClass('border-danger');
                notice = "{{ __('You must enter email address to proceed.') }}";
            } else {
                $amount.addClass('border-danger');
                notice = "{{ __('You must enter amount to proceed.') }}";
            }
            NioApp.Toast(notice, 'warning');
        }
    });
</script>   
@endpush