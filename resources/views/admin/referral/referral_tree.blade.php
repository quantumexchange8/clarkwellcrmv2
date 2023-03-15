@extends('layouts.master-admin')

@section('title') {{ $title }} @endsection

@section('contents')
    <h1 class="font-semibold text-2xl text-gray-500">Referral / {{ $title }}</h1>

    <!-- search -->
    <div class="flex flex-col">
        <form method="post" action="{{ route('referral_tree') }}">
            @csrf
            <div class="grid gap-6 mb-6 mt-4 md:grid-cols-1">
                <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" id="search" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-blue-500" placeholder="Search.." name="freetext" value="{{ @$search['freetext'] }}">
                </div>
                <div class="max-[755px]:flex max-[755px]:flex-col gap-2">
                    <button type="submit" class="text-white bg-primary hover:bg-primary-600 border border-primary-200 focus:ring-4 focus:outline-none focus:ring-primary-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" name="submit" value="search">Search</button>
                    <button type="submit" class="text-white bg-rose-500 hover:bg-rose-600 border border-rose-200 focus:ring-4 focus:outline-none focus:ring-rose-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-rose-800" name="submit" value="reset">Reset</button>
                    <a href="#" class=" text-white py-2 px-5 rounded rounded bg-[#FFA168] hover:bg-orange-400 text-md font-bold float-right">
                        <div class="flex items-center justify-center">
                            <svg class="h-6 w-6 text-white mr-2"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />  <polyline points="17 8 12 3 7 8" />  <line x1="12" y1="3" x2="12" y2="15" /></svg>
                            <button type="submit" name="submit" value="export"  class=" text-md font-bold">Export Report</button>
                        </div>
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($members->isNotEmpty())
        <div class="relative overflow-x-auto lg:max-w-[972px] xl:max-w-[1100px] 2xl:max-w-[1200px] container">
        @foreach ($members as $member)
            @php
                $count = 1
            @endphp
            @if (count($member->children))
                <!-- Parent with children -->
                <div class="inline-flex mb-4 w-auto justify-center items-center toggle-{{$member->id}}" id="container">
                    <button
                        class="inline-flex items-center justify-center w-10 h-10 bg-[#FFA168] hover:bg-orange-400 rounded-full shrink-0 grow-0 mr-4 dark:bg-gray-600 hide"
                        type="button"
                        id="{{ $member->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-white transform rotate-180" id="svgPlus{{ $member->id }}">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <svg class="h-6 w-6 text-white" style="display: none" id="svgMinus{{ $member->id }}"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="5" y1="12" x2="19" y2="12" /></svg>
                    </button>
                    <a class=" bg-[#FDFCF3] border w-auto border-orange-600 p-4 shadow-lg hover:shadow-2xl dark:bg-neutral-700 dark:text-neutral-50 inline-flex"
                        href="{{ route('referral_detail', $member->id) }}">
                        <div class="flex items-center space-x-4 sp">
                            <div class="inline-flex items-center justify-center w-10 h-10 bg-rose-400 rounded-full shrink-0 grow-0 dark:bg-gray-600" id="countBg">
                                <span class="font-bold text-xl text-gray-600 dark:text-gray-300">{{$count}}</span>
                            </div>
                            <div class="inline-flex items-center justify-center w-14 h-14 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600">
                                @if ($member->profile_image)
                                    <img src="{{ asset('uploads/users/' .$member->profile_image)}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                                @else
                                    <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                                @endif
                            </div>
                            <div class="font-semibold dark:text-white">
                                <div class=" text-md">{{$member->name}}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{$member->email}}</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 ml-12">
                            <div class="font-semibold dark:text-white">
                                <div class=" text-md">{{$member->rank->rank_short_form}}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Rank</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 ml-12">
                            <div class="font-semibold dark:text-white">
                                <div class=" text-md">${{number_format($member->wallet_balance, 2)}}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Wallet Balance</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 ml-12">
                            <div class="font-semibold dark:text-white">
                                <div class=" text-md">${{number_format($member->personalDeposits(), 2)}}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Total Personal Deposit</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 ml-12">
                            <div class="font-semibold dark:text-white">
                                <div class=" text-md">${{number_format($member->groupTotalDeposit(), 2)}}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Total Group Deposit</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 ml-12">
                            <div class="font-semibold dark:text-white">
                                <div class=" text-md">{{$member->getClientsCount()}}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Direct Downlines</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="!visible hidden hideContent-{{ $member->id }} ml-6" id="collapseExample-{{$member->id}}" data-te-collapse-item>
                    @include('admin.referral.child', [
                    'children' => $member->children,
                    'count' => $count
                    ])
                </div>
            @else
                <div class="inline-flex mb-4 hover:shadow-2xl" id="container">
                    <a
                        class=" bg-[#FDFCF3] border w-auto border-orange-600 p-4 shadow-lg dark:bg-neutral-700 dark:text-neutral-50 inline-flex"
                        href="{{ route('referral_detail', $member->id) }}">
                        <div class="flex items-center space-x-4 sp">
                            <div class="inline-flex items-center justify-center w-10 h-10 bg-rose-400 rounded-full shrink-0 grow-0 dark:bg-gray-600" id="countBg">
                                <span class="font-bold text-md text-gray-600 dark:text-gray-300">{{$count}}</span>
                            </div>
                            <div class="inline-flex items-center justify-center w-14 h-14 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600">
                                @if ($member->profile_image)
                                    <img src="{{ asset('uploads/users/' .$member->profile_image)}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-green-500 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                                @else
                                    <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-green-500 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                                @endif
                            </div>
                            <div class="font-semibold dark:text-white">
                                <div class=" text-md">{{$member->name}}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{$member->email}}</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 ml-12">
                            <div class="font-semibold dark:text-white">
                                <div class=" text-md">{{$member->rank->rank_short_form}}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Rank</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 ml-12">
                            <div class="font-semibold dark:text-white">
                                <div class=" text-md">${{number_format($member->wallet_balance, 2)}}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Wallet Balance</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 ml-12">
                            <div class="font-semibold dark:text-white">
                                <div class=" text-md">${{number_format($member->personalDeposits(), 2)}}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Total Personal Deposit</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 ml-12">
                            <div class="font-semibold dark:text-white">
                                <div class=" text-md">${{number_format($member->groupTotalDeposit(), 2)}}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Total Group Deposit</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 ml-12">
                            <div class="font-semibold dark:text-white">
                                <div class=" text-md">{{$member->getClientsCount()}}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Direct Downlines</div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        @endforeach


    </div>
    @else
        <div class="flex p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">No Record Found!</span>
            </div>
        </div>
    @endif

