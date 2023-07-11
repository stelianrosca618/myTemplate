@extends('emails.layouts.master')

@section('body')
<table style="width:100%;max-width:620px;margin:0 auto;background-color:#ffffff;">
    <tbody>
        <tr>
            <td style="padding: 30px 30px 20px">
                {!! auto_p($greeting) !!}
            </td>
        </tr>
        <tr>
            <td style="padding: 0 30px 20px">
                {!! auto_p($content) !!}
            </td>
        </tr>
        <tr>
            <td style="padding: 5px 30px">
                <p style="margin-bottom: 10px;">{{ __('Verification code:') }}</p>
                <h3 style="color: #6576ff; text-decoration:none; word-break: break-all; font-size: 18px;">{{ data_get($user, 'verify_token.code') }}</h3>
            </td>
        </tr>

        <tr>
            <td style="padding: 0 30px 20px">
                <h4 style="font-size: 15px; color: #000000; font-weight: 600; margin: 0; text-transform: uppercase; margin-bottom: 10px">or</h4>
                <p style="margin-bottom: 25px;">{{ __('You can use the below link to verify your account.') }}</p>
                <a href="{{ route('auth.email.verify', [ 'token' => data_get($user, 'verify_token.token').md5($user->email) ]) }}" style="background-color:#037dff;border-radius:4px;color:#ffffff;display:inline-block;font-size:13px;line-height:44px;text-align:center;text-decoration:none;padding: 0 30px">{{__('Verify Email') }}</a>
                <p style="margin-top: 25px;">{{ __('Note: The code or link will expire in 30 minutes and can only be used once.') }}</p>
            </td>
        </tr>

        @if(data_get($template, 'params.regards') == "on")
        <tr>
            <td style="padding: 20px 30px 30px">
                {!! auto_p($global_footer) !!}
            </td>
        </tr>
        @endif
    </tbody>
</table>
@endsection