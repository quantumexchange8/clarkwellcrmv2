@php
    $count += 1
@endphp
@foreach ($children as $child)
    @if (count($child->children))
        <!-- With Child -->
        <div class="flex justify-start items-center w-full mb-4" id="childContainer">
            <button
                class="inline-flex items-center justify-center w-8 h-8 bg-[#FFA168] hover:bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600 hide-child mr-4"
                type="button"
                id="{{ $child->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white transform rotate-180" id="svgPlus-child{{ $child->id }}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <svg class="h-6 w-6 text-white" style="display: none" id="svgMinus-child{{ $child->id }}"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="5" y1="12" x2="19" y2="12" /></svg>
            </button>
            <a href="{{ route('referral_detail', $child->id) }}" class=" border border-gray-200 rounded-lg shadow-lg hover:shadow-2xl dark:bg-gray-800 w-full" id="childBg-{{ $count }}">
                <div class="w-full container md:p-4 p-4 md:flex md:items-center md:justify-between">
                    <div class="flex flex-initial items-center space-x-2 w-auto" >
                        <div class="inline-flex items-center justify-center w-8 h-8 rounded-full shrink-0 grow-0 dark:bg-gray-600" id="childColor-{{ $count }}">
                            <span class="font-bold text-lg text-white">{{$count}}</span>
                        </div>
                        <div class="inline-flex items-center justify-center w-12 h-12 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600">
                            @if ($child->profile_image)
                                <img src="{{ asset('uploads/users/' .$child->profile_image)}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                            @else
                                <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                            @endif
                        </div>
                        <div class="font-semibold dark:text-white xs:truncate">
                            <div class=" text-md">{{$child->name}}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{$child->email}}</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center space-x-3 ml-6">
                        <div class="font-semibold dark:text-white">
                            <div class=" text-md">{{$child->rank->rank_short_form}}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">@lang('public.rank')</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center space-x-3 ml-6">
                        <div class="font-semibold dark:text-white">
                            <div class=" text-md">${{number_format($child->wallet_balance, 2)}}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">@lang('public.wallet_balance')</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center space-x-3 ml-6">
                        <div class="font-semibold dark:text-white">
                            <div class=" text-md">${{number_format($child->personalDeposits(), 2)}}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">@lang('public.total_personal_deposit')</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center space-x-3 ml-6">
                        <div class="font-semibold dark:text-white">
                            <div class=" text-md">${{number_format($child->groupTotalDeposit(), 2)}}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">@lang('public.total_group_deposit')</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center space-x-3 ml-6">
                        <div class="font-semibold dark:text-white">
                            <div class=" text-md">{{$child->getClientsCount()}}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">@lang('public.direct_downlines')</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="!visible hidden hideContent-{{ $child->id }} ml-6" id="collapseExample-{{$child->id}}" data-te-collapse-item>
            @include('admin.referral.child', ['children' => $child->children,])
        </div>
    @else
        <!-- Without Child -->
        <a href="{{ route('referral_detail', $child->id) }}" id="childContainer">
            <div class="rounded-lg border border-gray-200 rounded-lg shadow-lg hover:shadow-2xl mb-4 dark:bg-gray-800 w-full" id="childBg-{{ $count }}">
                <div class="w-full container md:p-4 p-4 md:flex md:items-center md:justify-between">
                    <div class="flex flex-initial items-center space-x-2 w-auto">
                        <div class="inline-flex items-center justify-center w-8 h-8 rounded-full shrink-0 grow-0 dark:bg-gray-600" id="childColor-{{ $count }}">
                            <span class="font-bold text-lg text-white">{{$count}}</span>
                        </div>
                        <div class="inline-flex items-center justify-center w-12 h-12 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600">
                            @if ($child->profile_image)
                                <img src="{{ asset('uploads/users/' .$child->profile_image)}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                            @else
                                <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                            @endif
                        </div>
                        <div class="font-semibold dark:text-white xs:truncate">
                            <div class=" text-md">{{$child->name}}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{$child->email}}</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center space-x-3 ml-6">
                        <div class="font-semibold dark:text-white">
                            <div class=" text-md">{{$child->rank->rank_short_form}}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">@lang('public.rank')</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center space-x-3 ml-6">
                        <div class="font-semibold dark:text-white">
                            <div class=" text-md">${{number_format($child->wallet_balance, 2)}}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">@lang('public.wallet_balance')</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center space-x-3 ml-6">
                        <div class="font-semibold dark:text-white">
                            <div class=" text-md">${{number_format($child->personalDeposits(), 2)}}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">@lang('public.total_personal_deposit')</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center space-x-3 ml-6">
                        <div class="font-semibold dark:text-white">
                            <div class=" text-md">${{number_format($child->groupTotalDeposit(), 2)}}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">@lang('public.total_group_deposit')</div>
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center space-x-3 ml-6">
                        <div class="font-semibold dark:text-white">
                            <div class=" text-md">{{$child->getClientsCount()}}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">@lang('public.direct_downlines')</div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endif
@endforeach
