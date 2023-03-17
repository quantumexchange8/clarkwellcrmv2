<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Alert;
use Session;

class NewsController extends Controller
{
    public function news_listing(Request $request)
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

        return view('admin.news.listing', [
            'news_all' => Announcements::get_record($search, 10),
            'search' =>  $search,
        ]);
    }

    public function create_news(Request $request)
    {
        $validator = null;
        $post = null;

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'content' => 'required',
            ])->setAttributeNames([
                'title' => trans('public.title'),
                'content' => trans('public.description'),
            ]);

            if (!$validator->fails()) {

                Announcements::create([
                    'title' => $request->input('title'),
                    'content' => $request->input('content'),
                    'visibility' => $request->input('visibility') == 'on' ? 1 : 0,
                    'userId' => Auth::user()->id,
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_added_news'));
                return redirect()->route('news_listing');
            }

            $post = (object) $request->all();

        }

        return view('admin.news.form', [
            'post' => $post,
            'title' => 'Add',
            'submit' => route('create_news'),
        ])->withErrors($validator);
    }

    public function news_edit(Request $request, $id)
    {
        $validator = null;
        $post = $news = Announcements::find($id);

        if (!$news) {
            Alert::error(trans('public.invalid_news'), trans('public.try_again'));
            return redirect()->back();
        }

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'content' => 'required',
            ])->setAttributeNames([
                'title' => trans('public.title'),
                'content' => trans('public.description'),
            ]);

            if (!$validator->fails()) {

                $news->update([
                    'title' => $request->input('title'),
                    'content' => $request->input('content'),
                    'visibility' => $request->input('visibility') == 'on' ? 1 : 0,
                    'userId' => Auth::user()->id,
                ]);

                Alert::success(trans('public.done'), trans('public.successfully_updated_news'));
                return redirect()->route('news_listing');
            }

            $post = (object) $request->all();

        }

        return view('admin.news.form', [
            'post' => $post,
            'submit' => route('news_edit', $id),
            'title' => 'Edit',
        ])->withErrors($validator);
    }

    public function delete(Request $request)
    {
        $news_id = $request->input('news_id');
        $news = Announcements::find($news_id);

        if (!$news) {
            Alert::error(trans('public.invalid_news'), trans('public.try_again'));
            return redirect()->route('news_listing');
        }

        $news->update([
            'deleted_at' => now()
        ]);

        Alert::success(trans('public.done'), trans('public.successfully_deleted_news'));
        return redirect()->route('news_listing');
    }}
