<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Google icont --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />



    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="http://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
    <script src="http://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
    <script src="https://ihcantabria.github.io/Leaflet.CanvasLayer.Field/dist/leaflet.canvaslayer.field.js"></script>
    <script src="{{asset('L.KML.js')}}"></script>
    <link rel="stylesheet" href="{{asset('build/assets/app-f641d9ac.css')}}">
    {{-- <script src="{{asset('build/assets/app-0d91dc04.js')}}"></script> --}}
    {{-- @vite('resources/css/app.css') --}}
    <title>GIS CISOKAN</title>

    <style>
        #EventSidebar.left-0 {
            transform: translateX(0);
        }

        #EventSidebar.-left-96 {
            transform: translateX(-100%);
        }

        #divForm {
            margin-top: 50px;

        }

        /* Untuk Transition Form */
        .transitionsFrom {
            margin-right: -435px;
        }
        #formContent {
            margin-top: 85px;
        }
        #overflowForm {
            scrollbar-width: thin;
            scrollbar-color: #4a4a4a transparent;
        }
        #overflowForm::-webkit-scrollbar-track {
            background-color: transparent;
        }
        #overflowForm::-webkit-scrollbar-thumb {
        background-color: transparent;
        border-radius: 6px;
        border: 2px solid #fff;
        }

        /* Untuk Animasi Add */
        @keyframes rotate {
            0% {
        transform: rotate(0deg);
        }
        50% {
            transform: rotate(180deg);
        }
        100% {
            transform: rotate(360deg);
        }
        }

        .clicked {
            background-color: red;
            animation-name: rotate;
            animation-duration: 2s;
            animation-timing-function: ease;
        }
    </style>
