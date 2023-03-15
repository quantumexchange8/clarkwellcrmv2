
<button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" data-drawer-backdrop="false" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-orange-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
</button>

<aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <button type="button" data-drawer-hide="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" class="text-gray-400 min-[644px]:hidden bg-transparent hover:bg-orange-200 hover:text-orange-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" >
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        <span class="sr-only">Close menu</span>
    </button>
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800" style="background: #FDFCF3">
        <img class="h-20 mx-auto my-6" src="{{url('/img/CW.png')}}">
        <ul class="space-y-2">
            <li>
                <a href="{{ url('admin/dashboard') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-orange-100 dark:hover:bg-gray-700">
                    <svg aria-hidden="true" class="w-6 h-6 {{ request()->is('admin/dashboard') ? 'text-orange-400' : 'text-gray-500'}} transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                    <span class="ml-3 {{ request()->is('admin/dashboard') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}">Dashboard</span>
                </a>
            </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-members" data-collapse-toggle="dropdown-members">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 {{ request()->is('admin/member/*') ? 'text-orange-400' : 'text-gray-500'}}">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap {{ request()->is('admin/member/*') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}" sidebar-toggle-item>Members</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-members" class="{{ request()->is('admin/member/*') ? '' : 'hidden' }} py-2 space-y-2">
                    <li>
                        <a href="{{ route('member_add') }}" class="{{ request()->is('admin/member/add') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-gray-500">Add New Member</a>
                    </li>
                    <li>
                        <a href="{{ route('member_listing') }}" class="{{ request()->is('admin/member/listing') || request()->is('admin/member/details/*') || request()->is('admin/member/edit/*') || request()->is('admin/member/deposit/*') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-gray-500">Member Listing</a>
                    </li>
                </ul>
            </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-report" data-collapse-toggle="dropdown-report">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 {{ request()->is('admin/report/*') ? 'text-orange-400' : 'text-gray-500'}}">
                        <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 013.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 013.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 01-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875zM9.75 17.25a.75.75 0 00-1.5 0V18a.75.75 0 001.5 0v-.75zm2.25-3a.75.75 0 01.75.75v3a.75.75 0 01-1.5 0v-3a.75.75 0 01.75-.75zm3.75-1.5a.75.75 0 00-1.5 0V18a.75.75 0 001.5 0v-5.25z" clip-rule="evenodd" />
                        <path d="M14.25 5.25a5.23 5.23 0 00-1.279-3.434 9.768 9.768 0 016.963 6.963A5.23 5.23 0 0016.5 7.5h-1.875a.375.375 0 01-.375-.375V5.25z" />
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap {{ request()->is('admin/report/*') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}" sidebar-toggle-item>Reports</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-report" class="{{ request()->is('admin/report/*') ? '' : 'hidden' }} py-2 space-y-2">
                    <li>
                        <button type="button" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-8 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-gray-500" aria-controls="dropdown-commission" data-collapse-toggle="dropdown-commission-child">
                            <span class="flex-1 ml-3 text-left whitespace-nowrap text-sm {{ request()->is('admin/report/commissions/*') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}" sidebar-toggle-item>Commissions</span>
                            <svg sidebar-toggle-item class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <ul id="dropdown-commission-child" class="{{ request()->is('admin/report/commissions/*') ? '' : 'hidden' }} py-2 space-y-2 ml-4">
                            <li>
                                <a href="{{ route('report_commission') }}" class="{{ request()->is('admin/report/commissions/listing') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} font-normal flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 text-gray-500">Listing</a>
                            </li>
                            <li>
                                <a href="{{ route('report_commission_children') }}" class="{{ request()->is('admin/report/commissions/children') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} font-normal flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 text-gray-500">Downline Listing</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <button type="button" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-8 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-gray-500" aria-controls="dropdown-deposits" data-collapse-toggle="dropdown-deposits-child">
                            <span class="flex-1 ml-3 text-left whitespace-nowrap text-sm {{ request()->is('admin/report/deposits/*') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}" sidebar-toggle-item>Deposits</span>
                            <svg sidebar-toggle-item class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <ul id="dropdown-deposits-child" class="{{ request()->is('admin/report/deposits/*') ? '' : 'hidden' }} py-2 space-y-2 ml-4">
                            <li>
                                <a href="{{ route('report_deposits') }}" class="{{ request()->is('admin/report/deposits/listing') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-normal text-gray-500">Listing</a>
                            </li>
                            <li>
                                <a href="{{ route('report_deposits_children') }}" class="{{ request()->is('admin/report/deposits/children') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-normal text-gray-500">Downline Listing</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <button type="button" class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-8 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-gray-500" aria-controls="dropdown-withdrawals" data-collapse-toggle="dropdown-withdrawals-child">
                            <span class="flex-1 ml-3 text-left whitespace-nowrap text-sm {{ request()->is('admin/report/withdrawals/*') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}" sidebar-toggle-item>Withdrawals</span>
                            <svg sidebar-toggle-item class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <ul id="dropdown-withdrawals-child" class="{{ request()->is('admin/report/withdrawals/*') ? '' : 'hidden' }} py-2 space-y-2 ml-4">
                            <li>
                                <a href="{{ route('report_withdrawal') }}" class="{{ request()->is('admin/report/withdrawals/listing') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-normal text-gray-500">Listing</a>
                            </li>
                            <li>
                                <a href="{{ route('report_withdrawal_children') }}" class="{{ request()->is('admin/report/withdrawals/children') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-normal text-gray-500">Downline Listing</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-referrals" data-collapse-toggle="dropdown-referrals">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 {{ request()->is('admin/referral/*') ? 'text-orange-400' : 'text-gray-500'}}">
                        <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" clip-rule="evenodd" />
                        <path d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z" />
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap {{ request()->is('admin/referral/*') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}" sidebar-toggle-item>Referrals</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-referrals" class="{{ request()->is('admin/referral/*') ? '' : 'hidden' }} py-2 space-y-2">
                    <li>
                        <a href="{{ route('referral_tree') }}" class="{{ request()->is('admin/referral/referral_tree') || request()->is('admin/referral/referral_tree/*') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-gray-500">Referral Tree</a>
                    </li>
                    <li>
                        <a href="{{ route('referral_transfer') }}" class="{{ request()->is('admin/referral/transfer') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} flex items-center w-full p-2 text-base font-semibold transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-gray-500">Transfer</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('broker_listing') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-orange-100 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 {{ request()->is('admin/broker/*') ? 'text-orange-400' : 'text-gray-500'}}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap {{ request()->is('admin/broker/*') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}">Brokers</span>
                </a>
            </li>
            <li>
                <a href="{{ route('news_listing') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-orange-100 dark:hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 {{ request()->is('admin/news/*') ? 'text-orange-400' : 'text-gray-500'}}">
                        <path fill-rule="evenodd" d="M4.125 3C3.089 3 2.25 3.84 2.25 4.875V18a3 3 0 003 3h15a3 3 0 01-3-3V4.875C17.25 3.839 16.41 3 15.375 3H4.125zM12 9.75a.75.75 0 000 1.5h1.5a.75.75 0 000-1.5H12zm-.75-2.25a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5H12a.75.75 0 01-.75-.75zM6 12.75a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5H6zm-.75 3.75a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5H6a.75.75 0 01-.75-.75zM6 6.75a.75.75 0 00-.75.75v3c0 .414.336.75.75.75h3a.75.75 0 00.75-.75v-3A.75.75 0 009 6.75H6z" clip-rule="evenodd" />
                        <path d="M18.75 6.75h1.875c.621 0 1.125.504 1.125 1.125V18a1.5 1.5 0 01-3 0V6.75z" />
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap {{ request()->is('admin/news/*') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}">News</span>
                </a>
            </li>
            <li>
                <form method="post" action="{{ url('logout') }}" class="inline-flex w-full whitespace-nowrap bg-transparent rounded-lg hover:bg-orange-100">
                    @csrf
                    <a href="javascript:void(0)" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white dark:hover:bg-gray-700">
                        <svg class="h-8 w-8 text-red-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />  <path d="M20 12h-13l3 -3m0 6l-3 -3" /></svg>
                        <button class="text-lg ml-1 text-rose-500 font-bold hover:text-rose-600">Logout</button>
                    </a>
                </form>
            </li>
        </ul>
    </div>
</aside>

