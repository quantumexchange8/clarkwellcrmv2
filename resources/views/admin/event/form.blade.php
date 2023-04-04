@extends('layouts.master-admin')

@section('title') {{ $title }} Event @endsection

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
            <h3 class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.event_image')</h3>
            @if($title == 'Edit')
                @if(@$post->event_image)
                    <div class="mb-4">
                        <a href="javascript:void(0)" class="text-primary" data-te-toggle="modal"
                           data-te-target="#eventModal-{{ @$post->id }}">
                            @lang('public.click_to_view')
                        </a>
                        @include('admin.event.modal')
                    </div>
                @endif
            @endif
            <div class="flex items-center justify-center w-full">
                <label for="event_image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-200 rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 @error('event_image') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="eventImage">
                        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <p class="mb-2 text-md text-gray-500 dark:text-gray-400"><span class="font-semibold">@lang('public.click_upload')</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">@lang('public.id_req')</p>
                    </div>
                    <input id="event_image" type="file" class="hidden" name="event_image" />
                    @error('event_image')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </label>
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
    <script>
        $(document).ready(function(e) {
            $("#event_image").change(function(){
                $("#eventImage").html(
                    `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 019 9v.375M10.125 2.25A3.375 3.375 0 0113.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 013.375 3.375M9 15l2.25 2.25L15 12" /></svg>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">@lang('public.file_uploaded')</p>
                `
                );
            });
        });
    </script>
@endsection

