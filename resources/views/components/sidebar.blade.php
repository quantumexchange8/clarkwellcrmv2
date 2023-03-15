
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
        <a href="{{ url('member/dashboard') }}">
            <img class="h-20 mx-auto my-6" src="{{url('/img/CW.png')}}">
        </a>
        <ul class="space-y-2">
            <li>
                <a href="{{ url('member/dashboard') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-orange-100 dark:hover:bg-gray-700">
                    <svg class="h-8 w-8 {{ request()->is('member/dashboard') ? 'text-orange-400' : 'text-gray-500'}}"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />  <line x1="8" y1="21" x2="16" y2="21" />  <line x1="12" y1="17" x2="12" y2="21" /></svg>
                    <span class="ml-3 {{ request()->is('member/dashboard') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ url('member/profile') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-orange-100 dark:hover:bg-gray-700">
                    <svg class="h-8 w-8 {{ request()->is('member/profile') ? 'text-orange-400' : 'text-gray-500'}}"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="7" r="4" />  <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                    <span class="flex-1 ml-3 whitespace-nowrap {{ request()->is('member/profile') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}">Profile</span>
                </a>
            </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                    <svg class="h-8 w-8 {{ request()->is('member/brokers') || request()->is('member/funds') ? 'text-orange-400' : 'text-gray-500'}}"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap {{ request()->is('member/brokers') || request()->is('member/funds') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}" sidebar-toggle-item>Broker & Funds</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-example" class="{{ request()->is('member/brokers') || request()->is('member/funds') ? '' : 'hidden' }} py-2 space-y-2">
                    <li>
                        <a href="{{ url('member/brokers') }}" class="{{ request()->is('member/brokers') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-gray-500">Broker List</a>
                    </li>
                    <li>
                        <a href="{{ url('member/funds') }}" class="{{ request()->is('member/funds') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-gray-500">Funds</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ url('member/tree') }}" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-orange-100 dark:hover:bg-gray-700">
                    <svg class="h-8 w-8 {{ request()->is('member/tree') ? 'text-orange-400' : 'text-gray-500'}}"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="3" y1="21" x2="21" y2="21" />  <line x1="3" y1="10" x2="21" y2="10" />  <polyline points="5 6 12 3 19 6" />  <line x1="4" y1="10" x2="4" y2="21" />  <line x1="20" y1="10" x2="20" y2="21" />  <line x1="8" y1="14" x2="8" y2="17" />  <line x1="12" y1="14" x2="12" y2="17" />  <line x1="16" y1="14" x2="16" y2="17" /></svg>
                    <span class="flex-1 ml-3 whitespace-nowrap {{ request()->is('member/tree') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}">Network Tree</span>
                </a>
            </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-wallet" data-collapse-toggle="dropdown-wallet">
                    <svg class="h-8 w-8 {{ request()->is('member/commissions') || request()->is('member/network') || request()->is('member/withdrawals') ? 'text-orange-400' : 'text-gray-500'}}"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />  <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" /></svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap {{ request()->is('member/commissions') || request()->is('member/network') || request()->is('member/withdrawals') ? 'font-semibold text-lg text-orange-400' : 'font-semibold text-lg text-gray-500'}}" sidebar-toggle-item>Wallet</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="dropdown-wallet" class="{{ request()->is('member/commissions') || request()->is('member/network') || request()->is('member/withdrawals') ? '' : 'hidden' }} py-2 space-y-2 font-semibold">
                    <li>
                        <a href="{{ url('member/commissions') }}" class="{{ request()->is('member/commissions') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-gray-500">Commissions</a>
                    </li>
                    <li>
                        <a href="{{ url('member/network') }}" class="{{ request()->is('member/network') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-gray-500">Network</a>
                    </li>
                    <li>
                        <a href="{{ url('member/withdrawals') }}" class="{{ request()->is('member/withdrawals') ? 'text-sm font-semibold text-orange-400' : 'text-sm font-semibold text-gray-500'}} flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group hover:bg-orange-100 dark:text-white dark:hover:bg-gray-700 font-medium text-lg text-gray-500">Withdrawals</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>

