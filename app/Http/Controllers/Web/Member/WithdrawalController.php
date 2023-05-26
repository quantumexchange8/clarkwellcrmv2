<?php

namespace App\Http\Controllers\Web\Member;

use App\Exports\ExportWithdrawal;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWithdrawalRequest;
use App\Models\Settings;
use App\Models\User;
use App\Models\Withdrawals;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Alert;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = array();
        $settings = Settings::getKeyValue();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':

                    session(['withdrawal_search' => [
                        'filter_status' =>  $request->input('filter_status'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportWithdrawal(Withdrawals::get_withdrawals_table(session('withdrawal_search'), $user->id)), $now . '-withdrawal-records.xlsx');
                case 'reset':
                    session()->forget('withdrawal_search');
                    break;
            }
        }

        $search = session('withdrawal_search') ? session('withdrawal_search') : $search;

        return view('member/withdrawal', [
            'submit' => route('withdrawals_listing'),
            'withdrawals' => Withdrawals::get_withdrawals_table($search, $user->id)->paginate(10),
            'user' => $user,
            'transaction_fee' => $settings['withdrawal_transaction_fee'] ?? 0,
            'search' =>  $search,
        ]);
    }
    public function store(StoreWithdrawalRequest $request)
    {
        $user = Auth::user();

        if ($user->withdrawal_action == User::DISABLE_WITHDRAWAL)
        {
            Alert::warning(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
        }

        if (Withdrawals::where('requested_by_user', $user->id)->where('status', Withdrawals::STATUS_PENDING)->exists()) {
            Alert::warning(trans('public.invalid_action'), trans('public.withdrawal_pending_request'));
            return back()->withInput();
        } elseif ($request->amount > $user->wallet_balance)
        {
            Alert::warning(trans('public.invalid_action'), trans('public.insufficient_amount'));
            return back()->withInput();
        }

        $settings = Settings::getKeyValue();
        $amount = round($request->amount, 2);
        $fee = $settings['withdrawal_transaction_fee'];
        $amount = $amount - $fee;

        if ($amount <= 0)
        {
            Alert::warning(trans('public.invalid_action'), trans('public.unnecessary_withdraw'));
            return back()->withInput();
        }

        $withdrawal = Withdrawals::create([
            'network' => $request->network,
            'amount' => $amount,
            'address' => $request->address,
            'transaction_fee' => $fee,
            'status' => Withdrawals::STATUS_PENDING,
            'requested_by_user' => $user->id,
        ]);
        return back();
    }

    public function withdrawal_edit(Request $request)
    {
        $user = Auth::user();
        $withdrawal = Withdrawals::find($request->withdrawal_id);

        if ($user->withdrawal_action == User::DISABLE_WITHDRAWAL)
        {
            Alert::warning(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'network' => ['required', Rule::in(Withdrawals::$walletTypes)],
            'address' => 'required',
            'amount' => 'required|numeric',
        ])->setAttributeNames([
            'network' => trans('public.network'),
            'address' => trans('public.address'),
            'amount' => trans('public.amount'),
        ]);

        if (!$validator->passes()){
            return response()->json([
                'status' => 0,
                'error' => $validator->errors()->toArray()
            ]);
        } else {

            if ($request->amount > $user->wallet_balance)
            {
                return response()->json([
                    'status' => 2,
                    'msg' => trans('public.insufficient_amount')
                ]);
            }

            $withdrawal->update([
                'address' => $request->input('address'),
                'amount' => $request->input('amount'),
            ]);

            return response()->json([
                'status' => 1,
                'msg' => trans('public.successfully_update_withdrawal'),
            ]);
        }
    }

    public function withdrawal_cancel(Request $request)
    {
        $withdrawal_id = $request->input('withdrawal_id');
        $withdrawal = Withdrawals::find($withdrawal_id);

        if (!$withdrawal) {
            Alert::error(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
        }

        $withdrawal->update([
            'status' => Withdrawals::STATUS_REJECTED
        ]);

        Alert::success(trans('public.done'), trans('public.successfully_cancel_withdrawal'));
        return redirect()->back();
    }

}
