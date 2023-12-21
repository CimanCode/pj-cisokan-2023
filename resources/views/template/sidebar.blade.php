<aside class="fixed w-2/12  inset-y-0 h-screen transition-all duration-500 bg-white shadow-lg z-20 flex flex-col px-4"
:class="showSidebar ? 'left-0' : '-left-96'">
    <div class="w-full mt-24">
        <ul class="mb-14 flex flex-col px-4 gap-2">
            <li>
                <a href="" class="flex items-center w-full gap-4 px-2 py-2 active:bg-slate-600 hover:bg-slate-500 rounded-lg transition-all duration-200 ease-in-out text-slate-800 hover:text-white"
                x-on:click="isLoading = true">
                    <i class="fa-solid fa-house text-[20px] w-6 text-center"></i><span class="text-lg font-semibold ">Dashboard</span>
                </a>
            </li>
            <li>
                <button type="button" x-on:click="showTable = !showTable" class="flex items-center w-full gap-4 px-2 py-2 hover:bg-slate-500 rounded-lg transition-all duration-200 ease-in-out text-slate-800 hover:text-white"
                x-on:click="isLoading = true">
                <i class="fa-solid fa-file text-[20px] w-6 text-center"></i><span class="text-lg font-semibold">Grievance</span>
                </button>
            </li>
        </ul>
    </div>
</aside>
