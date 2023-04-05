@extends('layouts.master-member')

@section('title') Welcome @endsection

@section('contents')

        <div class="grid grid-cols-2 max-[1000px]:grid-cols-1 gap-6 mb-6">
            <div class="w-full bg-[#FDFCF3] border border-gray-200 rounded-lg shadow hover:shadow-xl dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-end px-4 pt-4">
                    <button id="dropdownButton" data-dropdown-toggle="dropdown" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-orange-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-orange-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                        <span class="sr-only">Open dropdown</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdown" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2" aria-labelledby="dropdownButton">
                            <li>
                                <a href="{{ route('member_profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">@lang('public.profile')</a>
                            </li>
                            <li>
                                <a href="{{ route('member_change_password') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">@lang('public.change_password')</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col items-center pb-10">
                    <div class="flex-shrink-0 grow-0 mb-2">
                        @if ($user->profile_image)
                            <img src="{{ asset('uploads/users/' .$user->profile_image)}}" class="w-24 h-24 rounded-full shadow-lg bg-gray-100" alt="">
                        @else
                            <img src="{{url('/img/profile.png')}}" class="w-24 h-24 rounded-full shadow-lg bg-orange-400" alt="">
                        @endif
                    </div>
                    <h5 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ trans('public.'.$user->rank->rank_short_form) }}</span>
                </div>
            </div>
            <div class="w-full p-4 bg-[#FDFCF3] border border-gray-200 rounded-lg shadow hover:shadow-xl sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <h5 class="mb-4 text-xl font-bold text-orange-400 dark:text-gray-400">@lang('public.pending')</h5>
                <p class="text-sm text-gray-500">@lang('public.pending_description')</p>

                <!-- List -->
                <ul role="list" class="space-y-5 my-7">
                    <li class="flex space-x-3">
                        <!-- profile verification -->
                        @if($user->kyc_approval_status != 3)
                            <svg class="h-5 w-5 text-yellow-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <polyline points="12 6 12 12 16 14" /></svg>
                            <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">@lang('public.profile_verification')</span>
                        @else
                            <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-success-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Check icon</title><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-base font-normal line-through leading-tight text-gray-500">@lang('public.profile_verification')</span>
                        @endif
                    </li>
                    @if($withdrawal)
                        <li class="flex space-x-3">
                            <!-- withdrawal request -->
                            @if($withdrawal->status == 1)
                                <svg class="h-5 w-5 text-yellow-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <polyline points="12 6 12 12 16 14" /></svg>
                                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">@lang('public.withdraw_request')</span>
                            @elseif($withdrawal->status == 2)
                                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-success-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Check icon</title><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span class="text-base font-normal line-through leading-tight text-gray-500">@lang('public.withdraw_request')</span>
                            @else
                                <svg class="h-5 w-5 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="9" />  <line x1="12" y1="8" x2="12" y2="12" />  <line x1="12" y1="16" x2="12.01" y2="16" /></svg>
                                <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">@lang('public.withdraw_request') <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">@lang('public.rejected')</span></span>
                            @endif
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- news -->
        <div class="max-w p-6 bg-[#FDFCF3] border border-gray-200 rounded-lg shadow hover:shadow-xl dark:bg-gray-800 dark:border-gray-700">
            <h2 class="mb-6 underline text-2xl font-bold tracking-tight text-orange-400 dark:text-white">{{ $news->title }}</h2>
            <div class="mb-6 font-normal text-gray-700 dark:text-gray-400">
                <p class="text-2xl text-gray-400 dark:text-gray-500">{!! $news->content !!}</p>
            </div>
            <a href="{{ route('member_dashboard') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-orange-400 rounded-lg hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                @lang('public.read_more')
                <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </a>
        </div>

        <!-- event modal -->
        <div id="eventModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 backdrop-blur hidden p-4 mx-auto overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
            <div class="relative w-full h-full mx-auto max-w-2xl md:h-auto">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" id="closeEvent">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    @foreach($events as $event)
                        @if($event->pop_up_status)
                            <div class="p-4 odd:bg-gray-100 even:bg-white rounded-l border border-gray-300">
                                <h3 class="text-xl font-semibold text-[#FFA168] dark:text-white underline">
                                    {{ $event->event_title }}
                                </h3>
                                <span class="text-xs font-semibold text-gray-500">{{ $event->created_at }}</span>
                                <img class="mt-4 h-full my-auto" src="{{ asset('uploads/events/'.$event->event_image) }}" alt="">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#eventModal').fadeIn('15');

            $('#closeEvent').click(function (){
                $('#eventModal').hide();
            })
        });

    </script>
@endsection
