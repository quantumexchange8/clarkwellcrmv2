<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Alert;

class EventController extends Controller
{
    private $path_url = 'uploads/events';

    public function listing(Request $request)
    {
        $search = array();

        if ($request->isMethod('post')) {
            $submit_type = $request->input('submit');

            switch ($submit_type) {
                case 'search':
                    session(['news_search' => [
                        'freetext' =>  $request->input('freetext'),
                    ]]);
                    break;
                case 'reset':
                    session()->forget('news_search');
                    break;
            }
        }

        $search = session('news_search') ? session('news_search') : $search;

        return view('admin.event.listing', [
            'events' => Event::get_record($search, 10),
            'search' =>  $search,
        ]);
    }

    public function create_event(Request $request)
    {
        $validator = null;
        $post = null;

//        dd($request->all());

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'event_title' => 'required|max:255',
                'event_image' => 'required|image|max:5120',
            ])->setAttributeNames([
                'event_title' => trans('public.event_title'),
                'event_image' => trans('public.event_image'),
            ]);

            if (!$validator->fails()) {

                $event_image_name = null;
                $event_image = $request->file('event_image');
                if ($event_image) {
                    $event_image_name = pathinfo($event_image->getClientOriginalName(), PATHINFO_FILENAME) . time() . '.' . $event_image->getClientOriginalExtension();
                    $event_image->move($this->path_url, $event_image_name);
                }

                Event::create([
                    'event_title' => $request->input('event_title'),
                    'event_image' => $event_image_name,
                    'visibility' => $request->input('visibility') == 'on' ? 1 : 0,
                    'pop_up_status' => $request->input('pop_up_status') == 'on' ? 1 : 0,
                    'user_id' => Auth::user()->id,
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_added_event'));
                return redirect()->route('event_listing');
            }

            $post = (object) $request->all();

        }

        return view('admin.event.form', [
            'post' => $post,
            'title' => 'Add',
            'submit' => route('create_event'),
        ])->withErrors($validator);
    }

    public function event_edit(Request $request, $id)
    {
        $validator = null;
        $post = $event = Event::find($id);

        if (!$event) {
            Alert::error(trans('public.invalid_event'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'event_title' => 'required|max:255',
            ])->setAttributeNames([
                'event_title' => trans('public.event_title'),
            ]);

            if (!$validator->fails()) {

                $event_image = $request->file('event_image');
                if ($event_image) {
                    File::delete($this->path_url . '/' . $event->event_image);
                    $event_image_name = pathinfo($event_image->getClientOriginalName(), PATHINFO_FILENAME) . time() . '.' . $event_image->getClientOriginalExtension();
                    $event_image->move($this->path_url, $event_image_name);
                    $event->event_image = $event_image_name;
                }

                $event->update([
                    'event_title' => $request->input('event_title'),
                    'visibility' => $request->input('visibility') == 'on' ? 1 : 0,
                    'pop_up_status' => $request->input('pop_up_status') == 'on' ? 1 : 0,
                    'userId' => Auth::user()->id,
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_updated_event'));
                return redirect()->route('event_listing');
            }

            $post = (object) $request->all();

        }

        return view('admin.event.form', [
            'post' => $post,
            'event' => $event,
            'submit' => route('event_edit', $id),
            'title' => 'Edit',
        ])->withErrors($validator);
    }

    public function delete(Request $request)
    {
        $event_id = $request->input('event_id');
        $event = Event::find($event_id);

        if (!$event) {
            Alert::error(trans('public.invalid_event'), trans('public.try_again'));
            return redirect()->route('event_listing');
        }

        $event->update([
            'deleted_at' => now()
        ]);

        Alert::success(trans('public.done'), trans('public.successfully_deleted_event'));
        return redirect()->route('event_listing');
    }
}
