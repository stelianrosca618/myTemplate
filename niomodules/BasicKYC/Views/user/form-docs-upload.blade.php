<div class="nk-block-head nk-block-head-lg wide-xs mx-auto">
	<div class="nk-pps-steps">
		<span class="step"></span>
		<span class="step"></span>
		<span class="step active"></span>
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
	<form method="POST" class="form-validate is-alter" enctype="multipart/form-data">
		<div class="nk-kyc-app card card-bordered">
			<div class="nk-kycfm">
				<div class="nk-kycfm-content">
					<div class="nk-kycfm-text mb-3">
						<h5 class="title mb-1">{{ __("Upload Document") }}</h5>
						<p class="text-soft">{!! __("To verify, please upload a copy of your :document.", ['document' => '<strong class="text-base">'. __($document) .'</strong>']) !!}</p>

						<p class="fw-medium text-head mt-3 mb-1">{{ __("To avoid delays when verifying account, please make sure bellow:") }}</p>
						<ul class="list list-sm list-checked">
							<li>{{ __("Document should be good condition and clearly visible.") }}</li>
							<li>{{ __("Make sure that there is no light glare on the image.") }}</li>
						</ul>
						<input type="hidden" name="identity" value="{{ $session ? the_hash($session) : '' }}">
						<input type="hidden" name="docstype" value="{{ $doc }}">
					</div>
					<div class="row g-3">
						@if ($doc == "pp")
							<div class="col-md-12">
								<div class="form-group">
									<label class="form-label">{{ __(":Document Copy", ['document' => __($document)]) }}</label>
									<div class="upload-zone" id="upload-main" data-doc="main">
										<div class="dz-message">
											<span class="dz-message-text">{{ __("Drag and drop file") }}</span>
											<span class="dz-message-or">{{ __("or") }}</span>
											<button type="button" class="btn btn-sm btn-light">{{ __("Select") }}</button>
										</div>
									</div>
									<input id="main-doc" type="hidden" name="main">
								</div>
							</div>
						@endif
						@if ($doc == "nid" || $doc == "dvl")
							<div class="col-12">
								<label class="form-label">{{ __(":Document Copy", ['document' => __($document)]) }}</label>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<div class="upload-zone" id="upload-main" data-doc="front">
												<div class="dz-message">
													<span class="dz-message-text">{{ __("Drag and drop file") }}</span>
													<span class="dz-message-or">{{ __("or") }}</span>
													<button type="button" class="btn btn-sm btn-light">{{ __("Select") }}</button>
												</div>
											</div>
											<div class="pt-1 font-italic">{{ __("Front Side") }}</div>
											<input id="front-doc" type="hidden" name="front">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<div class="upload-zone" id="upload-back" data-doc="back">
												<div class="dz-message">
													<span class="dz-message-text">{{ __("Drag and drop file") }}</span>
													<span class="dz-message-or">{{ __("or") }}</span>
													<button type="button" class="btn btn-sm btn-light">{{ __("Select") }}</button>
												</div>
											</div>
											<div class="pt-1 font-italic">{{ __("Back Side") }}</div>
											<input id="back-doc" type="hidden" name="back">
										</div>
									</div>
								</div>
							</div>
						@endif
						@if (gss('kyc_doc_selfie', 'no') == 'yes')
							<div class="col-12">
								<div class="form-group">
									<label class="form-label">{{ __("Selfie with :document", ['document' => __($document)]) }}</label>
									<div class="upload-zone" id="upload-proof" data-doc="proof">
										<div class="dz-message">
											<span class="dz-message-text">{{ __("Drag and drop file") }}</span>
											<span class="dz-message-or">{{ __("or") }}</span>
											<button type="button" class="btn btn-sm btn-light">{{ __("Select") }}</button>
										</div>
									</div>
									<input id="proof-doc" type="hidden" name="proof">
								</div>
							</div>
						@endif
					</div>
					<div class="nk-kycfm-note mt-3">
						<em class="icon ni ni-info"></em>
						<p>{{ __("Upload upto 5MB image size and accepted format: JPG, PNG.") }}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="nk-kyc-app-action mt-4">
			<a class="btn btn-lg btn-wider btn-primary kyc-step-dcu" data-action="upload"><span>{{ __("Submit & Continue") }}</span></a>
			<a href="javascript:void(0)" class="link link-primary link-btn btn-block mt-2 kyc-step-dcu" data-action="back"><span>{{ __("Back to Previous") }}</span></a>
		</div>
	</form>

</div>
<script>
	var doc1 = NioApp.Uploader('#upload-main', vroutes['upload']), doc2 = NioApp.Uploader('#upload-back', vroutes['upload']), 
		doc3 = NioApp.Uploader('#upload-proof', vroutes['upload']), doc2i = {{ ($doc != 'pp') ? 1 : 0 }}, doc3i = {{ (gss('kyc_doc_selfie', 'no') == 'yes') ? 1 : 0 }};

	$('.kyc-step-dcu').on('click', function (e) {
		e.preventDefault();

		var $self = $(this), $form = $self.closest('form'), action = $self.data('action'), uploaded = true;
		var url = (action == 'upload') ? "{{ route("user.kyc.verify.documents.upload") }}" : "{{ route('user.kyc.verify.documents') }}";
		var data = (action == 'upload') ? $form.serialize() : {confirm: true, method: action, step: 'docs'};

		if (action == 'back') {
			if (doc1) { doc1.destroy() }
			if (doc2) { doc2.destroy() }
			if (doc3) { doc3.destroy() }
		}
		if (url && data) {
			NioApp.Form.nextStep({btn: $self, container: '#kyc-step-container'}, data, url);
		}
	});
</script>
