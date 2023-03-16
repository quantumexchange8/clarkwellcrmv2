@extends('layouts.master-member')

@section('title')
    Withdrawals
@endsection

@section('contents')

    <nav class="flex mb-4 max-[900px]:flex-col" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xl font-semibold mb-4">
            <li class="inline-flex items-center">
                <p href="#"
                   class="inline-flex items-center text-gray-700 hover:text-orange-600 dark:text-gray-400 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor" class="w-6 h-6 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3"/>
                    </svg>
                    @lang('public.wallet')
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
                       class="ml-1  text-gray-700 hover:text-orange-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                        @lang('public.withdrawals')</p>
                </div>
            </li>
        </ol>

    </nav>
    <div class=" w-auto ">
        <div class="px-4">
            <form action="{{ url('member/withdrawals') }}" method="post" class="grid grid-cols-2 gap-3 mb-4 max-[1450px]:grid-cols-2 max-[1100px]:grid-cols-1">
                @csrf
                <div date-rangepicker datepicker-format="yyyy/mm/dd" class="flex items-center">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-blue-500" placeholder="@lang('public.select_start_date')" autocomplete="off" name="created_start" value="{{ @$search['created_start'] }}">
                    </div>
                    <span class="mx-4 text-gray-500">@lang('public.to')</span>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-blue-500" placeholder="@lang('public.select_end_date')" autocomplete="off" name="created_end" value="{{ @$search['created_end'] }}">
                    </div>
                </div>
                <div class="w-full mr-4 ">
                    <select id="status" name="filter_status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">
                        <option selected value="all">@lang('public.filter_status')</option>
                        @foreach(\App\Models\Withdrawals::listApprovalStatus() as $status)
                            <option {{ @$search['filter_status'] == $status ? 'selected' : '' }} value="{{ $status }}">{{\App\Models\Withdrawals::getApprovalStatus($status)}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" name="submit" value="search" class="max-[900px]:justify-center max-[1000px]:w-full text-white bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                    <button type="submit" name="submit" value="reset" class="max-[900px]:justify-center max-[1000px]:w-full text-white bg-rose-500 hover:bg-rose-800 focus:ring-4 focus:outline-none focus:ring-rose-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-rose-800 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                    </button>
                    <button type="submit" name="submit" value="export" class="mb-2 max-[1000px]:w-full justify-center text-white bg-secondary-800 hover:bg-secondary-500 focus:ring-4 focus:outline-none focus:ring-secondary-300 font-semibold rounded-lg text-md px-5 py-2.5 text-center inline-flex items-center dark:bg-secondary-600 dark:hover:bg-secondary-700 dark:focus:ring-secondary-800">
                        <svg class="h-6 w-6 mr-2" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 15V6C8 4.89543 8.89543 4 10 4H38C39.1046 4 40 4.89543 40 6V42C40 43.1046 39.1046 44 38 44H10C8.89543 44 8 43.1046 8 42V33" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M31 15H34" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/>
                            <path d="M28 23H34" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/>
                            <path d="M28 31H34" stroke="#ffffff" stroke-width="3" stroke-linecap="round"/>
                            <rect x="4" y="15" width="18" height="18" fill="none" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10 21L16 27" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 21L10 27" stroke="#ffffff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        @lang('public.export_excel')
                    </button>
                    <button type="button" data-modal-target="withdrawModal" data-modal-toggle="withdrawModal" class="mb-2 max-[1000px]:w-full justify-center text-white bg-primary-500 hover:bg-primary-600 focus:ring-4 focus:outline-none focus:ring-primary-300 font-semibold rounded-lg text-md px-5 py-2.5 text-center inline-flex items-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        @lang('public.withdraw')
                    </button>
                </div>

            </form>

            <div class="relative overflow-x-auto sm:rounded-lg">
                <table class="w-full text-md text-left text-gray-500">
                    <thead class="text-md text-orange-500 uppercase border-b">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                @sortablelink('created_at', trans('public.date'))
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                @sortablelink('status', trans('public.status'))
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                @sortablelink('network', trans('public.method'))
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex items-center">
                                @sortablelink('amount', trans('public.amount'))
                                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($withdrawals as $data)
                        <tr class="odd:bg-white even:bg-[#FDFCF3] border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$data->created_at}}
                            </th>
                            @switch($data->status)
                                @case(\App\Models\Withdrawals::STATUS_PENDING)
                                    <td class="px-6 py-4 text-primary font-semibold">
                                    @lang('public.process')
                                    @break

                                @case(\App\Models\Withdrawals::STATUS_APPROVED)
                                    <td class="px-6 py-4 text-success font-semibold">
                                    @lang('public.approved')
                                    @break

                                @case(\App\Models\Withdrawals::STATUS_REJECTED)
                                    <td class="px-6 py-4 text-danger font-semibold">
                                    @lang('public.rejected')
                                    @break

                                @default
                                    <td class="px-6 py-4 text-primary font-semibold">
                                        @lang('public.process')
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$data->getNetwork()}}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${{ number_format($data->amount,2) }}
                                    </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class=" mt-4">
                <!-- Help text -->
                <span class="text-sm text-gray-700 dark:text-gray-400">
                        @if(count($withdrawals) > 0)
                        @lang('public.showing') <span
                            class="font-semibold text-gray-900 dark:text-white">{{$withdrawals->count()}}</span> @lang('public.to')
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $withdrawals->count() }}</span> @lang('public.of')
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $withdrawals->total() }}</span>
                        @lang('public.entries')
                    @else
                        <div
                            class="w-full flex p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
                            role="alert">
                            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd"
                                                                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                                                              clip-rule="evenodd"></path></svg>
                            <span class="sr-only">@lang('public.info')</span>
                            <div>
                                <span class="font-medium">@lang('public.info') :</span>@lang('public.no_record')
                            </div>

                    @endif
                </span>
                <!-- Buttons -->
                <div class="inline-flex mt-2">
                    <div class="d-flex justify-content-center">
                        {!! $withdrawals->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="withdrawModal" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <!-- Modal content -->

            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-md p-4 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-hide="withdrawModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">@lang('public.close_modal')</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-semibold text-orange-500 dark:text-white">@lang('public.withdrawal_as_USDT')</h3>
                    <form method="post" action="{{ url('member/store-withdrawal') }}"
                          enctype="multipart/form-data">@csrf
                        <div class="mb-4">
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                @foreach (\App\Models\Withdrawals::$walletTypes as $type)
                                    <div class="flex items-center pl-3">
                                        <input id="horizontal-list-radio-license" type="radio" value="{{$type}}"
                                               name="network" value= "{{ old('network') }}"
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="horizontal-list-radio-license"
                                               class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{strtoupper($type)}}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('network')
                            <div class="text-sm text-red-600">{{ $message }}</div>
                            @enderror
                            <div class="mb-4">
                                <label for="Address"
                                       class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">@lang('public.address')</label>
                                <input type="text" name="address" id="address" value= "{{ old('address') }}"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                       placeholder="" required>
                                @error('address')
                                <div class="text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="balance"
                                       class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">@lang('public.available_balance')
                                </label>
                                <input type="text" name="balance" id="balance" aria-label="disabled input 1" disabled
                                       readonly value="{{number_format($user->wallet_balance, 2)}} USDT"
                                       class="bg-gray-50 border border-gray-300 text-orange-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                       required>
                            </div>
                            <div class="mb-4">
                                <label for="amount"
                                       class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">@lang('public.withdrawal_amount')
                                </label>
                                <div class="relative">
                                    <input type="number" name="amount" id="amount-wallet" value= "{{ old('amount') }}"
                                           step="0.01" min="0"
                                           onchange oninput="test()"
                                           class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500"
                                           required>
                                    <button onclick="maxAmount()" type="button"
                                            class="text-white absolute right-2.5 bottom-2.5 bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                                        @lang('public.max')
                                    </button>
                                    @error('amount')
                                    <div class="text-sm text-red-600">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="fee" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                                    @lang('public.transaction_fee')
                                </label>
                                <input type="text" name="fee" id="fee" readonly aria-label="disabled input 2"
                                       value="{{number_format($transaction_fee,2)}} USDT"
                                       class="bg-gray-50 border border-gray-300 text-orange-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                       required>
                                @error('fee')
                                <div class="text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center font-medium text-md mt-2 text-orange-500  dark:text-orange-700">
                                @lang('public.withdrawal_total')
                            </div>
                            <button type="submit" id="total"
                                    class="w-full text-white bg-success hover:ring-success  focus:ring-4 focus:outline-none focus:ring-success font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                0.00 USDT
                            </button>
                            @if($errors->any())
                                @foreach ($errors->get('error_messages') as $error)
                                    <div class="flex p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                                        <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                        <span class="sr-only">@lang('public.info')</span>
                                        <div>
                                            <span class="font-medium"> {{ $error }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script>
        function maxAmount() {
            document.getElementById("amount-wallet").value =  Number({{$user->wallet_balance}});
            test();
        }

            function test(e) {
                var amount = document.getElementById("amount-wallet").value;
                var fee = {{\App\Models\Settings::where('name', 'withdrawal_transaction_fee')->first()->value}};
                document.getElementById("fee").setAttribute('value', fee);

                if (amount > fee) {
                    document.getElementById("total").innerHTML = amount - fee + ' USDT';
                } else {
                    document.getElementById("total").innerHTML = '0.00 USDT';
                }
            }
    </script>
@endsection
