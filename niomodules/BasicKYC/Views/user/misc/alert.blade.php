@php

use NioModules\BasicKYC\Helpers\KycStatus;

$alert          = (!empty($attr['type'])) ? $attr['type'] : 'wraning';
$alert_class    = (!empty($attr['class'])) ? ' '.$attr['class'] : '';
$alert_type     = 'alert-'.$alert;
$alert_block    = (!empty($attr['block'])) ? $attr['block'] : '';

@endphp

@if (!empty($message))
@if ($alert_block)
    <div class="nk-block">
@endif
    <div class="alert {{ $alert_type.$alert_class}}">
        <div class="alert-cta flex-wrap flex-md-nowrap g-2">
            <div class="alert-text has-icon">
                <em class="icon ni ni-user-check-fill text-{{ $alert }}"></em>
                <p>{{ $message }}</p>
            </div>
            <div class="alert-actions my-1 my-md-0">
                @if (data_get($getKycApplicant, 'status') == KycStatus::RESUBMIT)
                    <a href="{{ route('user.kyc.verify') }}" class="btn btn-sm btn-{{ $alert }}">{{ __('Resubmit Document') }}</a>
                @else
                    <a href="{{ route('user.kyc.verify') }}" class="btn btn-sm btn-{{ $alert }}">{{ __('Start Verification') }}</a>
                @endif
            </div>
        </div>
    </div>
@if ($alert_block)
</div>
@endif
@endif
