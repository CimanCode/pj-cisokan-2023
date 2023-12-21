<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{asset('build/assets/app-e9522f14.css')}}">
    @vite('resources/css/app.css')
    <title>GIS CISOKAN</title>
</head>
<body>
    <div>
        @include('sweetalert::alert')
        <div class="p-4  flex justify-between bg-white shadow-lg border-b-2 border-slate-500">
            <h1 class="font-bold text-2xl text-slate-700">
                <span class="text-blue-600">GRM PLT </span> PUMPED STORAGE
            </h1>
            <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="px-3 py-1 bg-blue-600 text-white text-lg font-bold rounded-md shadow-md">
                LOGIN
            </button>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h1 class="modal-title font-bold text-cyan-800 text-xl" id="staticBackdropLabel">LOGIN</h1>
                            <button type="button" class="font-semibold text-center text-white bg-red-800 rounded px-2" data-bs-dismiss="modal" aria-label="Close">X</button>
                        </div>
                        <form method="POST" action="{{route('login')}}">
                            @csrf
                            <div class="modal-body">
                                <div class="flex flex-col gap-2">
                                    <div class="flex flex-col gap-1">
                                        <label for="email" class="font-semibold text-slate-800 text-lg">Email Adress</label>
                                        <input type="text" name="email" class="border border-blue-300 bg-blue-50 focus:outline-none focus:ring-1 focus:ring-blue-300 rounded-md py-2 px-3" placeholder="Email">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label for="password" class="font-semibold text-slate-800 text-lg">Password</label>
                                        <input type="password" name="password" class="border border-blue-300 bg-blue-50 focus:outline-none focus:ring-1 focus:ring-blue-300 rounded-md py-2 px-3" placeholder="Password">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">LOGIN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 z-10">
            <div id="map" class="rounded shadow-lg min-h-screen w-[100%] z-10"></div>
            <div class="coordinate absolute z-20 bottom-6 left-3 px-3  py-2 rounded bg-white drop-shadow-lg text-slate-900 text-base font-medium"></div>
        </div>
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
    </script>
</body>
</html>

