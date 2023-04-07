<?php

namespace App\Http\Controllers\Web\Member;

use App\Exports\ExportCommissions;
use App\Exports\ExportUser;
use App\Exports\NetworkExport;
use App\Http\Controllers\Controller;
use App\Models\ActionLogs;
use App\Models\Announcements;
use App\Models\Brokers;
use App\Models\Commissions;
use App\Models\Deposits;
use App\Models\Event;
use App\Models\Rankings;
use App\Models\SettingCountry;
use App\Models\User;
use App\Models\Withdrawals;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;
use Jorenvh\Share\Share;
use Maatwebsite\Excel\Facades\Excel;
use Alert;
use Session;
use Illuminate\Support\Facades\Session as FacadesSession;


class UserController extends Controller
{
    public function welcome_page()
    {
        $user = Auth::user();

        $news = Announcements::query()
            ->where('deleted_at', null)
            ->where('visibility', 1)
            ->latest('created_at')
            ->first();

        $withdrawal = Withdrawals::query()
            ->where('requested_by_user', $user->id)
            ->orderByDesc('created_at')
            ->first();

        $events = Event::query()
            ->where('deleted_at', null)
            ->where('visibility', 1)
            ->where('pop_up_status', 1)
            ->orderByDesc('created_at')
            ->get();

        return view('member.welcome_page', [
            'user' => $user,
            'news' => $news,
            'events' => $events,
            'withdrawal' => $withdrawal,
        ]);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $first_time_logged_in = FacadesSession::get('first_time_logged_in');
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
            ->limit(4)
            ->get();

        $shareFB = (new Share)->page($user->url)->facebook()->getRawLinks();
        $shareTwitter = (new Share)->page($user->url, 'Sign up now to be a part of us! Simple registration through the link!')->twitter()->getRawLinks();
        $shareTelegram = (new Share)->page($user->url, 'Sign up now to be a part of us! Simple registration through the link!')->telegram()->getRawLinks();
        $shareWA = (new Share)->page($user->url, 'Sign up now to be a part of us! Simple registration through the link!')->whatsapp()->getRawLinks();

        return view('member/dashboard', compact('user', 'deposits', 'rank', 'personal_total', 'group_deposits', 'group_deposits_total', 'news_all', 'shareFB', 'shareTwitter', 'shareTelegram', 'shareWA', 'first_time_logged_in'));
    }

    public function profile()
    {
        $user = Auth::user();
        $rank = $user->rank;

        switch (app()->getLocale()) {
            case 'en':
                $userCountry = SettingCountry::where('name', $user->country)->first();
                $country_trans = $user->country;

                break;

            case 'cn':
                $userCountry = SettingCountry::where('name', $user->country)->first();
                $country_trans = $userCountry->name_cn;

                break;

            case 'tw':
                $userCountry = SettingCountry::where('name', $user->country)->first();
                $country_trans = $userCountry->name_tw;

                break;

            default:
                $userCountry = SettingCountry::where('name', $user->country)->first();
                $country_trans = $user->country;
        }

        $user->countryFlag = $userCountry->code ?? null;


        return view('member/profile', [
            'user' => $user,
            'rank' => $rank,
            'country_trans' => $country_trans,
        ]);
    }

