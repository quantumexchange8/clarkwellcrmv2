@extends('layouts.master-without-nav')

@section('title') Reset Password @endsection

@section('contents')
    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8 bg-[#FDFCF3] rounded-lg">
            <a href="#" class="flex justify-center my-4 items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="h-20 mr-2" src="{{asset('img/CW.png')}}" alt="logo">
            </a>
            <p class="font-semibold	m-6 text-center text-lg text-gray-700">Reset Password</p>
            <form method="post" action="{{ url('reset-password') }}">@csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="form-group mb-4">
                    <label for="newPassword" class="block mb-2 font-semibold text-orange-400">New Password</label>
                    <input type="password" name="password" id="newPassword" placeholder="New Password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" id="password" @if(old('password')) value="{{ old('password') }}" @endif >
                    @error('password')
                    <div>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <div class="form-group mb-6">
                    <label for="reenterNewPassword" class="block mb-2 font-semibold text-orange-400">Re-enter New Password</label>
                    <input type="password" name="password_confirmation" id="reenterNewPassword" placeholder="Confirm Password" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" id="password" @if(old('password')) value="{{ old('password') }}" @endif >
                    @error('password')
                    <div>
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
                <button type="submit" class="w-full px-6 py-2.5 bg-orange-400 text-white font-medium text-sm leading-tight rounded shadow-md hover:bg-orange-700 hover:shadow-lg focus:bg-orange-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-orange-800 active:shadow-lg transition duration-150 ease-in-out">Reset Password</button>
                <p class="text-gray-800 mt-6 text-center">
                    <a href="{{ url()->previous() }}" class="text-md font-medium text-orange-600 hover:text-orange-800 focus:text-orange-700 transition duration-200 ease-in-out hover:underline">Back</a>
                </p>
            </form>
        </div>
    </div>
@endsection
