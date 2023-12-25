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
    <link rel="stylesheet" href="{{asset('build/assets/app-e9522f14.css')}}">
    @vite('resources/css/app.css')
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
                                <button ><a href="{{route("riwayat")}}"><i class="fa-solid p-3 hover:bg-gray-700 hover:text-white hover:ease-in-out duration-200 rounded-full border border-gray-700 fa-arrow-left"></i></a></button>
                            </div>
                            <div>
                                <p class="font-bold">DETAIL <span class="text-blue-700">SUMMARY</span> GRIEVANCE</p>
                                <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Riwayat Laporan/Keluhan Yang Terjadi Di Project PLTA</p>
                            </div>
                        </div>
                        <div class="row-span-2 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <div class="py-4 w-[50%]">
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        Grievance Num
                                    </div>
                                    <div class="col-span-9">
                                        : {{$grievance->grievance_num}}
                                    </div>
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        Tanggal Laporan
                                    </div>
                                    <div class="col-span-9">
                                        : {{$grievance->created_at}}
                                    </div>
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        Lokasi
                                    </div>
                                    <div class="col-span-9">
                                        : {{$grievance->locations}}
                                    </div>
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        Kampung
                                    </div>
                                    <div class="col-span-9">
                                        : {{$grievance->kampung}}
                                    </div>
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        RT/RW
                                    </div>
                                    <div class="col-span-9">
                                        : {{$grievance->rt_rw}}
                                    </div>
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        Desa
                                    </div>
                                    <div class="col-span-9">
                                        : {{$grievance->desa}}
                                    </div>
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        Koordinate
                                    </div>
                                    <div class="col-span-9">
                                        : {{$grievance->lattitude}} {{$grievance->longitude}}
                                    </div>
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        Deskripsi Laporan
                                    </div>
                                    <div class="col-span-9">
                                        : {{$grievance->issue}}
                                    </div>
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        Status Laporan
                                    </div>
                                    @if($grievance->status == "Reported")
                                    <div class="col-span-9 ">
                                        : <span class="text-yellow-500">{{$grievance->status}}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        Kategori
                                    </div>
                                    <div class="col-span-9">
                                        : {{$grievance->category}}
                                    </div>
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        Jalur Laporan
                                    </div>
                                    <div class="col-span-9">
                                        : {{$grievance->jalur_aduan}}
                                    </div>
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        Pelapor
                                    </div>
                                    <div class="col-span-9">
                                        : {{$grievance->complainants}}
                                    </div>
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        No Handphone
                                    </div>
                                    <div class="col-span-9">
                                        : {{$grievance->no_telp}}
                                    </div>
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        No KTP
                                    </div>
                                    <div class="col-span-9">
                                        : {{$grievance->no_ktp}}
                                    </div>
                                </div>
                                <div class="flex px-5 text-base gap-14">
                                    <div class="col-span-3">
                                        Foto Lokasi
                                    </div>
                                    <div class="col-span-9">
                                       <img src="{{$grievance->image_location}}" alt="" class="w-60">
                                    </div>
                                </div>
                            </div>
                            <div class="p-5 flex gap-2 justify-end">
                                <button class="px-3 py-1 bg-yellow-600 text-white  rounded"><a href=""><i class="fa-solid fa-plus"></i> Pengembalian Aduan</a></button>
                                <button class="px-3 py-1 bg-blue-600 text-white  rounded"><a href=""><i class="fa-solid fa-plus"></i> Penyelesaian Aduan</a></button>
                                <button class="px-3 py-1 bg-green-600 text-white  rounded"><a href=""><i class="fa-solid fa-print"></i></a></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="map" class="rounded drop-shadow-lg h-screen w-full z-10 -mt-12 sm:mt-9">
                </div>
                <div class="coordinate absolute z-20 bottom-6 left-5 px-3  py-2 rounded bg-white drop-shadow-lg text-slate-900 text-base font-medium"></div>
            </div>
        </div>
    </div>
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



        document.getElementById('dateInput').addEventListener('change', function () {
        // Get the selected date value
        const selectedDate = this.value;

        // Convert the selected date to the desired format (MM/DD/YY)
        const formattedDate = new Date(selectedDate).toLocaleDateString('en-US', {
            year: '2-digit',
            month: '2-digit',
            day: '2-digit'
        });

        // Set the formatted date back to the input
        this.value = formattedDate;
        });

    </script>


</body>
</html>
