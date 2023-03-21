@extends('layouts.master-admin')

@section('title') Change Password @endsection

@section('contents')
    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">@lang('public.profile') / @lang('public.change_password')</h1>
        <a href="{{ route('admin_dashboard') }}" class="text-xl font-semibold text-[#FFA168]">@lang('public.back')</a>
    </div>

    <div class="block p-6 shadow-lg bg-[#FDFCF3] max-w-lg mx-auto mt-8">
        <form method="post" action="{{ route('admin_change_password') }}">
            @csrf
            <div class="form-group mb-6">
                <label for="newPassword" class="form-label inline-block mb-2 text-orange-400 font-semibold">@lang('public.current_password')</label>
                <input type="password" id="newPassword" name="current_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('current_password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.current_password')">
                @error('current_password')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-6">
                <label for="password" class="flex block mb-2 font-semibold text-orange-400">
                    @lang('public.new_password') <button data-popover-target="popover-description" data-popover-placement="bottom-start" type="button"><svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only"></span></button>
                    <div data-popover id="popover-description" role="tooltip" class="absolute z-10 invisible inline-block text-sm font-light text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                        <div class="p-3 space-y-2">
                            <h3 class="font-semibold text-gray-900 dark:text-white">@lang('public.password_type')</h3>
                            <p>@lang('public.password_validation_1')</p>
                            <p>@lang('public.password_validation_2')</p>
                            <p>@lang('public.password_validation_3')</p>
                            <p>@lang('public.password_validation_4')</p>
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                </label>
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
        </form>
    </div>
@endsection
