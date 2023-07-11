@extends('admin.layouts.modules')
@section('title', __('Components') . ' / ' . __('Basic KYC'))

@section('content')
<div class="nk-content-body">
	<div class="nk-block-head nk-block-head-sm">
		<div class="nk-block-between">
			<div class="nk-block-head-content">
				<h3 class="nk-block-title page-title">{{ __('Components') }} / {{ __("Basic KYC") }}</h3>
				<p>{{ __('Manage KYC settings to manually verify your users identity.') }}</p>
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

	@if(!$compatibility)
		<div class="nk-block card card-bordered">
			<div class="card-inner">
				<div class="alert alert-danger bg-white py-2 px-3">
					<div class="alert-cta flex-wrap flex-md-nowrap g-2">
						<div class="alert-text has-icon">
							<em class="icon ni ni-swap-alt"></em>
							<p><strong>{{ __("Important") }}:</strong> {{ __("Please upgrade your main application to latest version and try out.") }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="nk-block card card-bordered">
			<div class="card-inner">
				@if(is_demo())
                    <div class="alert alert-danger alert-dim mb-4">
                        {!! 'All the additional <span class="badge badge-pill badge-dark">Module</span> and <span class="badge badge-pill badge-danger">Add-ons</span> are NOT part of main product. Please feel free to <strong><a class="alert-link" href="'. the_link('softn' . 'io' .'.com' .'/'. 'contact'). '" target="_blank">contact us</a></strong> for more information or to get those.' !!}
                    </div>
                @endif
				<form class="form-settings" action="{{ route('admin.settings.component.kyc.update') }}" method="POST">
					<h5 class="title">
						{{ __("Identity Verification") }} / {{ __("Basic KYC") }} 
						<span class="badge badge-pill badge-xs badge-gray ml-1 nk-tooltip"{!! (is_demo()) ? ' title="This add-on is NOT part of the main package."' : '' !!}>{{ 'Module' }}</span>
						@if ($outdated)
	                    <span class="meta ml-1">
	                        <span class="badge badge-pill badge-dim badge-xs badge-danger tipinfo" title="v{{ $outdated }} Version Required">{{ __('Outdated') }}</span>
	                    </span>
	                    @endif
					</h5>
					<p>{{ __("Allow your users to submit KYC application to verify their identity and manage applications internally.") }}</p>
					<div class="form-sets gy-3 wide-md">
						<div class="row g-3 align-center">
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-label" for="kyc-feature-enable">{{ __('KYC Verification System') }}</label>
									<span class="form-note">{{ __('Enable identity verification feature for user.') }}</span>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group">
									<div class="custom-control custom-switch">
										<input class="switch-option-value" type="hidden" name="feature_enable" value="{{ gss('kyc_feature_enable') ?? 'no' }}">
										<input id="kyc-feature-enable" type="checkbox" class="custom-control-input switch-option"
											data-switch="yes"{{ (gss('kyc_feature_enable', 'no') == 'yes') ? ' checked=""' : ''}}>
										<label for="kyc-feature-enable" class="custom-control-label">{{ __('Enable') }}</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="divider"></div>
					<div class="form-sets gy-3 wide-md">
						<div class="row g-3 align-start">
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-label">{{ __('Identity Verification') }}</label>
									<span class="form-note">{{ __('User allow to complete the identity verification form.') }}</span>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group">
									<div class="custom-control custom-switch">
										<input class="switch-option-value" type="hidden" name="verification" value="{{ gss('kyc_verification') ?? 'yes' }}">
										<input id="kyc-verification-enable" type="checkbox" class="custom-control-input switch-option"
										data-switch="yes"{{ (gss('kyc_verification', 'yes') == 'yes') ? ' checked=""' : ''}}>
										<label for="kyc-verification-enable" class="custom-control-label">{{ __('Enable') }}</label>
									</div>
									<div class="form-note mt-1 text-info">{{ __("It will promote user to complete their verification but it will be not required.") }}</div>
								</div>
							</div>
						</div>
						<div class="row g-3 align-start">
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-label">{{ __('Required Verification') }}</label>
									<span class="form-note">{{ __('Before proceed, identity verification will be required.') }}</span>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group">
									<div class="form-control-wrap">
										<ul class="custom-control-group gx-1 gy-3">
											<li>
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input checkbox-option" id="required-kyc-invest" name="verified[invest]"{{ (gss('kyc_verified') !== null && data_get(gss('kyc_verified'), 'invest') == 'on') ? ' checked' : '' }}>
													<label for="required-kyc-invest" class="custom-control-label">{{ __('Investment') }}</label>
												</div>
											</li>
											<li>
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input checkbox-option" id="required-kyc-withdraw" name="verified[withdraw]"{{ (gss('kyc_verified') !== null && data_get(gss('kyc_verified'), 'withdraw') == 'on') ? ' checked' : '' }}>
													<label for="required-kyc-withdraw" class="custom-control-label">{{ __('Withdraw') }}</label>
												</div>
											</li>
											<li>
												<div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input checkbox-option" id="required-kyc-deposit" name="verified[deposit]"{{ (gss('kyc_verified') !== null && data_get(gss('kyc_verified'), 'deposit') == 'on') ? ' checked' : '' }}>
													<label for="required-kyc-deposit" class="custom-control-label">{{ __('Deposit') }}</label>
												</div>
											</li>
											@if (module_exist('FundTransfer', 'mod'))
												<li>
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input checkbox-option" id="required-kyc-transfer" name="verified[transfer]"{{ (gss('kyc_verified') !== null && data_get(gss('kyc_verified'), 'transfer') == 'on') ? ' checked' : '' }}>
														<label for="required-kyc-transfer" class="custom-control-label">{{ __('Fund Transfer') }}</label>
													</div>
												</li>
											@endif
										</ul>
									</div>
									<div class="form-note text-danger">{{ __("User unable to proceed until verified their identity.") }}</div>
								</div>
							</div>
						</div>
						<div class="row g-3 align-center">
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-label" for="kyc-profile-lock">{{ __('Locked Profile Information') }}</label>
									<span class="form-note">{{ __('Profile data will be locked once submitted the document.') }}</span>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group">
									<div class="custom-control custom-switch">
										<input class="switch-option-value" type="hidden" name="profile_locked" value="{{ gss('kyc_profile_locked') ?? 'yes' }}">
										<input id="kyc-profile-lock" type="checkbox" class="custom-control-input switch-option"
										data-switch="yes"{{ (gss('kyc_profile_locked', 'yes') == 'yes') ? ' checked=""' : ''}}>
										<label for="kyc-profile-lock" class="custom-control-label">{{ __('Locked') }}</label>
									</div>
									<div class="form-note mt-1 text-info">{{ __("User will not allow to change the name, address, country, date of birth, gender etc.") }}</div>
								</div>
							</div>
						</div>
						<div class="row g-3 align-center">
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-label" for="kyc-complete-profile">{{ __('Complete Before Application') }}</label>
									<span class="form-note">{{ __('User must complete the profile before submit the document.') }}</span>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group">
									<div class="custom-control custom-switch">
										<input class="switch-option-value" type="hidden" name="profile_complete" value="{{ gss('kyc_profile_complete') ?? 'yes' }}">
										<input id="kyc-complete-profile" type="checkbox" class="custom-control-input switch-option"
											data-switch="yes"{{ (gss('kyc_profile_complete', 'yes') == 'yes') ? ' checked=""' : ''}}>
										<label for="kyc-complete-profile" class="custom-control-label">{{ __('Enable') }}</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row g-3 align-start">
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-label">{{ __("Disable New Submission") }}</label>
									<span class="form-note">{{ __("Temporarily disable new application submission.") }}</span>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group">
									<div class="custom-control custom-switch">
										<input class="switch-option-value" type="hidden" name="disable_request" value="{{ sys_settings('kyc_disable_request') ?? 'no' }}">
										<input id="kyc-app-disable" type="checkbox" class="custom-control-input switch-option" data-switch="yes"{{ (sys_settings('kyc_disable_request', 'no') == 'yes') ? ' checked=""' : ''}}>
										<label for="kyc-app-disable" class="custom-control-label">{{ __("Disable") }}</label>
									</div>
									<span class="form-note mt-1"><em class="text-danger">{{ __("Users unable to submit form for identity verification.") }}</em></span>
								</div>
							</div>
						</div>
						<div class="row g-3 align-start">
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-label">{{ __("Display Notice to User") }}</label>
									<span class="form-note">{{ __("Add custom message to show on user-end.") }}</span>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group">
									<div class="form-control-wrap">
										<input type="text" class="form-control" name="disable_title" value="{{ sys_settings('kyc_disable_title', 'Temporarily unavailable!') }}">
									</div>
								</div>
								<div class="form-group">
									<div class="form-control-wrap">
										<textarea class="form-control textarea-sm" name="disable_notice">{{ sys_settings('kyc_disable_notice') }}</textarea>
									</div>
									<div class="form-note">
										<span>{{ __("This message will display when user going to proceed for identity verification.") }}</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-sets gy-3 wide-md">
						<div class="row g-3">
							<div class="col-md-7 offset-lg-5">
								<div class="form-group mt-2">
									@csrf
									<input type="hidden" name="form_type" value="kyc-settings">
									<button type="button" class="btn btn-primary submit-settings" disabled="">
										<span class="spinner-border spinner-border-sm hide" role="status" aria-hidden="true"></span>
										<span>{{ __('Update') }}</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="nk-block card card-bordered">
			<div class="card-inner">
				<form class="form-settings" action="{{ route('admin.settings.component.kyc.update') }}" method="POST">
					<h5 class="title">{{ __('KYC Form Settings') }}</h5>
					<p>{{ __("Manage your KYC application form to submit documents.") }}</p>
					<div class="form-set gy-3 wide-md">
						<div class="row g-3 align-center">
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-label" for="kyc-profile-preview">{{ __('Preview Without Asking') }}</label>
									<span class="form-note">{{ __('Form will not display if already present the user information.') }}</span>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group">
									<div class="custom-control custom-switch">
										<input class="switch-option-value" type="hidden" name="preview_quick" value="{{ gss('kyc_preview_quick') ?? 'yes' }}">
										<input id="kyc-profile-preview" type="checkbox" class="custom-control-input switch-option"
											data-switch="yes"{{ (gss('kyc_preview_quick', 'yes') == 'yes') ? ' checked=""' : ''}}>
										<label for="kyc-profile-preview" class="custom-control-label">{{ __('Enable') }}</label>
									</div>
									<div class="form-note mt-1 text-info">
										{{ __("User allow update the info before submission.") }}
									</div>
								</div>
							</div>
						</div>
						<div class="row g-3 align-start">
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-label">{{ __("Fields for User Information") }}</label>
									<span class="form-note">{{ __("Select whatever you need for identity verification.") }}</span>
								</div>
							</div>
							<div class="col-md-7">
								@if(filled($profileFields))
								<ul class="custom-control-group gx-1 gy-2 flex-wrap flex-column">
									@foreach ($profileFields as $field => $options)
									<li class="input-group w-max-350px flex-wrap flex-sm-nowrap justify-between">
										<div class="input-label">{{ $options['label'] }}</div>
										<div class="input-fields">
											<ul class="gx-gs justify-between">
												<li>
													<div class="custom-control custom-control-sm custom-switch">
														<input class="switch-option-value" type="hidden" name="fields[profile][{{ $field }}][show]" value="{{ data_get(gss('kyc_fields'), 'profile.'.$field.'.show') ?? (data_get($options, 'default.show') ? 'yes' : 'no') }}">
														<input id="profile-{{ $field }}-show" type="checkbox" class="custom-control-input switch-option" data-switch="yes" {!! data_get(gss('kyc_fields'), 'profile.'.$field.'.show') == 'yes' ? 'checked=""' : '' !!}
														{!! data_get($options, 'default.disabled') ? 'disabled=""' : '' !!} >
														<label for="profile-{{ $field }}-show" class="custom-control-label">{{ __("Show") }}</label>
													</div>
												</li>
												<li>
													<div class="custom-control custom-control-sm custom-checkbox">
														<input class="switch-option-value" type="hidden" name="fields[profile][{{ $field }}][req]" value="{{ data_get(gss('kyc_fields'), 'profile.'.$field.'.req') ?? (data_get($options, 'default.required') ? 'yes' : 'no') }}">
														<input id="profile-{{ $field }}-req" type="checkbox" class="custom-control-input switch-option" data-switch="yes" {!! data_get(gss('kyc_fields'), 'profile.'.$field.'.req') == 'yes' ? 'checked=""' : '' !!}
														{!! data_get($options, 'default.disabled') ? 'disabled=""' : '' !!} >
														<label for="profile-{{ $field }}-req" class="custom-control-label">{{ __("Required") }}</label>
													</div>
												</li>
											</ul>
										</div>
									</li>
									@endforeach
								</ul>
								@endif
							</div>
						</div>
					</div>
					<div class="divider"></div>
					<div class="form-set gy-3 wide-md">
						<div class="row g-3 align-start">
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-label">{{ __("Document for Verification") }}</label>
									<span class="form-note">{{ __("Select document that user allow to upload for verification.") }}</span>
								</div>
							</div>
							<div class="col-md-7">
								@if(filled($mainDocs))
								<ul class="custom-control-group gx-1 gy-3 flex-wrap flex-column">
									@foreach ($mainDocs as $field => $opts)
									<li>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input checkbox-option" id="docs-main-{{ $field }}-show"
												name="docs[main][{{ $field }}]" {!! data_get(gss('kyc_docs'), 'main.'.$field) ? 'checked=""' : ''  !!}>
											<label for="docs-main-{{ $field }}-show" class="custom-control-label">{{ $opts['label'] }}</label>
										</div>
										<div class="form-note mt-1">
											{{ $opts['note'] }}
										</div>
									</li>
									@endforeach
								</ul>
								@endif
								<div class="form-note text-danger mt-2">{{ __("Note") }}: {{ __("User can upload only one document if multiple selected.") }}</div>

								<div class="form-group mt-3">
									<label class="form-label">{{ __("More options for document") }}</label>
									<div class="form-control-wrap">
										<ul class="custom-control-group gx-1 gy-2 flex-wrap flex-column">
											<li class="input-group w-max-350px flex-wrap flex-sm-nowrap justify-between">
												<div class="input-label">{{ __("Issued by Country") }}</div>
												<div class="input-fields">
													<ul class="gx-gs justify-between">
														<li>
															<div class="custom-control custom-control-sm custom-switch">
																<input type="hidden" class="switch-option-value" name="docs[field][country][show]" value="on">
																<input id="docs-field-country-show" type="checkbox" class="custom-control-input switch-option" checked="" disabled>
																<label for="docs-field-country-show" class="custom-control-label">{{ __("Show") }}</label>
															</div>
														</li>
														<li>
															<div class="custom-control custom-control-sm custom-checkbox">
																<input type="hidden" class="switch-option-value" name="docs[field][country][req]" value="on">
																<input id="docs-field-country-req" type="checkbox" class="custom-control-input switch-option" name="docs[field][country][req]" checked="" disabled>
																<label for="docs-field-country-req" class="custom-control-label">{{ __("Required") }}</label>
															</div>
														</li>
													</ul>
												</div>
											</li>
											<li class="input-group w-max-350px flex-wrap flex-sm-nowrap justify-between">
												<div class="input-label">{{ __("ID Number") }}</div>
												<div class="input-fields">
													<ul class="gx-gs justify-between">
														<li>
															<div class="custom-control custom-control-sm custom-switch">
																<input id="docs-field-id-show" type="checkbox" class="custom-control-input switch-option" name="docs[field][id][show]" {!! data_get(gss('kyc_docs'), 'field.id.show') ? 'checked=""' : ''  !!}>
																<label for="docs-field-id-show" class="custom-control-label">{{ __("Show") }}</label>
															</div>
														</li>
														<li>
															<div class="custom-control custom-control-sm custom-checkbox">
																<input id="docs-field-id-req" type="checkbox" class="custom-control-input switch-option" name="docs[field][id][req]" {!! data_get(gss('kyc_docs'), 'field.id.req') ? 'checked=""' : ''  !!}>
																<label for="docs-field-id-req" class="custom-control-label">{{ __("Required") }}</label>
															</div>
														</li>
													</ul>
												</div>
											</li>
											<li class="input-group w-max-350px flex-wrap flex-sm-nowrap justify-between">
												<div class="input-label">{{ __("Issue Date") }}</div>
												<div class="input-fields">
													<ul class="gx-gs justify-between">
														<li>
															<div class="custom-control custom-control-sm custom-switch">
																<input id="docs-field-issue-show" type="checkbox" class="custom-control-input switch-option" name="docs[field][issue][show]" {!! data_get(gss('kyc_docs'), 'field.issue.show') ? 'checked=""' : ''  !!}>
																<label for="docs-field-issue-show" class="custom-control-label">{{ __("Show") }}</label>
															</div>
														</li>
														<li>
															<div class="custom-control custom-control-sm custom-checkbox">
																<input id="docs-field-issue-req" type="checkbox" class="custom-control-input switch-option" name="docs[field][issue][req]" {!! data_get(gss('kyc_docs'), 'field.issue.req') ? 'checked=""' : ''  !!}>
																<label for="docs-field-issue-req" class="custom-control-label">{{ __("Required") }}</label>
															</div>
														</li>
													</ul>
												</div>
											</li>
											<li class="input-group w-max-350px flex-wrap flex-sm-nowrap justify-between">
												<div class="input-label">{{ __("Expiry Date") }}</div>
												<div class="input-fields">
													<ul class="gx-gs justify-between">
														<li>
															<div class="custom-control custom-control-sm custom-switch">
																<input id="docs-field-expiry-show" type="checkbox" class="custom-control-input switch-option" name="docs[field][expiry][show]" {!! data_get(gss('kyc_docs'), 'field.expiry.show') ? 'checked=""' : ''  !!}>
																<label for="docs-field-expiry-show" class="custom-control-label">{{ __("Show") }}</label>
															</div>
														</li>
														<li>
															<div class="custom-control custom-control-sm custom-checkbox">
																<input id="docs-field-expiry-req" type="checkbox" class="custom-control-input switch-option" name="docs[field][expiry][req]" {!! data_get(gss('kyc_docs'), 'field.expiry.req') ? 'checked=""' : ''  !!}>
																<label for="docs-field-expiry-req" class="custom-control-label">{{ __("Required") }}</label>
															</div>
														</li>
													</ul>
												</div>
											</li>
										</ul>
									</div>
									<span class="form-note">{{ __("User allow to input their document information.") }}</span>
								</div>

							</div>
						</div>

						<div class="row g-3 align-start">
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-label">{{ __("Upload Selfie for Proof") }}</label>
									<span class="form-note">{{ __("Select if user need to upload selfie for proof.") }}</span>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group">
									<div class="custom-control custom-switch">
										<input class="switch-option-value" type="hidden" name="doc_selfie" value="{{ gss('kyc_doc_selfie') ?? 'yes' }}">
										<input id="kyc-doc-selfie" type="checkbox" class="custom-control-input switch-option"
											data-switch="yes"{{ (gss('kyc_doc_selfie', 'yes') == 'yes') ? ' checked=""' : ''}}>
										<label for="kyc-doc-selfie" class="custom-control-label">{{ __('Enable') }}</label>
									</div>
									<div class="form-note mt-1 text-info">
										{{ __("If Enable, Selfie with document will be required.") }}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="divider"></div>
					<div class="form-sets gy-3 wide-md">
						<div class="row g-3 align-start">
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-label">{{ __("Additional Documents") }}</label>
									<span class="form-note">{{ __("Select if you need additionally for verification.") }}</span>
								</div>
							</div>
							<div class="col-md-7">
								@if(filled($additionalDocs))
								<ul class="custom-control-group gx-1 gy-3 flex-wrap flex-column">
									@foreach ($additionalDocs as $field => $opts)
									<li>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input checkbox-option" id="docs-alter-{{ $field }}-show"
												name="docs[alter][{{ $field }}]" {!! data_get(gss('kyc_docs'), 'alter.'.$field) ? 'checked=""' : ''  !!}>
											<label for="docs-alter-{{ $field }}-show" class="custom-control-label">{{ $opts['label'] }}</label>
										</div>
										<div class="form-note mt-1">
											{{ $opts['note'] }}
										</div>
									</li>
									@endforeach
								</ul>
								@endif
								<div class="form-group mt-3">
									<label class="form-label">{{ __("More options for document") }}</label>
									<div class="form-control-wrap">
										<div class="custom-control custom-control-sm custom-switch">
											<input type="checkbox" class="custom-control-input switch-option" id="docs-alter-required-opt"
												name="docs[alter][required]" {!! data_get(gss('kyc_docs'), 'alter.required') ? 'checked=""' : ''  !!}>
											<label for="docs-alter-required-opt" class="custom-control-label">{{ __("Both Require to Upload") }}</label>
										</div>
									</div>
									<div class="form-note text-danger">{{ __("Note") }}: {{ __("By default one will be required if both enabled.") }}</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-sets gy-3 wide-md">
						<div class="row g-3">
							<div class="col-md-7 offset-lg-5">
								<div class="form-group mt-2">
									@csrf
									<input type="hidden" name="form_type" value="kyc-form-settings">
									<button type="button" class="btn btn-primary submit-settings" disabled="">
										<span class="spinner-border spinner-border-sm hide" role="status" aria-hidden="true"></span>
										<span>{{ __('Update') }}</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	@endif
</div>
@endsection
