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
						<p class="text-soft">{{ __("Your personal information required for identification.") }}</p>
					</div>
					<div class="row g-3">
						<div class="col-12">
							<div class="form-group">
								<label class="form-label" for="full-name">{{ __("Full Name") }}</label>
								<div class="form-control-group">
									<input type="hidden" name="identity" value="{{ $session ? the_hash($session) : '' }}">
									<input type="text" name="name" value="{{ data_get($basicInfo, 'name') }}" class="form-control" id="full-name" required maxlength="190">
								</div>
							</div>
						</div>
						@if(data_get($setting, "phone.show") == "yes")
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="phone-no">{{ __("Phone Number") }}
										@if(data_get($setting, "phone.req") == "no")
											<small class="text-soft">{{ __("Optional") }}</small>
										@endif
									</label>
									<div class="form-control-group">
										<input type="text" name="phone" value="{{ data_get($basicInfo, 'phone') }}" class="form-control" id="phone-no"{{ (data_get($setting, "phone.req") == "yes") ? ' required' : '' }}>
									</div>
								</div>
							</div>
						@endif
						@if(data_get($setting, "dob.show") == "yes")
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="birth-day">{{ __("Date of Birth") }}
										@if(data_get($setting, "dob.req") == "no")
											<small class="text-soft">{{ __("Optional") }}</small>
										@endif
									</label>
									<div class="form-control-group">
										<input type="text" name="dob" value="{{ data_get($basicInfo, 'dob') ?? '' }}" data-date-start-date="-85y" data-date-end-date="-12y" class="form-control date-picker-alt" id="birth-day"{{ (data_get($setting, "dob.req") == "yes") ? ' required' : '' }}>
									</div>
								</div>
							</div>
						@endif
						@if(data_get($setting, "gender.show") == "yes")
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="gender">{{ __("Gender") }}
										@if(data_get($setting, "gender.req") == "no")
											<small class="text-soft">{{ __("Optional") }}</small>
										@endif
									</label>
									<div class="form-control-group">
										<select name="gender" class="form-select form-control" id="gender" data-placeholder="{{ __('Please select') }}"{{ (data_get($setting, "gender.req") == "yes") ? ' required' : '' }}>
											<option value=""></option>
											<option value="male"{{ (data_get($basicInfo, 'gender') == 'male') ? ' selected' : '' }}>{{ __('Male') }}</option>
											<option value="female"{{ (data_get($basicInfo, 'gender') == 'female') ? ' selected' : '' }}>{{ __('Female') }}</option>
											<option value="other"{{ (data_get($basicInfo, 'gender') == 'other') ? ' selected' : '' }}>{{ __('Others') }}</option>
										</select>
									</div>
								</div>
							</div>
						@endif

						@if(data_get($setting, "nationality.show") == "yes")
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-label" for="nationality">{{ __("Nationality") }}
										@if(data_get($setting, "nationality.req") == "no")
											<small class="text-soft">{{ __("Optional") }}</small>
										@endif
									</label>
									<div class="form-control-group">
										<select name="nationality" class="form-select form-control" id="nationality" data-search="on" data-placeholder="{{ __('Please select') }}"{{ (data_get($setting, "nationality.req") == "yes") ? ' required' : '' }}>
											<option value=""></option>
											@foreach(config('countries') as $item)
												<option value="{{ $item }}"{{ ((data_get($basicInfo, 'nationality')) == $item) ? ' selected' : '' }}>{{ $item }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						@endif

						@if(data_get($setting, "address.show") == "no")
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="address-county">{{ __("Country of Residence") }}</label>
                                    <div class="form-control-group">
                                        <select name="country" class="form-select" id="address-county" data-search="on" data-placeholder="{{ __("Please select") }}" required>
                                        	<option value=""></option>
                                            @foreach($countries as $code => $country)
                                                <option value="{{ $country }}"{{ (data_get($basicInfo, 'country') == $country) ? ' selected' : '' }}>{{ config('countries')[$code] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
						@endif
					</div>
					<div class="nk-kycfm-note mt-4">
						<em class="icon ni ni-info"></em>
						<p>{{ __("Please carefully fill out the form with your personal details.") }}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="nk-kyc-app-action mt-4">
			<a class="btn btn-lg btn-wider btn-primary kyc-step-bpi" data-action="next"><span>{{ __("Update & Continue") }}</span></a>
			<a href="{{ route("user.kyc.verify") }}" class="link link-danger link-btn btn-block mt-2"><span>{{ __("Cancel & Return") }}</span></a>
		</div>
	</form>

	<script>
		$('.kyc-step-bpi').on('click', function (e) {
			e.preventDefault();
			var $self = $(this), $form = $self.closest('form');
			var url = "{{ route("user.kyc.verify.basic.info.update") }}", data = $form.serialize();

			if (url && data) {
				NioApp.Form.nextStep({btn: $self, container: '#kyc-step-container'}, data, url);
			}
		});
	</script>
</div>
