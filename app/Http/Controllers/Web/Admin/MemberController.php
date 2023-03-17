<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\ExportUser;
use App\Http\Controllers\Controller;
use App\Models\ActionLogs;
use App\Models\Brokers;
use App\Models\Deposits;
use App\Models\Rankings;
use App\Models\SettingCountry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use Alert;
use Session;

class MemberController extends Controller
{
    public function member_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['member_search' => [
                        'freetext' =>  $request->input('freetext'),
                        'created_start' => $request->input('created_start'),
                        'created_end' => $request->input('created_end'),
                    ]]);
                    break;
                case 'export':
                    $now = Carbon::now()->format('YmdHis');
                    return Excel::download(new ExportUser(null, $request->input('freetext'), $request->input('created_start'), $request->input('created_end')), $now . '-users-records.xlsx');
                case 'reset':
                    session()->forget('member_search');
                    break;
            }
        }

        $search = session('member_search') ? session('member_search') : $search;

        return view('admin.member.listing', [
            'submit' => route('member_listing'),
            'records' => User::get_record($search, 10),
            'search' =>  $search,
        ]);
    }

    public function member_add(Request $request)
    {
        $validator = null;
        $post = null;

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                'contact_number' => "required|unique:users,contact_number",
                'email' => "required|unique:users,email",
                'password' => ['required', 'string', 'max:15', 'confirmed',
                    Password::min(8)->letters()->numbers()->mixedCase()->symbols()],
                'role' => 'required',
                'rankId' => 'required',
                'address' => 'required|max:255',
                'country' => 'required',
                'status' => 'required',
//                'profile_image' => 'nullable|image',
            ])->setAttributeNames([
                'name' => 'Name',
                'contact_number' => 'Contact Number',
                'email' => 'Email',
                'password' => 'Password',
                'confirm_password' => 'Confirm Password',
                'address' => 'Address',
                'role' => 'Role',
                'rankId' => 'Rank',
                'country' => 'Country',
                'status' => 'Status',
//                'profile_image' => 'Profile Image'
            ]);

            if (!$validator->fails()) {
                 User::create([
                    'name' => $request->input('name'),
                    'contact_number' => $request->input('contact_number'),
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'role' => $request->input('role'),
                    'address' => $request->input('address'),
                    'rankId' => $request->input('rankId'),
                    'country' => $request->input('country'),
                    'status' => $request->input('status'),
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_added_member'));
                return redirect()->route('member_listing');
            }

            $post = (object) $request->all();
        }

        return view('admin.member.form', [
           'title' => 'Add',
           'post' => $post,
           'submit' => route('member_add'),
            'get_role_sel' => [1 => 'Member', 2 => 'Admin'],
            'get_rank_sel' => Rankings::get_rank_sel(),
            'get_status_sel' => [ 1 => 'Active', 2 => 'Inactive', 3 => 'Suspended' ],
            'get_country_sel' => SettingCountry::get_country_sel(),
        ])->withErrors($validator);
    }

    public function member_edit(Request $request, $id)
    {
        $validator = null;
        $post = User::find($id);
        $user = User::find($id);

        if (!$user)
        {
            Alert::error(trans('public.invalid_user'), trans('public.try_again'));
            return redirect()->back();
        }

        $post->password = 'Testtest__123';

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                'contact_number' => "required|unique:users,contact_number,{$user->id},id",
                'email' => "required|unique:users,email,{$user->id},id",
                'password' => ['required', 'string', 'max:15', 'confirmed',
                Password::min(8)->letters()->numbers()->mixedCase()->symbols()],
                'rankId' => 'required',
                'country' => 'required',
                'status' => 'required',
                'profile_image' => 'nullable|image',
            ])->setAttributeNames([
                'name' => 'Name',
                'contact_number' => 'Contact Number',
                'email' => 'Email',
                'password' => 'Password',
                'rankId' => 'Rank',
                'country' => 'Country',
                'status' => 'Status',
                'profile_image' => 'Profile Image'
            ]);

            if (!$validator->fails()) {
                $update_detail = [
                    'name' => $request->input('name'),
                    'contact_number' => $request->input('contact_number'),
                    'email' => $request->input('email'),
                    'rankId' => $request->input('rankId'),
                    'country' => $request->input('country'),
                    'status' => $request->input('status'),
                ];

                $profile_image = $request->file('profile_image');
                if ($profile_image) {
                    if ($user->profile_image) {
                        File::delete('uploads/users/' . $user->profile_image);
                    }
                    $imageName = time() . '.' . $profile_image->getClientOriginalExtension();
                    $resize_upload = Image::make( $profile_image->path() )
                        ->fit(250, 250);
                    $resize_upload->save(public_path('/uploads/users/'.$imageName));
                    $user->profile_image = $imageName;
                    $user->save();
                }

                if ($request->input('password') != 'Testtest__123') {
                    $update_detail['password'] = Hash::make($request->input('password'));
                }
                $user->update($update_detail);

                Alert::success(trans('public.done'), trans('public.successfully_updated_member'));
                return redirect()->route('member_details', $id);
            }

            $post = (object) $request->all();
        }

        return view('admin.member.form', [
            'user' => $user,
            'post' => $post,
            'title' => 'Edit',
            'submit' => route('member_edit', $id),
            'get_role_sel' => [1 => 'Member', 2 => 'Admin'],
            'get_rank_sel' => Rankings::get_rank_sel(),
            'get_status_sel' => [ 1 => 'Active', 2 => 'Inactive', 3 => 'Suspended' ],
            'get_country_sel' => SettingCountry::get_country_sel(),
        ])->withErrors($validator);
    }

    public function member_details(Request $request, $id)
    {
        $post = $user = User::find($id);
        $rank = $user->rank;
        $tempName =  explode(" ",$rank->name);
        $validator = null;

        if (!$user) {
            Alert::error(trans('public.invalid_user'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'rankId' => 'required',
            ])->setAttributeNames([
                'rankId' => 'Change Ranking',
            ]);

            if (!$validator->fails()) {
                $user->update([
                    'rankId' => $request->input('rankId'),
                    'auto_rank_up' => $request->input('auto_rank_up') == 'on' ? 1 : 0,
                    'rank_update_at' => Carbon::now()->toDateTimeString(),
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_updated_rank'));
                return redirect()->route('member_details', $id);
            }

            $post = (object) $request->all();
        }

        return view('admin.member.detail', [
            'user' => $user,
            'post' => $post,
            'get_rank_sel' => Rankings::get_rank_sel(),
        ])->withErrors($validator);
    }

    public function member_deposit(Request $request, $id)
    {
        $search = array();

        $user = User::find($id);
        $rank = $user->rank;
        $tempName =  explode(" ",$rank->name);

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

//            dd($request->all());
            switch ($submit_type) {
                case 'search':
                    session(['deposit_search' => [
                        'brokersId' => $request->input('brokersId'),
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

//        $deposits = Deposits::get_record($search, 10);

        $total_deposit = Deposits::query()
            ->with('user')
            ->where('userId', $id)
            ->sum('amount');

        $deposit_by_group = $user->personalDepositsByBrokers();

        return view('admin.member.deposit', [
            'user' => $user,
            'total_deposit' => $total_deposit,
            'deposits' => Deposits::get_record($search, $id, 8),
            'deposit_by_group' => $deposit_by_group,
            'get_broker_sel' => ['' => trans('public.choose_broker')] + Brokers::get_broker_sel(),
        ]);
    }
    public function transfer_network(Request $request)
    {
        $data = $request->all();

        if ($data['user'] == $data['parent']) {
            return back()->withErrors("Both users cannot be same.");
        }
        $user = User::find($data['user']);
        $new_parent = User::find($data['parent']);

        if ($user->upline_referral_id != $new_parent->id) {

            if (str_contains($new_parent->hierarchyList, $user->id)) {
                $new_parent->hierarchyList = $user->hierarchyList;
                $new_parent->upline_referral_id = $user->upline_referral_id;
                $new_parent->save();
            }

            if (empty($new_parent->hierarchyList)) {
                $user_hierarchy = "-" . $new_parent->id . "-";
            } else {
                $user_hierarchy = $new_parent->hierarchyList . $new_parent->id . "-";
            }

            $this->updateHierarchyList($user, $user_hierarchy, '-' . $user->id . '-');

            $user->hierarchyList = $user_hierarchy;
            $user->upline_referral_id = $new_parent->id;
            $user->save();
        }
    }

    private function updateHierarchyList($user, $list, $id)
    {
        $children = $user->children;
        if (count($children)) {
            foreach ($children as $child) {
                //$child->hierarchyList = substr($list, -1) . substr($child->hierarchyList, strpos($child->hierarchyList, $id) + strlen($id));
                $child->hierarchyList = substr($list, 0, -1) . $id;
                $child->save();
                $this->updateHierarchyList($child, $list, $id . $child->id . '-');
            }
        }
    }

    public function impersonate(Request $request)
    {
        if ($request->user_id) {
            $admin =  Auth::user();
            FacadesSession::put('impersonate-admin-id', $admin->id);
            FacadesSession::put('temp-admin-token', FacadesSession::get('jwt-token'));
            $user = User::find($request->user_id);
            $token = Auth::fromUser($user);
            FacadesSession::put('jwt-token', $token);
            ActionLogs::create([
                'user_id' => $admin->id,
                'type' => get_class($user),
                'description' =>  'Admin with id: '. $admin->id .' has IMPERSONATE user with id: '. $user->id,
            ]);
            return redirect()->route('member_dashboard');
        }


        Alert::error(trans('public.invalid_action'), trans('public.try_again'));
        return redirect()->route('member_listing');
    }


}
