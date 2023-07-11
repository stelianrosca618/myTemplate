@extends('auth.layouts.master')

@section('title', __('Registration Complete'))

@section('content')
<div class="card card-bordered">
    <div class="card-inner card-inner-lg">
        <div class="nk-block-head text-center">
            <h4 class="nk-block-title">{{ __('Verify your email address') }}</h4>
        </div>
        <div class="nk-block-content text-center">
            @include('auth.partials.error', ['class' => 'text-left'])

            <p>{!! __('You are almost there! A verification code has been sent to :mail', ['mail' => '<strong>'. $email .'</strong>' ]) !!}</p>
            <p>{!! __("Please check your inbox and enter the verification code below to verify your email address and activate your account.") !!}</p>

            <form action="{{ route('auth.confirm.code') }}" method="post" class="form-validate is-alter">
                <div class="form-group">
                    <div class="form-control-wrap">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="number" minlength="6" maxlength="6" name="code" class="form-control number-md form-control-lg" placeholder="{{ __('Enter verification code') }}" data-msg-minlength="{{ __('Minimum :num digit.', ['num' => 6]) }}" data-msg-maxlength="{{ __('Maximum :num digit.', ['num' => 6]) }}" data-msg-number="{{ __('Enter valid number.') }}" data-msg-required="{{ __('Required.') }}" required>
                    </div>
                </div>
                <div class="form-group mt-n1 mb-n2">
                    <ul class="btn-group-vertical align-center">
                        <li class="w-100">
                            <button id="btnconfirm" class="btn btn-lg btn-block btn-primary">{{ __('Confirm Code')}}</button>
                        </li>
                    </ul>
                    <div class="note mt-2 text-soft">
                        <p>{!! __("If the email doesn't arrive soon, check your :spam folder or have us :send.",
                            ['spam' => '<strong>'.__("spam").'</strong>', 'send' => '<a id="resend-email" href="javascript:void(0)" class="link">'.__("send it again").'</a>']) !!}</p>
                    </div>
                    <div class="text-center mt-4">
                        <a class="link link-btn" href="{{ route('welcome') }}">{{ __("Return to Home") }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    !(function(App, $) {
        $(document).ready(function() {
            const emrout = "{{ route('auth.email.resend') }}";

            $('#resend-email').on('click', function(e) {
                e.preventDefault();
                $('#btnconfirm').attr('disabled', true).addClass('disabled');
                NioApp.Form.toPost(emrout, {
                    action: 'confirm',
                    mail: "{{ $email }}"
                }, {
                    onSuccess: function(res) {
                        if (res.msg) {
                            NioApp.Toast(res.msg, res.type, {
                                position: 'top-right'
                            });
                            $('#btnconfirm').removeAttr('disabled', true).removeClass('disabled');
                        }
                    }
                });
            });
        })
    })(NioApp, jQuery);
</script>
@endpush