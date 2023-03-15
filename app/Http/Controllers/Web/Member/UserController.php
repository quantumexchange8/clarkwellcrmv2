<?php

namespace App\Http\Controllers\Web\Member;

use App\Exports\ExportCommissions;
use App\Exports\NetworkExport;
use App\Http\Controllers\Controller;
use App\Models\ActionLogs;
use App\Models\Announcements;
use App\Models\Brokers;
use App\Models\Commissions;
use App\Models\Deposits;
use App\Models\Rankings;
use App\Models\SettingCountry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Jorenvh\Share\Share;
use Maatwebsite\Excel\Facades\Excel;
use Alert;
use Session;
use Illuminate\Support\Facades\Session as FacadesSession;


class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $user->url = url('') .'/register/' . $user->referral_id;
        $deposits = $user->personalDepositsByBrokers();
        $personal_total = $user->personalDeposits();
        $rank = $user->rank;
        $group_deposits = $user->groupDepositsByBrokers();
        $group_deposits_total = $user->groupTotalDeposit();
        $news_all = Announcements::query()
            ->where('deleted_at', null)
            ->where('visibility', 1)
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        $shareFB = (new Share)->page($user->url)->facebook()->getRawLinks();
        $shareTwitter = (new Share)->page($user->url, 'Sign up now to be a part of us! Simple registration through the link!')->twitter()->getRawLinks();
        $shareTelegram = (new Share)->page($user->url, 'Sign up now to be a part of us! Simple registration through the link!')->telegram()->getRawLinks();
        $shareWA = (new Share)->page($user->url, 'Sign up now to be a part of us! Simple registration through the link!')->whatsapp()->getRawLinks();

        return view('member/dashboard', compact('user', 'deposits', 'rank', 'personal_total', 'group_deposits', 'group_deposits_total', 'news_all', 'shareFB', 'shareTwitter', 'shareTelegram', 'shareWA'));
    }

    public function profile()
    {
        $user = Auth::user();
        $rank = $user->rank;
        $userCountry = SettingCountry::where('name', $user->country)->first();
        $user->countryFlag = $userCountry->code ?? null;


        return view('member/profile', compact('user', 'rank'));
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|dimensions:max_width=250,max_height=250',
        ]);
        $user = Auth::user();
        $profile_image = $request->file('profile_image');
        if ($profile_image) {
            if ($user->profile_image) {
                File::delete('uploads/users/' . $user->profile_image);
            }
            $imageName = pathinfo($profile_image->getClientOriginalName(), PATHINFO_FILENAME) . time() . '.' . $profile_image->getClientOriginalExtension();
            $profile_image->move('uploads/users', $imageName);
            $user->profile_image = $imageName;
            $user->save();
        }
        $rank = $user->rank;
        return view('member/profile', compact('user', 'rank'));
    }

    public function account($id)
    {
        //TODO:: abort 404 if the id not belongs to user chilren
        $user = User::findOrFail($id);
        $children = $user->getChildrenIds();
        $directClients = $user->children()->pluck('id')->toArray();

        $brokers = Brokers::all();

        for ($i = 0; $i < $brokers->count(); $i++) {
            $broker = $brokers[$i];

            $personalTotal = Deposits::where('userId', $user->id)->where('brokersId', $broker->id)->sum('amount');
            $groupTotal = Deposits::whereIn('userId', $children)->where('brokersId', $broker->id)->sum('amount');
            $groupTotal = $personalTotal + $groupTotal;

            $personalCommissionTotal = Commissions::where('userId', $user->id)->where('brokersId', $broker->id)->sum('commissions_amount');
            $groupCommissionTotal = Commissions::whereIn('userId', $children)->where('brokersId', $broker->id)->sum('commissions_amount');
            $groupCommissionTotal = $personalCommissionTotal + $groupCommissionTotal;
            $downlines = Deposits::where('brokersId', $broker->id)->whereIn('userId', $children)->distinct()->count('userId');
            $clients = Deposits::where('brokersId', $broker->id)->whereIn('userId', $directClients)->distinct()->count('userId');


            $brokers[$i]->data = [
                'personal_deposit' => $personalTotal ?? 0,
                'group_deposit' => $groupTotal ?? 0,
                'personal_commissions' => $personalCommissionTotal ?? 0,
                'group_commissions' => $groupCommissionTotal ?? 0,
                'downlines' => $downlines ?? 0,
                'clients' => $clients ?? 0,
            ];
        }

        $total = [
            'total_personal' => 0,
            'total_group' => 0,
            'total_personal_comm' => 0,
            'total_group_comm' => 0,
        ];


        foreach ($brokers as $broker) {
            $total['total_personal'] += $broker->data['personal_deposit'];
            $total['total_group'] += $broker->data['group_deposit'];
            $total['total_personal_comm'] += $broker->data['personal_commissions'];
            $total['total_group_comm'] += $broker->data['group_commissions'];
        }


        return view('member/account', compact('user', 'brokers', 'total'));
    }

    public function tree(Request $request)
    {
        $search = array();
        $user = Auth::user();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');
            switch ($submit_type) {
                case 'search':

                    session(['tree_network_search' => [
                        'freetext' => $request->input('freetext'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new NetworkExport($user->id, $request->input('freetext')), $now . '-network-records.xlsx');

                    case 'reset':
                    session()->forget('tree_network_search');
                    break;
            }
        }

        $search = session('tree_network_search') ? session('tree_network_search') : $search;

        $searchTerms = @$search['freetext'] ?? NULL;
        $freetext = explode(' ', $searchTerms);
        $members = [];
        if ($searchTerms) {
            $query =  User::query();
            foreach ($freetext as $freetexts) {
                $query->where('email', 'like', '%' . $freetexts . '%');

            }
            $members = $query->whereIn('id', $user->getChildrenIds())->take(1)->get();
        } else {
            $members = Auth::user()->children;
        }

        return view('member/tree', compact('members', 'search'));
    }

    public function exportExcel(Request $request)
    {
        {
            $user = Auth::user();
            $now = Carbon::now()->format('YmdHis');
            return Excel::download(new NetworkExport($user->id), $now . '-network-records.xlsx');
        }
    }

    public function changePassword()
    {
        return view('change-password');
    }

    public function changePasswordSave(Request $request)
    {

        $this->validate($request, [
            'current_password' => 'required|string',
            'password' => ['required', 'string', 'max:15', 'confirmed',
                Password::min(8)->letters()->numbers()->mixedCase()->symbols()],
        ]);
        $auth = Auth::user();

        // The passwords matches
        if (!Hash::check($request->get('current_password'), $auth->password)) {

            Alert::error('Invalid', 'Current Password is Invalid!');
            return back();
        }

        // Current password and new password same
        if (strcmp($request->get('current_password'), $request->password) == 0) {

            Alert::warning('Invalid', 'New Password cannot be same as your current password!');
            return back();
        }

        $user = User::find($auth->id);
        $user->password = Hash::make($request->password);
        $user->save();

        Alert::success('Done', 'Successfully Updated Password!');
        return redirect()->route('member_dashboard');
    }

    public function leaveImpersonate()
    {
        $user = Auth::user();
        FacadesSession::put('jwt-token', FacadesSession::get('temp-admin-token'));
        $admin = User::find(FacadesSession::get('impersonate-admin-id'));
        FacadesSession::put('impersonate-admin-id', 0);

        ActionLogs::create([
            'user_id' => $admin->id,
            'type' => get_class($admin),
            'description' =>  'Admin with id: '. $admin->id .' has LEAVE IMPERSONATE user with id: '. $user->id,
        ]);
        return redirect()->route('admin_dashboard');
    }
}

