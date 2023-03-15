@extends('layouts.master-admin')

@section('title') Referral-Referral Tree @endsection

@section('contents')
    <div class="flex flex-row">
        <h1 class="flex-1 font-semibold text-lg text-gray-500">Referral / {{ $title }} / {{ $user->name }}</h1>
    </div>

    <div class="grid grid-cols-2 gap-4 mt-8">
        <div>
            <a href="javascript:void(0)" class="flex flex-col items-center bg-[#FDFCF3] border border-orange-300 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-orange-100 dark:border-orange-700 dark:bg-orange-800 dark:hover:bg-orange-700">
                <div class="inline-flex items-center m-4 justify-center w-20 h-20 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-orange-600">
                    @if ($user->profile_image)
                        <img src="{{ asset('uploads/users/' .$user->profile_image)}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                    @else
                        <img src="{{url('/img/profile.png')}}" id="profile_pic_preview" class="inline-flex items-center justify-center w-32 h-32 overflow-hidden bg-orange-400 rounded-full shrink-0 grow-0 dark:bg-gray-600font-bold text-white dark:text-gray-300 text-4xl object-contain">
                    @endif
                </div>
                <div class="flex flex-col justify-between p-4 leading-normal">
                    <h2 class="font-semibold text-lg text-[#FFA168] mb-4">{{ $user->name }}</h2>
                    <span class="text-sm text-gray-500">
                            {{ $user->email }}
                    </span>
                </div>
                <div class="ml-6">
                    <h2 class="font-semibold text-lg text-[#FFA168] mb-4">{{ $user->rank->name }}</h2>
                    <span class="text-sm text-gray-500">
                            Rank
                    </span>
                </div>
            </a>
        </div>
        <div>
            <a href="javascript:void(0)" class="grid grid-cols-2 gap-4 block max-w-lg p-6 bg-[#FDFCF3] border border-orange-300 rounded-lg shadow hover:bg-orange-100 dark:bg-orange-800 dark:border-orange-700 dark:hover:bg-orange-700">
                <div class="">
                    <h2 class="font-semibold text-lg text-gray-500 mb-2">Total Direct Clients</h2>
                    <span class="font-semibold text-lg text-[#FFA168]">
                            {{ $user->getClientsCount() }}
                    </span>
                </div>
                <div class="ml-12">
                    <h2 class="font-semibold text-lg text-gray-500 mb-2">Total Downlines</h2>
                    <span class="font-semibold text-lg text-[#FFA168]">
                            {{ $user->getDownlinesCount() }}
                    </span>
                </div>
            </a>
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-8">
        <table class="w-full text-md text-left text-gray-700 dark:text-gray-400">
            <thead class="border-b-4 text-sm text-gray-700 uppercase dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 bg-[#FDFCF3] dark:bg-gray-800">
                    Broker
                </th>
                <th scope="col" class="px-6 py-3">
                    Total Personal Deposit
                </th>
                <th scope="col" class="px-6 py-3 bg-[#FDFCF3] dark:bg-gray-800">
                    Total Group Deposit
                </th>
                <th scope="col" class="px-6 py-3">
                    Total Rebate for Personal Deposit
                </th>
                <th scope="col" class="px-6 py-3 bg-[#FDFCF3] dark:bg-gray-800">
                    Total Rebate for Group Deposit
                </th>
                <th scope="col" class="px-6 py-3">
                    Total Downlines
                </th>
                <th scope="col" class="px-6 py-3 bg-[#FDFCF3] dark:bg-gray-800">
                    Total Direct Clients
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($brokers as $broker)
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-orange-600 whitespace-nowrap bg-[#FDFCF3] dark:text-white dark:bg-gray-800">
                        {{$broker->name}}
                    </th>
                    <td class="px-6 py-4">
                        ${{number_format($broker->data['personal_deposit'],2)}}
                    </td>
                    <td class="px-6 py-4 bg-[#FDFCF3] dark:bg-gray-800">
                        ${{number_format($broker->data['group_deposit'],2)}}
                    </td>
                    <td class="px-6 py-4">
                        ${{number_format($broker->data['personal_commissions'],2)}}
                    </td>
                    <td class="px-6 py-4 bg-[#FDFCF3] dark:bg-gray-800">
                        ${{number_format($broker->data['group_commissions'],2)}}
                    </td>
                    <td class="px-6 py-4">
                        {{$broker->data['downlines']}}
                    </td>
                    <td class="px-6 py-4 bg-[#FDFCF3] dark:bg-gray-800">
                        {{$broker->data['clients']}}
                    </td>
                </tr>

            @endforeach

            <tr class="border-t-4 border-gray-200 dark:border-gray-700 font-bold text-lg">
                <th scope="row" class="px-6 py-4 font-bold text-orange-600 whitespace-nowrap bg-[#FDFCF3] dark:text-white dark:bg-gray-800">
                    Total:
                </th>
                <td class="px-6 py-4">
                    ${{number_format( $total['total_personal'],2)}}
                </td>
                <td class="px-6 py-4 bg-[#FDFCF3] dark:bg-gray-800">
                    ${{number_format($total['total_group'],2)}}
                </td>
                <td class="px-6 py-4">
                    ${{number_format($total['total_personal_comm'],2)}}
                </td>
                <td class="px-6 py-4 bg-[#FDFCF3] dark:bg-gray-800">
                    ${{number_format($total['total_group_comm'],2)}}
                </td>
                <td class="px-6 py-4">

                </td>
                <td class="px-6 py-4 bg-[#FDFCF3] dark:bg-gray-800">

                </td>
            </tr>

            </tbody>
        </table>
    </div>


@endsection
