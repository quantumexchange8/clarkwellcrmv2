<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\ExportBonusHistories;
use App\Http\Controllers\Controller;
use App\Models\BonusHistories;
use App\Models\Brokers;
use App\Models\SettingCountry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BonusHistoryController extends Controller
{
    public function listing(Request $request)
    {
        $search = array();

        $users = User::query()
            ->where('status', 1)
            ->where('role', 1)
            ->where('deleted_at', null)
            ->where('name','LIKE','%'.$request->keyword.'%')
            ->get();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['admin_bonus_history_search' => [
                        'user_id' =>  $request->input('user_id'),
                        'freetext' =>  $request->input('freetext'),
                        'type' => 'children',
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end')
                    ]]);

                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportBonusHistories(BonusHistories::get_record( session('admin_bonus_history_search'))), $now . '-bonus-histories-records.xlsx');
                case 'reset':
                    session()->forget('admin_bonus_history_search');
                    break;
            }
        }

        $search = session('admin_bonus_history_search') ? session('admin_bonus_history_search') : $search;
        $query = BonusHistories::get_record($search);

        return view('admin.report.bonus_history_list', [
            'title' => trans('public.network'),
            'submit' => route('member_listing'),
            'records' => BonusHistories::get_record($search)->paginate(10),
            'search' =>  $search,
            'users' => $users,
            'brokers' => Brokers::all(),
            'total_amount' => $query->get()->sum('bonus_amount')
        ]);
    }
}
