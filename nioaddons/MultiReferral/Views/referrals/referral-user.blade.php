@extends('user.layouts.master')

@section('title', __('Referrals'))

@php
    use App\Helpers\NioHash;
@endphp

@section('content')
<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-head-sub">
            <a href="{{ route('referrals') }}" class="text-soft back-to"><em class="icon ni ni-arrow-left"> </em><span>{{ __('Referrals') }}</span></a>
        </div>
        <div class="nk-block-head-content">
            <h2 class="nk-block-title fw-normal">{{ __('Referral Network') }}</h2>
            <div class="nk-block-des">
                <p>{{ __("See your referral network in tree view.") }}</p>
            </div>
        </div>
    </div>
    <div class="nk-block">
        <div class="card card-bordered card-stretch">
            <div class="card-inner">
                <div class="nk-tree-cointainer" data-simplebar>
                    <div class="nk-tree sm">
                        <ul class="nk-tree-pr mt-1">
                            <li class="nk-tree-cl">
                                @include('MultiReferral::referrals.tree.user', ['user' => $user, 'treeCollapse' => false, 'first' => true])
                                @if(count(data_get($user, 'referrals', [])) > 0)
                                <ul class="nk-tree-pr">
                                    @foreach(data_get($user, 'referrals', []) as $referral)
                                    <li class="nk-tree-cl" id="tree-{{ NioHash::of(data_get($referral, 'referred.id')) }}">
                                        @include('MultiReferral::referrals.tree.user', ['user' => data_get($referral, 'referred')])
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nk-block">
        {!! Panel::referral('invite-card') !!}
    </div>

    {!! Panel::cards('support') !!}

</div>
@endsection

@push('scripts')
<script>
    !function(a,b){b(document).ready(function(){
        b(document).on("click",".tree-collapse",function(){
            let c=b(this),d=c.children(".ni-plus-circle-fill"),e=c.children(".spinner-border");if(c.hasClass("is-clicked"))return;c.addClass("is-clicked");let f=b(this).data("network"),g=b("#tree-"+f);if(0===g.children(".nk-tree-pr").length){d.addClass("d-none"),e.removeClass("d-none");a.Form.toAjax("{{ route('referral.network.more') }}",{network:f},{method:"GET",onSuccess:function(b){g.append(b),a.Treetip(".uinfo-pop"),c.removeClass("is-clicked"),e.addClass("d-none"),d.removeClass("d-none"),d.removeClass("ni-plus-circle-fill"),d.addClass("ni-plus")}})}
        })
    })}(NioApp,jQuery);
</script>
@endpush
