@extends('layouts.master-admin')

@section('title') Member Deposit @endsection

@section('contents')

    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-2xl text-gray-500">Members / {{ $user->name }}'s Deposit</h1>
        <a href="{{ route('member_details', $user->id) }}" class="font-semibold text-xl text-[#FFA168]">Back</a>
    </div>
    <div class="mt-8 grid grid-flow-row grid-flow-cols grid-cols-3 gap-3 my-4 max-[1200px]:grid-rows-auto max-[1200px]:grid-cols-none ">
        <div class="relative overflow-x-auto  max-[1200px]:col-span-3 mb-4">
            <table class="w-full text-sm text-left border-2 border-orange-500 bg-[#FDFCF3] text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="flex items-center  border-orange-500 justify-center bg-[#FDFCF3]">
                        <div class="my-6 relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600">
                            @if ($user->profile_image)
                                <img src="{{ asset('uploads/users/' .$user->profile_image)}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl">
                            @else
                                <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="relative inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl">
                            @endif
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center text-xl">
                            <div class="font-bold">{{ $user->name }}</div>
                            <div class="mb-4 text-orange-500 font-semibold">${{ number_format($total_deposit, 2) }}</div>
                        </td>
                    </tr>
                    @foreach($deposit_by_group as $deposit_group)
                        <tr class="border border-orange-500">
                            <td class="flex items-center justify-center">
                                <span class="m-4">{{ $deposit_group->broker->name }} : <b>${{ number_format($deposit_group->amount, 2) }}</b></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="w-11/12 col-span-2 ml-4">
            <form method="post" action="{{ route('member_deposit', $user->id) }}">
                @csrf
                <div class="grid gap-6 grid-cols-2 max-[900px]:grid-cols-1">
                    <div class="w-full">
                        {!! Form::select('brokersId', $get_broker_sel, @$search['brokersId'], ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500']) !!}
                    </div>
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
                    <div class="flex">
                        <button type="submit" class="mr-4 text-white bg-primary hover:bg-primary-600 border border-primary-200 focus:ring-4 focus:outline-none focus:ring-primary-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" name="submit" value="search">Search</button>
                        <button type="submit" class="text-white bg-rose-500 hover:bg-red-600 border border-red-200 focus:ring-4 focus:outline-none focus:ring-red-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" name="submit" value="reset">Reset</button>
                    </div>
                </div>
            </form>
            @if($deposits->isNotEmpty())
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8 border-2">
                    <table class="w-full text-left">
                        <thead class="font-bold">
                        <tr>
                            <th scope="col" class="px-6 py-6">
                                <div class="flex items-center">
                                    @sortablelink('transaction_at', 'Date Created')
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-6">
                                <div class="flex items-center">
                                    @sortablelink('broker.name', 'Broker')
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-6">
                                <div class="flex items-center">
                                    @sortablelink('amount')
                                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true" fill="currentColor" viewBox="0 0 320 512"><path d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/></svg></a>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($deposits as $deposit)
                                <tr class="border-b odd:bg-[#F6F6F6] even:bg-[#FDFCF3]">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $deposit->transaction_at }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $deposit->broker->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $deposit->amount }}
                                    </td>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- pagination -->
                    <div class="m-4 flex">
                        {!! $deposits->links() !!}
                    </div>
                </div>
            @else
                <div class="flex p-4 mt-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">No Record Found!</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
