

<aside class="fixed w-1/2 sm:w-1/3 md:w-1/5 inset-y-0 h-screen transition-all duration-500 bg-white shadow-lg z-50 flex flex-col items-center"
:class="showSidebar ? 'left-0' : '-left-96'">
    <div class="w-full mt-24">
        <ul class="mb-14 flex flex-col gap-2 items-center">
            <li>
                <a href="/admin" class="flex px-4 items-center w-full gap-3 py-2 active:bg-slate-600 hover:bg-slate-500 rounded-lg transition-all duration-200 ease-in-out text-slate-800 hover:text-white"
                x-on:click="isLoading = true">
                    <i class="fa-solid fa-house text-[20px]  text-center"></i><span class="text-lg font-semibold ">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/laporanAdmin">
                    <button type="button" x-on:click="showTable = !showTable" class="flex items-center px-4 w-full gap-4 py-2 hover:bg-slate-500 rounded-lg transition-all duration-200 ease-in-out text-slate-800 hover:text-white"
                    x-on:click="isLoading = true">
                    <i class="fa-solid fa-file text-[20px] text-center"></i><span class="text-lg font-semibold">Grievance</span>
                    </button>
                </a>
            </li>
            <li class="">
                <a href="/master" class="flex items-center w-full gap-7 py-2 px-4 active:bg-slate-600 hover:bg-slate-500 rounded-lg transition-all duration-200 ease-in-out text-slate-800 hover:text-white"
                x-on:click="isLoading = true">
                    <i class="fa-solid fa-user text-[20px]  text-center"></i><span class="text-lg font-semibold ">Petugas</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
