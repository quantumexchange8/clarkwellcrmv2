@extends('layouts.master-admin')

@section('title')
    {{ $title }}
@endsection

@section('contents')
    <h1 class="font-semibold text-2xl text-gray-500">@lang('public.members') / @lang('public.kyc_approval')</h1>
    <!-- search -->
    <div class="flex flex-col">
        <form method="post" action="{{ route('member_kyc_listing') }}">
            @csrf
            <div class="grid gap-6 mb-6 mt-4 md:grid-cols-1">
                <label for="search"
                       class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="search"
                           class="block w-full p-2.5 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-blue-500"
                           placeholder="@lang('public.search_email')" name="freetext"
                           value="{{ @$search['freetext'] }}">
                </div>
                <div class="max-[755px]:flex max-[755px]:flex-col gap-2">
                    <button type="submit"
                            class="text-white bg-primary hover:bg-primary-600 border border-primary-200 focus:ring-4 focus:outline-none focus:ring-primary-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                            name="submit" value="search">@lang('public.search')</button>
                    <button type="submit"
                            class="text-white bg-rose-500 hover:bg-rose-600 border border-rose-200 focus:ring-4 focus:outline-none focus:ring-rose-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-rose-600 dark:hover:bg-rose-700 dark:focus:ring-rose-800"
                            name="submit" value="reset">@lang('public.reset')</button>
                </div>
            </div>
        </form>
    </div>

    @if($records->isNotEmpty())
            <?php
            $no = $records->firstItem();
            ?>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-2 text-sm">
            <table class="w-full text-left">
                <thead class="uppercase bg-[#FDFCF3]">
                <tr>
                    <th scope="col" class="p-4 text-center">
                        #
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @sortablelink('name', trans('public.name'))
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true"
                                     fill="currentColor" viewBox="0 0 320 512">
                                    <path
                                        d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                                </svg>
                            </a>
                        </div>
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @sortablelink('email', trans('public.email'))
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true"
                                     fill="currentColor" viewBox="0 0 320 512">
                                    <path
                                        d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                                </svg>
                            </a>
                        </div>
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @sortablelink('contact_number', trans('public.contact'))
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true"
                                     fill="currentColor" viewBox="0 0 320 512">
                                    <path
                                        d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                                </svg>
                            </a>
                        </div>
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @sortablelink('contact_number', trans('public.country'))
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true"
                                     fill="currentColor" viewBox="0 0 320 512">
                                    <path
                                        d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                                </svg>
                            </a>
                        </div>
                    </th>
                    <th scope="col" class="p-4 text-center">
                        @lang('public.copy_id')
                    </th>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            @sortablelink('status', trans('public.status'))
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true"
                                     fill="currentColor" viewBox="0 0 320 512">
                                    <path
                                        d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z"/>
                                </svg>
                            </a>
                        </div>
                    </th>
                    <th scope="col" class="p-4 text-center">
                        @lang('public.kyc_approval_status')
                    </th>
                    <th scope="col" class="p-4 text-center">
                        @lang('public.action')
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($records as $record)
                    <tr class="border-b odd:bg-[#F6F6F6] even:bg-[#FDFCF3]">
                        <th scope="row"
                            class="p-4 font-medium text-center uppercase text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $no }}
                        </th>
                        <td class="p-4">
                            <a href="{{ route('member_details', $record->id) }}"
                               class="underline text-[#1A8BFF]">{{ $record->name }}</a>
                        </td>
                        <td class="p-4">
                            {{ $record->email }}
                        </td>
                        <td class="p-4">
                            {{ $record->contact_number }}
                        </td>
                        <td class="p-4">
                            {{ $record->country }}
                        </td>
                        <td class="p-4">
                            <button data-modal-target="defaultModal-{{$record->id}}"
                                    data-modal-toggle="defaultModal-{{$record->id}}"
                                    class="block text-blue-600 underline  bg-transparent focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                    type="button">
                                @lang('public.view_id')
                            </button>
                            <!-- Main modal -->
                            <div id="defaultModal-{{$record->id}}" tabindex="-1" aria-hidden="true"
                                 class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
                                <div class="relative w-full h-full max-w-2xl md:h-auto">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                @lang('public.copy_id')
                                            </h3>
                                            <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="defaultModal-{{$record->id}}">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                          clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-6 space-y-6">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div class="flex justify-center item-center">
                                                    <img
                                                        class="object-cover w-full rounded-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-lg mb-4"
                                                        src="{{ asset('uploads/users/' .$record->front_id_image)}}"
                                                        alt="">
                                                </div>
                                                <div class="flex justify-center item-center">
                                                    <img
                                                        class="object-cover w-full rounded-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-lg mb-4"
                                                        src="{{ asset('uploads/users/' .$record->back_id_image)}}"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="p-4">
                            @if($record->status == 1)
                                <span class="text-success font-semibold uppercase">Active</span>
                            @elseif($record->status == 2)
                                <span class="text-warning font-semibold uppercase">Inactive</span>
                            @elseif($record->status == 3)
                                <span class="text-danger font-semibold uppercase">Suspended</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($record->kyc_approval_status == 3)
                                <span class="text-success font-semibold uppercase">@lang('public.kyc_verified')</span>
                            @elseif($record->kyc_approval_status == 2)
                                <span class="text-warning font-semibold uppercase">@lang('public.kyc_pending_verify')</span>
                            @elseif($record->kyc_approval_status == 1)
                                <span class="text-danger font-semibold uppercase">@lang('public.kyc_not_verify')</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <a href="javascript:void(0)"
                               class="impersonate bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
                               data-modal-target="impersonate_modal" data-modal-toggle="impersonate_modal"
                               data-te-ripple-init
                               data-te-ripple-color="light" id="{{ $record->id }}">
                                @lang('public.approval')
                            </a>
                        </td>
                    </tr>
                        <?php
                        $no++;
                        ?>
                @endforeach
                </tbody>
            </table>
            <!-- pagination -->
            <div class="m-4 flex">
                {!! $records->links() !!}
            </div>
        </div>
    @else
        <div class="flex p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300"
             role="alert">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                      clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">@lang('public.info')</span>
            <div>
                <span class="font-medium">@lang('public.info') :</span>@lang('public.no_record')
            </div>
        </div>
    @endif


    <!-- approval Modal -->
    <div id="impersonate_modal" tabindex="-1"
         class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-hide="impersonate_modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <form method="POST" action="{{ route('member_kyc_approval') }}">
                        @csrf
                        <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="modal-body">
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">@lang('public.access_confirmation')</h3>
                            <input type="hidden" name="user_id" id="user_id">
                        </div>
                        <button type="submit" value="{{App\Models\User::KYC_STATUS_VERIFIED}}" name="approval"
                                class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            @lang('public.delete_confirmed')
                        </button>
                        <button data-modal-hide="impersonate_modal" type="button"
                                class="text-gray-700 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">@lang('public.delete_cancel')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function (e) {
            $('.impersonate').on('click', function () {
                var id = $(this).attr('id');
                $(".modal-body #user_id").val(id);
            });
        });

    </script>
@endsection
