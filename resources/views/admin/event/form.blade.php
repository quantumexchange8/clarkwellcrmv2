@extends('layouts.master-admin')

@section('title') {{ $title }} Event @endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('contents')
    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.event') / {{ $title == 'Add' ? trans('public.create_event') : trans('public.update_event') }}</h1>
        <a href="{{ route('event_listing') }}" class="text-xl font-semibold text-[#FFA168]">@lang('public.back')</a>
    </div>

    <form class="space-y-6" action="{{ $submit }}" enctype="multipart/form-data" method="post">
        @csrf
        <div>
            <label for="event_title" class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.event_title')</label>
            <input type="text" name="event_title" id="event_title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white @error('event_title') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.event_title')" value="{{ @$post->event_title }}">
            @error('event_title')
            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <div>
                <label for="event_image" class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.event_image')</label>
                <textarea id="event_image" class="@error('event_image') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" name="event_image">{!! @$post->event_image !!}</textarea>
                @error('event_image')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div>
            <h3 class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.visible')</h3>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="visibility" value="on" class="sr-only peer" @if(@$post->visibility == 1) checked @endif>
                <span class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-[#FFA168]"></span>
            </label>
        </div>
        <div>
            <h3 class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.popup_status')</h3>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="pop_up_status" value="on" class="sr-only peer" @if(@$post->pop_up_status == 1) checked @endif>
                <span class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-[#FFA168]"></span>
            </label>
        </div>

        @if($title == 'Add')
            <button type="submit" class="w-full text-white bg-[#FFA168] hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">@lang('public.create_event')</button>
        @elseif($title = 'Edit')
            <button type="submit" class="w-full text-white bg-[#4DA5FF] hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('public.update_event')</button>
        @endif
    </form>


@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function(e) {

            $('#event_image').summernote({
                placeholder: '@lang('public.event_image')',
                tabsize: 2,
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['insert', ['link', 'picture', 'video']],
                ]
            });
        });
    </script>
@endsection

