<?php

namespace App\Http\Controllers\Web\Member;

use App\Exports\ExportDeposits;
use App\Http\Controllers\Controller;
use App\Imports\DepositsImport;
use App\Models\Brokers;
use App\Models\Deposits;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class DepositController extends Controller
{

    public function deposit(Request $request, $id)
    {
        $user = User::find($id);

        $search = array();

        if ($request->isMethod('post')) {

            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':

                    session(['deposit_search' => [
                        'filter_broker' =>  $request->input('filter_broker'),
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('deposit_search');
                    break;
            }
        }

        $search = session('deposit_search') ? session('deposit_search') : $search;

        return view("member/deposit", [
            'submit' => route('deposits_listing', $id),
            'deposits' => Deposits::get_deposits_table($search, 10, $user->id),
            'brokers' => Brokers::all(),
            'personal_total' => $user->personalDeposits(),
            'broker_group' =>  $user->personalDepositsByBrokers(),
            'user' => $user,
            'search' =>  $search,
        ]);
    }
    public function index2(Request $request)
    {
        $user = Auth::user();

        $search = array();

        if ($request->isMethod('post')) {

            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':

                    session(['fund_search' => [
                        'filter_broker' =>  $request->input('filter_broker'),
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('fund_search');
                    break;
            }
        }

        $search = session('fund_search') ? session('fund_search') : $search;

        return view('member/funds', [
            'submit' => route('funds_listing'),
            'deposits' => Deposits::get_deposits_table($search, 10, $user->id),
            'brokers' => Brokers::all(),
            'personal_total' => $user->personalDeposits(),
            'broker_group' =>  $user->personalDepositsByBrokers(),
            'search' =>  $search,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'file'          => 'required|mimes:xlsx, csv, xls',
            ]
        );
        $import = new DepositsImport;
        $import->import($request->file('file'));
        $errorMsg = [];
        if(count($import->failures()) > 0) {
            foreach ($import->failures() as $failure) {
                $tempMsg = 'Error on row '.' '.$failure->row().'. '.  $failure->errors()[0];
                array_push($errorMsg, $tempMsg);
            }
            return back()->withErrors($errorMsg);
        }
        return back()->with('success', 'User Imported Successfully.');
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now()->format('YmdHis');
        $userIds = [$user->id];
        if ($request->underline) {
            $userIds= $user->getChildrenIds();
        }
        return Excel::download(new ExportDeposits($userIds), $now.'-deposits-records.xlsx');
    }

}
