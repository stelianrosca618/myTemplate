@extends('admin.layouts.master')
@section('title', __('Verification Center'))

@php
    use NioModules\BasicKYC\Helpers\KycStatus;
    use NioModules\BasicKYC\Helpers\KycDocStatus;
    use NioModules\BasicKYC\Helpers\KycSessionStatus;
@endphp

@section('content')
<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">{{ __("KYC") }} / {{ __("Verification Center") }}</h3>
                <div class="nk-block-des text-soft">
                    <p>{!! __('Total :number submission.', ['number' => '<strong class="text-base">'. $totalCount .'</strong>']) !!}</p>
                </div>
            </div>
            <div class="nk-block-head-content">
                <ul class="nk-block-tools g-3">
                    <li>
                        <a href="{{ route('admin.settings.component.kyc') }}" class="btn btn-primary d-none d-sm-inline-flex"><em class="icon ni ni-setting"></em><span>{{ __("KYC Settings") }}</span></a>
                        <a href="{{ route('admin.settings.component.kyc') }}" class="btn btn-icon btn-primary d-inline-flex d-sm-none"><em class="icon ni ni-setting"></em></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <ul class="nk-nav nav nav-tabs mt-n3 mb-md-n3">
        <li class="nav-item">
            <a class="nav-link{{ ($listing == 'process') ? ' active' : '' }}" href="{{ route('admin.kyc.list', 'process') }}"><span>{{ __('Process') }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ ($listing == 'approve') ? ' active' : '' }}" href="{{ route('admin.kyc.list', 'approve') }}"><span>{{ __('Approved') }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ ($listing == 'all') ? ' active' : '' }}" href="{{ route('admin.kyc.list', 'all') }}"><span>{{ __('All') }}</span></a>
        </li>
    </ul>
    <div class="nk-block">
         <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h6 class="nk-block-title">{{ __('All Documents') }}</h6>
                </div>
                <ul class="nk-block-tools gx-3">
                    <li>
                        <a href="#" class="search-toggle toggle-search btn btn-icon btn-trigger" data-target="search"><em class="icon ni ni-search"></em></a>
                    </li>
                    <li>
                        <div class="dropdown">
                            <a class="dropdown-toggle btn btn-icon btn-trigger mx-n1" data-toggle="dropdown"
                               data-offset="-8,0" aria-expanded="false"><em class="icon ni ni-setting"></em></a>
                            <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right" style="">
                                <ul class="link-check">
                                    <li><span>{{ __('Show') }}</span></li>
                                    @foreach(config('investorm.pgtn_pr_pg') as $item)
                                    <li class="update-meta{{ (user_meta('kyc_perpage', '10') == $item) ? ' active' : '' }}">
                                        <a href="#" data-value="{{ $item }}" data-meta="perpage" data-type="kyc">{{ $item }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                <ul class="link-check">
                                    <li><span>{{ __('Order') }}</span></li>
                                    @foreach(config('investorm.pgtn_order') as $item)
                                    <li class="update-meta{{ (user_meta('kyc_order', 'desc') == $item) ? ' active' : '' }}">
                                        <a href="#" data-value="{{ $item }}" data-meta="order" data-type="kyc">{{ __(strtoupper($item)) }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                <ul class="link-check">
                                    <li><span>{{ __('Density') }}</span></li>
                                    @foreach(config('investorm.pgtn_dnsty') as $item)
                                    <li class="update-meta{{ (user_meta('kyc_display', 'regular') == $item) ? ' active' : '' }}">
                                        <a href="#" data-value="{{ $item }}" data-meta="display" data-type="kyc">{{ __(ucfirst($item)) }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <form action="{{ url()->current() }}" method="GET">
                <div class="search-wrap search-wrap-extend bg-lighter{{ (request()->get('query')) ? ' active' : '' }}" data-search="search">
                    <div class="search-content">
                        <a href="{{ url()->current() }}" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                        <input type="text" name="query" value="{{ request()->get('query') }}" class="form-control border-transparent form-focus-none" placeholder="{{ __("Search by user id or reference") }}">
                        <button class="search-submit btn btn-icon mr-1"><em class="icon ni ni-search"></em></button>
                    </div>
                </div>
            </form>
        </div>

        @if(filled($applicants))
        <div class="card card-bordered card-stretch">
            <div class="card-inner-group">
                <div class="card-inner p-0">
                    <div class="nk-tb-list nk-tb-tnx {{ user_meta('kyc_display') == 'compact' ? 'is-compact': '' }}">
                        <div class="nk-tb-item nk-tb-head">
                            <div class="nk-tb-col"><span>{{ __('User') }}</span></div>
                            <div class="nk-tb-col tb-col-lg"><span>{{ __('Phone') }}</span></div>
                            <div class="nk-tb-col tb-col-xxl"><span>{{ __('Country') }}</span></div>
                            <div class="nk-tb-col tb-col-sm"><span>{{ __('Documents') }}</span></div>
                            <div class="nk-tb-col tb-col-md"><span>{{ __('Submitted At') }}</span></div>
                            <div class="nk-tb-col"><span class="d-none d-sm-inline-block">{{ __('Status') }}</span></div>
                            <div class="nk-tb-col nk-tb-col-tools">&nbsp;</div>
                        </div>
                        @foreach($applicants as $item)
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <a href="{{ route('admin.kyc.view', $item->session) }}">
                                        <div class="user-card">
                                            {!! user_avatar($item->user) !!}
                                            <div class="user-info">
                                                <span class="tb-lead">{{ $item->data('name') }}</span>
                                                <span class="tipinfo" title="{{ the_uid($item->user->id) }}">{{ $item->kyc->user_reference }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="nk-tb-col tb-col-lg">
                                    <span>{{ $item->data('phone') ? $item->data('phone') : __('Not found') }}</span>
                                </div>
                                <div class="nk-tb-col tb-col-xxl">
                                    <span>{{ $item->data('country') ? $item->data('country') : __('Not found') }}</span>
                                </div>
                                <div class="nk-tb-col tb-col-sm">
                                    @if (!blank($item->documents))
                                    <ul class="list-status">
                                        @foreach ($item->documents as $doc)
                                            @if ($item->in_docs($doc->type))
                                            <li>
                                                @if ($doc->state == KycDocStatus::VALID)
                                                <em class="icon text-success ni ni-check-circle"></em>
                                                @elseif ($doc->state == KycDocStatus::INVALID)
                                                <em class="icon text-danger ni ni-cross-circle"></em>
                                                @else
                                                <em class="icon text-primary ni ni-check-circle"></em>
                                                @endif
                                                <span>
                                                    <span class="d-none d-xxl-inline">{{ __(short_to_docs($doc->type)) }}</span>
                                                    <span class="d-xxl-none">{{ strtoupper($doc->type) }}</span>
                                                </span>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    @else
                                        <span class="font-italic small">{{ __("No document") }}</span>
                                    @endif
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-date">{{ show_date($item->created_at, true) }}</span>
                                </div>
                                <div class="nk-tb-col text-right text-sm-left">
                                    <span class="badge badge-pill badge-dim{{ the_state($item->status, ['prefix' => 'badge']) }} d-none d-sm-inline-block">
                                        {{ ($item->status == KycSessionStatus::COMPLETED) ? __("Pending") : __(ucfirst(to_past($item->status))) }}
                                    </span>
                                    <span class="dot{{ the_state($item->status, ['prefix' => 'dot']) }} d-sm-none ml-1"></span>
                                </div>
                                <div class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">
                                        <li class="nk-tb-action-hidden">
                                            <a href="{{ route('admin.kyc.view', $item->session) }}" class="btn btn-sm btn-trigger btn-icon"><em class="icon ni ni-eye-fill"></em></a>
                                        </li>
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="{{ route('admin.kyc.view', $item->session) }}"><em class="icon ni ni-file-docs"></em><span>{{ __('View Documents') }}</span></a></li>
                                                        <li><a href="{{ route('admin.users.details', ['id' => $item->user_id, 'type' => 'personal']) }}" target="_blank"><em class="icon ni ni-user"></em><span>{{ __('View Profile') }}</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if(filled($applicants) && $applicants->hasPages())
                <div class="card-inner pt-3 pb-3">
                    {{ $applicants->appends(request()->all())->links('misc.pagination') }}
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="card card-bordered card-stretch">
            <div class="card-inner card-inner-lg py-5 text-center">
                <h4>{{ __('Nothing Found!') }}</h4>
                <p>{{ __('Sorry, here is no verification documents found.') }}</p>
                @if(request()->get('query'))
                <a class="btn btn-primary" href="{{ route('admin.kyc.list') }}">{{ __('Back to KYC list') }}</a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('modal')
    <div class="modal fade" role="dialog" id="ajax-modal"></div>
@endpush

@push('scripts')
<script type="text/javascript">
    const updateSetting = "{{ route('admin.profile.update') }}";
</script>
@endpush
