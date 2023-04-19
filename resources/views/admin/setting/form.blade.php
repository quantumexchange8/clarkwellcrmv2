@extends('layouts.master-admin')

@section('title') {{ $title }} @lang('public.setting') @endsection

@section('contents')
    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.setting') / @lang('public.update_setting')</h1>
        <a href="{{ route('setting_listing') }}" class="text-xl font-semibold text-[#FFA168]">@lang('public.back')</a>
    </div>

    <form class="space-y-6" action="{{ $submit }}" method="post">
        @csrf
        <div>
            <label for="title" class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.title')</label>
            <input type="text" name="title" id="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Setting Title" value="{{ ucfirst(str_replace('_', ' ', @$setting->name)) }}" disabled>
        </div>
        <div>
            <label for="content" class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.value')</label>
            <input type="text" name="value" id="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white @error('value') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.value')" value="{{ @$post->value }}">
            @error('value')
            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="w-full text-white bg-[#4DA5FF] hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('public.update_setting')</button>
    </form>


@endsection

