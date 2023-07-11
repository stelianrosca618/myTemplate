@extends('admin.layouts.master')
@section('title', __('Email Configuration'))

@section('has-content-sidebar', 'has-content-sidebar')

@section('content-sidebar')
    @include('admin.settings.content-sidebar')
@endsection

@section('content')
    <div class="nk-content-body">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">{{ __('Email Configuration') }}</h3>
                    <p>{{ __('Setup your email system that used in application.') }}</p>
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
        <div class="nk-block card card-bordered nk-block-mh">
            <div class="card-inner">
                <form action="{{ route('admin.save.app.settings') }}" class="form-settings" method="POST" autocomplete="off">
                    <div class="form-sets wide-sm">
                        <div class="card-head">
                            <h5 class="card-title">{{ __('Email Notification') }}</h5>
                        </div>
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Email Recipient') }} <span>({{ __('Default') }})</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="mail_recipient" value="{{ sys_settings('mail_recipient') }}">
                                    </div>
                                    <div class="form-note">{{ __('By default, all the email notification sent to this address.') }} <br>{{ __('If leave blank then notification sent to site email.') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Email Recipient') }} <span>({{ __('Alternet') }})</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="mail_recipient_alter" value="{{ sys_settings('mail_recipient_alter') }}">
                                    </div>
                                    <div class="form-note">{{ __('You can specify this email optionally on each email notification.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="form-sets wide-sm">
                        <div class="card-head">
                            <h5 class="card-title">{{ __('Mailing Setting') }}</h5>
                        </div>
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Email From Name') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="mail_from_name" value="{{ sys_settings('mail_from_name') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Email From Address') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="mail_from_email" value="{{ sys_settings('mail_from_email') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Email Global Footer') }}</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control" name="mail_global_footer">{{ sys_settings('mail_global_footer') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="form-sets wide-sm">
                        <div class="card-head">
                            <h5 class="card-title">{{ __('Configuration') }}</h5>
                        </div>
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="mail-driver">{{ __('Mailing Driver') }}</label>
                                    <div class="form-control-wrap">
                                        <select name="mail_driver" class="form-select" id="mail-driver">
                                            @foreach($drivers as $driver => $label)
                                                <option value="{{ $driver }}"{{ ($activeDriver == $driver) ? ' selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gy-3 mail-settings smtp @if ($activeDriver != 'smtp') d-none @endif">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('SMTP HOST') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="mail_smtp_host" value="{{ sys_settings('mail_smtp_host') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('SMTP Port') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" placeholder="465" name="mail_smtp_port" value="{{ sys_settings('mail_smtp_port') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">{{ __('SMTP Secure') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" placeholder="ssl" name="mail_smtp_secure" value="{{ sys_settings('mail_smtp_secure') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('SMTP Username') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="mail_smtp_user" value="{{ sys_settings('mail_smtp_user') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('SMTP Password') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="password" autocomplete="new-password" class="form-control" placeholder="********" name="mail_smtp_password" value="{{ sys_settings('mail_smtp_password') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gy-3 mail-settings mailgun @if ($activeDriver != 'mailgun') d-none @endif">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Mailgun Domain') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="mail_mailgun_domain" value="{{ sys_settings('mail_mailgun_domain') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Mailgun API Key') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" name="mail_mailgun_api_key" value="{{ sys_settings('mail_mailgun_api_key') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Mailgun API Base Url') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="mail_mailgun_api_base_url" value="{{ sys_settings('mail_mailgun_api_base_url', 'api.mailgun.net') }}" placeholder="api.mailgun.net">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gy-3 mail-settings postmark @if ($activeDriver != 'postmark') d-none @endif">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Postmark Server API Token') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" name="mail_postmark_api_token" value="{{ sys_settings('mail_postmark_api_token') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gy-3 mail-settings ses @if ($activeDriver != 'ses') d-none @endif">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('AWS Access Key ID') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="mail_aws_access_key_id" value="{{ sys_settings('mail_aws_access_key_id') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('AWS Secret Access Key') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" name="mail_aws_secret_access_key" value="{{ sys_settings('mail_aws_secret_access_key') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('AWS Default Region') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" name="mail_aws_default_region" value="{{ sys_settings('mail_aws_default_region') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gy-3 mail-settings sendgrid @if ($activeDriver != 'sendgrid') d-none @endif">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('SendGrid API Key') }}</label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" name="mail_sendgrid_api_key" value="{{ sys_settings('mail_sendgrid_api_key') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="form-group">
                                    @csrf
                                    <input type="hidden" name="form_type" value="email-settings">
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
                <form action="{{ route('admin.settings.email.test') }}" class="form-settings wide-sm">
                    <label class="form-label" for="email-to-test">{{ __('Test Email Address') }}</label>
                    <div class="row mt-4 gy-2">
                        <div class="col-sm-8 col-md-6">
                            <div class="form-control-wrap">
                                <input type="text" name="send_to" class="form-control">
                                <input type="hidden" name="slug" value="users-welcome-email">
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-6">
                            <div class="form-control-wrap">
                                <button type="button" class="btn btn-primary send-test-mail" disabled="">
                                    <span class="spinner-border spinner-border-sm hide" role="status" aria-hidden="true"></span>
                                    <span>{{ __('Send Test Email') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    const mail_sent_url = "{{ route('admin.settings.email.test') }}";

    $(document).ready(function () {
        let $mailDriver = $('#mail-driver'), $mailSettings = $('.mail-settings'), $mailer = null;

        $mailDriver.on('change', function (e) {
            $mailSettings.addClass('d-none');
            $mailer = $(`.${e.target.value}`);
            $mailer.removeClass('d-none');
        });
    });
</script>
@endpush
