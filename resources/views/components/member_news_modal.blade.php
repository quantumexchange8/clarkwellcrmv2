<div id="newsModal-{{ $news->id }}" tabindex="-1" aria-hidden="true"
     class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 ">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-6 border-b rounded-t dark:border-gray-600 ">
                <div class="flex items-center space-x-4">
                    <div class="font-medium dark:text-white">
                        <h3 class="text-xl font-semibold text-orange-400 dark:text-white mt-px underline">
                            {{ $news->title }}
                        </h3>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $news->created_at }}</div>
                    </div>
                </div>
                <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="newsModal-{{ $news->id }}">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-3">
                {!! $news->content !!}
            </div>
            <!-- Modal footer -->

        </div>
    </div>
</div>