</head>
<body class="h-[200px]" x-data="{
    show: false,
    showTable: false,
    }">
    <div>
        @include('sweetalert::alert')

        <div class="p-6 fixed z-50 w-full top-0 flex justify-between items-center text-center drop-shadow-lg bg-white border-b-2 border-slate-500">
            <button id="toggleSidebar" class="flex flex-col gap-1 p-2 bg-white rounded-md">
                <span id="bar1" class="h-[4px] w-6 bg-black transition-transform duration-300 transform origin-center"></span>
                <span id="bar2" class="h-[4px] w-6 bg-black transition-transform duration-300 transform origin-center"></span>
                <span id="bar3" class="h-[4px] w-6 bg-black transition-transform duration-300 transform origin-center"></span>
              </button>

            <h1 class="font-bold text-2xl text-slate-700">
                <span class="text-blue-600">GRM PLT </span><span id="pumped">PUMPED STORAGE</span>
            </h1>
            <div class="flex gap-4">
                <p id="haloUser" class="text-lg font-semibold text-slate-600">
                    Hi,<span class="text-blue-600">
                        @if(session()->has('logged','id_petugas'))
                        {{$user->username}}
                        @endif
                    </span>
                </p>
                <button x-on:click="show = !show" class="flex items-center gap-2 focus:outline-none">
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
                class="absolute top-16 p-2 rounded bg-white border border-blue-400 right-2">
                    <a href="{{route('logout')}}" class="flex items-center gap-2 focus:outline-none hover:no-underline">
                        <button class="text-lg font-semibold focus:outline-none">
                            <i class="fa-solid fa-arrow-right-from-bracket text-lg"></i>
                            Logout
                        </button>
                    </a>
                </div>
            </div>
        </div>

        {{-- <button id="toggleSidebar" class="flex flex-col gap-1 p-2 bg-white rounded-md">
            <span id="bar1" class="h-[4px] w-6 bg-black transition-all duration-500"></span>
            <span id="bar2" class="h-[4px] w-6 bg-black transition-all duration-500"></span>
            <span id="bar3" class="h-[4px] w-6 bg-black transition-all duration-500"></span>
        </button> --}}

        <aside id="EventSidebar" class="fixed inset-y-0 h-screen bg-white shadow-lg z-20 flex flex-col items-center px-4 -left-96 transition-transform duration-300">
            <div class="w-full mt-24">
                <ul class="mb-14 flex flex-col  gap-2">
                    <li class="md:text-base lg:px-4">
                        <a href="/petugasmap" class="flex items-center w-full gap-4 px-2 py-2 active:bg-slate-600 hover:bg-slate-500 rounded-lg transition-all duration-200 ease-in-out text-slate-800 hover:text-white" x-on:click="isLoading = true">
                            <i class="fa-solid fa-house text-[20px] w-6 text-center"></i><span class="text-lg font-semibold ">Dashboard</span>
                        </a>
                    </li>
                    <li class="md:text-base lg:px-4">
                        <button type="button" x-on:click="showTable = !showTable" class="flex items-center w-full gap-4 px-2 py-2 hover:bg-slate-500 rounded-lg transition-all duration-200 ease-in-out text-slate-800 hover:text-white" x-on:click="isLoading = true">
                            <i class="fa-solid fa-file text-[20px] w-6 text-center"></i><span class="text-lg font-semibold">Grievance</span>
                        </button>
                    </li>
                    @if (session()->has('logged','id_role_admin'))
                    <li class="md:text-base lg:px-4">
                        <a href="{{route('listpetugas')}}" class="flex items-center w-full gap-7 py-2 px-4 active:bg-slate-600 hover:bg-slate-500 rounded-lg transition-all duration-200 ease-in-out text-slate-800 hover:text-white"
                        x-on:click="isLoading = true">
                            <i class="fa-solid fa-user text-[20px]  text-center"></i><span class="text-lg font-semibold ">Petugas</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </aside>



        <div id="btnAddEvent" class="fixed bottom-0 flex z-20 px-3 py-2 w-full justify-start items-center">
            <button id="myButton" class="px-3 py-3 rounded-full flex items-center justify-center bg-blue-600 text-slate-900 text-center drop-shadow-xl font-semibold focus:outline-none transition ease-out duration-300">
                <span id="buttonAdd" class="material-symbols-outlined text-white">add</span>
            </button>
        </div>

        <div id="divForm" class="flex justify-center relative">
            <div class="flex relative drop-shadow-xl z-10 w-full justify-center">
                <div class="absolute z-20 w-[75%] h-[70%] top-[10%] overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <div class="p-5 text-lg font-semibold flex justify-between text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                            <div class="flex items-center">
                                @if(session()->get('api_token'))
                                <button ><a href="{{route("riwayat")}}"><i class="fa-solid p-3 hover:bg-gray-700 hover:text-white hover:ease-in-out duration-200 rounded-full border border-gray-700 fa-arrow-left"></i></a></button>
                                @elseif(session()->get('id_role_admin'))
                                <button ><a href="{{route("laporanAdmin")}}"><i class="fa-solid p-3 hover:bg-gray-700 hover:text-white hover:ease-in-out duration-200 rounded-full border border-gray-700 fa-arrow-left"></i></a></button>
                                @endif
                            </div>
                            <div>
                                <p class="font-bold">DETAIL <span class="text-blue-700">SUMMARY</span> GRIEVANCE</p>
                                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Riwayat Laporan/Keluhan Yang Terjadi Di Project PLTA</p>
                            </div>
                        </div>
                        <div class="row-span-2 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <div class="py-4 w-[100%]">
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-6">
                                        <ul>
                                            <li>Grievance Num </li>
                                        </ul>
                                        <ul>
                                            <li>Tanggal Laporan </li>
                                        </ul>
                                        <ul>
                                            <li>Lokasi </li>
                                        </ul>
                                        <ul>
                                            <li>Kampung </li>
                                        </ul>
                                        <ul>
                                            <li>RT/RW </li>
                                        </ul>
                                        <ul>
                                            <li>Desa </li>
                                        </ul>
                                        <ul>
                                            <li>Koordinate </li>
                                        </ul>
                                        <ul>
                                            <li>Deskripsi Laporan </li>
                                        </ul>
                                        <ul>
                                            <li>Status Laporan </li>
                                        </ul>
                                        <ul>
                                            <li>Kategori </li>
                                        </ul>
                                        <ul>
                                            <li>Jalur Laporan </li>
                                        </ul>
                                        <ul>
                                            <li>Pelapor </li>
                                        </ul>
                                        <ul>
                                            <li>No. Handphone </li>
                                        </ul>
                                        <ul>
                                            <li>No. KTP </li>
                                        </ul>
                                        <ul>
                                            <li>Foto Lokasi </li>
                                        </ul>
                                    </div>
                                    <div class="col-span-6">
                                        <ul>
                                            <li>: {{$grievance->grievance_num}}</li>
                                        </ul>
                                        <ul>
                                            <li>: {{$grievance->created_at}}</li>
                                        </ul>
                                        <ul>
                                            <li>: {{$grievance->locations}}</li>
                                        </ul>
                                        <ul>
                                            <li>: {{$grievance->kampung}}</li>
                                        </ul>
                                        <ul>
                                            <li>: {{$grievance->rt_rw}}</li>
                                        </ul>
                                        <ul>
                                            <li>: {{$grievance->desa}}</li>
                                        </ul>
                                        <ul>
                                            <li>: {{$grievance->lattitude}}, {{$grievance->longitude}}</li>
                                        </ul>
                                        <ul>
                                            <li>: {{$grievance->issue}}</li>
                                        </ul>
                                        <ul>
                                            @if($grievance->status == "Reported")
                                                <li>: <span class="text-yellow-500">{{$grievance->status}}</span></li>
                                            @elseif($grievance->status == "proses")
                                                <li>: <span class="text-blue-500">{{$grievance->status}}</span></li>
                                            @endif
                                        </ul>
                                        <ul>
                                            <li>: {{$grievance->category}}</li>
                                        </ul>
                                        <ul>
                                            <li>: {{$grievance->jalur_aduan}}</li>
                                        </ul>
                                        <ul>
                                            <li>: {{$grievance->complainants}}</li>
                                        </ul>
                                        <ul>
                                            <li>: {{$grievance->no_telp}}</li>
                                        </ul>
                                        <ul>
                                            <li>: {{$grievance->no_ktp}}</li>
                                        </ul>
                                        <ul>
                                            <li>: <img src="{{$grievance->image_location}}" alt="" class="w-60"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 flex gap-2 justify-end">
                                @if(session()->get('id_role_admin'))
                                <button id="editmodal" class="px-3 py-1 bg-blue-600 text-white  rounded"><i class="fa-solid fa-plus"></i> Update Status & Tindak Lanjut</button>
                                <button class="px-3 py-1 bg-green-600 text-white  rounded"><a href="{{route('downloadlaporan', ['id' => $grievance->grievance_id])}}"><i class="fa-solid fa-print"></i></a></button>
                                @endif
                            </div>
                        </div>
                         <!-- Main modal -->
                        </div>
                    </div>
                    <div id="map" class="rounded drop-shadow-lg h-screen w-full z-10 -mt-12 sm:mt-9">
                    </div>
                    <div class="coordinate absolute z-20 bottom-6 left-5 px-3  py-2 rounded bg-white drop-shadow-lg text-slate-900 text-base font-medium"></div>
                </div>
            </div>
            <div id="crud-modal" tabindex="-1" aria-hidden="true" class="-mt-[500px] z-50 fixed top-0 left-1/2 transform -translate-x-1/2 w-full sm:w-[70%] lg:w-1/2 transition-all duration-500">
                <div class="relative px-4 w-full max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Update Proses Penanganan
                            </h3>
                            <button id="btnModalClose" type="button" class="text-gray-400 bg-red-500 -mt-[45px] -mr-[25px] rounded-full text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                                <svg class="w-3 h-3 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form class="px-4 pb-4" method="POST" action="{{route('updateProgress')}}">
                            @csrf
                            <div class="grid gap-2 px-2 mb-4 w-full">
                                <div class=" w-full ">
                                    <input type="hidden" name="grievance_id" value="{{$grievance->grievance_id}}">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                    <select name="status" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required="">
                                        <option value="proses">Dalam Proses</option>
                                        <option value="finish">Selesai</option>
                                    </select>
                                    {{-- <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required=""> --}}
                                </div>
                                <div class="flex flex-col sm:flex-row gap-2 w-full ">
                                    <div class=" w-full">
                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tindak Lanjut</label>
                                        <textarea name="tindak_lanjut" id="tindak_lanjut" cols="30" rows="10" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type product name" required=""></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="px-2 pt-4 flex gap-2 items-center justify-between">
                                <button type="submit" class=" text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 sm:px-8 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    <div id="blockLayar" class="hidden top-0 w-full h-full bg-black opacity-50 z-40 absolute transition duration-700 ease-in-out"></div>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-omnivore/0.3.4/leaflet-omnivore.min.js" integrity="sha512-55AYz+N6WyuiC8bRpQftNyCcSBCl3AEutoTsb4EeZuFVFP1+G4gll30iczAvvTpdL9nz48F7ZFEUavRUXp3FNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{asset('L.KML.js')}}"></script>
    <script type="text/javascript">

        // map
        var map = L.map('map').setView([-7.419576565392435, 108.13217590348474], 15);
        map.zoomControl.setPosition('bottomright');

        googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        });

        googleStreets.addTo(map);

        googleHybrid = L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        });

        googleSat = L.tileLayer('http://{s}.google.com/vt?lyrs=s&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        });

        var baseMaps = {
            "Street": googleStreets,
            "Hybrid": googleHybrid,
            "satelite": googleSat
        };


        // var overlayMaps = {
        //     "Cities": cities
        // };

        var layers = L.control.layers(baseMaps).addTo(map);

        function getCurentPosition(){
            // console.log('your location');
            setInterval(() => {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var currentLatLng = L.latLng(position.coords.latitude, position.coords.longitude);

                    // Move the map to the current position
                    map.setView(currentLatLng, 15); // You can adjust the zoom level as needed

                    // Create a marker at the current position
                    L.marker(currentLatLng).addTo(map)
                        .openPopup("Its Your Position");
                }, function (error) {
                    alert("Unable to retrieve your location. Error: " + error.message);
                });
            }, 500);
        }


            fetch('/getKmlFile')
                .then(res => res.text())
                .then(kmltext => {
                    // Create new kml overlay
                    const parser = new DOMParser();
                    const kml = parser.parseFromString(kmltext, 'text/xml');
                    const track = new L.KML(kmltext, 'text/xml');
                    map.addLayer(track);

                    // Adjust map to show the kml
                    const bounds = track.getBounds();
                    map.fitBounds(bounds);
                });



        function getPosition(position) {
            var lat = position.coords.latitude
            var long = position.coords.longitude
            var accuracy = position.coords.accuracy

            if(marker) {
                map.removeLayer(marker);
            }
            if(circle) {
                map.removeLayer(circle);
            }

            var marker = L.marker([lat, long])
            var circle = L.circle([lat, long])

            var featureGroup = L.featureGroup([marker]).addTo(map)

            // map.fitBounds(featureGroup.getBounds())
            console.log("lat: " + lat + ", lon: " + long + ", accuracy: " + accuracy)
        }

        function GetLatLon(e){
            const latTitude = document.querySelector("[name=lattitude]")
            const longitude = document.querySelector("[name=longitude]")
            let lat = e.latlng.lat
            let lon = e.latlng.lng

            latTitude.value = lat
            longitude.value = lon
        }

        map.on('click',GetLatLon)

        function MoveLatLng(e){
            $('.coordinate').html(`Lat : ${e.latlng.lat}, Long : ${e.latlng.lng}`);
        }
        map.on('mousemove', MoveLatLng)


        // For Tmmbol add
        const icon = document.getElementById('buttonAdd');
        const button = document.getElementById('myButton');
        const content = document.getElementById('formContent');

        button.addEventListener('click', () => {
        content.classList.toggle('hidden');
        if (icon.innerText === 'add') {
                icon.innerText = 'close';
                button.classList.add('bg-red-500')
            } else {
                icon.innerText = 'add';
                button.classList.remove('bg-red-500')
            }

            // Berikan animasi putar pada ikon
            icon.style.animation = 'rotatePlusToX 0.5s ease-in-out';

                // Setel timeout untuk menghapus animasi setelah selesai
                setTimeout(() => {
                    icon.style.animation = '';
                }, 1000);
            });

        // Untuk Sidebar
        const toggleSidebar = document.getElementById('toggleSidebar');
        const eventSidebar = document.getElementById('EventSidebar');


        toggleSidebar.addEventListener('click', () => {
            eventSidebar.classList.toggle('-left-96');

            document.getElementById('bar1').classList.toggle('-rotate-45');
            document.getElementById('bar1').classList.toggle('translate-y-2');
            document.getElementById('bar2').classList.toggle('opacity-0');
            document.getElementById('bar3').classList.toggle('rotate-45');
            document.getElementById('bar3').classList.toggle('-translate-y-2');
        });




        // Untuk Responsive navbar
        function removeHiddenClass() {
        const element = document.getElementById('pumped');
        const haloUser = document.getElementById('haloUser');
        const formContent = document.getElementById('formContent');
        const btnAddEvent = document.getElementById('btnAddEvent');


        // responsive
        if (window.innerWidth <= 640) {
            element.classList.add('hidden');
            haloUser.classList.add('hidden');

            btnAddEvent.classList.add('justify-center')
        } else {

            element.classList.remove('hidden');
            haloUser.classList.remove('hidden');

            btnAddEvent.classList.remove('justify-center')
        }
        }

        window.addEventListener('load', removeHiddenClass);
        window.addEventListener('resize', removeHiddenClass);

        const btnModalClose = document.getElementById('btnModalClose');
        const editModal = document.getElementById('editmodal');
        const crudModal = document.getElementById('crud-modal');
        const blockLayar = document.getElementById('blockLayar');
        btnModalClose.addEventListener('click', () => {
            crudModal.classList.toggle('-mt-[500px]');
            blockLayar.classList.add('hidden');
            crudModal.classList.add('top-0');
            crudModal.classList.remove('top-48');

        })

        editModal.addEventListener('click', () => {
            crudModal.classList.toggle('-mt-[500px]');
            crudModal.classList.add('opacity-100');
            crudModal.classList.remove('top-0');
            crudModal.classList.add('top-48');
            blockLayar.classList.remove('hidden')
        })

        // document.getElementById('dateInput').addEventListener('change', function () {
        // // Get the selected date value
        // const selectedDate = this.value;

        // // Convert the selected date to the desired format (MM/DD/YY)
        // const formattedDate = new Date(selectedDate).toLocaleDateString('en-US', {
        //     year: '2-digit',
        //     month: '2-digit',
        //     day: '2-digit'
        // });

        // // Set the formatted date back to the input
        // this.value = formattedDate;
        // });

    </script>


</body>
</html>
