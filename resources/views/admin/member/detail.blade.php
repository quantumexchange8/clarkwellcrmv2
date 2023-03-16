@extends('layouts.master-admin')

@section('title') Member Details @endsection

@section('contents')

    <div class="flex flex-row gap-4 max-[1150px]:block">
        <h1 class="flex-1 font-semibold text-2xl text-gray-600">@lang('public.members') / {{ $user->name }}</h1>
        <a href="{{ route('member_deposit', $user->id) }}" class="mt-2 bg-[#1AB759] hover:bg-green-400 border border-green-200 focus:ring-4 focus:outline-none focus:ring-green-600 text-card-14 rounded-lg px-5 py-2.5 text-center inline-flex items-center ">
            <svg class="h-4 w-4 text-white"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            <span class="ml-4 text-white">@lang('public.view_deposit')</span>
        </a>
        <a href="{{ route('member_edit', $user->id) }}" class="mt-2 bg-[#4DA5FF]  hover:bg-blue-600 border border-blue-200 focus:ring-4 focus:outline-none focus:ring-blue-600 font-semibold text-md text-gray-500 rounded-lg px-5 py-2.5 text-center inline-flex items-center ">
            <svg class="h-4 w-4 text-white" width="24"  height="24"  viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" /></svg>
            <span class="ml-4 text-white">>@lang('public.edit')</span>
        </a>

    </div>
    <div class="flex justify-center mt-8">
        <div class="grid grid-cols-4 items-start rounded-xl bg-[#FDFCF3] p-4 shadow-lg w-full max-[1150px]:grid-cols-3">

            <div class="col-span-1 flex-col items-center py-8 border-r-4 border-orange-500 h-full px-12 text-center max-[1150px]:col-span-3 max-[1150px]:border-none">
                <div class="relative inline-flex items-center justify-center w-20 h-20 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600">
                    @if ($user->profile_image)
                        <img src="{{ asset('uploads/users/' .$user->profile_image)}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                    @else
                        <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                    @endif

                </div>
                <h5 class="font-bold text-lg text-gray-600 text-center mt-4 mb-2">{{ $user->name }}</h5>
                <span class="font-semibold text-lg text-orange-400 text-center">{{ $user->rank->rank_short_form }}</span>
                <div class="items-center mt-4 md:mt-6">
                    <span class="font-semibold text-lg text-orange-400 mt-4">@lang('public.last_rank_up'):</span> <br>
                    <span class="font-semibold text-lg text-gray-600">{{\Carbon\Carbon::parse($user->rank_update_at)->format('Y-m-d')}} {{$user->auto_rank_up ? '('.trans('public.auto').')' : '('.trans('public.manual').')'}}</span>
                </div>
                <div class="flex mt-4 space-x-3 md:mt-6">
                    <button
                        data-modal-target="ranking_details_modal" data-modal-toggle="ranking_details_modal"
                        class="mx-auto inline-flex items-center px-8 py-2 text-center text-card-14 text-white bg-[#FFA168] rounded-lg hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-300"
                        data-te-ripple-init
                        data-te-ripple-color="light">
                        @lang('public.rank_details')
                    </button>
                </div>
            </div>

            <div class="col-span-3 ml-4 p-4 md:mt-6">
                <div class="grid grid-cols-2 gap-8 break-words max-[800px]:grid-cols-1">
                    <div class="px-4">
                        <h2 class="font-semibold text-lg text-orange-400 mb-4">@lang('public.email')</h2>
                        <span class="font-semibold text-lg text-gray-500">
                            {{ $user->email }}
                        </span>
                    </div>
                    <div class="px-4">
                        <h2 class="font-semibold text-lg text-orange-400 mb-4">@lang('public.contact')</h2>
                        <span class="font-semibold text-lg text-gray-500">
                            {{ $user->contact_number }}
                        </span>
                    </div>
                    <div class="mt-10 px-4">
                        <h2 class="font-semibold text-lg text-orange-400 mb-4">@lang('public.address')</h2>
                        <span class="font-semibold text-lg text-gray-500">
                            {{ $user->address }}
                        </span>
                    </div>
                    <div class="mt-10 px-4">
                        <h2 class="font-semibold text-lg text-orange-400 mb-4">@lang('public.country')</h2>
                        <span class="font-semibold text-lg text-gray-500">
                            {{ $user->country }}
                        </span>
                    </div>
                    <div class="mt-10 px-4">
                        <h2 class="font-semibold text-lg text-orange-400 mb-4">@lang('public.date_join')</h2>
                        <span class="font-semibold text-lg text-gray-500">
                            {{ $user->created_at }}
                        </span>
                    </div>
                    <div class="mt-10 px-4">
                        <h2 class="font-semibold text-lg text-orange-400 mb-4">@lang('public.status')</h2>
                        @if($user->status == 1)
                            <span class="text-success font-semibold text-lg text-gray-500">@lang('public.active')</span>
                        @elseif($user->status == 2)
                            <span class="text-warning font-semibold text-lg text-gray-500">@lang('public.inactive')</span>
                        @elseif($user->status == 3)
                            <span class="text-danger font-semibold text-lg text-gray-500">@lang('public.suspend')</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ranking Details Modal -->
    <div id="ranking_details_modal" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-md p-4 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-hide="ranking_details_modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 space-y-6">
                    <form method="post" action="{{ route('member_details', $user->id) }}">
                        @csrf
                        <div class="mb-2 text-center text-sm font-bold">
                            @lang('public.rank_details')
                        </div>
                        <div class="mb-6 text-center text-2xl font-bold">
                            {{ $user->name }}
                        </div>
                        <div class="mb-6">
                            <label for="rank" class="block mb-2 text-lg text-[#FFA168]">@lang('public.change_rank')</label>
                            {!! Form::select('rankId', $get_rank_sel, $post->rankId, ['class' => 'bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500', 'id' => 'rank_sel']) !!}
                        </div>
                        <div class="mb-6">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="auto_rank_up" id="autoRankSwitch" value="on" class="sr-only peer" @if( @$post->auto_rank_up == 1 ) checked @endif>
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-gray-200 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-[#FFA168]"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">@lang('public.auto_rank_up')</span>
                            </label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="text-white bg-[#FFA168] hover:bg-orange-400 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm w-full sm:w-auto px-10 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center justify-center">@lang('public.confirm')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function(e) {
            $("#rank_sel").click(function() {
                var checkBoxes = $("#autoRankSwitch");
                checkBoxes.prop("checked", false);
            });
        });
    </script>
@endsection
