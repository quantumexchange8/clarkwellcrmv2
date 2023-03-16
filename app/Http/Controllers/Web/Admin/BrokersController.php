<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrokerRequest;
use App\Http\Requests\UpdateBrokerRequest;
use App\Models\Brokers;
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

        return view('admin.broker.listing', [
            'title' => 'Listing',
            'records' => Brokers::get_record($search, 10),
            'search' =>  $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
                'name' => 'required',
                'description' => 'required',
                'note' => 'required',
                'url' => 'required|url',
                'broker_image' => 'required|image|dimensions:max_width=256,max_height=256',
                'qr_image' => 'required|image|dimensions:max_width=256,max_height=256',
            ], [
                'broker_image.dimensions' => 'The broker image required image with 200x200 pixels.',
                'qr_image.display_length' => 'The maximum dimensions of qr_image is 512x256 pixels',
            ])->setAttributeNames([
                'url' => 'URL',
                'description' => 'Description',
                'note' => 'Instructor Notes',
                'broker_image' => 'Broker Image',
                'qr_image' => 'QR Code',
            ]);

            if (!$validator->fails()) {
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

                Brokers::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'note' => $request->note,
                    'url' => $request->url,
                    'broker_image' => $brokerImageName,
                    'qr_image' => $qrImageName,
                    'userId' => $user->id
                ]);

                Alert::success('Done', 'Successfully Added Broker.');
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
            Alert::error('Invalid Broker Profile', 'Please Try Again Later..');
            return redirect()->back();
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'note' => 'required',
                'url' => 'required|url',
                'broker_image' => 'image|dimensions:max_width=256,max_height=256',
                'qr_image' => 'image|dimensions:max_width=256,max_height=256',
            ], [
                'broker_image.dimensions' => 'The broker image required image with 200x200 pixels.',
                'qr_image.display_length' => 'The maximum dimensions of qr_image is 512x256 pixels',
            ])->setAttributeNames([
                'url' => 'URL',
                'description' => 'Description',
                'note' => 'Instructor Notes',
                'broker_image' => 'Broker Image',
                'qr_image' => 'QR Code',
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

                $broker->name = $request->name;
                $broker->description = $request->description;
                $broker->note = $request->note;
                $broker->url = $request->url;
                $broker->updated_at = now();
                $broker->save();

                Alert::success('Done', 'Successfully Updated Broker Profile');
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
            Alert::error('Invalid Broker Profile', 'Please try again later..');
            return redirect('broker_listing');
        }

        $broker->update([
            'deleted_at' => now()
        ]);

        Alert::success('Done', "Successfully Deleted Broker Profile.");
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
