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
	<form method="POST" class="form-validate is-alter">
		<div class="nk-kyc-app card card-bordered">
			<div class="nk-kycfm">
				<div class="nk-kycfm-content">
					<div class="nk-kycfm-text mb-4">
						<h5 class="title mb-1">{{ __("Basic Information") }}</h5>
						<p class="text-soft">{{ __("Your address details required for identification.") }}</p>
					</div>
					<div class="row g-3">
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label" for="address-l1">{{ __('Address Line 1') }}</label>
								<div class="form-control-group">
									<input type="hidden" name="identity" value="{{ $session ? the_hash($session) : '' }}">
									<input type="text" name="address_line_1" class="form-control" id="address-l1" value="{{ data_get($basicInfo, 'address_line_1') }}" maxlength="100"{{ (data_get($setting, "address.req") == "yes") ? ' required' : '' }}>
								</div>
							</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label class="form-label" for="address-l2">{{ __('Address Line 2') }}</label>
								<div class="form-control-group">
									<input type="text" name="address_line_2" class="form-control" id="address-l2" value="{{ data_get($basicInfo, 'address_line_2') }}" maxlength="100">
								</div>
							</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label class="form-label" for="address-city">{{ __('City') }}</label>
								<div class="form-control-group">
									<input type="text" name="city" class="form-control" id="address-city" value="{{ data_get($basicInfo, 'city') }}" maxlength="50"{{ (data_get($setting, "address.req") == "yes") ? ' required' : '' }}>
								</div>
							</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label class="form-label" for="address-st">{{ __('State / Province') }}</label>
								<div class="form-control-group">
									<input type="text" name="state" class="form-control" id="address-st" value="{{ data_get($basicInfo, 'state') }}" maxlength="50">
								</div>
							</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label class="form-label" for="address-zip">{{ __('Zip / Postal Code') }}</label>
								<div class="form-control-group">
									<input type="text" name="zip" class="form-control" id="address-zip" value="{{ data_get($basicInfo, 'zip') }}" maxlength="20">
								</div>
							</div>
						</div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="address-county">{{ __("Country") }}</label>
                                <div class="form-control-group">
                                    <select name="country" class="form-select form-control" id="address-county" data-search="on" data-placeholder="{{ __("Please select") }}" required>
                                    	<option value=""></option>
                                        @foreach($countries as $code => $country)
                                            <option value="{{ $country }}"{{ (data_get($basicInfo, 'country') == $country) ? ' selected' : '' }}>{{ config('countries')[$code] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
					</div>
					<div class="nk-kycfm-note mt-4">
						<em class="icon ni ni-info"></em>
						<p>{{ __("Please carefully fill out the form with your address details.") }}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="nk-kyc-app-action mt-4">
			<a class="btn btn-lg btn-wider btn-primary kyc-step-adr" data-action="next"><span>{{ __("Update & Continue") }}</span></a>
			<a href="javascript:void(0)" class="link link-primary link-btn btn-block mt-2 kyc-step-adr" data-action="back"><span>{{ __("Back to Previous") }}</span></a>
		</div>
	</form>

	<script>
		$('.kyc-step-adr').on('click', function (e) {
			e.preventDefault();
			var $self = $(this), $form = $self.closest('form'), action = $self.data('action');
			var url = (action == 'next') ? "{{ route("user.kyc.verify.basic.address.update") }}" : "{{ route('user.kyc.verify.basic.form') }}",
				data = (action == 'next') ? $form.serialize() : {confirm: true, method: 'back'};

			if (url && data) {
				NioApp.Form.nextStep({btn: $self, container: '#kyc-step-container'}, data, url);
			}
		});
	</script>
</div>
