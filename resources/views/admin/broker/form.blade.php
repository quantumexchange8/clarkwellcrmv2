@extends('layouts.master-admin')

@section('title') Brokers {{ $title }} @endsection

@section('contents')

    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">Broker / {{ $title }} Broker</h1>
        <a href="{{ route('broker_listing') }}" class="text-xl font-semibold text-[#FFA168]">Back</a>
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

    <form class="space-y-6" action="{{ $submit }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="name" class="block mb-2 font-bold text-[#FFA168] dark:text-white">Name</label>
                <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Name" required name="name" value="{{ @$post->name }}">
            </div>
            <div>
                <label for="url" class="block mb-2 font-bold text-[#FFA168] dark:text-white">URL</label>
                <input type="text" id="url" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="URL" required name="url" value="{{ @$post->url }}" >
            </div>
            <div>
                <label for="description" class="block mb-2 font-bold text-[#FFA168] dark:text-white">Description</label>
                <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Broker Description.." name="description" >{{ @$post->description }}</textarea>

            </div>
            <div>
                <label for="note" class="block mb-2 font-bold text-[#FFA168] dark:text-white">Instructor Notes</label>
                <textarea id="note" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Broker Instructions.." name="note" >{{ @$post->note }}</textarea>
            </div>
            <div>
                <label for="broker_image" class="block mb-2 font-bold text-[#FFA168] dark:text-white">Broker Image</label>
                @if($title == 'Edit')
                    <img class="object-cover w-full rounded h-96 md:h-auto md:w-48 md:rounded-none md:rounded-lg mb-4" src="{{ asset('uploads/brokers/' .$broker->broker_image)}}" alt="">
                @endif
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="broker_image_desc" id="file_input" accept=".xls" type="file" name="broker_image" value="{{ @$post->broker_image }}">
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-300" id="broker_image_desc">SVG, PNG, JPG or GIF (MAX. 200 x 200 pixels).</p>
            </div>
            <div>
                <label for="qr_image" class="block mb-2 font-bold text-[#FFA168] dark:text-white">QR Code</label>
                @if($title == 'Edit')
                    <img class="object-cover w-full rounded-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-lg mb-4" src="{{ asset('uploads/brokers/' .$broker->qr_image)}}" alt="">
                @endif
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="qr_image_desc" id="file_input" type="file" name="qr_image" value="{{ @$post->qr_image }}">
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-300" id="qr_image_desc">SVG, PNG, JPG or GIF (MAX. 512 x 256 pixels).</p>
            </div>
        </div>
        @if($title == 'Add')
            <button type="submit" class="float-right text-white bg-[#40DD7F] hover:bg-[#40DD7F]/90 focus:ring-4 focus:outline-none focus:ring-[#40DD7F]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#40DD7F]/55 mr-2 mb-2">
                <svg class="h-6 w-6 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="ml-2">
                Create Broker Profile
            </span>
            </button>
        @elseif($title == 'Edit')
            <button type="submit" class="float-right text-white bg-[#1A8BFF] hover:bg-[#1A8BFF]/90 focus:ring-4 focus:outline-none focus:ring-[#1A8BFF]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#1A8BFF]/55 mr-2 mb-2">
                <svg class="h-6 w-6 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="ml-2">
                Update Broker Profile
            </span>
            </button>
        @endif
    </form>


@endsection
