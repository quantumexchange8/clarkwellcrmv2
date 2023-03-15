<?php

namespace App\Http\Controllers\Web\Member;

use App\Exports\ExportWithdrawal;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWithdrawalRequest;
use App\Models\Settings;
use App\Models\Withdrawals;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
                    return Excel::download(new ExportWithdrawal($user->id, $request->input('filter_status'), $request->input('created_start'), null, null, $request->input('created_end')), $now . '-withdrawal-records.xlsx');
                case 'reset':
                    session()->forget('withdrawal_search');
                    break;
            }
        }

        $search = session('withdrawal_search') ? session('withdrawal_search') : $search;

        return view('member/withdrawal', [
            'submit' => route('withdrawals_listing'),
            'withdrawals' => Withdrawals::get_withdrawals_table($search, 10, $user->id),
            'user' => $user,
            'transaction_fee' => $settings['withdrawal_transaction_fee'] ?? 0,
            'search' =>  $search,
        ]);
    }
    public function store(StoreWithdrawalRequest $request)
    {
        $user = Auth::user();
        if ($request->amount > $user->wallet_balance)
        {
            return back()->withInput()->withErrors(["error_messages" => "Withdrawal amount cannot more than wallet balance."]);
        }

        $settings = Settings::getKeyValue();
        $amount = round($request->amount, 2);
        $fee = $settings['withdrawal_transaction_fee'];
        $amount = $amount - $fee;

        if ($amount <= 0)
        {
            return back()->withInput()->withErrors(["error_messages" => "Final withdraw amount will be equal or less than 0."]);
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



}
