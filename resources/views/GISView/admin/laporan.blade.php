@extends('Layout.app')
@section('content')
    <div>
        @include('sweetalert::alert')
        <div class="p-4 w-[100%] top-0 fixed z-[9999] flex justify-between items-center text-center drop-shadow-lg bg-white border-b-2 border-slate-500">
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
                    <span class="text-blue-600">GRM PLTA UPPER CISOKAN </span> PUMPED STORAGE 4X260 MW
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
        <div id="divForm" class="flex justify-center relative">
            <div class="flex relative drop-shadow-xl z-10 w-full justify-center">
                <div class="absolute z-20 w-[75%] top-[20%] overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                            <p class="font-bold"><span class="text-blue-700">SUMMARY</span> GRIEVANCE</p>
                            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Riwayat Laporan/Keluhan Yang Terjadi Di Project PLTA</p>
                        </caption>
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Grievance Num
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date of Summary
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
                                    Complainants
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span>Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_grievance as $value)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
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
                                <td class="px-6 py-4">
                                    @if($value->status == "Reported")
                                    <p class="px-3 py-1 rounded bg-yellow-400 text-white">{{$value->status}}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex gap-2">
                                        <a href="{{route('detail')}}?id={{$value->grievance_id}}" class="font-medium text-white dark:text-blue-500 hover:underline bg-blue-700 px-2 py-1 rounded"><i class="fa-solid fa-eye"></i></i></a>
                                        <a href="{{route('edit_grievance')}}?id={{$value->grievance_id}}" class="font-medium text-white dark:text-blue-500 hover:underline bg-yellow-400 px-2 py-1 rounded"><i class="fa-solid fa-pen"></i></a>
                                        <a href="{{route('delete')}}?id={{$value->grievance_id}}" class="font-medium text-white dark:text-blue-500 hover:underline bg-red-700 px-2 py-1 rounded"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="map" class="rounded drop-shadow-lg h-screen w-full z-10 -mt-12 sm:mt-9" style="margin-top: 65px;">
                </div>
                <div class="coordinate absolute z-20 bottom-6 left-5 px-3  py-2 rounded bg-white drop-shadow-lg text-slate-900 text-base font-medium"></div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-omnivore/0.3.4/leaflet-omnivore.min.js" integrity="sha512-55AYz+N6WyuiC8bRpQftNyCcSBCl3AEutoTsb4EeZuFVFP1+G4gll30iczAvvTpdL9nz48F7ZFEUavRUXp3FNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{asset("KML/kml.js")}}"></script>
    <script type="text/javascript">

        // map
        var map = L.map('map').setView([-7.419576565392435, 108.13217590348474], 15);
        map.zoomControl.setPosition('bottomright');
        @foreach ($data_grievance as $value)
            L.marker([{{$value->lattitude}}, {{$value->longitude}}], 15).bindPopup('<p>Complainants : {{$value->complainants}}</p><br> Issue : {{$value->issue}} <br> Category : {{$value->category}} <br> <img class="w-[500px]" src="{{$value->image_location}}"/> <br>/>'),
        @endforeach

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


        fetch("{{asset('./Layers.kml')}}")
                .then(res => res.text())
                .then(kmltext => {
                    // Create new kml overlay
                    const parser = new DOMParser();
                    const kml = parser.parseFromString(kmltext, 'text/xml');
                    const track = new L.KML(kml);
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
@endsection
