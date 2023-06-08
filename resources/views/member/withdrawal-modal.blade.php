<!-- Manage Withdrawal Request Modal -->
<div id="withdrawal-edit-{{ $data->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
    <div class="relative w-full h-full max-w-md md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="withdrawal-edit-{{ $data->id }}">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">@lang('public.close_modal')</span>
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-semibold text-orange-500 dark:text-white">@lang('public.withdrawal_as_USDT')</h3>
                <form method="post" action="{{ route('withdrawal-edit') }}" enctype="multipart/form-data" id="edit-withdrawal">
                    @csrf

                    <input type="hidden" name="withdrawal_id" value="{{ $data->id }}">
                    <div class="mb-4">
                        <div class="mb-4">
                            <label for="balance"
                                   class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">@lang('public.available_balance')
                            </label>
                            <input type="text" name="balance" id="balance" aria-label="disabled input 1" disabled
                                   readonly value="{{number_format($user->wallet_balance, 2)}} USDT"
                                   class="bg-gray-50 border border-gray-300 text-orange-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white balance"
                                   required>
                            <span class="text-danger text-xs error-text balance_error"></span>
                        </div>
                        <div class="mb-4">
                            <label for="amount-wallet-edit"
                                   class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">@lang('public.withdrawal_amount')
                            </label>
                            <div class="relative">
                                <input type="number" name="amount" id="amount-wallet-edit" value="{{ $data->amount }}"
                                       step="0.01" min="0"
                                       class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500 amount"
                                       >
                                <button type="button" id="max-button-edit"
                                        class="text-white absolute right-2.5 bottom-2.5 bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                                    @lang('public.max')
                                </button>
                            </div>
                            <span class="text-danger text-xs error-text amount_error"></span>

                        </div>
                        <div class="mb-4">
                            <label for="fee-edit" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                                @lang('public.transaction_fee')
                            </label>
                            <input type="text" name="fee" id="fee-edit" readonly aria-label="disabled input 2"
                                   value="{{number_format($transaction_fee,2)}} USDT"
                                   class="bg-gray-50 border border-gray-300 text-orange-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                   required>
                            <div class="text-sm text-center">@lang('public.fee_remark')</div>
                        </div>
                        <div class="mb-4">
                            <label for="withdrawal_pin" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                                @lang('public.withdrawal_pin')
                            </label>
                            <input type="password" name="withdrawal_pin" id="withdrawal_pin" aria-label="disabled input 2" class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Enter Pin">
                            <span class="text-danger text-xs error-text withdrawal_pin_error"></span>
                        </div>

                        <div class="text-center font-medium text-md mt-2 text-orange-500  dark:text-orange-700">
                            @lang('public.withdrawal_total')
                        </div>
                        <button type="submit" id="total-edit"
                                class="w-full text-white bg-success hover:ring-success  focus:ring-4 focus:outline-none focus:ring-success font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            {{ $data->amount - number_format($transaction_fee,2) }} USDT
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
