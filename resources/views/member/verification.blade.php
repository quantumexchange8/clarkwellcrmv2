@extends('layouts.master-member')

@section('title')
    Profile
@endsection

@section('contents')
    <nav class="flex " aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-lg font-semibold">
            <li class="inline-flex items-center">
                <p href="#"
                   class="inline-flex items-center text-gray-700 hover:text-orange-600 dark:text-gray-400 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                         class="w-7 h-7 mr-4">
                        <path fill-rule="evenodd"
                              d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                              clip-rule="evenodd"/>
                    </svg>
                    @lang('public.profile')
                </p>
            </li>
            <li>
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <p href="#"
                       class="ml-1  text-gray-700 hover:text-orange-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">@lang('public.profile_verification')</p>
                </div>
            </li>
        </ol>
    </nav>

    <div
        class="w-full h-auto p-4 text-center border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 mt-6 bg-[#FDFCF3]">
        <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
            @lang('public.member_verification_message')
        </p>

        <form class="space-y-6" action="{{ route('member_verification') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-2">

                <div>
                    <label for="front_id_image"
                           class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.front_id')</label>
                    @if($user->front_id_image)
                        <div class="flex justify-center item-center">
                            <img
                                class="object-cover w-full rounded-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-lg mb-4"
                                src="{{ asset('uploads/users/'.$user->front_id_image)}}" alt="">
                        </div>
                    @endif
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('front_id_image') block w-full text-sm text-red-900 border border-red-500 rounded-lg cursor-pointer bg-red-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @enderror"
                        aria-describedby="front_id_image_desc" id="file_input" type="file" name="front_id_image"
                        value="{{ @$user->front_id_image }}">
                    @error('front_id_image')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300"
                       id="front_id_image_desc">@lang('public.id_req')</p>
                </div>

                <div>
                    <label for="back_id_image"
                           class="block mb-2 font-bold text-[#FFA168] dark:text-white">@lang('public.back_id')</label>
                    @if($user->back_id_image)
                        <div class="flex justify-center item-center">
                            <img
                                class="object-cover w-full rounded-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-lg mb-4"
                                src="{{ asset('uploads/users/' .$user->back_id_image)}}" alt="">
                        </div>
                    @endif
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @error('back_id_image') block w-full text-sm text-red-900 border border-red-500 rounded-lg cursor-pointer bg-red-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 @enderror"
                        aria-describedby="back_id_image_desc" id="file_input" type="file" name="back_id_image"
                        value="{{ @$user->back_id_image }}">
                    @error('back_id_image')
                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300"
                       id="back_id_image_desc">@lang('public.id_req')</p>
                </div>
            </div>

            <button type="submit"
                    class="text-white bg-[#40DD7F] hover:bg-[#40DD7F]/90 focus:ring-4 focus:outline-none focus:ring-[#40DD7F]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#40DD7F]/55 ">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="ml-2">
                @lang('public.upload_id')
            </span>
            </button>
        </form>
    </div>

@endsection
@section('script')
    <script>
        let imageUpload = document.getElementById("file_input");
        // display file name if file has been selected
        imageUpload.onchange = function () {
            let input = this.files[0];
            let image = document.getElementById('profile_pic_preview');
            if (input) {
                image.src = URL.createObjectURL(input);
            } else {
                image.src = '/img/profile.png';
            }
        };
    </script>
@endsection
