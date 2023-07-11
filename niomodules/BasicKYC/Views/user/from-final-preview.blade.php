@php
    $setting = data_get(gss("kyc_fields"), 'profile');
    $dir = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, 'kyc-temp/');
@endphp

<div class="nk-block-head nk-block-head-lg wide-xs mx-auto">
    <div class="nk-pps-steps">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        @if (!empty(data_get(gss('kyc_docs'), 'alter')))
            <span class="step"></span>
        @endif
        <span class="step active"></span>
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
                <h6 class="title mb-1">{{ __('Basic Information') }}</h6>
                <table class="table table-plain table-mbs table-middle">
                    <tbody>
                    <tr>
                        <td width="160" class="text-soft">{{ __('Full Name') }}</td>
                        <td>{{ data_get($data, 'profile.name') }}</td>
                    </tr>

                    @if (data_get($setting, "phone.show") == "yes" && data_get($data, 'profile.phone'))
                    <tr>
                        <td class="text-soft">{{ __('Phone') }}</td>
                        <td>{{ data_get($data, 'profile.phone') }}</td>
                    </tr>
                    @endif

                    @if (data_get($setting, "dob.show") == "yes" && data_get($data, 'profile.dob'))
                    <tr>
                        <td class="text-soft">{{ __("Date of Birth") }}</td>
                        <td>{{ show_dob(data_get($data, 'profile.dob')) }}</td>
                    </tr>
                    @endif

                    @if (data_get($setting, "gender.show") == "yes" && data_get($data, 'profile.gender'))
                    <tr>
                        <td class="text-soft">{{ __("Gender") }}</td>
                        <td>{{ __(ucfirst(data_get($data, 'profile.gender'))) }}</td>
                    </tr>
                    @endif

                    @if (data_get($setting, "nationality.show") == "yes" && data_get($data, 'profile.nationality'))
                    <tr>
                        <td class="text-soft">{{ __("Nationality") }}</td>
                        <td>{{ data_get($data, 'profile.nationality') }}</td>
                    </tr>
                    @endif

                    <tr>
                        <td class="text-soft">{{ __("Country of Residence") }}</td>
                        <td>{{ data_get($data, 'profile.country') }}</td>
                    </tr>

                    @if (data_get($setting, "address.show") == "yes")
                    <tr>
                        <td class="text-soft">{{ __('Address') }}</td>
                        <td>{{ address_lines(data_get($data, 'profile')) }}</td>
                    </tr>
                    @endif
                    </tbody>
                </table>

                <h6 class="title mt-2 mb-1">{{ __('Uploaded Documents') }}</h6>
                <table class="table table-plain table-borderless table-mbs table-middle">
                    <tbody>
                        @if (!blank($main) && !empty(data_get($main, 'files', [])) && data_get($data, 'docs.main') == data_get($main, 'type'))
                        <tr>
                            @php 
                                $files = data_get($main, 'files', []); 
                                $count = count($files);
                                $document = short_to_docs(data_get($main, 'type'));
                            @endphp

                            @foreach ($files as $part => $file)
                                <td width="33.3%">
                                    <div class="nk-gg">
                                        <div class="nk-gg-item">
                                            <div class="nk-gg-media">
                                                <img src="{{ preview_media($dir . $file) }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    @if ($part == 'main')
                                        <span class="text-soft small">{{ __(":Document", ['document' => $document]) }}</span>
                                    @elseif ($part == 'proof')
                                        <span class="text-soft small">{{ __('Proof / Selfie')  }}</span>
                                    @else 
                                        <span class="text-soft small">
                                            {{ __(":Document / :Part", ['part' => __($part), 'document' => $document]) }}
                                        </span>
                                    @endif
                                </td>
                            @endforeach

                            @if($count == 1 || $count == 2)
                                <td colspan="{{ $count }}"></td>
                            @endif
                        </tr>
                        @endif

                        @if (!empty(data_get($bs, 'files.main')) || !empty(data_get($ub, 'files.main')))
                        <tr>
                            @if (!empty(data_get($bs, 'files.main')) && in_array('bs', data_get($data, 'docs.proof')))
                            <td>
                                <div class="nk-gg">
                                    <div class="nk-gg-item">
                                        <div class="nk-gg-media">
                                            <img src="{{ preview_media($dir . data_get($bs, 'files.main')) }}" alt="">
                                        </div>
                                    </div>
                                </div>
                                <span class="text-soft small">{{ __("Bank Statement") }}</span>
                            </td>
                            @endif

                            @if (!empty(data_get($ub, 'files.main')) && in_array('ub', data_get($data, 'docs.proof')))
                            <td>
                                <div class="nk-gg">
                                    <div class="nk-gg-item">
                                        <div class="nk-gg-media">
                                            <img src="{{ preview_media($dir . data_get($ub, 'files.main')) }}" alt="">
                                        </div>
                                    </div>
                                </div>
                                <span class="text-soft small">{{ __("Utility Bill") }}</span>
                            </td>
                            @endif

                            @if (empty(in_array('bs', data_get($data, 'docs.proof'))) || empty(in_array('ub', data_get($data, 'docs.proof'))))
                                <td colspan="2"></td>
                            @endif
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="nk-kycfm-note mt-3">
                    <em class="icon ni ni-info"></em>
                    <p>{{ __('You have agreed our terms and & conditions once you submit the application for verification.') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="nk-kyc-app-action mt-4">
        <a href="javascript:void(0)" class="btn btn-lg btn-wider btn-primary" id="submit-application"><span>{{ __('Submit for Verification') }}</span></a>
        <a href="{{ route('user.kyc.cancel.application') }}" class="link link-danger link-btn btn-block mt-2"><span>{{ __('Cancel & Return') }}</span></a>
    </div>
</div>

<script type="text/javascript">
    $('#submit-application').on('click', function (e) {
        e.preventDefault();
        let $self = $(this), url = "{{ route('user.kyc.submit.application') }}";
        NioApp.Form.nextStep({btn: $self, container: '#kyc-step-container'}, {identity: "{{ $session ? the_hash($session) : '' }}", confirm: true, method: 'submit'}, url);
    });
</script>
