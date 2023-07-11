@php
    use App\Helpers\NioHash;

    $treeCollapse = $treeCollapse ?? true;
    $mainUser = $first ?? false;
    $members  = count(data_get($user, 'referrals', []));
@endphp

@if ($mainUser && $members == 0)
    <p class="p-4 mt-5 border border-light rounded"><span class="icon ni ni-meh fs-22px text-soft"></span><br>{{ __("No one join yet!") }}</p>
@else
<div class="nk-tree-sb">
    <div class="user-pro-info">
        @if ($mainUser)
            {!! user_avatar($user) !!}
            <div class="user-info">
                <span class="lead-text">{{ $user->name }} <small>{{ __("(You)") }}</small></span>
            </div>
        @else
        <span class="uinfo-pop">
            {!! user_avatar($user, 'sm') !!}
            <div class="user-info">
                <span class="lead-text">
                    {{ in_array('compact', sys_settings('referral_user_table_opts', [])) ? str_compact($user->username) : $user->username }}
                </span>
            </div>
        </span>
        @endif

        @if (!$mainUser)
        <div class="uinfo-over">
            <div class="user-info">
                <span class="lead-text">
                    {{ in_array('compact', sys_settings('referral_user_table_opts', [])) ? str_compact($user->username) : $user->username }}
                </span>
                <span class="sub-text mt-1 lh-4">
                    {{ __("Joined Date") }}: <span>{{ show_date($user->created_at) }}</span> <br>
                    @if (in_array('earning', sys_settings('referral_user_table_opts', [])))
                    {{ __("Total Earned") }}: <span>{{ $user->referral_bonus_earned }} {{ base_currency() }}</span> <br>
                    @endif
                    @if ($members)
                    {{ __("Total Referral") }}: <span>{{ ($members >= 2) ? __(":num Members", ['num' => $members]) : __(":num Member", ['num' => $members]) }}</span>
                    @endif
                </span>
            </div>
        </div>
        @endif

        @if($treeCollapse && ($members > 0))
        <div class="tree-collapse" data-network="{{ NioHash::of(data_get($user, 'id')) }}">
            <em class="icon ni ni-plus-circle-fill"></em>
            <em class="spinner-border spinner-border-sm d-none"></em>
        </div>
        @endif
    </div>
</div>
@endif