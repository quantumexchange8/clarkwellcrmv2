@extends('layouts.master-without-nav')

@section('title') Register @endsection

@section('contents')
    <div class="p-6 space-y-4 md:space-y-6 sm:p-8 bg-[#FDFCF3] rounded-lg">
        <a href="javascript:void(0)" class="flex justify-center my-4 items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            <img class="h-20 mr-2" src="{{asset('img/CW.png')}}" alt="logo">
        </a>
        <h1 class="text-xl font-bold leading-tight tracking-tight md:text-2xl dark:text-white text-gray-900">Sign Up</h1>
        <p class="font-medium mb-6 text-gray-500">Please fill in all the details to join our great community.</p>

        <form method="post" action="{{ url('register') }}">@csrf

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 font-semibold text-orange-400">Name</label>
                    <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('name') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" @if(old('name')) value="{{ old('name') }}" @endif placeholder="Full Name" required>
                    @error('name')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block mb-2 font-semibold text-orange-400">Email</label>
                    <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('email') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" @if(old('email')) value="{{ old('email') }}" @endif placeholder="Email" required>
                    @error('email')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="countries" class="block mb-2 font-semibold text-orange-400">Country</label>
                    <div class="flex w-full">
                        <span id="flag" class="fi fi-us mx-4"></span>
                        <select id="countries" onchange= "onchangeDropdown()" name="country" class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('country') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror">
                            <option value="">
                                Please select your country
                            </option>
                            @foreach ($countries as $country)
                                <option value="{{ $country }}" @selected(old('country') == $country)>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('country')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block mb-2 font-semibold text-orange-400">Phone No.</label>
                    <input type="tel" id="phone" name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('phone') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" @if(old('phone')) value="{{ old('phone') }}" @endif placeholder="w. Country Code" required>
                    @error('phone')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-6">
                <label for="address" class="block mb-2 font-semibold text-orange-400">Address</label>
                <input type="text" id="address" @if(old('email')) value="{{ old('email') }}" @endif name="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('address') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="Address" required>
                @error('address')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="password" class="flex block mb-2 font-semibold text-orange-400">
                    Password <button data-popover-target="popover-description" data-popover-placement="bottom-start" type="button"><svg class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg><span class="sr-only"></span></button>
                    <div data-popover id="popover-description" role="tooltip" class="absolute z-10 invisible inline-block text-sm font-light text-gray-500 transition-opacity duration-300 bg-[#FDFCF3] border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                        <div class="p-3 space-y-2">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Password type</h3>
                            <p>Must include a-z & A-Z</p>
                            <p>Must include a number</p>
                            <p>Must include a special character</p>
                            <p>Must be between 8-15 words</p>
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                </label>
                <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="•••••••••" required>
                @error('password')
                <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-6">
                <label for="confirm_password" class="block mb-2 font-semibold text-orange-400">Confirm password</label>
                <input type="password" id="confirm_password" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange- @error('password') bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-red-100 dark:border-red-400 @enderror" placeholder="•••••••••" required>
            </div>
            <div class="flex items-start mb-3">
                <div class="flex items-center h-5">
                    <input id="terms" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-orange-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-orange-600 dark:ring-offset-gray-800 checked:bg-orange-600 checked:border-orange-600" required>
                </div>
                <label for="terms" class="ml-2 text-sm font-medium text-gray-600 dark:text-gray-300 mb-4">I have read, understood and accept the terms and conditions.</label>
            </div>
            <button type="submit" class="w-full px-6 py-2.5 bg-orange-400 text-white font-medium text-sm leading-tight rounded shadow-md hover:bg-orange-700 hover:shadow-lg focus:bg-orange-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-orange-800 active:shadow-lg transition duration-150 ease-in-out">Register</button>
        </form>
        <p class="text-gray-600 text-sm mt-6 text-center">Already have an account?
            <a href="{{url('/')}}" class="font-medium text-orange-500 hover:text-orange-700 focus:text-orange-700 transition duration-200 ease-in-out hover:underline">Login Here</a>
        </p>
    </div>
@endsection

@section('script')
    <script>
        function onchangeDropdown(){
            var x = document.getElementById("countries").value;
            x = JSON.parse(x);
            document.getElementById("flag").classList = 'fi fi-' + x.code +' mx-4'
            document.getElementById("phone").value = x.phonecode
        }
    </script>
@endsection
