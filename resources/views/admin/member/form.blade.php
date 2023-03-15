@extends('layouts.master-admin')

@section('title') Member {{ $title }} @endsection

@section('contents')

    <div class="flex flex-row">
        @if($title == 'Add')
            <h1 class="flex-1 font-semibold text-2xl text-gray-500">Members / {{ $title }}</h1>
            <a href="{{ route('member_listing') }}" class=" font-semibold text-md text-gray-500 rounded-lg px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 dark:hover:bg-[#050708]/30 mr-2 mb-2">
                <svg class="h-4 w-4 text-white"  fill="none" viewBox="0 0 24 24" stroke="#fb923c">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                </svg>
                <span class="ml-4 text-xl text-orange-400">Cancel</span>
            </a>
        @elseif($title == 'Edit')
            <h1 class="flex-1 font-semibold text-2xl text-gray-500">Members / {{ @$user->name }} - EDIT Profile</h1>
            <a href="{{ route('member_details', @$user->id) }}" class=" font-semibold text-md text-gray-500 rounded-lg px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 dark:hover:bg-[#050708]/30 mr-2 mb-2">
                <svg class="h-4 w-4 text-white"  fill="none" viewBox="0 0 24 24" stroke="#fb923c">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                </svg>
                <span class="ml-4 text-xl text-orange-400">Cancel</span>
            </a>
        @endif
    </div>
    @if($errors->any())
        @foreach($errors->all() as $key => $error)
            <div id="toast-danger-{{ $key }}" class="absolute top-30 right-10 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Error icon</span>
                </div>
                <div class="ml-3 font-normal">{{ $error }}</div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-danger-{{ $key }}" aria-label="Close">

                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        @endforeach
    @endif


    <form method="post" action="{{ $submit }}" enctype="multipart/form-data">
        @csrf
        <div class="bg-[#FDFCF3] shadow-lg p-8">
            <h3 class="text-gray-500 font-bold text-xl mb-4">Member Access</h3>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="email" class="block mb-2 font-semibold text-md text-orange-400 dark:text-white">Email Address</label>
                    <input type="email" id="email" name="email" class="font-medium text-md placeholder:text-gray-400 text-gray-500 bg-gray-50 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="email@company.com" value="{{ @$post->email }}" required>
                </div>
                <div>
                    <label for="rank" class="block mb-2 font-semibold text-md text-orange-400 dark:text-white">Role</label>
                    {!! Form::select('role', $get_role_sel, @$post->role, ['class' => 'font-medium text-md text-gray-500 bg-gray-50 border border-gray-300 text-md placeholder:text-gray-400 text-gray-500 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                </div>
                <div>
                    <label for="password" class="block mb-2 font-semibold text-md text-orange-400 dark:text-whit">Password</label>
                    <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" value="{{ @$post->password }}">
                </div>
                <div>
                    <label for="confirm_password" class="block mb-2 font-semibold text-md text-orange-400 dark:text-whit">Confirm password</label>
                    <input type="password" id="confirm_password" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" value="{{ @$post->confirm_password ?? @$post->password }}">
                </div>
            </div>
        </div>
        <div class="bg-[#FDFCF3] shadow-lg p-8 mt-6">
            <h3 class="text-gray-500 font-bold text-xl mb-4">Member Details</h3>
            @if($title == 'Edit')
                <div class="flex flex-col items-center p-8">
                    <div class="relative inline-flex items-center justify-center w-20 h-20 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600">
                        @if (@$user->profile_image)
                            <img src="{{ asset('uploads/users/' .@$user->profile_image)}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                        @else
                            <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                        @endif
                    </div>
                    <div class="mt-4">
                        <label class="font-semibold text-md text-gray-500 block mb-2 text-gray-900 dark:text-white" for="file_input">Upload file</label>
                        <input class="font-medium text-md text-gray-500 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 file" name="profile_image" id="file_input" type="file" accept="image/png, image/gif, image/jpeg">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG or JPEG (MAX. 250 x 250 px).</p>
                    </div>
                </div>
            @endif
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 font-semibold text-md text-orange-400 dark:text-white">Name</label>
                    <input type="text" id="name" name="name" class="font-medium text-md placeholder:text-gray-400 text-gray-500 bg-gray-50 border border-gray-300  rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Full Name" value="{{ @$post->name }}" required>
                </div>
                <div>
                    <label for="address" class="block mb-2 font-semibold text-md text-orange-400 dark:text-white">Address</label>
                    <input type="text" id="address" name="address" class="font-medium text-md placeholder:text-gray-400 text-gray-500 bg-gray-50 border border-gray-300  rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Address" value="{{ @$post->address }}" required>
                </div>
                <div>
                    <label for="rank" class="block mb-2 font-semibold text-md text-orange-400 dark:text-white">Rank</label>
                    {!! Form::select('rankId', $get_rank_sel, @$post->rankId, ['class' => 'font-medium text-md text-gray-500 bg-gray-50 border border-gray-300 text-md placeholder:text-gray-400 text-gray-500 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                </div>
                <div>
                    <label for="contact" class="block mb-2 font-semibold text-md text-orange-400 dark:text-white">Contact Number</label>
                    <input type="text" id="contact" name="contact_number" class="font-medium text-md text-gray-500 bg-gray-50 border border-gray-300 text-md placeholder:text-gray-400 text-gray-500 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Ex. +6012..." value="{{ @$post->contact_number }}" required>
                </div>
                <div>
                    <label for="countries" class="block mb-2 text-md font-semibold text-orange-400 dark:text-white">Country</label>
                    {!! Form::select('country', $get_country_sel, @$post->country, ['class' => 'font-medium text-md placeholder:text-gray-400 text-gray-500 bg-gray-50 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                </div>
                <div>
                    <label for="status" class="block mb-2 font-semibold text-md text-orange-400 dark:text-white">Status</label>
                    {!! Form::select('status', $get_status_sel, @$post->status, ['class' => 'font-medium text-md placeholder:text-gray-400 text-gray-500 bg-gray-50 border border-gray-300 text-md text-gray-500 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                </div>
            </div>
            @if($title == 'Add')
                <button type="submit" class="text-white bg-[#40DD7F] hover:bg-success-800 focus:ring-4 focus:outline-none focus:ring-success-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-success-600 dark:hover:bg-success-700 dark:focus:ring-success-800">Add Member</button>
            @else
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
            @endif

        </div>
    </form>

@endsection
@section('script')

    <script>
        let imageUpload = document.getElementById("file_input");
        // display file name if file has been selected
        imageUpload.onchange = function() {
            let input = this.files[0];
            let image = document.getElementById('profile_pic_preview');
            if (input) {
                image.src =URL.createObjectURL(input);
            } else {
                image.src = '/img/profile.png';
            }
        };
    </script>
@endsection
