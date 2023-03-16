@extends('layouts.master-admin')

@section('title') Profile {{ $title }} @endsection

@section('contents')

    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">Profile / {{ $title }}</h1>
        <a href="{{ route('admin_dashboard') }}" class="text-xl font-semibold text-[#FFA168]">Back</a>
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
                    <span class="sr-only">Close</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        @endforeach
    @endif

    <div class="flex justify-center mt-8">
        <form method="post" action="{{ $submit }}" enctype="multipart/form-data">
            @csrf
            <div class="flex items-start rounded-xl bg-[#FDFCF3] shadow-lg">
                <div class="ml-4 px-12 pb-8 md:mt-6">
                    <div class="flex flex-col items-center p-8">
                        <div class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600">
                            @if ($user->profile_image)
                                <img src="{{ asset('uploads/users/' .$user->profile_image)}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl">
                            @else
                                <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="object-contain relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl">
                            @endif
                        </div>
                        <div class="mt-4">
                            <label class="font-semibold text-md text-gray-500 block mb-2 text-gray-900 dark:text-white" for="file_input">Upload file</label>
                            <input class="font-semibold text-md text-gray-500 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="profile_image" id="file_input" type="file" accept="image/png, image/gif, image/jpeg">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="name" class="block mb-2 font-semibold text-md text-orange-400 dark:text-white">Name</label>
                        <input type="text" id="name" name="name" class="font-semibold text-md text-gray-500 bg-gray-50 border border-gray-300  rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="email@company.com" value="{{ $post->name }}" required>
                    </div>
                    <div class="mb-6">
                        <div>
                            <label for="email" class="block mb-2 font-semibold text-md text-orange-400 dark:text-white">Email Address</label>
                            <input type="email" id="email" name="email" class="font-semibold text-md text-gray-500 bg-gray-50 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="email@company.com" value="{{ $post->email }}" readonly>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="contact" class="block mb-2 font-semibold text-md text-orange-400 dark:text-white">Contact Number</label>
                        <input type="text" id="contact" name="contact_number" class="font-semibold text-md text-gray-500 bg-gray-50 border border-gray-300 font-semibold text-md text-gray-500 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Ex. +6012..." value="{{$post->contact_number }}" required>
                    </div>
                    <div class="mb-6">
                        <div>
                            <label for="countries" class="block mb-2 font-semibold text-orange-400 dark:text-white">Country</label>
                            {!! Form::select('country', $get_country_sel, $post->country, ['class' => 'font-semibold text-md text-gray-500 bg-gray-50 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                        </div>
                    </div>
                    <button type="submit" class="text-white rounded-lg bg-[#1A8BFF] hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-700 font-semibold text-mdrounded-lg px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-blue-500 dark:hover:bg-[#050708]/30 float-right">Update</button>
                </div>
            </div>
        </form>
    </div>

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

