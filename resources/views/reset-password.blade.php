@extends('layouts.master-without-nav')

@section('title') Reset Password @endsection

@section('contents')
    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdownLanguage" class="text-gray-500 font-bolded text-md px-4 py-2.5 float-right" type="button">
            @switch(app()->getLocale())
                @case('en')
                    <span class="fi fi-us mr-3 "></span>
                    EN
                    @break

                @case('cn')
                    <span class="fi fi-cn mr-3 "></span>
                    简体字
                    @break


                @case('tw')
                    <span class="fi fi-tw mr-3 "></span>
                    繁体字
                    @break

                @default
                    <span class="fi fi-us mr-3 "></span>
                    EN
            @endswitch
        </button>
        <div id="dropdownLanguage" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                <li>
                    <a href="{{ url('localization/en') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><span class="fi fi-us mr-3"></span>English</a>
                </li>
                <li>
                    <a href="{{ url('localization/cn') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><span class="fi fi-cn mr-3"></span>简体字</a>
                </li>
                <li>
                    <a href="{{ url('localization/tw') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><span class="fi fi-tw mr-3"></span>繁体字</a>
                </li>
            </ul>
        </div>
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8 bg-[#FDFCF3] rounded-lg">
            <a href="#" class="flex justify-center my-4 items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="h-20 mr-2" src="{{asset('img/CW.png')}}" alt="logo">
            </a>
            <p class="font-semibold	m-6 text-center text-lg text-gray-700">@lang('public.reset_password')</p>
            <form method="post" action="{{ url('reset-password') }}">@csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="form-group mb-4">
                    <label for="password" class="flex block mb-2 font-semibold text-orange-400">
                        @lang('public.password') <button data-popover-target="popover-description" data-popover-placement="bottom-start" type="button"><svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only"></span></button>
                        <div data-popover id="popover-description" role="tooltip" class="absolute z-10 invisible inline-block text-sm font-light text-gray-700 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
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
                    <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="@lang('public.password')">
                    @error('password')
                    <div>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div class="form-group mb-6">
                    <label for="reenterNewPassword" class="block mb-2 font-semibold text-orange-400">@lang('public.confirm_password')</label>
                    <input type="password" name="password_confirmation" id="reenterNewPassword" placeholder="@lang('public.confirm_password')" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" id="password" @if(old('password')) value="{{ old('password') }}" @endif >
                    @error('password')
                    <div>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <button type="submit" class="w-full px-6 py-2.5 bg-orange-400 text-white font-medium text-sm leading-tight rounded shadow-md hover:bg-orange-700 hover:shadow-lg focus:bg-orange-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-orange-800 active:shadow-lg transition duration-150 ease-in-out">@lang('public.reset_password')</button>
                <p class="text-gray-800 mt-6 text-center">
                    <a href="{{ url()->previous() }}" class="text-md font-medium text-orange-600 hover:text-orange-800 focus:text-orange-700 transition duration-200 ease-in-out hover:underline">@lang('public.back')</a>
                </p>
            </form>
        </div>
    </div>
@endsection