    public function verification(Request $request)
    {
        $post = $user = Auth::user();
        $validator = null;
        if ($request->isMethod('post')) {
            if ($user->kyc_approval_status ==  User::KYC_STATUS_VERIFIED)
            {
                Alert::error(trans('public.invalid_action'), trans('public.fail_uploaded_ic'));
                return redirect()->route('member_verification');
            }


                $validator = Validator::make($request->all(), [
                'front_id_image' => 'nullable|image|max:5120',
                'back_id_image' => 'nullable|image|max:5120',
            ])->setAttributeNames([
                'front_id_image' => trans('public.front_id'),
                'back_id_image' => trans('public.back_id'),
            ]);


            if (!$validator->fails()) {
                $front_id_image = $request->file('front_id_image');
                if ($front_id_image) {
                    if ($user->front_id_image) {
                        File::delete('uploads/users/' . $user->$front_id_image);
                    }
                    $imageName = time() . '.' . $front_id_image->getClientOriginalExtension();
                    $resize_upload = Image::make( $front_id_image->path() );
                    $resize_upload->save(public_path('/uploads/users/'.$imageName));
                    $user->front_id_image = $imageName;
                }


                $back_id_image = $request->file('back_id_image');
                if ($back_id_image) {
                    if ($user->back_id_image) {
                        File::delete('uploads/users/' . $user->back_id_image);
                    }
                    $imageName = time() . '.' . $back_id_image->getClientOriginalExtension();
                    $resize_upload = Image::make( $back_id_image->path() );
                    $resize_upload->save(public_path('/uploads/users/'.$imageName));
                    $user->back_id_image = $imageName;
                }

                if ($user->back_id_image && $user->front_id_image) {
                    $user->kyc_approval_status = User::KYC_STATUS_PENDING_VERIFICATION;
                }
                $user->save();
                Alert::success(trans('public.done'), trans('public.successfully_uploaded_ic'));
                return redirect()->route('member_verification');
            }
            $post = (object) $request->all();
        }

        return view('member/verification', [
            'user' => $user,
            'post' => $post,
            'get_country_sel' => SettingCountry::get_country_sel(),
            'submit' => route('member_verification'),
        ])->withErrors($validator);

    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image',
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
        Alert::success(trans('public.done'), trans('public.successfully_updated_profile'));
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
                        return Excel::download(new NetworkExport(User::get_member_tree_record(session('tree_network_search')), true), $now . '-network-records.xlsx');

                    case 'reset':
                        session()->forget('tree_network_search');
                        break;
                }
            }

            $search = session('tree_network_search') ? session('tree_network_search') : $search;

            return view('member/tree', [
                'members' => User::get_member_tree_record($search),
                'search' => $search,
            ]);
    }

    public function treeVerification(Request $request, $type)
    {
        $user = Auth::user();

        if ($request->isMethod('post')) {

            $credentials = [
                'email' => $user->email,
                'password' => $request['current_password'],
            ];

            if (Auth::guard('web')->setTTL(1)->attempt($credentials)) {

                FacadesSession::put('tree_verification', Carbon::now()->addMinutes(30));

                return redirect()->route($type);
            } else {
                Alert::error(trans('public.access_denied'), trans('public.invalid_auth'));
                return back()->withErrors(['error_message' => 'Invalid email or password']);
            }
        }


        return view('member/tree-verification', [
            'type' => $type
        ]);
    }

    public function exportExcel(Request $request)
    {
        {
            $user = Auth::user();
            $now = Carbon::now()->format('YmdHis');
            return Excel::download(new NetworkExport($user->id), $now . '-network-records.xlsx');
        }
    }

    public function changePassword(Request $request)
    {
        $validator = null;
        $user_id = Auth::id();
        $user = User::find($user_id);

        if(!$user){
            Alert::error(trans('public.invalid_user'), trans('public.try_again'));
            return redirect('/');
        }
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'current_password' => 'required|min:8',
                'password' => ['required', 'string', 'confirmed',
                    Password::min(6)->letters()->numbers()],
                'password_confirmation' => 'required|same:password'
            ])->setAttributeNames([
                'current_password' => trans('public.current_password'),
                'password' => trans('public.new_password'),
                'password_confirmation' => trans('public.confirm_password'),
            ]);
            if (!$validator->fails()) {

                // The passwords match
                if (!Hash::check($request->get('current_password'), $user->password)) {

                    Alert::error(trans('public.invalid_action'), trans('public.current_password_invalid'));
                    return back();
                }

                // Current password and new password same
                if (strcmp($request->get('current_password'), $request->password) == 0) {
                    Alert::warning(trans('public.invalid_action'), trans('public.current_same_password'));
                    return back();
                }

                $user->password = Hash::make($request->password);
                $user->save();

                Alert::success(trans('public.done'), trans('public.successfully_updated_password'));
                return redirect()->route('member_dashboard');

            }
        }
        return view('change-password')->withErrors($validator);
    }

    public function downline_listing(Request $request)
    {
        $user = Auth::user();
        $start_date =  Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $end_date = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        $search =   session('member_downline_search') ? session('member_downline_search') : session(['member_downline_search' => [
            'created_start' => $start_date,
            'created_end' => $end_date,
        ]]);

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['member_downline_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportUser(User::get_record(session('member_downline_search'), false, $user->id), true), $now . '-users-records.xlsx');
                case 'reset':
                    session(['member_downline_search' => [
                        'created_start' => $start_date,
                        'created_end' => $end_date,
                    ]]);
                    break;
            }
        }

        $search = session('member_downline_search') ? session('member_downline_search') : $search;


        return view('member.downline-listing', [
            'submit' => route('member_downline_listing'),
            'records' => User::get_record($search, false, $user->id)->paginate(10),
            'search' =>  $search,
        ]);
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

