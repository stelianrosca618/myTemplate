@php
	$setting = data_get(gss("kyc_fields"), 'profile');
@endphp

<div class="nk-block-head nk-block-head-lg wide-xs mx-auto">
	<div class="nk-pps-steps">
		<span class="step"></span>
		<span class="step active"></span>
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
		</div>
	</div>
</div>

<div class="nk-block wide-xs mx-auto">
	<div class="nk-kyc-app card card-bordered">
		<div class="nk-kycfm">
			<div class="nk-kycfm-content">
				<div class="nk-kycfm-text mb-3">
					<h5 class="title mb-1">{{ __("Basic Information") }}</h5>
					<p class="text-soft">{{ __("Your personal information for identity.") }}</p>
					<p class="fw-medium text-base">{{ __("Please review your personal information before you are going to submit identity documents.") }}</p>
				</div>
				<div class="row gy-2">
					<div class="col-md-6">
						<span class="sub-text">{{ __("Full Name") }}</span>
						<span class="caption-text">{{ data_get($basicInfo, 'name') }}</span>
					</div>

                    @if (data_get($setting, "phone.show") == "yes")
					<div class="col-md-6">
						<span class="sub-text">{{ __("Phone") }}</span>
						<span class="caption-text text-break{{ (data_get($basicInfo, 'phone')) ? '' : ' font-italic' }}">
							{{ data_get($basicInfo, 'phone') ? data_get($basicInfo, 'phone') : __('Not added yet') }}
						</span>
					</div>
                    @endif

                    @if (data_get($setting, "dob.show") == "yes")
					<div class="col-md-6">
						<span class="sub-text">{{ __("Date of Birth") }}</span>
						<span class="caption-text{{ (data_get($basicInfo, 'dob')) ? '' : ' font-italic' }}">
							{{ data_get($basicInfo, 'dob') ? show_dob(data_get($basicInfo, 'dob')) : __('Not added yet') }}
						</span>
					</div>
                    @endif

                    @if (data_get($setting, "gender.show") == "yes")
					<div class="col-md-6">
						<span class="sub-text">{{ __("Gender") }}</span>
						<span class="caption-text{{ (data_get($basicInfo, 'gender')) ? '' : ' font-italic' }}">
							{{ data_get($basicInfo, 'gender') ? __(ucfirst(data_get($basicInfo, 'gender'))) : __('Not added yet') }}
						</span>
					</div>
                    @endif

                    @if (data_get($setting, "nationality.show") == "yes")
					<div class="col-md-6">
						<span class="sub-text">{{ __("Nationality") }}</span>
						<span class="caption-text{{ (data_get($basicInfo, 'nationality')) ? '' : ' font-italic' }}">
							{{ data_get($basicInfo, 'nationality') ? data_get($basicInfo, 'nationality') : __('Not added yet') }}
						</span>
					</div>
                    @endif

					<div class="col-md-6">
						<span class="sub-text">{{ __("Country of Residence") }}</span>
						<span class="caption-text{{ (data_get($basicInfo, 'country')) ? '' : ' font-italic' }}">
							{{ data_get($basicInfo, 'country') ? data_get($basicInfo, 'country') : __('Not added yet') }}
						</span>
					</div>

					@if (data_get($setting, "address.show") == "yes")
					<div class="col-md-12">
						<span class="sub-text">{{ __("Address") }}</span>
						<span class="caption-text{{ (address_lines($basicInfo)) ? '' : ' font-italic' }}">
							{{ (address_lines($basicInfo)) ? (address_lines($basicInfo)) : __('Not added yet') }}
						</span>
					</div>
					@endif

					<div class="col-12">
						<p>{!! __(":update, if its incorrect or inconsistent.", ['update' => '<a href="javascript:void(0)" class="link link-primary kyc-step-bpc">'. __("Update your information") .'</a>']) !!}</p>
					</div>
				</div>
				<div class="nk-kycfm-note mt-3">
					<em class="icon ni ni-info"></em>
					<p>{{ __("These information should consistent with your documents.") }}</p>
				</div>
			</div>
		</div>
	</div>
	<div class="nk-kyc-app-action mt-4">
		<a class="btn btn-lg btn-wider btn-primary kyc-step-bpc" data-action="next"><span>{{ __("Confirm & Continue") }}</span></a>
		<a href="{{ route("user.kyc.verify") }}" class="link link-danger link-btn btn-block mt-2"><span>{{ __("Cancel & Return") }}</span></a>
	</div>

	<script>
		$('.kyc-step-bpc').on('click', function (e) {
			e.preventDefault();
			var $self = $(this), $form = $self.closest('form'), action = $self.data('action');
			var url = (action == 'next') ? "{{ route('user.kyc.verify.next') }}" : "{{ route('user.kyc.verify.basic.form') }}",
				data = {identity: "{{ $session ? the_hash($session) : '' }}", confirm: true, method: action};

			if (url && data) {
				NioApp.Form.nextStep({btn: $self, container: '#kyc-step-container'}, data, url);
			}
		});
	</script>
</div>
