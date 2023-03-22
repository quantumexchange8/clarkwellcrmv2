<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrokerRequest;
use App\Http\Requests\UpdateBrokerRequest;
use App\Models\Brokers;
use App\Models\BrokersTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Alert;
use Session;

class BrokersController extends Controller
{
    private $path_url = 'uploads/brokers';

    /**
     * Display a listing.blade.php of the resource.
     */
    public function broker_listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['broker_search' => [
                        'freetext' =>  $request->input('freetext'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('broker_search');
                    break;
            }
        }

        $search = session('broker_search') ? session('broker_search') : $search;


        $posts = Brokers::translatedIn(app()->getLocale())
            ->latest()
            ->take(10)
            ->get();

        return view('admin.broker.listing', [
            'title' => 'Listing',
            'records' => Brokers::get_record($search, 10),
            'posts' => $posts,
            'search' =>  $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(StoreBrokerRequest $request)
    {
        $user = Auth::user();
        $brokerImageName = $qrImageName = null;
        $brokerImage = $request->file('broker_image');
        if ($brokerImage) {
            $brokerImageName = pathinfo($brokerImage->getClientOriginalName(), PATHINFO_FILENAME) . time() . '.' . $brokerImage->getClientOriginalExtension();
            $brokerImage->move($this->path_url, $brokerImageName);
        }

        $qrImage = $request->file('qr_image');
        if ($qrImage) {
            $qrImageName = pathinfo($qrImage->getClientOriginalName(), PATHINFO_FILENAME) . time() . '.' . $qrImage->getClientOriginalExtension();
            $qrImage->move($this->path_url, $qrImageName);
        }

        Brokers::create($request->validated()+[
            'url' => $request->url,
            'broker_image' => $brokerImageName,
            'qr_image' => $qrImageName,
            'userId' => $user->id]);

        Alert::success(trans('public.done'), trans('public.successfully_added_broker'));
        return redirect()->route('broker_listing');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function broker_add(Request $request)
    {
        $validator = null;
        $post = null;

        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'en.name' => 'required',
                'cn.name' => 'required',
                'tw.name' => 'required',
                'en.description' => 'required',
                'cn.description' => 'required',
                'tw.description' => 'required',
                'en.note' => 'required',
                'cn.note' => 'required',
                'tw.note' => 'required',
                'url' => 'required|url',
                'broker_image' => 'required|image',
                'qr_image' => 'required|image',
            ])->setAttributeNames([
                'en.name' => trans('public.name').' (EN)',
                'cn.name' => trans('public.name').' (CN)',
                'tw.name' => trans('public.name').' (TW)',
                'en.description' => trans('public.description').' (EN)',
                'cn.description' => trans('public.description').' (CN)',
                'tw.description' => trans('public.description').' (TW)',
                'en.note' => trans('public.note').' (EN)',
                'cn.note' => trans('public.note').' (CN)',
                'tw.note' => trans('public.note').' (TW)',
                'url' => trans('public.url'),
                'description' => trans('public.description'),
                'note' => trans('public.instructor_note'),
                'broker_image' => trans('public.broker_image'),
                'qr_image' => trans('public.qr_code'),
            ]);

            if (!$validator->fails())
            {
                $brokers_data = [
                    'en' => [
                        'name'       => $request->input('en.name'),
                        'description' => $request->input('en.description'),
                        'note' => $request->input('en.note'),
                    ],
                    'cn' => [
                        'name'       => $request->input('cn.name'),
                        'description' => $request->input('cn.description'),
                        'note' => $request->input('cn.note'),
                    ],
                    'tw' => [
                        'name'       => $request->input('tw.name'),
                        'description' => $request->input('tw.description'),
                        'note' => $request->input('tw.note'),
                    ],
                ];

                $user = Auth::user();
                $brokerImageName = $qrImageName = null;
                $brokerImage = $request->file('broker_image');
                if ($brokerImage) {
                    $brokerImageName = pathinfo($brokerImage->getClientOriginalName(), PATHINFO_FILENAME) . time() . '.' . $brokerImage->getClientOriginalExtension();
                    $brokerImage->move($this->path_url, $brokerImageName);
                }

                $qrImage = $request->file('qr_image');
                if ($qrImage) {
                    $qrImageName = pathinfo($qrImage->getClientOriginalName(), PATHINFO_FILENAME) . time() . '.' . $qrImage->getClientOriginalExtension();
                    $qrImage->move($this->path_url, $qrImageName);
                }

                Brokers::create($brokers_data+[
                    'url' => $request->url,
                    'broker_image' => $brokerImageName,
                    'qr_image' => $qrImageName,
                    'userId' => $user->id
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_added_broker'));
                return redirect()->route('broker_listing');
            }
            $post = (object) $request->all();
        }

        return view(' admin.broker.form', [
            'title' => 'Add',
            'submit' => route('broker_add'),
            'post' => $post,
        ])->withErrors($validator);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function broker_edit(Request $request, $id)
    {
        $validator = null;
        $post = $broker = Brokers::find($id);

        if (!$broker) {
            Alert::error(trans('public.invalid_broker'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'en.name' => 'required',
                'cn.name' => 'required',
                'tw.name' => 'required',
                'en.description' => 'required',
                'cn.description' => 'required',
                'tw.description' => 'required',
                'en.note' => 'required',
                'cn.note' => 'required',
                'tw.note' => 'required',
                'url' => 'required|url',
                'broker_image' => 'image',
                'qr_image' => 'image',
            ])->setAttributeNames([
                'en.name' => trans('public.name').' (EN)',
                'cn.name' => trans('public.name').' (CN)',
                'tw.name' => trans('public.name').' (TW)',
                'en.description' => trans('public.description').' (EN)',
                'cn.description' => trans('public.description').' (CN)',
                'tw.description' => trans('public.description').' (TW)',
                'en.note' => trans('public.note').' (EN)',
                'cn.note' => trans('public.note').' (CN)',
                'tw.note' => trans('public.note').' (TW)',
                'url' => trans('public.url'),
                'description' => trans('public.description'),
                'note' => trans('public.instructor_note'),
                'broker_image' => trans('public.broker_image'),
                'qr_image' => trans('public.qr_code'),
            ]);

            if (!$validator->fails()) {
                $brokerImage = $request->file('broker_image');
                if ($brokerImage) {
                    File::delete($this->path_url . '/' . $broker->broker_image);
                    $brokerImageName = pathinfo($brokerImage->getClientOriginalName(), PATHINFO_FILENAME) . time() . '.' . $brokerImage->getClientOriginalExtension();
                    $brokerImage->move($this->path_url, $brokerImageName);
                    $broker->broker_image = $brokerImageName;
                }

                $qrImage = $request->file('qr_image');
                if ($qrImage) {
                    File::delete($this->path_url . '/' . $broker->qr_image);
                    $qrImageName = pathinfo($qrImage->getClientOriginalName(), PATHINFO_FILENAME) . time() . '.' . $qrImage->getClientOriginalExtension();
                    $qrImage->move($this->path_url, $qrImageName);
                    $broker->qr_image = $qrImageName;
                }

                $brokers_data = [
                    'en' => [
                        'name'       => $request->input('en.name'),
                        'description' => $request->input('en.description'),
                        'note' => $request->input('en.note'),
                    ],
                    'cn' => [
                        'name'       => $request->input('cn.name'),
                        'description' => $request->input('cn.description'),
                        'note' => $request->input('cn.note'),
                    ],
                    'tw' => [
                        'name'       => $request->input('tw.name'),
                        'description' => $request->input('tw.description'),
                        'note' => $request->input('tw.note'),
                    ],
                ];

                $broker->update($brokers_data+[
                    'url' => $request->input('url'),
                    'updated_at' => now(),
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_updated_broker'));
                return redirect()->route('broker_listing');
            }

            $post = (object) $request->all();
        }

        return view('admin.broker.form', [
            'title' => 'Edit',
            'submit' => route('broker_edit', $id),
            'broker' => $broker,
            'post' => $post,
        ])->withErrors($validator);
    }

    public function delete(Request $request)
    {
        $broker_id = $request->input('broker_id');
        $broker = Brokers::find($broker_id);

        if (!$broker) {
            Alert::error(trans('public.invalid_broker'), trans('public.try_again'));
            return redirect('broker_listing');
        }

        $broker->update([
            'deleted_at' => now()
        ]);

        Alert::success(trans('public.done'), trans('public.successfully_deleted_broker'));
        return redirect()->route('broker_listing');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $broker = Brokers::find($id);
        $broker->delete();
        return back();
    }
}
