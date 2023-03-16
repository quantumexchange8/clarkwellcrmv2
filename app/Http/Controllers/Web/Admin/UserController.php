<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brokers;
use App\Models\Commissions;
use App\Models\Deposits;
use App\Models\SettingCountry;
use App\Models\User;
use App\Models\Withdrawals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Alert;
use Session;

class UserController extends Controller
{
    public function dashboard()
    {
        $total_group_sales = Deposits::getActiveUserDepositAmount();
        $total_withdrawals = Withdrawals::getApprovedWithdrawalAmount();
        $total_commissions = Commissions::getActiveUserCommissionsRebateAmount();
        $total_members = User::getActiveUsersCount();


        $brokers = Brokers::all();

        for ($i = 0; $i < $brokers->count(); $i++) {
            $broker = $brokers[$i];

            $personalTotal = Deposits::where('brokersId', $broker->id)->with('user')
                ->whereHas('user', function($q) {
                $q->where('status', User::STATUS_ACTIVE);
                })->sum('amount');

            $personalCommissionTotal = Commissions::where('brokersId', $broker->id)->with('user')
                ->whereHas('user', function($q) {
                    $q->where('status', User::STATUS_ACTIVE);
                })->sum('commissions_amount');

            $clients = Deposits::where('brokersId', $broker->id)->distinct()->count('userId');


            $brokers[$i]->data = [
                'total_deposit' => $personalTotal ?? 0,
                'total_commissions' => $personalCommissionTotal ?? 0,
                'clients' => $clients ?? 0,
            ];
        }

        return view('admin/dashboard', [
            'total_group_sales' => $total_group_sales,
            'total_withdrawals' => $total_withdrawals,
            'total_commissions' => $total_commissions,
            'total_members' => $total_members,
            'brokers' => $brokers
        ]);
    }

    public function profile(Request $request)
    {
//        dd($request->all());
        $validator = null;
        $user_id = Auth::id();
        $post = $user = User::find($user_id);

        if(!$user){
            Session::flash('fail_msg', 'Invalid User! Please try again later..');
            return redirect()->route('admin_dashboard');
        }

        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^[a-zA-Z0-9. -_]+$/u|max:100',
                'contact_number' => "required|unique:users,contact_number,{$user_id},id",
                'country' => 'required',
                'profile_image' => 'nullable|image',
            ])->setAttributeNames([
                'name' => 'Name',
                'contact_number' => 'Contact Number',
                'country' => 'Country',
                'profile_image' => 'Profile Image'
            ]);

            if (!$validator->fails()) {
                $user->update([
                    'name' => $request->input('name'),
                    'contact_number' => $request->input('contact_number'),
                    'country' => $request->input('country'),
                ]);

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

                Alert::success('Done', 'Successfully Updated Your Profile!');
                return redirect()->route('admin_dashboard');
            }
            $post = (object) $request->all();
        }

        return view('admin.profile', [
            'title' => 'Edit',
            'user' => $user,
            'post' => $post,
            'get_country_sel' => SettingCountry::get_country_sel(),
            'submit' => route('admin_profile'),
        ])->withErrors($validator);
    }
}
