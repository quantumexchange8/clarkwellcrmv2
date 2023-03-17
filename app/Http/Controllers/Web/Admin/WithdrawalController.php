<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\ExportWithdrawal;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWithdrawalRequest;
use App\Models\User;
use App\Models\Withdrawals;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Alert;
use Session;

class WithdrawalController extends Controller
{
    public function approval(Request $request, $id)
    {
        $request->validate([
            'approval' => ['required', Rule::in([Withdrawals::STATUS_APPROVED, Withdrawals::STATUS_REJECTED])],
        ]);
        $approval = $request->input('approval');
        $withdrawal = Withdrawals::find($id);
        $user = Auth::user();

        if ($withdrawal->status != Withdrawals::STATUS_PENDING) {
            return back()->withErrors(["error" => "Only pending status can perform approval action."]);
        } else if ($approval == Withdrawals::STATUS_APPROVED && $withdrawal->amount > $user->wallet_balance) {
            return back()->withErrors(["error" => "User's wallet balance insufficient to approve."]);
        }

        $withdrawal->status = $approval;
        $withdrawal->save();
        if ($withdrawal->status == Withdrawals::STATUS_APPROVED) {
            $user->wallet_balance  -= $withdrawal->amount;
            $user->save();
        }
        return back();
    }

    public function listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['report_withdrawal' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                        'status' => $request->input('status')
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportWithdrawal(null, $request->input('status'), $request->input('created_start'), $request->input('freetext'), null, $request->input('created_end')), $now . '-withdrawal-records.xlsx');
                case 'reset':
                    session()->forget('report_withdrawal');
                    break;
            }
        }

        $search = session('report_withdrawal') ? session('report_withdrawal') : $search;

        return view('admin.report.withdrawal', [
            'title' => 'Withdrawals',
            'submit' => route('report_withdrawal'),
            'records' => Withdrawals::get_record($search, 10),
            'search' =>  $search,
            'get_status_sel' => ['' => trans('public.select_status')] + [1 => 'Processing', 2 => 'Approved', 3 => 'Rejected'],
        ]);
    }

    public function listingChildren(Request $request)
    {

        $users = User::query()
            ->where('status', 1)
            ->where('role', 1)
            ->where('deleted_at', null)
            ->where('name','LIKE','%'.$request->keyword.'%')
            ->get();
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['report_withdrawal_children' => [
                        'user_id' =>  $request->input('user_id'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                        'status' => $request->input('status'),
                        'type' => 'children'
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportWithdrawal(null, $request->input('status'), $request->input('created_start'), null, $request->input('user_id'), $request->input('created_end')), $now . '-withdrawal-records.xlsx');
                case 'reset':
                    session()->forget('report_withdrawal_children');
                    break;
            }
        }

        $search = session('report_withdrawal_children') ? session('report_withdrawal_children') : $search;

        return view('admin.report.withdrawal-children', [
            'title' => 'Withdrawals - Downline',
            'submit' => route('report_withdrawal_children'),
            'records' => Withdrawals::get_record($search, 10),
            'search' =>  $search,
            'users' => $users,
            'get_status_sel' => ['' => trans('public.select_status')] + [1 => 'Processing', 2 => 'Approved', 3 => 'Rejected'],
        ]);
    }

    public function withdrawal_request(Request $request, $id)
    {
        $user = Withdrawals::find($id);

        if (!$user)
        {
            Alert::error(trans('public.invalid_action'), trans('public.try_again'));
            return redirect()->back();
        }

        switch ($request->input('status')) {
            case 'approve':
                $user->update([
                    'status' => 2,
                ]);
                break;

            case 'reject':
                $user->update([
                    'status' => 3,
                ]);
                break;
        }

        Alert::success(trans('public.done'), trans('public.successfully_updated_withdrawal_status'));
        return redirect()->back();

    }
}
