@php 

use \App\Enums\TransactionType;
use \App\Enums\TransactionStatus;

$amount = $transaction->amount;
$currency = $transaction->currency;

$tnx_amount = $transaction->tnx_amount;
$tnx_currency = $transaction->tnx_currency;

$user_amount = money($transaction->tnx_amount, $transaction->tnx_currency);

if($transaction->tnx_currency!=base_currency()) {
    $user_amount = money($transaction->tnx_amount, $transaction->tnx_currency) . ' ('. money($transaction->amount, $transaction->currency). ')';
}

$transferTo = get_user(data_get($transaction, 'meta.transfer.user'));
$transferFrom = get_user($transaction->user_id);

@endphp

<div class="nk-modal-title">
	<h5 class="title mb-3">{!! __('Transaction ID# :orderid', ['orderid' => '<span class="text-primary">'.the_tnx($transaction->tnx).'</span>' ]) !!}</h5>
</div>
<div class="nk-block">
    <p class="caption-text">{!! __("The transfer amount of :amount add into :account.", ['account' => '<span class="fw-bold text-dark">'.ucfirst(data_get($transferTo, 'username')).'</span>', 'amount' => '<span class="fw-bold text-dark text-nowrap">'.$user_amount.'</span>' ]) !!}</p>
    <form action="{{ route('admin.transactions.transfer.update', ['action' => 'approve', 'uid' => the_hash($transaction->id)]) }}" data-action="update"> 
        <div class="row gy-3">
            <div class="col-sm-6">
        		<div class="form-group">
					<label class="form-label">{{ __('Transfer From') }}</label>
                    <div class="form-control-wrap">
                        <input type="text" value="{{ data_get($transferFrom, 'email') . " (" . the_uid(data_get($transferFrom, 'id')) . ")" }}" class="form-control" readonly="">
                    </div>
                    <div class="form-note">
                    	{{ __('This user has sent the money.') }}
                    </div>
                </div>
        	</div>
            <div class="col-sm-6">
        		<div class="form-group">
					<label class="form-label">{{ __('Transfer To') }}</label>
                    <div class="form-control-wrap">
                        <input type="text" value="{{ data_get($transferTo, 'email') . " (" . the_uid(data_get($transferTo, 'id')) . ")" }}" class="form-control" readonly="">
                    </div>
                    <div class="form-note">
                    	{{ __('This user will receive the money.') }}
                    </div>
                </div>
        	</div>
            @if (data_get($transaction, "meta.transfer.unote"))
            <div class="col-sm-12">
        		<div class="form-group">
                    <div class="form-control-wrap">
                        <input type="text" value="{{ data_get($transaction, "meta.transfer.unote") }}" class="form-control" readonly="">
                    </div>
                    <div class="form-note">
                    	{{ __('This description is provided by the user.') }}
                    </div>
                </div>
        	</div>
            @endif
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="form-label justify-between align-center" for="note">{{ __('Note for User') }} <span class="small">{{ __("Show in userend") }}</span></label>
                    <div class="form-control-wrap">
                        <input type="text" name="note" class="form-control" id="note" placeholder="{{ __('Enter public note') }}" maxlength="190">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="form-label justify-between align-center" for="remarks">{{ __('Remarks') }}</label>
                    <div class="form-control-wrap">
                        <input type="text" name="remarks" class="form-control" id="remarks" placeholder="{{ __('Enter remarks') }}" maxlength="190">
                        <input type="hidden" value="{{ $transaction->tnx }}" name="orderid">
                        <input type="hidden" value="{{ TransactionStatus::COMPLETED }}" name="status">
                    </div>
                    <div class="form-note">
                    	{{ __('The remarks help to reminder. Only administrator can read from transaction details.') }}
                    </div>
                </div>
            </div>
            <div class="col-12">
            	<p>{!! __("Please confirm that you want to :type this amount.", ['type' => '<span class="fw-bold text-dark">'.strtoupper($type).'</span>']) !!}</p>
            </div>
        </div>
        <ul class="align-center flex-nowrap gx-2 pt-4 pb-2">
            <li>
                <button{{ ($transferTo) ? '' : ' disabled="disabled"' }} type="button" class="btn btn-primary atx-upd" data-confirm="yes" data-state="{{ TransactionStatus::COMPLETED }}">{{ __('Approve Transfer') }}</button>
            </li>
            <li>
                <button data-dismiss="modal" type="button" class="btn btn-trans btn-light">{{ __('Return') }}</button>
            </li>
        </ul>
        <div class="divider md stretched"></div>
        <div class="notes">
            <ul>
                <li class="alert-note is-plain">
                    <em class="icon ni ni-info"></em>
                    <p>{{ __("The amount will adjust into user account once you confirmed.") }}</p>
                </li>
                <li class="alert-note is-plain text-danger">
                    <em class="icon ni ni-alert"></em>
                    <p>{{ __("You can not undo this action once you approve the transfer and procced.") }}</p>
                </li>
            </ul>
        </div>
    </form>
</div>