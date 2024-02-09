@extends('Layout.app')
@section('content')
<div class="relative">
    <div class="p-4 absolute w-[100%] z-[9999] flex justify-between items-center text-center drop-shadow-lg bg-white border-b-2 border-slate-500">
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
    <div id="map" class="min-h-screen w-[100%] z-10"></div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script>
        var map = L.map('map').setView([-7.419576565392435, 108.13217590348474], 15);
        map.zoomControl.setPosition('bottomright');
        @foreach ($data_grievance as $value)
            L.marker([{{$value->lattitude}},{{$value->longitude}}], 15).addTo(map).bindPopup('Complainants : {{$value->complainants}} <br> Issue : {{$value->issue}} <br> Category : {{$value->category}} <br> Status : {{$value->status}} <img class="w-[500px]" src="{{$value->image_location}}"/> <br>'),
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
        // layerControl.addTo(map);
        if(!navigator.geolocation){
            console.log("Your location is not supported geolocation!")
        } else {
            setInterval(() => {
                navigator.geolocation.getCurrentPosition(getPosition)
            }, 3000);
        }

        function getPosition(position) {
            var lat = position.coords.latitude
            var long = position.coords.longitude
            var accuracy = position.coords.accuracy

            if(marker) {
                map.removelayer(marker);
            }

            if(circle) {
                map.removelayer(circle);
            }

            var marker = L.marker([lat, long])
            var circle = L.circle([lat, long], {radius: accuracy})

            var featureGroup = L.featureGroup([marker, circle]).addTo(map).bindPopup("<h1>Marker</h1>,<p></P>")

            // map.fitBounds(featureGroup.getBounds())
            console.log("lat: " + lat + ", lon: " + long + ", accuracy: " + accuracy)
        }

        function GetLatLon(e){
            const coords = document.querySelector("[name=coordinate]")
            const latTitude = document.querySelector("[name=lat]")
            const longitude = document.querySelector("[name=long]")
            let lat = e.latlng.lat
            let lon = e.latlng.lng

            coords.value = lat + "," + lon
            latTitude.value = lat
            longitude.value = lon
        }

        map.on('click',GetLatLon)

        function MoveLatLng(e){
            $('.coordinate').html(`Lat : ${e.latlng.lat}, Long : ${e.latlng.lng}`);
        }
        map.on('mousemove', MoveLatLng)


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