@endsection

@section('script')

    <script>
        $(document).ready(function(e) {
            var color = [
                "#FFB347", "#FFC166", "#FFCE84", "#FFDCA3", "#FFEABE", "#FFF8D8", "#F2FFE9", "#D4FFD8", "#B4FFCC", "#94FFC0",
                "#75FFB5", "#58FFAB", "#3DFFA1", "#24FF98", "#0CFF8F", "#00FF87", "#00FF7E", "#00FF76", "#00FF6E", "#00FF67",
                "#00FF60", "#0EFF5A", "#1EFF54", "#2FFF4E", "#3FFF49", "#4FFF44", "#5FFF3F", "#6FFF3B", "#7FFF37", "#8FFF34",
                "#9FFF31", "#AEFF2E", "#BEFF2C", "#CEFF2A", "#DEFF29", "#EEFF27", "#FFFF26", "#FFFF25", "#FFFF24", "#FFFF23",
                "#FFFF22", "#FFFF21", "#FFFF20", "#FFFF20", "#FFFF1F", "#FFFF1E", "#FFFF1D", "#FFFF1C", "#FFFF1B", "#FFFF1A",
                "#FFFF19", "#FFFF18", "#FFFF18", "#FFFF17", "#FFFF16", "#FFFF15", "#FFFF14", "#FFFF13", "#FFFF12", "#FFFF11",
                "#FFFF10", "#FFFF10", "#FFFE0F", "#FFFD0E", "#FFFC0D", "#FFFB0C", "#FFFA0B", "#FFF90A", "#FFF809", "#FFF708",
                "#FFF607", "#FFF506", "#FFF405", "#FFF304", "#FFF203", "#FFF102", "#FFF001", "#FFEF01", "#FFEE02", "#FFED03",
                "#FFEC04", "#FFEB05", "#FFEA06", "#FFE907", "#FFE808", "#FFE709", "#FFE60A", "#FFE50B", "#FFE40C", "#FFE30D",
                "#FFE20E", "#FFE10F", "#FFE00F", "#FFDF10", "#FFDE11", "#FFDD12", "#FFDC13", "#FFDB14", "#FFDA15", "#FFD916",
                "#FFD817", "#FFD718", "#FFD619", "#FFD51A", "#FFD41B", "#FFD31C", "#FFD21D", "#FFD11E", "#FFD01F", "#FFCF20",
                "#FFCE20", "#FFCD21", "#FFCC22", "#FFCB23", "#FFCA24", "#FFC925", "#FFC826", "#FFC727", "#FFC628", "#FFC529",
                "#FFC42A", "#FFC32B", "#FFC22C", "#FFC12D", "#FFC02E", "#FFBF2F", "#FFBE30", "#FFBD30", "#FFBC31", "#FFBB32",
                "#FFBA33", "#FFB934", "#FFB835", "#FFB736", "#FFB637", "#FFB538", "#FFB439", "#FFB33A", "#FFB23B", "#FFB13C",
                ]

            var colorChild = [
                "#003366", "#003f73", "#004880", "#00558c", "#006199", "#006ca6", "#0078b2", "#0085bf", "#0092cc", "#009fdf",
                "#00a8f2", "#00b0f2", "#00b8f2", "#00c1f2", "#00c9f2", "#00d1f2", "#00d9f2", "#00e2f2", "#00eaf2", "#00f2f2",
                "#00f2eb", "#00f2e3", "#00f2db", "#00f2d3", "#00f2cb", "#00f2c4", "#00f2bc", "#00f2b4", "#00f2ac", "#00f2a4",
                "#00f29d", "#00f295", "#00f28d", "#00f285", "#00f27d", "#00f276", "#00f26e", "#00f266", "#00f25e", "#00f256",
                "#00f24e", "#00f246", "#00f23f", "#00f237", "#00f22f", "#00f227", "#00f21f", "#00f218", "#00f210", "#00f208",
                "#00f200", "#08f200", "#10f200", "#18f200", "#20f200", "#28f200", "#2ff200", "#37f200", "#3ff200", "#47f200",
                "#4ff200", "#57f200", "#5ef200", "#66f200", "#6ef200", "#76f200", "#7ef200", "#86f200", "#8df200", "#95f200",
                "#9df200", "#a5f200", "#adf200", "#b5f200", "#bcf200", "#c4f200", "#ccf200", "#d4f200", "#dbf200", "#e3f200",
                "#ebf200", "#f2f200", "#f2eb00", "#f2e300", "#f2db00", "#f2d300", "#f2cb00", "#f2c400", "#f2bc00", "#f2b400",
                "#f2ac00", "#f2a400", "#f29d00", "#f29500", "#f28d00", "#f28500", "#f27d00", "#f27600", "#f26e00", "#f26600",
                "#f25e00", "#f25600", "#f24e00", "#f24600", "#f23f00", "#f23700", "#f22f00", "#f22700", "#f21f00", "#f21800",
                "#f21000", "#f20800", "#f20000", "#f20008", "#f20010", "#f20018", "#f20020", "#f20028", "#f2002f", "#f20037",
                "#f2003f", "#f20047", "#f2004f", "#f20057", "#f2005e", "#f20066", "#f2006e", "#f20076", "#f2007e", "#f20086",
                "#f2008d", "#f20095"
                ]


                $("#container #countBg").each(function(i) {
                $(this).css('background', color[i])
            });
            $("#containerChild #countBg-child").each(function(i) {
                $(this).css('background', colorChild[i])
            });

            $('.hide').on('click', function() {
                var id = $(this).attr('id');
                $(".hideContent-"+id).toggle('fast');
                $('#svgPlus'+id).toggle('fast');
                $('#svgMinus'+id).toggle('fast');
            });

            $('.hide-child').on('click', function() {
                var id = $(this).attr('id');
                $(".hideContent-"+id).toggle('fast');
                $('#svgPlus-child'+id).toggle('fast');
                $('#svgMinus-child'+id).toggle('fast');
            });
        });
    </script>
@endsection
