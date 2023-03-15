@extends('layouts.master-member')

@section('title') Network @endsection

@section('contents')
        <nav class="flex mb-4 max-[1000px]:flex-col" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xl font-semibold mb-4">
                <li class="inline-flex items-center">
                <p href="#" class="inline-flex items-center text-gray-700 hover:text-orange-600 dark:text-gray-400 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
                </svg>
                Wallet
                </p>
                </li>
                <li>
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <p href="#" class="ml-1  text-gray-700 hover:text-orange-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Network</p>
                </div>
                </li>
            </ol>
            <div class="flex ml-auto gap-3 ">
                <div class="block max-w-md px-6 py-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                    <h5 class=" text-xl font-bold tracking-tight text-orange-500 dark:text-white">Total Earned:</h5>
                    <p class="font-semibold text-gray-700 dark:text-gray-400">${{ number_format($group_total,2) }}</p>
                </div>
            </div>
        </nav>
        <div class=" w-auto ">
            <div class="px-4">
            <form action="{{ url('member/network') }}"  method="post"  class="grid grid-cols-2 gap-3 mb-4 max-[1300px]:grid-cols-2 max-[1000px]:grid-cols-1">
                @csrf
                <div date-rangepicker datepicker-format="yyyy/mm/dd" class="flex items-center">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-blue-500" placeholder="Select Date Start" autocomplete="off" name="transaction_start" value="{{ @$search['transaction_start'] }}">
                    </div>
                    <span class="mx-4 text-gray-500">to</span>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-blue-500" placeholder="Select Date End" autocomplete="off" name="transaction_end" value="{{ @$search['transaction_end'] }}">
                    </div>
                </div>
                <div class="relative w-full mr-4 ">
                    <div class="absolute top-3 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="text" id="simple-search"  name="freetext" value="{{ @$search['freetext'] }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search by user name">
                </div>
                <div>
                    <button type="submit" name="submit" value="search" class="mb-2 max-[1000px]:w-full justify-center text-white bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>
                    <button type="submit" name="submit" value="reset" class="mb-2 max-[1000px]:w-full justify-center text-white bg-rose-500 hover:bg-rose-800 focus:ring-4 focus:outline-none focus:ring-rose-300 font-medium rounded-lg text-lg p-2.5 text-center inline-flex items-center mr-2 dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-rose-800">
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
                        Export as Excel
                    </button>
                </div>

            </form>
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-md text-left text-gray-500">
                        <thead class="text-md text-orange-500 uppercase border-b">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        @sortablelink('transaction_at', 'Date')
                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        @sortablelink('userId', 'Referral Name')
                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        @sortablelink('brokersId', 'Broker')
                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        @sortablelink('lot_size', 'Lot Size')
                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        @sortablelink('amount', 'Amount')
                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody >
                        @foreach($commissions as $data)
                            <tr class="odd:bg-white even:bg-[#FDFCF3] border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$data->transaction_at}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$data->user->name}}
                                </td>
                                <td class="px-6 py-4 text-orange-500">
                                    {{$data->broker->name}}
                                </td>
                                <td class="px-6 py-4">
                                    {{ number_format($data->lot_size,2) }}
                                </td>
                                <td class="px-6 py-4">
                                    $ {{ number_format($data->comissions_amount,2) }}
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <div class=" mt-4">
                    <!-- Help text -->
                    <span class="text-sm text-gray-700 dark:text-gray-400">
                        @if(count($commissions) > 0)
                            Showing <span class="font-semibold text-gray-900 dark:text-white">{{$commissions->count()}}</span> to <span class="font-semibold text-gray-900 dark:text-white">{{ $commissions->count() }}</span> of <span class="font-semibold text-gray-900 dark:text-white">{{ $commissions->total() }}</span> Entries
                        @else
                            <div class="w-full flex p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800" role="alert">
                            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Info</span>
                            <div>
                                <span class="font-medium">Info :</span> There are no records yet.
                            </div>
                        </div>

                        @endif
                </span>
                    <!-- Buttons -->
                    <div class="inline-flex mt-2">
                        <div class="d-flex justify-content-center">
                            {!! $commissions->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
