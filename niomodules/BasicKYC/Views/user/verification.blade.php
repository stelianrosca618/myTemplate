@extends('user.layouts.master')

@section('title', __('Identity Verification'))

@php

use NioModules\BasicKYC\Helpers\KycSessionStatus;

$started	= ($status == KycSessionStatus::STARTED) ? true : false;
$iconCheck 	= 'ni-check-circle-fill fs-22px';
$iconArrow 	= 'ni-forward-ios fs-14px';
$iconInfo 	= 'ni-info fs-14px';
$iconAlert 	= 'ni-alert-c fs-14px';

$pending = __("Submission Pending");
$require = __("Required Resubmission");

@endphp

@section('content')
	<div class="nk-content-body">
        <div class="kyc-app wide-xs m-auto" id="kyc-step-container">
			<div class="nk-block-head nk-block-head-md wide-xs mx-auto">
				<div class="nk-pps-steps">
					<span class="step active"></span>
					<span class="step"></span>
					<span class="step"></span>
					@if (!empty(data_get(gss('kyc_docs'), 'alter')))
						<span class="step"></span>
					@endif
					<span class="step"></span>
				</div>
				<div class="nk-block-head-content text-center">
					<h2 class="nk-block-title fw-normal">{{ __("Identity Verification") }}</h2>
					<div class="nk-block-des">
						<p>{{ __("To comply with regulation you will have to go through identity verification.") }}</p>
						<p><strong>{{ __("Complete the verification steps below.") }}</strong></p>
					</div>
				</div>
			</div>

			<div class="nk-block wide-xs mx-auto">
				<div class="nk-kyc-app">
					<ul class="list-group">
						<li class="list-group-item kyc-unext" data-action="basic">
							<div class="nk-kyc-step d-flex justify-content-between align-items-center py-1">
								<div class="nk-kyc-step-info">
									<h6 class="title mb-1">{{ __("Basic Information") }}</h6>
									<p class="text-soft">{{ __("Your personal information for identity.") }}</p>
								</div>
								<div class="nk-kyc-step-state d-inline-flex align-items-center">
									@if ($status == 'none')
										<span class="icon ni {{ $iconArrow }} text-soft"></span>
									@else
										<span class="icon ni {{ (empty($basic)) ? $iconArrow : $iconCheck }} text-soft"></span>
									@endif
								</div>
							</div>
						</li>
						<li class="list-group-item{{ ($started && $basic) ? ' kyc-unext' : '' }}" data-action="docs">
							<div class="nk-kyc-step d-flex justify-content-between align-items-center py-1">
								<div class="nk-kyc-step-info">
									<h6 class="title mb-1">{{ __("Identity Documents") }}</h6>
									<p class="text-soft">{{ __("Submit proof of identity document.") }}</p>
								</div>
								<div class="nk-kyc-step-state d-inline-flex align-items-center">
									@if ($document && $basic)
										<span class="icon ni {{ $iconCheck }} text-soft"></span>
									@elseif ($started && $basic)
										<span class="icon ni {{ $iconArrow }} text-soft"></span>
									@else
										<span class="icon ni {{ $resubmit ? $iconAlert : $iconInfo }} text-soft nk-tooltip" 
											  data-placement="left" title="{{ $resubmit ? $require : $pending }}"></span>
									@endif
								</div>
							</div>
						</li>
						@if (!empty(data_get(gss('kyc_docs'), 'alter')))
						<li class="list-group-item{{ ($started && $basic && $document) ? ' kyc-unext' : '' }}" data-action="proof">
							<div class="nk-kyc-step d-flex justify-content-between align-items-center py-1">
								<div class="nk-kyc-step-info">
									<h6 class="title mb-1">{{ __("Proof of Address") }}</h6>
									<p class="text-soft">{{ __("Submit document for address verification.") }}</p>
								</div>
								<div class="nk-kyc-step-state d-inline-flex align-items-center">
									@if ($document && $basic && $additional)
										<span class="icon ni {{ $iconCheck }} text-soft"></span>
									@elseif ($started && $basic && $document)
										<span class="icon ni {{ $iconArrow }} text-soft"></span>
									@else
										<span class="icon ni {{ $resubmit ? $iconAlert : $iconInfo }} text-soft nk-tooltip" 
											  data-placement="left" title="{{ $resubmit ? $require : $pending }}"></span>
									@endif
								</div>
							</div>
						</li>
						@endif
					</ul>
					@if ($resubmit)
						<p class="mt-1"><span class="text-soft fs-13px fw-normal">* {{ __("Resubmit all the necessary document to verify your identity.") }}</span></p>
					@endif
				</div>{{-- .nk-kyc-app --}}
				<div class="nk-kyc-app-action mt-4">
					<a class="btn btn-lg btn-wider btn-primary kyc-unext" data-action="proceed">
						<span>{{ ($document && $basic && $additional) ? __("Procced for Submission") : __("Click to Proceed") }}</span>
					</a>
				</div>
				<div class="nk-kyc-app-note text-center mt-3">
					<div class="note text-soft small">{!! __("By click proceed, you have agreed with our :terms", ['sitename' => site_info('name'), 'terms' => get_page_link('terms', '', true) ]) !!}</div>
				</div>
			</div>
	    </div>
    </div>{{-- .nk-content-body --}}
@endsection

@push('scripts')
<script src="{{ asset('/assets/js/libs/dropzone.js') }}"></script>
<script>
	const vroutes = {proceed: "{{ route('user.kyc.verify.next') }}", basic: "{{ route("user.kyc.verify.basic") }}", docs: "{{ route("user.kyc.verify.documents") }}", proof: "{{ route("user.kyc.verify.additional") }}", upload: "{{ route('user.kyc.verify.files') }}"};

    $('.kyc-unext').on('click', function (e) {
    	e.preventDefault();
    	let $self = $(this), action = $self.data("action");

    	if (vroutes && action && vroutes[action] !== null) {
    		NioApp.Form.nextStep({btn: $self, container: '#kyc-step-container'}, {confirm: true, method: action}, vroutes[action]);
    	}
    });
</script>
@endpush
