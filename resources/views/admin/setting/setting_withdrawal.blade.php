@extends('layouts.master-admin')

@section('title') {{ $title }} Setting @endsection

@section('css')
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet" />
@endsection

@section('contents')
    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.setting') / @lang('public.withdrawal_action')</h1>
        <a href="{{ route('setting_listing') }}" class="text-xl font-semibold text-[#FFA168]">@lang('public.back')</a>
    </div>

    <form class="space-y-6" action="{{ $submit }}" method="post">
        @csrf
        <p class="block font-bold text-[#FFA168] dark:text-white">@lang('public.choose_type')</p>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex items-center pl-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                <input id="value_type" type="radio" checked value="personal" name="withdrawal_setting_type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="value_type" class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">@lang('public.personal')</label>
            </div>
            <div class="flex items-center pl-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                <input id="value_type" type="radio" value="group" name="withdrawal_setting_type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="value_type" class="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">@lang('public.group')</label>
            </div>
        </div>
        <div class="text-value">
            <label for="user" class="block mb-6 font-bold text-[#FFA168] dark:text-white">User</label>
            <select class="js-example-basic-single w-full max-w-sm" id="user" name="user">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <label for="countries" class="block mb-6 font-bold text-[#FFA168] dark:text-white">@lang('public.select_action')</label>
        {!! Form::select('withdrawal_action', $get_withdrawal_sel, @$post['withdrawal_action'], ['class' => 'font-medium text-sm max-w-sm placeholder:text-gray-400 text-gray-500 bg-gray-50 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}



        <button type="submit" class="w-full text-white bg-[#4DA5FF] hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('public.update_setting')</button>
    </form>


@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function(e){
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection

