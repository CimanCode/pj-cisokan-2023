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
        
        <div id="formContent" class="w-full right-0 inset-y-0 shadow-2xl drop-shadow-lg h-screen bg-white z-30 absolute sm:w-1/2 lg:w-1/3 -top-[700px] overflow-y-scroll transition-all duration-500">
            <div class="fixed w-full z-50 bg-white p-4 text-center border-b border-slate-600 shadow-sm">
                <h1 class="font-bold text-lg text-slate-600">GRIEVANCE <span class="text-cyan-600">FORM</span> GRM</h1>
            </div><br><br><br>
            <form id="overflowForm" method="POST" action="{{route('add_grievance')}}" class="" enctype="multipart/form-data">
                @csrf
                
                <div class="px-4 flex flex-col gap-2">
                    <div class="flex gap-2 flex-col sm:flex-row w-full">

                        <div class="flex flex-col w-full">
                            <label for="dateInput" class="block text-sm font-medium text-slate-600">Hari/Tanggal</label>
                            <div class="mt-1 relative">
                                <input type="date" id="dateInput" name="dateInput" class="form-input px-2 py-1 block w-full leading-5 rounded-md border  focus:outline-none focus:ring-1 focus:ring-blue-400">
                            </div>
                        </div>
                        <div class="flex flex-col w-full">
                            <label for="nomorAduan" class="font-semibold text-slate-600 text-base">Nomor Kode Aduan</label>
                            <input type="number" name="nomorAduan" id="nomorAduan" class="px-2 py-1 border  focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md w-full uppercase">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="flex flex-col w-full">
                            <label for="namaPelapor" class="font-semibold text-slate-600 text-base">Nama Pelapor</label>
                            <input type="text" name="namaPelapor" id="namaPelapor" class="px-2 py-1 border  focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md w-full uppercase">
                        </div>
                        <div class="flex flex-col w-full">
                            <label for="inputRt" class="font-semibold text-slate-600 text-base">RT/RW</label>
                            <input type="number" name="inputRt" id="inputRt" class="px-2 py-1 border  focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md w-full uppercase">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="flex flex-col w-full">
                            <label for="inputDusun" class="font-semibold text-slate-600 text-base">Dusun/Kampung</label>
                            <input type="text" name="inputDusun" id="inputDusun" class="px-2 py-1 border focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md w-full uppercase">
                        </div>
                        <div class="flex flex-col w-full">
                            <label for="desa" class="font-semibold text-slate-600 text-base">Desa</label>
                            <input type="text" name="desa" id="desa" class="px-2 py-1 border  focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md w-full uppercase">
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label for="noKTP" class="font-semibold text-slate-600 text-base">No. KTP</label>
                        <input type="number" name="noKTP" id="noKTP" class="px-2 py-1 border  focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md w-full uppercase">
                    </div>
                    <div class="flex flex-col">
                        <label for="noKontak" class="font-semibold text-slate-600 text-base">No. Kontak Pelapor</label>
                        <input type="number" name="noKontak" id="noKontak" class="px-2 py-1 border  focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md w-full uppercase">
                    </div>
                    <div class="flex flex-col">
                        <label for="kategori" class="font-semibold text-slate-600 text-base">Kategori</label>
                        <input type="text" name="kategori" id="kategori" class="px-2 py-1 border  focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md w-full uppercase">
                    </div>
                    <div class="flex flex-col">
                        <label class="font-semibold text-slate-600 text-base">Uraian aduan</label>
                        <textarea name="uraianAduan" id="" class="px-2 py-1 border  focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md w-full"></textarea>
                    </div>
                    <div class="flex flex-col">
                        <label class="font-semibold text-slate-600 text-base">Jalur aduan </label>
                        <input name="jalurAduan" type="text" class="px-2 py-1 border  focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md w-full">
                    </div>
                    <div class="flex flex-col">
                        <label class="font-semibold text-slate-600 text-base">Uraian rencana tindak lanjut</label>
                        <textarea name="uraianAduan" id="" class="px-2 py-1 border  focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md w-full"></textarea>
                    </div>
                    <div class="flex gap-2">
                        <div class="flex flex-col w-full">
                            <label class="font-semibold text-slate-600 text-base">Lattitude</label>
                            <input type="text" name="lattitude" id="lat" class="px-2 py-1 border  focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md w-full uppercase">
                        </div>
                        <div class="flex flex-col w-full">
                            <label class="font-semibold text-slate-600 text-base">Longitude</label>
                            <input type="text" name="longitude" id="long" class="px-2 py-1 border  focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md w-full">
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label for="" class="font-semibold text-slate-600 text-base">Input File Image</label>
                        <label class="flex border rounded-full">
                            <span class="sr-only">Choose File</span>
                            <input type="file" name="image_location"
                                  class="block w-full text-[12px] text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </label>
                    </div>
                    <div class="block overflow-hidden">   
                        <div class="flex justify-between h-8">
                            <input type="hidden" name="image_ttd" id="image_ttd_canvas" class="rounded-tl-none">
                            <label for="signature_ttd">TTD</label>
                            <button type="button" class="px-2 py-1 text-white bg-red-800 rounded hover:cursor-pointer text-base rounded-bl-none focus:outline-none" data-action="clear_ttd">CLEAR TTD</button>
                        </div>
                        <canvas id="signature_ttd" class="px-2 py-1 border  focus:outline-none focus:ring-1 focus:ring-blue-400 rounded-md shadow-md w-full"></canvas>  
                    </div>
                    <div class="pb-2">
                        <button type="submit" class="px-2 py-2 text-white bg-cyan-800 rounded w-full" data-action="save_image_ttd">SUBMIT</button>
                    </div>
                </div>
            
            </form>
        </div>

        <div id="btnAddEvent" class="absolute sm:fixed sm:bottom-0 flex z-40  px-3 py-2 w-full justify-start items-center">
            <button id="myButton" class="px-6 sm:px-3 py-3 rounded-full flex items-center justify-center bg-blue-600 text-slate-900 text-center drop-shadow-xl font-semibold focus:outline-none transition ease-out duration-300">
                <span id="buttonAdd" class="material-symbols-outlined text-transparent sm:text-white">add</span>
            </button>
        </div>
    
        <div id="divForm" class="flex justify-center relative">   
            <div class="flex relative drop-shadow-xl z-10 w-full justify-center">
                <button class="absolute z-20 left-5 -mt-10 py-1 px-3  sm:mt-12 bg-white text-slate-900 rounded text-center drop-shadow-xl font-semibold focus:outline-none " onclick="getCurentPosition()">Get Postion</button>
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


        // For Tmmbol add
        const icon = document.getElementById('buttonAdd');
        const button = document.getElementById('myButton');
        const content = document.getElementById('formContent');

        button.addEventListener('click', () => {
        content.classList.toggle('-top-[700px]');
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
            icon.classList.remove('hidden')
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