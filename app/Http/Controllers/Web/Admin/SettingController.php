<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActionLogs;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Alert;

class SettingController extends Controller
{
    public function listing(Request $request)
    {
        return view('admin.setting.listing', [
            'settings' => Settings::query()->paginate(10),
        ]);
    }

    public function setting_edit(Request $request, $id)
    {
        $validator = null;
        $post = $setting = Settings::find($id);
        $user = Auth::user();

        if (!$setting) {
            Alert::error(trans('public.invalid_setting'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'value' => 'required',
            ])->setAttributeNames([
                'value' => trans('public.value'),
            ]);

            if (!$validator->fails()) {

                $setting_value_type = $request->input('setting_value_type');

                if($setting_value_type == 'text')
                {
                    $setting->update([
                        'setting_value_type' => $setting_value_type,
                        'value' => $request->input('value'),
                    ]);

                    ActionLogs::create([
                        'user_id' => $user->id,
                        'type' => get_class($setting),
                        'description' => $user->name. ' has EDITED value type to ' . $setting_value_type . ' with value ' . $request->input('value') . ' with id: '. $setting->id,
                    ]);
                }
                else
                {
                    $setting->update([
                        'setting_value_type' => $setting_value_type,
                        'value' => $request->input('date_value'),
                    ]);

                    ActionLogs::create([
                        'user_id' => $user->id,
                        'type' => get_class($setting),
                        'description' => $user->name. ' has EDITED value type to ' . $setting_value_type . ' with value ' . $request->input('date_value') . ' with id: '. $setting->id,
                    ]);
                }



                Alert::success(trans('public.done'), trans('public.successfully_updated_setting'));
                return redirect()->route('setting_listing');
            }

            $post = (object) $request->all();

        }

        return view('admin.setting.form', [
            'post' => $post,
            'setting' => $setting,
            'submit' => route('setting_edit', $id),
            'title' => 'Edit',
        ])->withErrors($validator);
    }
}
