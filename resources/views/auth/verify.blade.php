@extends('auth.layouts.master')

@section('title', __('Email Verification'))

@section('content')
<div class="card card-bordered">
    <div class="card-inner card-inner-lg">
        <div class="nk-block-head text-center">
            <h4 class="nk-block-title">{{ __('Verify your email address') }}</h4>
        </div>
        <div class="nk-block-content text-center">
            @include('auth.partials.error', ['class' => 'text-left'])

            <p>{!! __('Your email address (:mail) has not been verified yet! In order to start using your account, you need to confirm your email address first.', ['mail' => '<strong>'. $email .'</strong>' ]) !!}</p>
            <p>{!! __("Please check your inbox and enter the verification code below to verify your email address and activate your account.") !!}</p>

            <form action="{{ route('auth.email.verify.code') }}" class="form-validate is-alter" method="post">
                <div class="form-group">
                    <div class="form-control-wrap">
                        @csrf
                        <input type="number" minlength="6" maxlength="6" name="code" class="form-control number-md form-control-lg" placeholder="{{ __('Enter verification code') }}"
                            data-msg-minlength="{{ __('Minimum :num digit.', ['num' => 6]) }}" data-msg-maxlength="{{ __('Maximum :num digit.', ['num' => 6]) }}" data-msg-number="{{ __('Enter valid number.') }}"
                            data-msg-required="{{ __('Required.') }}" required>
                    </div>
                </div>
                <div class="form-group mt-n1 mb-n3">
                    <ul class="btn-group-vertical align-center">
                        <li class="w-100">
                            <button id="btnconfirm" class="btn btn-lg btn-block btn-primary">{{ __('Confirm Code')}}</button>
                        </li>
                    </ul>
                    <div class="form-note-s2 font-italic mt-2">
                        <p>{!! __("If the email doesn't arrive soon, check your :spam folder or have us :send.", 
                                ['spam' => '<strong>'.__("spam").'</strong>', 'send' => '<a id="resend-email" href="javascript:void(0)" class="link">'.__("send it again").'</a>']) !!}</p>
                    </div>
                </div>
            </form>

            <div class="divider"></div>
            <p>{{ __("If you registered with wrong email address, update it now.") }}</p>
            <form action="{{ route('auth.email.change') }}" method="post" class="form-validate is-alter">
                <div class="form-group">
                    <div class="form-control-wrap">
                        @csrf
                        <input type="email" name="email" class="form-control" placeholder="{{ $email }}" required
                            data-msg-email="{{ __('Enter a valid email.') }}" data-msg-required="{{ __('Required.') }}">
                    </div>
                </div>
                <div class="form-group mb-n3">
                    <ul class="btn-group-vertical align-center gy-3">
                        <li class="w-100">
                            <button class="btn btn-block btn-light">{{ __('Update Email Address') }}</button>
                        </li>
                        <li>
                            <a class="link link-primary" href="{{ route('auth.logout') }}" onclick="event.preventDefault(); document.getElementById('quick-logout').submit();">
                                {{ __('Sign Out') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </form>
            <form id="quick-logout" action="{{ route('auth.logout') }}" method="POST" style="display: none;">@csrf</form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    !(function (App, $) {
        $(document).ready(function () {
            const emrout = "{{ route('auth.email.resend') }}";

            $('#resend-email').on('click', function(e) {
                e.preventDefault();
                $('#btnconfirm').attr('disabled', true).addClass('disabled');
                NioApp.Form.toPost(emrout, {action : 'email'}, {
                    onSuccess: function (res) {
                        if (res.msg) {
                            NioApp.Toast(res.msg, res.type, {position: 'top-right'});
                            $('#btnconfirm').removeAttr('disabled', true).removeClass('disabled');
                        }
                    }
                });
            });
        })
    })(NioApp, jQuery);
</script>
@endpush
