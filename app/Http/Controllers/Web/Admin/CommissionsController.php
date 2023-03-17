<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\ExportCommissions;
use App\Exports\ExportUser;
use App\Http\Controllers\Controller;
use App\Imports\CommissionsImport;
use App\Models\ActionLogs;
use App\Models\Announcements;
use App\Models\Brokers;
use App\Models\Commissions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Alert;
use Session;

class CommissionsController extends Controller
{
    public function store(Request $request)
    {

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'import':
                    $request->validate(
                        [
                            'file' => 'required|mimes:xlsx, csv, xls',
                            'broker_id' => ['required', Rule::in(Brokers::pluck('id')->toArray())],
                        ], [
                            'file.required' => 'Please UPLOAD a file to import',
                            'file.mimes' => 'File extension must be .xlsx, .csv, .xls',

                            'broker_id' => 'The Broker selection is invalid',
                        ]
                    );
                    $import = new CommissionsImport($request->input('broker_id'));
                    $import->import($request->file('file'));
                    $errorMsg = [];
                    if (count($import->failures()) > 0) {
                        foreach ($import->failures() as $failure) {
                            $tempMsg = 'Error on row ' . ' ' . $failure->row() . '. ' . $failure->errors()[0];
                            array_push($errorMsg, $tempMsg);
                        }
                        return back()->withErrors($errorMsg);
                    }
                    break;
                case 'download':
                    $filePath = public_path('ClarkWell_Commissions_Import_Template.xlsx');
                    return response()->download($filePath);
            }
        }

        return back()->with('success', 'User Imported Successfully.');
    }

    public function listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['admin_commissions_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportCommissions(null,  $request->input('freetext'), $request->input('transaction_start'), null, null, $request->input('transaction_end')), $now . '-commissions-records.xlsx');
                case 'reset':
                    session()->forget('admin_commissions_search');
                    break;
            }
        }

        $search = session('admin_commissions_search') ? session('admin_commissions_search') : $search;

        return view('admin.report.commission', [
            'title' => 'Commissions',
            'submit' => route('member_listing'),
            'records' => Commissions::get_record($search, 10),
            'search' =>  $search,
            'brokers' => Brokers::all(),
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
                    session(['admin_commissions_children_search' => [
                        'user_id' =>  $request->input('user_id'),
                        'transaction_start' => $request->input('transaction_start'),
                        'transaction_end' => $request->input('transaction_end'),
                        'type' => 'children'
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportCommissions(null,  null, $request->input('transaction_start'), null, $request->input('user_id'), $request->input('transaction_end')), $now . '-commissions-records.xlsx');
                case 'reset':
                    session()->forget('admin_commissions_children_search');
                    break;
            }
        }

        $search = session('admin_commissions_children_search') ? session('admin_commissions_children_search') : $search;

        return view('admin.report.commission-children', [
            'title' => 'Commissions - Downline',
            'submit' => route('report_commission_children'),
            'records' => Commissions::get_record($search, 10),
            'search' =>  $search,
            'users' => $users,
            'brokers' => Brokers::all(),
        ]);
    }

    public function delete(Request $request)
    {
        $commission_id = $request->input('commission_id');
        $commission = Commissions::find($commission_id);
        $user = Auth::user();
        $route = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();

        if (!$commission) {
            Alert::error(trans('public.invalid_commission'), trans('public.try_again'));
            return redirect()->route($route);
        }

        if ($commission->status ==  Commissions::STATUS_CALCULATED) {
            Alert::error(trans('public.invalid_commission'), trans('public.commission_status_error'));
            return redirect()->route($route);
        }

        $commission->delete();

        ActionLogs::create([
            'user_id' => $user->id,
            'type' => get_class($commission),
            'description' => $user->name. ' has DELETED commission with id: '. $commission->id,
        ]);

        Alert::success(trans('public.done'), trans('public.successfully_deleted_commission'));
        return redirect()->route($route);
    }
}
