<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="http://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
    <script src="http://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
    <script src="https://ihcantabria.github.io/Leaflet.CanvasLayer.Field/dist/leaflet.canvaslayer.field.js"></script>
    <script src="{{asset('L.KML.js')}}"></script>
    <link rel="stylesheet" href="{{asset('build/assets/app-e9522f14.css')}}">
    @vite('resources/css/app.css')
    <title>GIS CISOKAN</title>
</head>
<body class="h-[200px]" x-data="{
    show: false,
    showTable: false,
    }">
    <div>
        @include('sweetalert::alert')
        <div class="p-4 flex justify-between items-center text-center drop-shadow-lg bg-white border-b-2 border-slate-500">
            <h1 class="font-bold text-2xl text-slate-700">
                <span class="text-blue-600">GRM PLT </span>PUMPED STORAGE
            </h1>
            <div class="flex gap-4">
                <p class="text-lg font-semibold text-slate-600">
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
        <div class="p-2 flex">
            <div class="w-8/12 p-2 drop-shadow-xl relative z-10">
                <button class="absolute z-20 top-6 left-5 px-3 py-2 bg-white text-slate-900 rounded text-center drop-shadow-xl font-semibold focus:outline-none " onclick="getCurentPosition()">Get Postion</button>
                <div id="map" class="rounded drop-shadow-lg h-[550px] w-[100%] z-10">
                </div>
                <div class="coordinate absolute z-20 bottom-6 left-5 px-3  py-2 rounded bg-white drop-shadow-lg text-slate-900 text-base font-medium"></div>
            </div>
            <div class="w-4/12 p-2 shadow-lg flex flex-col drop-shadow-lg rounded-md h-[550px]">
                <div class="p-4 text-center border-b border-slate-600">
                    <h1 class="font-bold text-lg text-slate-600">GRIEVANCE <span class="text-cyan-600">FORM</span> GRM</h1>
                </div>
                <form method="POST" action="{{route('add_grievance')}}" class="overflow-y-scroll" enctype="multipart/form-data">
                    @csrf
                    <div class="p-2 flex flex-col gap-2 drop-shadow-lg mt-4">
                        <div class="flex gap-2">
                            <div class="flex flex-col">
                                <label class="font-semibold text-lg text-slate-600">Lattitude</label>
                                <input type="text" name="lattitude" id="lat" class="px-2 py-1 border border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md shadow-md w-full">
                            </div>
                            <div class="flex flex-col">
                                <label class="font-semibold text-lg text-slate-600">Longitude</label>
                                <input type="text" name="longitude" id="long" class="px-2 py-1 border border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md shadow-md w-full">
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <label class="font-semibold text-lg text-slate-600">Issue</label>
                            <textarea name="issue" id="" class="px-2 py-1 border border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md shadow-md w-full"></textarea>
                        </div>
                        <div class="flex flex-col">
                            <label class="font-semibold text-lg text-slate-600">Category</label>
                            <input name='category' type="text" class="px-2 py-1 border border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md shadow-md w-full">
                        </div>
                        <div class="flex flex-col">
                            <label class="font-semibold text-lg text-slate-600">Locations</label>
                            <input name="locations" type="text" class="px-2 py-1 border border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md shadow-md w-full">
                        </div>
                        <div class="flex flex-col">
                            <label class="font-semibold text-lg text-slate-600">Complainants</label>
                            <input name="complainants" type="text" class="px-2 py-1 border border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md shadow-md w-full">
                        </div>
                        <div class="flex flex-col">
                            <label for="" class="font-semibold text-lg text-slate-600">Input File Image</label>
                            <div class="border border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-300 rounded-full shadow-md w-full">
                                <label class="block">
                                  <span class="sr-only">Choose File</span>
                                  <input type="file" name="image_location"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </label>
                            </div>
                        </div>
                        <div class="flex flex-col" id="signaturPad">
                            <label for="signature_ttd">TTD</label>
                            <canvas id="signature_ttd" class="px-2 py-1 border border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md shadow-md w-full"></canvas>
                            <div class="flex justify-between">
                                <input type="hidden" name="image_ttd" id="image_ttd_canvas">
                                <button type="button" class="px-2 py-1 text-white bg-red-800 rounded hover:cursor-pointer" data-action="clear_ttd">CLEAR TTD</button>
                                {{-- <button type="button" class="px-2 py-1 text-white bg-cyan-800 rounded" data-action="save_image_ttd">SUBMIT</button> --}}
                                <button type="submit" class="px-2 py-1 text-white bg-cyan-800 rounded" data-action="save_image_ttd">SUBMIT</button>
                                <button type="button" class="px-2 py-1 text-white bg-yellow-800 rounded" x-on:click="showTable = !showTable">SHOW SUMMARY GRIEVANCE</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div  x-show="showTable"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90" class="z-50">
                <div class="relative w-full">
                    <div class="z-50 absolute h-[500px] -translate-x-[1170px] bg-white px-4 py-2 rounded drop-shadow-lg text-center overflow-y-auto">
                        <button type="button"  x-on:click="showTable = false">
                            <i class="fa-solid fa-rectangle-xmark text-2xl absolute translate-x-[450px] text-red-600"></i>
                        </button>
                        <p class="text-lg font-bold text-center py-4 text-blue-600">SUMMMARY <span class="text-neutral-600">GRIVANCE</span></p>
                        <div>
                            <table>
                                <thead>
                                    <tr class=" border-b border-neutral-500">
                                        <th class="px-6 py-1">Grievance Num</th>
                                        <th class="px-6 py-1">Date Of Submission</th>
                                        <th class="px-6 py-1">Issue</th>
                                        <th class="px-6 py-1">Category</th>
                                        <th class="px-6 py-1">Location</th>
                                        <th class="px-6 py-1">Complaiments</th>
                                        <th class="px-6 py-1">Status</th>
                                        <th class="px-6 py-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($data_grievance as $value)
                                    <tr class="border-b border-neutral-500 m-6">
                                        <td class=" text-neutral-600 font-semibold">{{$value->grievance_num}}</td>
                                        <td class=" text-neutral-600 font-semibold">{{$value->created_at}}</td>
                                        <td class=" text-neutral-600 font-semibold">{{$value->issue}}</td>
                                        <td class=" text-neutral-600 font-semibold">{{$value->category}}</td>
                                        <td class=" text-neutral-600 font-semibold">{{$value->locations}}</td>
                                        <td class=" text-neutral-600 font-semibold">{{$value->complainants}}</td>
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
                    </div>
                </div>
                <div class="fixed inset-0 z-10 bg-neutral-500/10 backdrop-blur-sm" x-on:click="showTable = false"></div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-omnivore/0.3.4/leaflet-omnivore.min.js" integrity="sha512-55AYz+N6WyuiC8bRpQftNyCcSBCl3AEutoTsb4EeZuFVFP1+G4gll30iczAvvTpdL9nz48F7ZFEUavRUXp3FNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="{{asset('L.KML.js')}}"></script>
    <script type="text/javascript">
        // signature_pad
        const signaturePad = document.getElementById("signaturePad");
        const clearButton = document.querySelector("[data-action=clear_ttd]");
        const saveButton = document.querySelector("[data-action=save_image_ttd]");
        const signature_ttd = document.querySelector("canvas");
        const signature_save = new SignaturePad(signature_ttd, {
            minWidth: 0.5,
            maxWidth: 1,
        });

        clearButton.addEventListener("click", function(e){
            signature_save.clear();
        })

        saveButton.addEventListener("click", function(e){
            if(signature_save.isEmpty()){
                alert("provire signature first");
                e.preventDefault();
            } else {
                const canvas = document.getElementById("signature_ttd");
                const dataURL = canvas.toDataURL(canvas);
                document.getElementById("image_ttd_canvas").value = dataURL
                // console.log(image);
            }
        })
        // const data_signature_pad = signature_pad.toDataURL();
        // document.getElementById('image_ttd_canvas').value = data_signature_pad
        // saveButton.addEventListener("click", function () {
        // });
        // if (!signature_pad.isEmpty()){
        // }

        // saveButton.addEventListener("click", function () {
        //     if (!signature_pad.isEmpty()) {
        //     const data_signature_pad = signature_pad.toDataURL();
        //     savedSignature.innerHTML =
        //         '<img src="' + data_signature_pad + '" alt="Tanda Tangan">';
        //     } else {
        //     alert("Tanda tangan kosong.");
        //     }
        //     document.getElementById('image_ttd_canvas').value = data_signature_pad
        // });

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
    </script>
</body>
</html>
