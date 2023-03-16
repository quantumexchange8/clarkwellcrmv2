@extends('layouts.master-member')

@section('title') Change Password @endsection

@section('contents')
    <div class="block p-6 shadow-lg bg-[#FDFCF3] max-w-lg mx-auto">
        <a href="{{ url('member/dashboard') }}">
            <img class ="h-20 mx-auto my-6" src="{{url('/img/CW.png')}}">
        </a>
        <p class="font-semibold m-6 text-center text-lg text-gray-700">@lang('public.change_password')</p>
        <form method="post" action="{{ url('member/change-password') }}">@csrf
            <div class="form-group mb-6">
                <label for="newPassword" class="form-label inline-block mb-2 text-orange-400 font-semibold">@lang('public.current_password')</label>
                <input type="password" id="newPassword" name="current_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('current_password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.current_password')">
                @error('current_password')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-6">
                <label for="newPassword" class="form-label inline-block mb-2 text-orange-400 font-semibold">@lang('public.new_password')</label>
                <input type="password" id="newPassword" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.new_password')">
                @error('password')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-6">
                <label for="reenterNewPassword" class="form-label inline-block mb-2 text-orange-400 font-semibold">@lang('public.confirm_password')</label>
                <input type="password" id="reenterNewPassword" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange- @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.confirm_password')">
            </div>
            <button type="submit" class="
            w-full
            px-6
            py-2.5
            bg-orange-400
            text-white
            font-medium
            text-sm
            leading-tight
            rounded
            shadow-md
            hover:bg-orange-700 hover:shadow-lg
            focus:bg-orange-700 focus:shadow-lg focus:outline-none focus:ring-0
            active:bg-orange-800 active:shadow-lg
            transition
            duration-150
            ease-in-out">@lang('public.change_password')</button>
            <p class="text-gray-800 mt-6 text-center">
                <a href="{{ url('member/dashboard')}}" class="text-orange-600 hover:text-orange-700 focus:text-orange-700 transition duration-200 ease-in-out underline">@lang('public.back')</a>
            </p>
        </form>
    </div>
@endsection
