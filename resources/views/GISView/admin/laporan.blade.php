@extends('Layout.app')
@section('content')
<div class="p-4 fixed w-[100%] z-50 flex justify-between items-center text-center drop-shadow-lg bg-white border-b-2 border-slate-500">
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
    <h1 class="text-center pt-24 pb-6 text-2xl font-bold"><span class="text-blue-600">SUMMARY</span> <span class="text-slate-600">GRIVANCE</span></h1>
    <div class="overflow-x-auto shadow-md sm:rounded-lg pt-4">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Grievance Num
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date Of Submission
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Issue
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Location
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Complaiments
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_grievance as $value)
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{$value->grievance_num}}
                    </th>
                    <td class="px-6 py-4">
                        {{$value->created_at}}
                    </td>
                    <td class="px-6 py-4">
                        {{$value->issue}}
                    </td>
                    <td class="px-6 py-4">
                        {{$value->category}}
                    </td>
                    <td class="px-6 py-4">
                        {{$value->locations}}
                    </td>
                    <td class="px-6 py-4">
                        {{$value->complainants}}
                    </td>
                    <td class="">
                        <a href="" class="bg-yellow-600 text-white rounded px-3 py-2">{{$value->status}}</a>
                    </td>
                    <td class="px-6 py-1">
                        <a href="" class="bg-green-800 text-white rounded px-4 py-2"><i class="fa-solid fa-download"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
</script>
@endsection