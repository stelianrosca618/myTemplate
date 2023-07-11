@php 
	$setting = gss("kyc_docs");
	$docs = data_get($setting, 'alter');
@endphp

<div class="nk-block-head nk-block-head-lg wide-xs mx-auto">
	<div class="nk-pps-steps">
		<span class="step"></span>
		<span class="step"></span>
		<span class="step"></span>
		<span class="step active"></span>
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
					<div class="nk-kycfm-text mb-3">
						<h5 class="title mb-1">{{ __("Proof of Address") }}</h5>
						<p class="text-soft">
							{{ __("Please provide document for address verification.") }}
							@if ($bothRequire)
								<br class="d-none d-sm-inline">{{ __("You have to submit both documents to complete verification.") }}
							@elseif (data_get($docs, 'ub') == 'on' && data_get($docs, 'bs') == 'on')
								<br class="d-none d-sm-inline">{{ __("You can submit both or at-least one document for verification.") }}
							@endif
						</p>

						<p class="fw-medium text-head mt-3 mb-1">{{ __("To avoid delays when verifying account, please make sure bellow:") }}</p>
						<ul class="list list-sm list-checked">
							<li>{{ __("Make sure your provided address match with document.") }}</li>
							<li>{{ __("Document should be good condition and clearly visible.") }}</li>
							<li>{{ __("Make sure that there is no light glare on the image.") }}</li>
						</ul>
						<input type="hidden" name="identity" value="{{ $session ? the_hash($session) : '' }}">
					</div>
					<div class="row g-3">
						@if (data_get($docs, 'bs') == 'on')
						<div class="col-{{ (data_get($docs, 'bs') == 'on' && data_get($docs, 'ub') == 'on') ? '6' : '12' }}">
							<div class="form-group">
								<label class="form-label">{{ __("Bank Statement Copy") }}</label>
								<div class="upload-zone" id="upload-bsmt" data-doc="bs">
									<div class="dz-message">
										<span class="dz-message-text">{{ __("Drag and drop file") }}</span>
										<span class="dz-message-or">{{ __("or") }}</span>
										<button type="button" class="btn btn-sm btn-light">{{ __("Select") }}</button>
									</div>
								</div>
								<input id="bs-doc" type="hidden" name="bs">
							</div>
						</div>
						@endif
						@if (data_get($docs, 'ub') == 'on')
						<div class="col-{{ (data_get($docs, 'bs') == 'on' && data_get($docs, 'ub') == 'on') ? '6' : '12' }}">
							<div class="form-group">
								<label class="form-label">{{ __("Utility Bill Copy") }}</label>
								<div class="upload-zone" id="upload-ubill" data-doc="ub">
									<div class="dz-message">
										<span class="dz-message-text">{{ __("Drag and drop file") }}</span>
										<span class="dz-message-or">{{ __("or") }}</span>
										<button type="button" class="btn btn-sm btn-light">{{ __("Select") }}</button>
									</div>
								</div>
								<input id="ub-doc" type="hidden" name="ub">
							</div>
						</div>
						@endif
					</div>
					<div class="nk-kycfm-note mt-2">
						<em class="icon ni ni-info"></em>
						<p>{{ __("Upload upto 5MB image size and accepted format: JPG, PNG.") }}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="nk-kyc-app-action mt-4">
			<a class="btn btn-lg btn-wider btn-primary kyc-step-dpu" data-action="upload"><span>{{ __("Submit & Continue") }}</span></a>
			<a href="javascript:void(0)" class="link link-primary link-btn btn-block mt-2 kyc-step-dpu" data-action="back"><span>{{ __("Back to Previous") }}</span></a>
		</div>
	</form>
</div>
<script>
	var doc1 = NioApp.Uploader('#upload-bsmt', vroutes['upload']), doc2 = NioApp.Uploader('#upload-ubill', vroutes['upload']), doc1i = {{ (data_get($docs, 'bs') == 'on') ? 1 : 0 }}, doc2i = {{ (data_get($docs, 'ub') == 'on') ? 1 : 0 }}, docReq = {{ $bothRequire ? 1 : 0 }};

	$('.kyc-step-dpu').on('click', function (e) {
		e.preventDefault();

		var $self = $(this), $form = $self.closest('form'), action = $self.data('action'), uploaded = true;
		var url = (action == 'upload') ? "{{ route("user.kyc.verify.additional.upload") }}" : "{{ route('user.kyc.verify.documents') }}";
		var data = (action == 'upload') ? $form.serialize() : {confirm: true, method: action, step: 'proof'};

		if (action == 'back') {
			if (doc1) { doc1.destroy() }
			if (doc2) { doc2.destroy() }
		}
		if (url && data) {
			NioApp.Form.nextStep({btn: $self, container: '#kyc-step-container'}, data, url);
		}
	});
</script>
