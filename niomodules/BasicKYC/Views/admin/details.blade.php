@php
    use NioModules\BasicKYC\Helpers\KycStatus;
    use NioModules\BasicKYC\Helpers\KycDocStatus;
    use NioModules\BasicKYC\Helpers\KycSessionStatus;

    $dir = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, 'kyc/');
    $review = ($data->status == KycSessionStatus::COMPLETED) ? true : false;
@endphp

@extends('admin.layouts.master')
@section('title', __('Verification Center'))

@section('content')
<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between-md g-3">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">
                    {{ __("KYC") }} / 
                    <span class="text-grey fw-normal">{{ strtoupper(str_compact(str_replace('-', '', $data->session), '', 8)) }}</span>
                </h3>
                <div class="nk-block-des text-soft">
                    <ul class="list-inline">
                        <li>
                            <span class="badge badge-xs{{ the_state($data->status, ['prefix' => 'badge']) }}">
                            {{ ($data->status == KycSessionStatus::COMPLETED) ? __("Pending") : __(ucfirst(to_past($data->status))) }}
                            </span>
                        </li>
                        <li>{{ __('KYC') }}: <span class="text-base">{{ $data->kyc->user_reference }}</span></li>
                        <li>{{ __('User') }}: <span class="text-base">{{ $data->user->name . ' / ' .the_uid($data->user_id) }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools gx-1">
                    @if ($data->status == KycSessionStatus::COMPLETED)
                    <li class="order-md-last">
                        <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#approve-entry{{ $data->id }}"><em class="icon ni ni-check"></em> <span>{{ __("Approve") }}</span></a>
                    </li>
                    <li class="order-md-last">
                        <a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal" data-target="#reject-entry{{ $data->id }}"><em class="icon ni ni-cross"></em> <span>{{ __("Reject") }}</span></a>
                    </li>
                    @endif
                    @if (data_get($data, 'kyc.status') === KycStatus::REJECTED)
                    <li class="order-md-last">
                        <a href="javascript:void(0)" class="btn btn-secondary kyc-update" data-action="resubmit"><span>{{ __("Request for Resubmission") }}</span></a>
                    </li>
                    @endif
                    <li class="order-md-first ml-auto">
                        <a href="{{ (url()->previous() && (url()->previous() != url()->current())) ? url()->previous() : route("admin.kyc.list", "all") }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                            <em class="icon ni ni-arrow-left"></em>
                            <span>{{ __('Back') }}</span>
                        </a>
                        <a href="{{ (url()->previous() && (url()->previous() != url()->current())) ? url()->previous() : route("admin.kyc.list", "all") }}" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none">
                            <em class="icon ni ni-arrow-left"></em>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="nk-block">
        <div class="row gy-gs">
            <div class="col-xxl-5">
                <div class="card card-bordered card-stretch card-full">
                    <ul class="data-list is-compact">
                        <li class="data-item">
                            <h6 class="card-title">{{ __("Application Info") }}</h6>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">{{ __("Session ID") }}</div>
                                <div class="data-value">{{ $data->session }}</div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">{{ __("Submitted By") }}</div>
                                <div class="data-value">{{ the_uid($data->user_id) }}</div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">{{ __("Submitted At") }}</div>
                                <div class="data-value">{{ show_date($data->created_at, true) }}</div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">{{ __("Checked At") }}</div>
                                <div class="data-value">
                                    {{ data_get($data, 'checked_at') ? show_date(data_get($data, 'checked_at'), true) : __("Not checked yet") }}
                                </div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">{{ __("Checked By") }}</div>
                                <div class="data-value">
                                    @if (data_get($data, 'checked_by'))
                                        {{ data_get($data, 'checked_by.name') }} <span class="text-soft small">({{ is_admin() ? __('Admin') : '' }})</span>
                                    @else
                                        {{ __("Not checked yet") }}
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <span class="lead-text fw-medium">{{ __("Submission Information") }}</span>
                            </div>
                            <div class="data-value justify-end">
                                <a class="link link-sm" href="{{ route('admin.users.details', ['id' => $data->user->id, 'type' => 'personal']) }}" target="_blank">{{ __("View Profile") }}</a>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">{{ __("Full Name") }}</div>
                                <div class="data-value">
                                    {{ data_get($data, 'profile.name') ? data_get($data, 'profile.name') : __('Not given by user') }}
                                    @if ($review && data_get($data, 'profile.name') != $data->user->name)
                                        <em class="ml-1 ni ni-alert-fill fs-12px text-primary" data-toggle="tooltip" title="{{ $data->user->name }}"></em>
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">{{ __("Mobile Number") }}</div>
                                <div class="data-value">
                                    {{ data_get($data, 'profile.phone') ? data_get($data, 'profile.phone') : __('Not given by user') }}
                                    @if ($review && data_get($data, 'profile.phone') != $data->user->meta('profile_phone'))
                                        @if ($data->user->meta('profile_phone'))
                                            <em class="ml-1 ni ni-alert-fill fs-12px text-primary nk-tooltip" title="{{ $data->user->meta('profile_phone') }}"></em>
                                        @else
                                            <em class="ml-1 ni ni-info fs-12px text-grey nk-tooltip" title="{{ __("Not added yet") }}"></em>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">{{ __("Date of Birth") }}</div>
                                <div class="data-value">
                                    {{ data_get($data, 'profile.dob') ? show_dob(data_get($data, 'profile.dob')) : __('Not given by user') }}
                                    @if ($review && data_get($data, 'profile.dob') != $data->user->meta('profile_dob'))
                                        @if ($data->user->meta('profile_dob'))
                                            <em class="ml-1 ni ni-alert-fill fs-12px text-primary nk-tooltip" title="{{ show_dob($data->user->meta('profile_dob')) }}"></em>
                                        @else
                                            <em class="ml-1 ni ni-info fs-12px text-grey nk-tooltip" title="{{ __("Not added yet") }}"></em>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">{{ __("Gender") }}</div>
                                <div class="data-value">
                                    {{ data_get($data, 'profile.gender') ? __(ucfirst(data_get($data, 'profile.gender'))) : __('Not given by user') }}
                                    @if ($review && data_get($data, 'profile.gender') != $data->user->meta('profile_gender'))
                                        @if ($data->user->meta('profile_gender'))
                                        <em class="ml-1 ni ni-alert-fill fs-12px text-primary nk-tooltip" title="{{ $data->user->meta('profile_gender') }}"></em>
                                        @else
                                        <em class="ml-1 ni ni-info fs-12px text-grey nk-tooltip" title="{{ __("Not added yet") }}"></em>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">{{ __("Nationality") }}</div>
                                <div class="data-value">
                                    {{ data_get($data, 'profile.nationality') ? data_get($data, 'profile.nationality') : __('Not given by user') }}
                                    @php 
                                        $nationality = ($data->user->meta('profile_nationality') == 'same') ? $data->user->meta('profile_country') : $data->user->meta('profile_nationality');
                                    @endphp
                                    @if ($review && data_get($data, 'profile.nationality') != $nationality)
                                        @if ($nationality)
                                        <em class="ml-1 ni ni-alert-fill fs-12px text-primary nk-tooltip" title="{{ $nationality }}"></em>
                                        @else
                                        <em class="ml-1 ni ni-info fs-12px text-grey nk-tooltip" title="{{ __("Not added yet") }}"></em>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">{{ __("Country") }}</div>
                                <div class="data-value">
                                    {{  data_get($data, 'profile.country') ? data_get($data, 'profile.country') : __('Not given by user') }}
                                    @if ($review && data_get($data, 'profile.country') != $data->user->meta('profile_country'))
                                        @if ($data->user->meta('profile_country'))
                                        <em class="ml-1 ni ni-alert-fill fs-12px text-primary nk-tooltip" title="{{ $data->user->meta('profile_country') }}"></em>
                                        @else
                                        <em class="ml-1 ni ni-info fs-12px text-grey nk-tooltip" title="{{ __("Not added yet") }}"></em>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">{{ __("Address") }}</div>
                                <div class="data-value">
                                    {{ (address_lines(data_get($data, 'profile'))) ? address_lines(data_get($data, 'profile')) : __('Not given by user') }}
                                    @if ($review && !empty(address_lines($data->user->meta('addresses'))))
                                        <em class="ml-1 ni ni-alert-fill fs-12px text-dark nk-tooltip" title="{{ address_lines($data->user->meta('addresses')) }}"></em>
                                    @endif
                                </div>
                            </div>
                        </li>
                        @if (in_array($data->status, [KycSessionStatus::COMPLETED]))
                        <li class="data-item">
                            <div class="data-col">
                                <p class="small text-soft">{{ __("Caution: Above information will be updated into user profile once you verified. And also user unable to edit mandatory details such as name, dob, address etc.") }}</p>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-xxl-7">
                <div class="card card-bordered card-stretch card-full">
                    <ul class="data-list is-compact">
                        <li class="data-item">
                            <h6 class="card-title">{{ __("Documents for Verification") }}</h6>
                        </li>
                        <li class="data-item">
                            <div class="data-col">
                                <div class="data-label">{{ __("Main Document") }}</div>
                                <div class="data-value">{{ short_to_docs($data->main_doc_type) }}</div>
                            </div>
                        </li>
                        @if (!empty($data->main_doc_meta))
                            @foreach($data->main_doc_meta as $meta => $value)
                                @if(!empty($value))
                                <li class="data-item">
                                    <div class="data-col">
                                        <div class="data-label">
                                            @if ($meta == 'country')
                                                {{ __("Issued by Country") }}
                                            @elseif ($meta == 'number')
                                                {{ __("ID Number") }}
                                            @elseif ($meta == 'issue')
                                                {{ __("Issue Date") }}
                                            @elseif ($meta == 'expiry')
                                                {{ __("Expiry Date") }}
                                            @else
                                                {{ __(ucfirst($meta)) }}
                                            @endif
                                        </div>
                                        <div class="data-value">{{ $value }}</div>
                                    </div>
                                </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                    <div class="divider md mt-0"></div>
                    <div class="card-inner pt-0">
                        <div class="title mb-2">
                            <span class="lead-text fw-medium">{{ __("Uploaded Document") }}</span>
                        </div>
                        @if (!blank($documents))
                            <div class="row g-gs">
                            @foreach ($documents as $doc)
                                @if (!empty(data_get($doc, 'files', [])) && $data->in_docs($doc->type))
                                    @foreach (data_get($doc, 'files') as $part => $file)
                                    <div class="col-4">
                                        <div class="card card-bordered">
                                            <div class="card-inner p-2">
                                                <div class="card-media overflow-hidden round mb-2">
                                                    <div class="nk-gg">
                                                        <div class="nk-gg-item w-100 h-150px m-0 p-0 border-0">
                                                            <div class="nk-gg-media w-100 h-150px">
                                                                <img src="{{ preview_media($dir . $file) }}" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        @if ($part == 'main')
                                                            <span class="fw-medium">{{ __(":Document", ['document' => __(short_to_docs($doc->type))]) }}</span>
                                                        @elseif ($part == 'proof')
                                                            <span class="fw-medium">{{ __('Proof / Selfie')  }}</span>
                                                        @else 
                                                            <span class="fw-medium">
                                                                {{ __(":Document / :Part", ['part' => __($part), 'document' => __(short_to_docs($doc->type))]) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <ul class="list-inline">
                                                        <li><a target="_blank" href="{{ route('admin.kyc.download', ['file' => the_hash($doc->id), 'part' => $part]) }}"><em class="icon ni ni-download"></em></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            @endforeach
                            </div>
                        @else
                            <div class="py-1 font-italic">
                                {{ __("No uploaded document found!") }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modal')
    @if (in_array($data->status, [KycSessionStatus::COMPLETED]))
    <div class="modal fade" role="dialog" id="approve-entry{{ $data->id }}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <a href="javascript:void(0)" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body">
                    <div class="row gy-3">
                        <div class="col-md-12">
                            <h5 class="title mb-2">{{ __('Approve Submission') }}</h5>
                            <p>{{ __("Please review all the documents before take any action.") }}</p>
                        </div>
                        <div class="col-md-12">
                            <table class="table table-plain table-borderless table-sm mb-0">
                                <th>{{ __("Uploaded Document") }}</th>
                                <th></th>
                                @if (!blank($documents))
                                    @foreach ($documents as $doc)
                                    <tr>
                                        <td><span class="sub-text">{{ __(short_to_docs($doc->type)) }}</span></td>
                                        <td>
                                            <span class="sub-text">
                                                @if (in_array($doc->state, [KycDocStatus::VALID, KycDocStatus::INVALID]))
                                                    {{ ($doc->state == KycDocStatus::VALID) ? __("Approved") : __("Rejected") }}
                                                @else
                                                    {{ __("New") }}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                    <ul class="align-center flex-nowrap gx-2 pt-2 mt-2">
                        <li>
                            <a href="#" class="btn btn-primary kyc-update" data-action="verify"><span>{{ __("Confirm & Verified") }}</span></a>
                        </li>
                        <li>
                            <button data-dismiss="modal" type="button" class="btn btn-trans btn-light">{{ __('Cancel') }}</button>
                        </li>
                    </ul>
                    <div class="notes mt-3">
                        <p class="fs-13px">
                            {{ __("Caution:") }} <span class="text-soft">{{ __("All the documents will be verified once you confirm and the applicant KYC status will be verified.") }}</span>
                        </p>
                    </div>
                    <div class="divider md stretched"></div>
                    <div class="notes">
                        <ul>
                            <li class="alert-note is-plain">
                                <em class="icon ni ni-info"></em>
                                <p>{{ __("The original profile data will be updated with this submission data and user won't be able to edit profile info such as name, dob, address etc.") }}</p>
                            </li>
                            <li class="alert-note is-plain text-danger">
                                <em class="icon ni ni-alert"></em>
                                <p>{{ __("You can not undo this action once you take action.") }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" id="reject-entry{{ $data->id }}">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <a href="javascript:void(0)" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body">
                    <div class="row gy-3">
                        <div class="col-md-12">
                            <h5 class="title mb-2">{{ __('Reject Submission') }}</h5>
                            <p>{{ __("Please review all the documents before take any action. You can request for resubmission if provided documents are not valid.") }}</p>
                        </div>
                        @if (!blank($documents))
                        <div class="col-md-12">
                            <table class="table table-plain table-borderless table-sm mb-0">
                                <th>{{ __("Uploaded Document") }}</th>
                                <th></th>
                                    @foreach ($documents as $doc)
                                    <tr>
                                        <td><span class="sub-text">{{ __(short_to_docs($doc->type)) }}</span></td>
                                        <td>
                                            <span class="sub-text">
                                                @if (in_array($doc->state, [KycDocStatus::VALID, KycDocStatus::INVALID]))
                                                    {{ ($doc->state == KycDocStatus::VALID) ? __("Approved") : __("Rejected") }}
                                                @else
                                                    {{ __("New") }}
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                            </table>
                        </div>
                        @endif
                    </div>
                    <ul class="align-center flex-nowrap gx-2 pt-2 mt-2">
                        <li>
                            <a href="#" class="btn btn-secondary kyc-update" data-action="resubmit"><span>{{ __("Request for Resubmission") }}</span></a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-danger kyc-update" data-action="reject"><span>{{ __("Reject & Close") }}</span></a>
                        </li>
                    </ul>
                    <div class="notes mt-3">
                        <p class="fs-13px">
                            {{ __("Caution:") }} <span class="text-soft">{{ __("User can submit again if you request for resubmission. But if you reject then user won't be able to submit again.") }}</span>
                        </p>
                    </div>
                    <div class="divider md stretched"></div>
                    <div class="notes">
                        <ul>
                            <li class="alert-note is-plain text-danger">
                                <em class="icon ni ni-alert"></em>
                                <p>{{ __("You can not undo this action once you take action.") }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endpush

@push('scripts')
<script>
    $('.kyc-update').on('click', function (e) {
        e.preventDefault();
        let $self = $(this), action = $self.data("action"), url = "{{ route('admin.kyc.update', $data->id) }}";
		if (url !== null && action) { NioApp.Form.toPost(url, {action: action}) }
    });
</script>
@endpush
