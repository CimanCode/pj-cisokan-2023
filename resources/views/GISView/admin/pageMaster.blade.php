@extends('Layout.app')
@section('content')


<div class="relative">
    <div class="fixed top-0 p-4 w-[100%] z-[9999] flex justify-between items-center text-center drop-shadow-lg bg-white border-b-2 border-slate-500">
        <div class="flex gap-4">
            <button class="flex flex-col gap-1 px-2 py-2 bg-white rounded-md" x-on:click="showSidebar = !showSidebar">
                <span class=" h-[4px] w-6 bg-black transition-all duration-500"
                :class="showSidebar ? '-rotate-45 origin-top-right' : ''"></span>
                <span class=" h-[4px] w-6 bg-black transition-all duration-500"
                :class="showSidebar ? 'scale-0' : ''"></span>
                <span class=" h-[4px] w-6 bg-black transition-all duration-500"
                :class="showSidebar ? 'rotate-45 origin-bottom-right' : ''"></span>
            </button>
            <h1 class="font-bold text-2xl text-slate-700 absolute left-1/2 transform -translate-x-1/2 sm:relative">
                <span class="text-blue-600">GRM PLT </span> <span id="pumped">PUMPED STORAGE</span>
            </h1>
        </div>
        <div class="flex gap-4">
            <p id="halloP" class="text-lg font-semibold text-slate-600">
                Hi,<span class="text-blue-600">
                    @if(session()->has('logged','id_petugas'))
                    {{$user->username}}
                    @endif
                </span>
            </p>
            <button x-on:click="show = !show" class="flex items-center gap-2 focus:outline-none z-30">
                <div class="w-7 h-7 rounded-full bg-white border border-slate-600 overflow-hidden">
                    <i class="fa-solid fa-user-large text-2xl"></i>
                </div>
                <i class="fa-solid fa-chevron-down"></i>
            </button>
            <div x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="absolute z-30 top-16 p-2 rounded bg-white border border-blue-400 right-2">
                <a href="{{route('logout')}}" class="flex items-center gap-2 focus:outline-none hover:no-underline">
                    <button class="text-lg font-semibold focus:outline-none">
                        <i class="fa-solid fa-arrow-right-from-bracket text-lg"></i>
                        Logout
                    </button>
                </a>
            </div>
        </div>
    </div>
    <main class="pt-28  relative">
        <div class="fixed top-16 py-4 pt-8 bg-white z-30 w-full">
            <div class="relative flex justify-end pr-4">
                <div class="absolute inset-y-0  right-0 flex items-center ps-3 pr-8 pointer-events-none ">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for users">
            </div>
        </div>
        <br>
        <div class=" w-full overflow-x-auto shadow-md sm:rounded-lg px-6 pt-2 h-screen relative">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 relative">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            E-mail
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Password
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" src="./aang.png" alt="Jese image">
                            <div class="ps-3">
                                <div class="text-base font-semibold">Neil Sims</div>
                                <div class="font-normal text-gray-500">neil.sims@flowbite.com</div>
                            </div>  
                        </th>
                        <td class="px-6 py-4">
                            <p>Admin@gmail.com</p>
                        </td>
                        <td class="px-6 py-4">
                            <p>admin123</p>
                        </td>
                        <td class="px-6 py-4">
                            <button id="editModal" class="rounded-lg font-medium bg-yellow-500 px-2 py-2 text-white dark:text-blue-500 hover:underline">Edit user</button>
                            
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" src="./aang.png" alt="Jese image">
                            <div class="ps-3">
                                <div class="text-base font-semibold">Neil Sims</div>
                                <div class="font-normal text-gray-500">neil.sims@flowbite.com</div>
                            </div>  
                        </th>
                        <td class="px-6 py-4">
                            <p>Admin@gmail.com</p>
                        </td>
                        <td class="px-6 py-4">
                            <p>admin123</p>
                        </td>
                        <td class="px-6 py-4">
                            <button id="editModal" class="rounded-lg font-medium bg-yellow-500 px-2 py-2 text-white dark:text-blue-500 hover:underline">Edit user</button>
                            
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" src="./aang.png" alt="Jese image">
                            <div class="ps-3">
                                <div class="text-base font-semibold">Neil Sims</div>
                                <div class="font-normal text-gray-500">neil.sims@flowbite.com</div>
                            </div>  
                        </th>
                        <td class="px-6 py-4">
                            <p>Admin@gmail.com</p>
                        </td>
                        <td class="px-6 py-4">
                            <p>admin123</p>
                        </td>
                        <td class="px-6 py-4">
                            <button id="editModal" class="rounded-lg font-medium bg-yellow-500 px-2 py-2 text-white dark:text-blue-500 hover:underline">Edit user</button>
                            
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" src="./aang.png" alt="Jese image">
                            <div class="ps-3">
                                <div class="text-base font-semibold">Neil Sims</div>
                                <div class="font-normal text-gray-500">neil.sims@flowbite.com</div>
                            </div>  
                        </th>
                        <td class="px-6 py-4">
                            <p>Admin@gmail.com</p>
                        </td>
                        <td class="px-6 py-4">
                            <p>admin123</p>
                        </td>
                        <td class="px-6 py-4">
                            <button id="editModal" class="rounded-lg font-medium bg-yellow-500 px-2 py-2 text-white dark:text-blue-500 hover:underline">Edit user</button>
                            
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" src="./aang.png" alt="Jese image">
                            <div class="ps-3">
                                <div class="text-base font-semibold">Neil Sims</div>
                                <div class="font-normal text-gray-500">neil.sims@flowbite.com</div>
                            </div>  
                        </th>
                        <td class="px-6 py-4">
                            <p>Admin@gmail.com</p>
                        </td>
                        <td class="px-6 py-4">
                            <p>admin123</p>
                        </td>
                        <td class="px-6 py-4">
                            <button id="editModal" class="rounded-lg font-medium bg-yellow-500 px-2 py-2 text-white dark:text-blue-500 hover:underline">Edit user</button>
                            
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Main modal -->
            <div id="crud-modal" tabindex="-1" aria-hidden="true" class="-mt-[500px] z-50 fixed top-48 left-1/2 transform -translate-x-1/2 w-full sm:w-[70%] lg:w-1/2 transition-all duration-500">
                <div class="relative px-4 w-full max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Edit Petugas
                            </h3>
                            <button id="btnModalClose" type="button" class="text-gray-400 bg-red-500 -mt-[45px] -mr-[25px] rounded-full text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                                <svg class="w-3 h-3 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form class="px-4 pb-4">
                            <div class="grid gap-2 px-2 mb-4 w-full">
                                <div class=" w-full ">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                    <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required="">
                                </div>
                                <div class="flex flex-col sm:flex-row gap-2 w-full ">
                                    <div class=" w-full">
                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required="">
                                    </div>
                                    <div class=" w-full">
                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                        <input type="password" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 pt-4 flex gap-2 items-center justify-between">

                                <button type="submit" class=" text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 sm:px-8 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Simpan 
                                </button>
                                <button type="submit" class=" text-white inline-flex items-center bg-yellow-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 sm:px-8 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Edit 
                                </button>
                                <button type="submit" class=" text-white inline-flex items-center bg-red-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 sm:px-8 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Delete 
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </main>
    <div id="blockLayar" class="hidden top-0 w-full h-full bg-black opacity-50 z-40 absolute transition duration-700 ease-in-out"></div>
</div>


<script>
    function resfonsiveNavbar() {
            const pumped = document.getElementById('pumped');
            const halloP = document.getElementById('halloP');

            if (window.innerWidth <= 640) {
                pumped.classList.add('hidden');
                halloP.classList.add('hidden');
            } else {
                pumped.classList.remove('hidden');
                halloP.classList.remove('hidden');
            }
            
        }    
        window.addEventListener('load', resfonsiveNavbar);
        window.addEventListener('resize', resfonsiveNavbar);

        const btnModalClose = document.getElementById('btnModalClose');
        const editModal = document.getElementById('editModal');
        const crudModal = document.getElementById('crud-modal');
        const blockLayar = document.getElementById('blockLayar');
        btnModalClose.addEventListener('click', () => {
            crudModal.classList.toggle('-mt-[500px]');
            blockLayar.classList.add('hidden')
            
        })
        editModal.addEventListener('click', () => {
            crudModal.classList.toggle('-mt-[500px]');
            crudModal.classList.add('opacity-100');
            blockLayar.classList.remove('hidden')
        })
</script>
@endsection