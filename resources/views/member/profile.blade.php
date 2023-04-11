@extends('layouts.master-member')

@section('title') Profile @endsection

@section('contents')
    <nav class="flex " aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-lg font-semibold">
            <li class="inline-flex items-center">
                <p href="#" class="inline-flex items-center text-gray-700 hover:text-orange-600 dark:text-gray-400 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 mr-4">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                    </svg>
                    @lang('public.profile')
                </p>
            </li>
            <li>
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <p href="#" class="ml-1  text-gray-700 hover:text-orange-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">@lang('public.profile_details')</p>
                </div>
            </li>
        </ol>
    </nav>
        <div class="grid grid-flow-row grid-flow-cols grid-cols-3 gap-3 my-4 max-[1200px]:grid-rows-auto max-[1200px]:grid-cols-none ">
            <div class="flex justify-center max-[1200px]:justify-start ">
                <div class="block rounded-lg bg-[#FDFCF3] border-2 text-center shadow-lg dark:bg-neutral-700 w-full">
                    <div class="pt-6 pb-4 px-6 dark:text-neutral-50 flex text-orange-400 font-bold text-lg">
                        @lang('public.rank')
                    </div>
                    <div class="py-1">
                        <div class="relative inline-flex items-center justify-center w-28 h-28 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600">
                            <span class="font-bold text-white dark:text-gray-300 text-lg">{{$rank->rank_short_form}}</span>
                        </div>
                        <h5 class="my-6 text-lg font-bold leading-tight text-[#696057] dark:text-neutral-50">
                            @lang('public.'. $rank->rank_short_form )
                        </h5>
                    </div>
                </div>
            </div>
            <div class="flex justify-center col-span-2 max-[1200px]:col-span-1 max-[1200px]:justify-start ">
                <div class="block rounded-lg bg-[#FDFCF3] border-2 shadow-lg dark:bg-neutral-700 w-full py-4">
                    <div class="pt-4 px-6 flex text-orange-400 font-bold text-lg">
                        @lang('public.personal_details')
                    </div>
                    <div class="grid grid-cols-2 max-[1200px]:grid-cols-none">
                        <div class="px-12 py-4 col-span-2 max-[1200px]:col-span-1">
                            <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.name'):</p>
                            <h5 class="mb-2 text-lg font-semibold tracking-tight text-[#696057] dark:text-white">{{$user->name}}</h5>
                        </div>
                        <div class="px-12 py-4 ">
                            <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.email'):</p>
                            <h5 class="mb-2 text-lg font-semibold tracking-tight text-[#696057] dark:text-white">{{$user->email}}</h5>
                        </div>
                        <div class="px-12 py-4">
                            <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.contact'):</p>
                            <div class="flex items-center space-x-4">
                                <h5 class=" text-lg font-semibold tracking-tight text-[#696057] dark:text-white">{{$user->contact_number}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center max-[1200px]:justify-start mt-3 ">
                <div class="block  rounded-lg bg-[#FDFCF3] border-2 text-center shadow-lg dark:bg-neutral-700 w-full py-4">
                    <div class="py-4 px-6 dark:text-neutral-50 flex text-orange-400 font-bold text-lg">
                        @lang('public.avatar')
                    </div>
                    <div class="">
                        @if ($user->profile_image)
                            <img src="{{ asset('uploads/users/' .$user->profile_image)}}" class="relative inline-flex items-center justify-center w-28 h-28 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                        @else
                            <img src="{{url('/img/profile.png')}}" class="relative inline-flex items-center justify-center w-28 h-28 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                        @endif
                    </div>
                    <button data-modal-target="avatarModal" data-modal-toggle="avatarModal" type="button" class="font-semibold my-6 text-white bg-orange-400 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 rounded-lg text-sm px-5 py-2.5  dark:bg-orange-600 dark:hover:bg-orange-700 focus:outline-none dark:focus:ring-orange-800">
                        @lang('public.change_avatar')
                    </button>
                </div>
            </div>
            <div class="flex justify-center col-span-2 max-[1200px]:col-span-1 max-[1200px]:justify-start mt-3 ">
                <div class="block rounded-lg bg-[#FDFCF3] border-2 shadow-lg dark:bg-neutral-700 w-full py-4">
                    <div class="pt-4 px-6 flex text-orange-400 font-bold text-lg">
                        @lang('public.location')
                    </div>
                    <div class="grid grid-cols-2 max-[1400px]:grid-cols-none">
                        <div class="px-12 py-4 ">
                            <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.address'):</p>
                            <h5 class="mb-2 text-lg font-semibold tracking-tight text-[#696057] dark:text-white">
                                {{$user->address}}
                            </h5>
                        </div>
                        <div class="px-12 py-4">
                            <p class="font-medium text-gray-500 dark:text-gray-400 "> @lang('public.country'):</p>
                            <div class="flex items-center space-x-4">
                                @if($user->countryFlag)
                                <span class="fi fi-{{$user->countryFlag}} "></span>
                                @endif
                                <h5 class=" text-lg font-semibold tracking-tight text-[#696057] dark:text-white">{{ $user->getTranslatedCountry() }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
      <div id="avatarModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl md:h-auto">
            <form method="post" action="{{ url('member/update-profile-pic') }}" enctype="multipart/form-data">@csrf
            <!-- Modal content -->
            <div class="relative bg-[#FDFCF3] rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-orange-500 dark:text-white">
                        @lang('public.upload_avatar')
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="avatarModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only"> @lang('public.close_modal')</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-2 ">

                    <img class="mx-auto w-32 h-32 p-1 rounded-full ring-2 ring-gray-300 dark:ring-gray-500 bg-gray-100" id="profile_pic_preview"
                    @if ($user->profile_image)
                        src="{{ asset('uploads/users/' .$user->profile_image)}}"
                    @else
                       src="{{url('/img/profile.png')}}"
                    @endif
                         alt="avatar">

                    <label class="block my-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">@lang('public.upload_file')</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                           aria-describedby="file_input_help" id="file_input" name="profile_image" type="file"
                           accept="image/png, image/gif, image/jpeg" >
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">@lang('public.profile_pic_req')</p>
                    @error('profile_image')
                    <div class="text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button  type="submit" name="submit" data-modal-hide="avatarModal" type="button" class="text-white bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">@lang('public.save')</button>
                    <button data-modal-hide="avatarModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-orange-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">@lang('public.cancel')</button>
                </div>

            </div>
            </form>

        </div>
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
