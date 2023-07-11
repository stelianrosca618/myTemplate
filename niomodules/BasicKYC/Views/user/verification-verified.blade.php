@extends('user.layouts.master')

@section('title', __('Identity Verification'))

@section('content')
	<div class="nk-content-body">
        <div class="kyc-app wide-xs m-auto" id="kyc-step-container">
			<div class="nk-block-head nk-block-head-md wide-xs mx-auto">
				<div class="nk-block-head-content text-center">
					<h2 class="nk-block-title fw-normal">{{ __("Identity Verification") }}</h2>
					<div class="nk-block-des">
						<p>{{ __("To comply with regulation you will have to go through identity verification.") }}</p>
						<p><strong>{{ __("Congrats, we have successfully verified your identity and submitted documents.") }}</strong></p>
					</div>
				</div>
			</div>

			<div class="nk-block wide-xs mx-auto">
				<div class="nk-kyc-app">
					<ul class="list-group">
						<li class="list-group-item">
							<div class="nk-kyc-step d-flex justify-content-between align-items-center py-1">
								<div class="nk-kyc-step-info">
									<h6 class="title mb-1">{{ __("Basic Information") }}</h6>
									<p class="text-soft">{{ __("Your personal information for identity.") }}</p>
								</div>
								<div class="nk-kyc-step-state d-inline-flex align-items-center">
									<span class="icon ni ni-check-circle-fill fs-22px text-success"></span>
								</div>
							</div>
						</li>
						<li class="list-group-item">
							<div class="nk-kyc-step d-flex justify-content-between align-items-center py-1">
								<div class="nk-kyc-step-info">
									<h6 class="title mb-1">{{ __("Identity Documents") }}</h6>
									<p class="text-soft">{{ __("Submit proof of identity document.") }}</p>
								</div>
								<div class="nk-kyc-step-state d-inline-flex align-items-center">
									<span class="icon ni ni-check-circle-fill fs-22px text-success"></span>
								</div>
							</div>
						</li>
						@if (!empty(data_get(gss('kyc_docs'), 'alter')))
						<li class="list-group-item">
							<div class="nk-kyc-step d-flex justify-content-between align-items-center py-1">
								<div class="nk-kyc-step-info">
									<h6 class="title mb-1">{{ __("Proof of Address") }}</h6>
									<p class="text-soft">{{ __("Submit document for address verification.") }}</p>
								</div>
								<div class="nk-kyc-step-state d-inline-flex align-items-center">
									<span class="icon ni ni-check-circle-fill fs-22px text-success"></span>
								</div>
							</div>
						</li>
						@endif
					</ul>
				</div>{{-- .nk-kyc-app --}}
				<div class="nk-kyc-app-note text-center mt-3">
					<div class="note text-soft small">{{ __("Please feel free to contact if you need any further information.") }}</div>
				</div>
				<div class="nk-kyc-app-action mt-5 text-center">
					<a href="{{ route('dashboard') }}" class="btn btn-lg btn-primary"><span>{{ __("Back to Dashboard") }}</span></a>
				</div>
			</div>
	    </div>
    </div>{{-- .nk-content-body --}}
@endsection
