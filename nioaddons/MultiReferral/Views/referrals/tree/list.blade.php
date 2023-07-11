@php
    use App\Helpers\NioHash;
@endphp

<ul class="nk-tree-pr">
    @foreach(data_get($user, 'referrals', []) as $referral)
        <li class="nk-tree-cl" id="tree-{{ NioHash::of(data_get($referral, 'referred.id')) }}">
            @include('MultiReferral::referrals.tree.user', ['user' => data_get($referral, 'referred')])
        </li>
    @endforeach
</ul>
