<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard HSE') }}
        </h2>
    </x-slot>
    @push('css')
    <style>
        [type="checkbox"]+label, [type="radio"]:not(:checked)+label, [type="radio"]:checked+label, [type="date"] {
            color: unset;
            background-color: unset;
        }
        .dark-skin .form-control, .dark-skin .form-select{
            border-color: unset;
            color: unset;
        }
        @media (min-width: 768px) {
            .md\:row-span-4 {
                grid-row: span 4 / span 4;
            }
            .md\:col-start-4 {
                grid-column-start: 4;
            }
            .md\:row-start-1 {
                grid-row-start: 1;
            }
            .md\:row-end-4 {
                grid-row-end: 4;
            }
            .md\:grid-cols-5 {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }
            .md\:grid-cols-8 {
                grid-template-columns: repeat(8, minmax(0, 1fr))
            }
            .md\:grid-cols-14 {
                grid-template-columns: repeat(14, minmax(0, 1fr));
            }
            .md\:grid-cols-16 {
                grid-template-columns: repeat(16, minmax(0, 1fr));
            }
            .md\:col-span-15 {
                grid-column: span 15 / span 15;
            }
            .md\:grid-rows-2 {
                grid-template-rows: repeat(2, minmax(0, 1fr));
            }
            .md\:grid-flow-col {
                grid-auto-flow: column;
            }
            .md\:justify-center {
                justify-content: center
            }
            .md\:col-span-3 {
                grid-column: span 3/span 3
            }
            .md\:col-span-4 {
                grid-column: span 4/span 4
            }
            .md\:mb-28{
                margin-bottom: 7rem; /* 112px */
            }
        }
        @media (min-width: 640px) {
            .sm\:col-span-2 {
                grid-column: span 2 / span 2;
            }
            .sm\:\!flex-row {
                flex-direction: row !important;
            }
            .sm\:\!m-2 {
                margin: 0.5rem /* 8px */ !important;
            }
        }
        .justify-self-end{
            justify-self: end;
        }
        .col-start-1 {
            grid-column-start: 1;
        }
        .custom-bg-color{
            background-color:#ebedf3;
        }
        .dark-skin .custom-bg-color{
            background-color: #242439;
        }
        .form-control{
            border-color:unset;
        }
        /* Mematikan navigasi lewat header di jquery steps */
        /* .steps { 
            pointer-events: none;
        } */
    </style>
    @endpush

<div class="box-body wizard-content">
    <form id="form" name="form" method="POST" class="validation-hse wizard-circle card py-10">
        @csrf
        <!-- Step 1 -->
        <h6 class="text-md font-semibold mb-4">Ijin Kerja 1</h6>
        <section id="ijinKerja1">
            <div class="rounded-lg custom-bg-color" id="pelaksanaPekerjaan">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Pelaksana Pekerjaan</span>
                </div>
                <div class="p-2" id="pelaksanaPekerjaanContent">
                    <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2">
                        @php 
                            $workTitle = ["Nama Perusahaan / Departemen","No HP","Tanggal Mulai Pelaksanaan", "Tanggal Berakhir Pelaksanaan","Penanggung Jawab Lapangan","Lokasi Pekerjaan","Jam Mulai Kerja","Jam Berakhir Kerja","Jumlah Tenaga Kerja", "Penjelasan Pekerjaan"];
                        @endphp
                        @foreach($workTitle as $title)
                            @if($title == "No HP")
                            <div class="form-group flex flex-col">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <input type="number" id="{{$title}}" name="{{$title}}" class="form-control rounded-lg w-3/4" placeholder="Input data" required>
                            </div>
                            @elseif($title == "Tanggal Mulai Pelaksanaan")
                            <div class="form-group flex flex-col">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <input type="date" id="{{$title}}" name="{{$title}}" class="form-control flex rounded-lg w-3/4"  onchange="ubahTanggal()">

                            </div>
                            @elseif($title == "Tanggal Berakhir Pelaksanaan")
                            <div class="form-group flex flex-col">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <input type="date" id="{{$title}}" name="{{$title}}" class="form-control flex rounded-lg w-3/4" readonly>
                            </div>
                            @elseif($title == "Jam Mulai Kerja" || $title == "Jam Berakhir Kerja")
                            <div class="form-group flex flex-col">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <input type="time" id="{{$title}}" name="{{$title}}" class="form-control flex rounded-lg w-3/4">                                    
                            </div>
                            @elseif($title == "Penjelasan Pekerjaan")
                            <div class="form-group flex flex-col md:col-span-3">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <textarea name="{{$title}}" id="{{$title}}" class="form-control w-3/4" style="resize: none;" rows="4" placeholder="Penjelasaan..."></textarea>
                            </div>
                            @elseif($title == "Jumlah Tenaga Kerja")
                            <div class="form-group flex flex-col">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <div class="flex w-3/4 items-center">
                                    <input type="number" id="{{$title}}" name="{{$title}}" class="form-control rounded-lg w-3/4" placeholder="Input data" required>
                                    <label for="{{$title}}" class="p-2">orang</label>
                                </div>
                            </div>
                            @else
                            <div class="form-group flex flex-col">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <input type="text" id="{{$title}}" name="{{$title}}" class="form-control rounded-lg w-3/4" placeholder="Input data" required>
                            </div>
                            @endif
                        @endforeach
                    </div>

                    <div class=" flex justify-end">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" name="selanjutnya" id="selanjutnya"onClick="nextClass('pelaksanaPekerjaanContent', 'potensiBahayaContent')">
                            Lanjut
                        </div>
                    </div>
                
                </div>
            </div>

            <div class="rounded-lg custom-bg-color" id="potensiBahaya">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Potensi Bahaya di Area Kerja</span>
                </div>
                @php 
                    $workTitle = ["Mudah Terbakar", "Gas Beracun", "Bising", "Benda Berat", "Ledakan", "Listrik", "Ketinggian", "Lantai Licin", "Temperatur Tinggi", "Bahan Kimia", "Ruang Tertutup"];
                @endphp
                <div class="p-2 hidden" id="potensiBahayaContent">
                    <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2" >
                        @foreach($workTitle as $title)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="danger {{$title}}">
                            <label class="block text-md font-medium" for="danger {{$title}}">
                                {{$title}}
                            </label>
                        </div>
                        @endforeach
                        <div class="form-check flex items-center">
                            <input class="form-check-input" type="checkbox" value="" id="newInput">
                            <label class="form-check-label block text-md font-medium" for="newInput">
                                <input type="text" id="newInput" name="newInput" class="form-control rounded-lg w-3/4" style="height:100%;">
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-5">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="previousClass('potensiBahayaContent', 'pelaksanaPekerjaanContent')">
                            Kembali
                        </div>
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="nextClass('potensiBahayaContent', 'apdContent')">
                            Lanjut
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-lg custom-bg-color" id="apd">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Alat Pelindung Diri (APD)</span>
                </div>

                <div class="p-2 hidden" id="apdContent">
                    <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2">
                        <div>
                            <div class="p-1.5 pl-3"><i>Kepala/Mata/Wajah</i></div>
                            @php 
                                $workTitle = ["Safety Helmet", "Goggles (Impact)", "Goggles (Chemical)", "Face Shield (Chemical)", "Face Shield (Welding)", "Face Shield (Grinding)"];
                            @endphp
                            @foreach($workTitle as $title)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="{{$title}}">
                                <label class="block text-md font-medium" for="{{$title}}">
                                    {{$title}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div>
                            <div class="p-1.5 pl-3"><i>Pernapasan</i></div>
                            @php 
                                $workTitle = ["Respirator", "Dust Mask"];
                            @endphp
                            @foreach($workTitle as $title)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="{{$title}}">
                                <label class="block text-md font-medium" for="{{$title}}">
                                    {{$title}}
                                </label>
                            </div>
                            @endforeach
                            
                            <div class="p-1.5 pl-3"><i>Badan</i></div>
                            @php 
                                $workTitle = ["Safety Body Harness", "Apron (Hot & Welding)"];
                            @endphp
                            @foreach($workTitle as $title)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="{{$title}}">
                                <label class="block text-md font-medium" for="{{$title}}">
                                    {{$title}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div>
                            <div class="p-1.5 pl-3"><i>Kaki</i></div>
                            @php 
                                $workTitle = ["Safety Shoes (Impact)", "Rubber / PVC Shoes"];
                            @endphp
                            @foreach($workTitle as $title)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="{{$title}}">
                                <label class="block text-md font-medium" for="{{$title}}">
                                    {{$title}}
                                </label>
                            </div>
                            @endforeach

                            <div class="p-1.5 pl-3"><i>Telinga</i></div>
                            @php 
                                $workTitle = ["Ear Plug", "Ear Muff"];
                            @endphp
                            @foreach($workTitle as $title)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="{{$title}}">
                                <label class="block text-md font-medium" for="{{$title}}">
                                    {{$title}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div>
                            <div class="p-1.5 pl-3"><i>Tangan</i></div>
                            @php 
                                $workTitle = ["Cotton Gloves", "Rubber/PVC" , "Leather Gloves"];
                            @endphp
                            @foreach($workTitle as $title)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="{{$title}}">
                                <label class="block text-md font-medium" for="{{$title}}">
                                    {{$title}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                
                    <div class=" flex justify-end mt-5">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="previousClass('apdContent', 'potensiBahayaContent')">
                            Kembali
                        </div>
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="nextClass('apdContent', 'daftarPeralatanContent')">
                            Lanjut
                        </div>
                    </div>
                </div >
            </div>
            
            <div class="rounded-lg custom-bg-color" id="daftarPeralatan">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Daftar Peralatan Kerja</span>
                </div>
                
                <div class="p-2 hidden" id="daftarPeralatanContent">
                    <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2">
                        @php 
                            $workTitle = ["Power Tools", "Tangga (Ladder)" , "Bahan Kimia", "Hand Tools", "Stagger (Scaffolds)", "Tabung Gas & Fittings", "Welding Set", "Alat angkat & Angkut", "Air Compressor", "Gerinda / Cutting Tools"];
                        @endphp
                        @foreach($workTitle as $title)
                        <div class="form-check">
                            @if($title == "Alat angkat & Angkut")
                                <input class="form-check-input" type="checkbox" value="" id="{{$title}}" onClick="sioSilo(this)">
                                <label class="block text-md font-medium" for="{{$title}}">
                                    {{$title}} </br> (Forklift, Crane, Hoise, Boomlift)
                                </label>
                                    
                            @else
                                <input class="form-check-input" type="checkbox" value="" id="{{$title}}">
                                <label class="block text-md font-medium" for="{{$title}}">
                                    {{$title}}
                                </label>
                            @endif
                        </div>
                        @endforeach

                        <div class="form-check"> 
                            <input class="form-check-input" type="checkbox" value="" id="extraTool">
                            <label class="form-check-label block text-md font-medium" for="extraTool">
                                <input type="text" id="extraTool" name="extraTool" class="form-control rounded-lg w-3/4" style="height:100%;">
                            </label>
                        </div>
                            
                    </div>
                    
                    <div class=" flex justify-end mt-5">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="previousClass('daftarPeralatanContent', 'apdContent')">
                            Kembali
                        </div>
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="nextClass('daftarPeralatanContent', 'ijinKerjaTambahanContent')">
                            Lanjut
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-lg custom-bg-color" id="ijinKerjaTambahan">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Ijin Kerja Tambahan yang Diperlukan</span>
                </div>
                
                <div class="p-2 hidden" id="ijinKerjaTambahanContent"> 
                    <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2">
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="hotWork" onclick="hotWorkPermit(this)">
                                <label class="block text-md font-medium" for="hotWork">
                                    <p class="">Ijin Pekerjaan Panas</p>
                                </label>
                            </div>
                        </div>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="confinedSpace" onclick="confinedSpacePermit(this)">
                                <label class="block text-md font-medium" for="confinedSpace">
                                    <p class="">Ijin Kerja Di Ruang Terbatas</p>
                                </label>
                            </div>
                        </div>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="heightWork" onclick="heightWorkPermit(this)">
                                <label class="block text-md font-medium" for="heightWork">
                                    <p class="">Ijin Kerja Di Ketinggian</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class=" flex justify-end mt-5">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="previousClass('ijinKerjaTambahanContent', 'daftarPeralatanContent')">
                            Kembali
                        </div>
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="nextClass('ijinKerjaTambahanContent', 'pengendaliBahayaContent')">
                            Lanjut
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-lg custom-bg-color" id="pengendaliBahaya">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Pengendali Bahaya Kebakaran</span>
                </div>
        
                <div class="p-2 hidden"  id="pengendaliBahayaContent">
                    <div id="peralatanProteksiKebakaran">
                        <div class="my-10">
                            <div class="font-medium">Apakah pekerjaan memerlukan Sistem Proteksi Kebakaran?</div>
                        </div>
                        <div>
                            <label class="inline-flex items-center cursor-pointer">
                                <span class="ms-3 text-sm font-medium mr-3">Tidak</span>
                                <input type="checkbox" value="" id="" class="sr-only peer" onclick="sistemProteksiKebakaran(this)">
                                <div class="relative w-11 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                <span class="ms-3 text-sm font-medium ">Ya</span>
                            </label>
                        </div>
                    </div>
                    
                    
                    
                    <div class="flex justify-end mt-5">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="previousClass('pengendaliBahayaContent', 'ijinKerjaTambahanContent')">
                            Kembali
                        </div>
                    </div>
                </div>
            </div>

        </section>


        <!-- Step 2 -->
        <h6 class="text-md font-semibold mb-4">Ijin Kerja 2</h6>
        <section id="ijinKerja2">
            <div class="rounded-lg custom-bg-color" id="tenagaKerja">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Fit to Work</span>
                </div>
                <div class="p-2" id="tenagaKerjaContent">
                    <div class="border rounded-lg p-3">
                        <div id="tenagaKerjaGrid" class="grid gap-y-3">
                            <div class="grid md:grid-cols-16">
                                <div>
                                    <div class="flex md:justify-center">
                                        <label for="" class="block text-md font-medium">No. 1</label>
                                    </div>
                                </div>
                                <div class="md:col-span-15 grid md:grid-cols-4 gap-x-4">
                                    <div class="flex md:justify-center">
                                        <label for="namaTenagaKerja1" class="font-medium">Nama Tenaga Kerja :</label>
                                    </div>
                                    <div class="col-span-3">
                                        <input type="text" id="namaTenagaKerja1" name="namaTenagaKerja1" class="form-control rounded-lg w-full" placeholder="Input data">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex sm:!flex-row flex-col mt-2">
                            <div id="addButtonTenagaKerja" class="m-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn">
                                <i class="fas fa-plus">
                                </i>
                                Tambah
                            </div>
                            <div id="removeButtonTenagaKerja" class="mx-2 sm:!m-2 px-4 py-2 text-white rounded-lg hover:bg-red-600 btn bg-red-500 btn" >
                                <i class="fas fa-times">
                                </i>
                                Hapus Baris Terakhir
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>


        <!-- Step 3 -->
        <h6>Formulir Analisis Keamanan Pekerjaan (JSA)</h6>
        <section id="formJSA">
            <div class="rounded-lg custom-bg-color" id="jsa">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Job Safety Analysis (JSA)</span>
                </div>

                <div class="p-2" id="jsaContent">
                    
                    <div class="border rounded-lg p-3">
                        <div class="grid flex justify-center md:grid-cols-3 sm:grid-cols-2 grid-cols-1">
                            @php 
                                $workTitle = ["JSA dilakukan oleh","Lokasi","Tanggal","Penjelasan Pekerjaan"];
                            @endphp
                            @foreach($workTitle as $title)
                                @if ($title == "Penjelasan Pekerjaan")
                                    <div class="form-group flex flex-col col-start-1 sm:col-span-2 md:col-span-3">
                                        <label for="department" class="block text-md font-medium">{{$title}}</label>
                                        <textarea id="{{$title}}1" name="{{$title}}1" class="form-control rounded-lg w-full" style="resize: none;" rows="4" placeholder="Tolong isi penjelasan pekerjaan." readonly></textarea>
                                    </div>
                                @else
                                    <div class="form-group flex flex-col">
                                        <label for="department" class="block text-md font-medium">{{$title}}</label>
                                        <input type="text" id="{{$title}}1" name="{{$title}}1" class="form-control rounded-lg w-3/4" readonly>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    
                    <div class="grid md:grid-cols-8" >
                        <div class="md:col-span-3 my-2">
                            <img src="{{ asset('assets\images\hse\Matriks HSE.jpg')}}" alt="Gambar Matriks" class="w-full" style="max-height:300px; object-fit: contain;">
                        </div>
                        <div class="md:col-span-2 my-2">
                            <img src="{{ asset('assets\images\hse\Kemungkinan Matriks.jpg')}}" alt="Gambar Matriks" class="w-full" style="max-height:300px; object-fit: contain;">
                        </div>
                        <div class="md:col-span-3 my-2">
                            <img src="{{ asset('assets\images\hse\Keparahan Matriks.png')}}" alt="Gambar Matriks" class="w-full" style="max-height:300px; object-fit: contain;">
                        </div>
                    </div>

                    <div class="border rounded-lg p-3 mt-4 md:mb-28">
                        <div id="potentialDangerGrid" class="grid gap-y-3">
                            <div class="grid md:grid-cols-16">
                                <div>
                                    <div class="flex md:justify-center">
                                        <label for="bahayaPotensial" class="block text-md font-medium">No. 1</label>
                                    </div>
                                </div>
                                <div class="md:col-span-15 grid md:grid-cols-14 md:grid-rows-2 md:grid-flow-col gap-x-4 gap-1">
                                    <div class="md:col-span-4">
                                        <div><label for="bahayaPotensial1" class="block text-md font-medium">Bahaya Potensial / Konsekuensi (Apa yang menyebabkan bahaya)</label></div>
                                    </div>
                                    <div class="md:col-span-4">
                                        <input type="text" id="bahayaPotensial1" class="form-control rounded-lg w-full" placeholder="Input data">
                                    </div>
                                    <div>
                                        <div><label for="severityBefore1" class="block text-md font-medium">S</label></div>
                                    </div>
                                    <div>
                                        <div class="relative inline-block text-left" style="min-width:50px;">
                                            <div>
                                                <button type="button" id="severityBefore1Button"  class="dropDownButton inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" aria-expanded="true" aria-haspopup="true" onclick="dropDownToggle(this)">
                                                1
                                                <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                                </svg>
                                                </button>
                                            </div>
                                            <ul id="severityBefore1" class="hidden dropDownMenu absolute w-full z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" onchange="updateButtonText()">
                                                <div class="py-1" role="none">
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">1</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">2</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">3</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">4</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">5</li>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div><label for="opportunityBefore1" class="block text-md font-medium">O</label></div>
                                    </div>
                                    <div>
                                        <div class="relative inline-block text-left" style="min-width:50px;">
                                            <div>
                                                <button type="button" id="opportunityBefore1Button"  class="dropDownButton inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" aria-expanded="true" aria-haspopup="true" onclick="dropDownToggle(this)">
                                                1
                                                <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                                </svg>
                                                </button>
                                            </div>
                                            <ul id="opportunityBefore1" class="hidden dropDownMenu absolute w-full z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" onchange="updateButtonText()">
                                                <div class="py-1" role="none">
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">1</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">2</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">3</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">4</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">5</li>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div><label for="riskFactorBefore1" class="block text-md font-medium">RF</label></div>
                                    </div>
                                    <div>
                                        <input type="number" id="riskFactorBefore1" class="form-control rounded-lg w-full" value="1" readonly>
                                    </div>
                                    <div class="md:col-span-4">
                                        <div><label for="pengendalianBahayaHirarki1" class="block text-md font-medium">Pengendalian (Gunakan Hirarki Pengendalian Bahaya)</label></div>
                                    </div>
                                    <div class="md:col-span-4">
                                        <input type="text" id="pengendalianBahayaHirarki1" class="form-control rounded-lg w-full" placeholder="Input data">
                                    </div>
                                    <div>
                                        <div><label for="severityAfter1" class="block text-md font-medium">S</label></div>
                                    </div>
                                    <div>
                                        <div class="relative inline-block text-left" style="min-width:50px;">
                                            <div>
                                                <button type="button" id="severityAfter1Button"  class="dropDownButton inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" aria-expanded="true" aria-haspopup="true" onclick="dropDownToggle(this)">
                                                1
                                                <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                                </svg>
                                                </button>
                                            </div>
                                            <ul id="severityAfter1" class="hidden dropDownMenu absolute w-full z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" onchange="updateButtonText()">
                                                <div class="py-1" role="none">
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">1</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">2</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">3</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">4</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">5</li>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div><label for="opportunityAfter1" class="block text-md font-medium">O</label></div>
                                    </div>
                                    <div>
                                        <div class="relative inline-block text-left" style="min-width:50px;">
                                            <div>
                                                <button type="button" id="opportunityAfter1Button"  class="dropDownButton inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" aria-expanded="true" aria-haspopup="true" onclick="dropDownToggle(this)">
                                                1
                                                <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                                </svg>
                                                </button>
                                            </div>
                                            <ul id="opportunityAfter1" class="hidden dropDownMenu absolute w-full z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" onchange="updateButtonText()">
                                                <div class="py-1" role="none">
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">1</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">2</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">3</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">4</li>
                                                <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">5</li>
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div><label for="riskFactorAfter1" class="block text-md font-medium">RF</label></div>
                                    </div>
                                    <div>
                                        <input type="number" id="riskFactorAfter1" class="form-control rounded-lg w-full" value="1" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Button  -->
                        <div class="flex mt-2">
                            <div id="addButtonPotentialDanger" class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn">
                                <i class="fas fa-plus">
                                </i>
                                Tambah
                            </div>
                            <div id="removeButtonPotentialDanger" class="mx-2 px-4 py-2 text-white rounded-lg hover:bg-red-600 btn bg-red-500 btn" >
                                <i class="fas fa-times">
                                </i>
                                Hapus Baris Terakhir
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

        </section>
    </form>
</div>


@push('scripts')
<script>
var form = $(".validation-hse").show();
var lastCurrSection;
var childCurrDiv;




function ubahTanggal() {
    const inputDate = new Date(document.getElementById("Tanggal Mulai Pelaksanaan").value);
    if (!isNaN(inputDate)) {
        let daysAdded = 0;
        let nextDate = new Date(inputDate);

        while (daysAdded < 6) {
            nextDate.setDate(nextDate.getDate() + 1);
            // Cek apakah hari tersebut bukan Sabtu (6) atau Minggu (0)
            if (nextDate.getDay() !== 0 && nextDate.getDay() !== 6) {
                daysAdded++;
            }
        }

        // Format tanggal dalam "yyyy-MM-dd"
        const startYear = inputDate.getFullYear();
        const startMonth = String(inputDate.getMonth() + 1).padStart(2, '0'); // Tambahkan 1 karena bulan dimulai dari 0
        const startDay = String(inputDate.getDate()).padStart(2, '0');

        const endYear = nextDate.getFullYear();
        const endMonth = String(nextDate.getMonth() + 1).padStart(2, '0'); // Tambahkan 1 karena bulan dimulai dari 0
        const endDay = String(nextDate.getDate()).padStart(2, '0');

        document.getElementById("Tanggal Berakhir Pelaksanaan").value = `${endYear}-${endMonth}-${endDay}`;
        document.getElementById('Tanggal1').value = `${startDay}-${startMonth}-${startYear} - ${endDay}-${endMonth}-${endYear}`;
    } else {
        document.getElementById('Tanggal Berakhir Pelaksanaan').value = '';
    }
};

$(".validation-hse").steps({
    headerTag: "h6"
    , bodyTag: "section"
    , transitionEffect: "none"
    , titleTemplate: '#title#'
    , enableAllSteps: false
    , labels: {
        next: "Lanjut",
        previous: "Sebelumnya",
        finish: "Selesai", 
    }
    , onStepChanging: function (event, currentIndex, newIndex) {
        return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
    }
    ,onStepChanged: function(event, currentIndex) {
        lastCurrSection = $(".validation-hse section").eq(currentIndex).children("div").last();
        childCurrDiv = lastCurrSection.children("div").last();
        if (childCurrDiv.hasClass("hidden")) {
            // Lakukan sesuatu jika div terakhir memiliki kelas 'hidden'
            console.log("Div terakhir di section ini tersembunyi!");
            
            $("a[href$='next']").hide();
            $("a[href$='previous']").hide();
        }else{
            $("a[href$='next']").show();
            $("a[href$='previous']").show();
        }
    }
    , onFinishing: function (event, currentIndex) {
        return form.validate().settings.ignore = ":disabled", form.valid()
    }
    , onFinished: function (event, currentIndex) {
        swal("Success", "Your Form Submitted!.");
        // $("#form").submit();
    }
}), $(".validation-hse").validate({
    ignore: "input[type=hidden]"
    , errorClass: "text-danger"
    , successClass: "text-success"
    , highlight: function (element, errorClass) {
        $(element).removeClass(errorClass)
    }
    , unhighlight: function (element, errorClass) {
        $(element).removeClass(errorClass)
    }
    , errorPlacement: function (error, element) {
        // Mengambil elemen induk
        var parent = element.parent();
        // Menambahkan pesan kesalahan ke dalam elemen induk
        parent.append(error);
    }
    , rules: {
        email: {
            email: !0
        }
    }
});


$("a[href$='next']").hide();
$("a[href$='previous']").hide();

function nextClass(currContent,nextContent) {

    let allFilled = true;

    const inputs = document.querySelectorAll(`#${currContent} input[required]`); 
    inputs.forEach(input => {
    
    const tempElement = document.getElementById(input.id + '-error');
    // Kondisi ketika element yang required tidak diisi
    if (input.value.trim() == '') {
        allFilled = false;
        // Membuat label baru untuk error
        if(tempElement){
            tempElement.removeAttribute('style');
        }else{
            const newLabel = document.createElement('label');
            newLabel.id = input.id + '-error'; // Set ID
            newLabel.textContent = 'This field is required'; // Isi teks
            newLabel.classList.add('text-danger'); 
            input.parentNode.appendChild(newLabel);
        }
        }else{
            if(tempElement){
                tempElement.style.display='none';
            }
        }
    });

    if(allFilled){
        const currElement = document.getElementById(currContent);
        currElement.classList.add('hidden'); // Menambahkan class 'hidden'
        const nextElement = document.getElementById(nextContent);
        nextElement.classList.remove('hidden'); // Menghapus class 'hidden'
        
        // Mengarahkan tampilan ke bagian selanjutnya
        const tujuan = document.getElementById(nextContent.replace("Content", ''));
        const headerHeight = document.querySelector('header').offsetHeight;
        const elementPosition = tujuan.getBoundingClientRect().top + window.scrollY;
        const offsetPosition = elementPosition - 120;
        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth' 
        });
        
        // Jika berada pada bagian terakhir, akan ditampilkan tombol next
        if (nextContent === "pengendaliBahayaContent"){
            $("a[href$='next']").show();
            $("a[href$='previous']").show();
        }else if(childCurrDiv){
            if(nextContent === childCurrDiv.attr("id") ){
                $("a[href$='next']").show();
                $("a[href$='previous']").show();
            }
        }
    }
}

function previousClass(currContent,previousContent) {

    const currElement = document.getElementById(currContent);
    currElement.classList.add('hidden'); // Menambahkan class 'hidden'
    const previousElement = document.getElementById(previousContent);
    previousElement.classList.remove('hidden'); // Menghapus class 'hidden'

    // Mengarahkan tampilan ke bagian selanjutnya
    const dest = document.getElementById(previousContent.replace("Content", ''));
    const headerHeight = document.querySelector('header').offsetHeight;
    const elementPosition = dest.getBoundingClientRect().top + window.scrollY;
    const offsetPosition = elementPosition - 120;
    window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth' 
    });

    // Jika berada pada bagian terakhir, akan ditampilkan tombol next
    if (currContent === "pengendaliBahayaContent"){
        $("a[href$='next']").hide();
        $("a[href$='previous']").hide()
    }else if(childCurrDiv){
        if(currContent === childCurrDiv.attr("id") ){
            $("a[href$='next']").hide();
            $("a[href$='previous']").hide()
        }
    }
}

function sioSilo(button){
    var parentDiv = document.getElementById('daftarPeralatanContent');
    var firstChild = parentDiv.firstElementChild;
    if (button.checked){
        var newDiv = document.createElement('div');
        newDiv.innerHTML = `
        <div class="flex" style="justify-content: space-around;">
            <div class="form-check flex flex-col p-1">
                <input type="file" name="uploadSIO" id="SIO" class="form-control w-3/4 hidden" onchange="fileChange(this,'SIO')" required/>
                <label for="SIO">
                    SIO
                    <i class="fa-solid fa-file-arrow-up"></i>
                </label>
            </div>
            <div class="form-check flex flex-col p-1">
                <input type="file" name="uploadSILO" id="SILO" class="form-control w-3/4 hidden" onchange="fileChange(this,'SILO')" required/>
                <label for="SILO">
                    SILO
                    <i class="fa-solid fa-file-arrow-up"></i>
                </label>
            </div>
        </div>
        <div>
            <table id="sioSiloTable">
                <thead>
                    <tr>
                        <th>Tipe</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        `;
        firstChild.appendChild(newDiv);
        
    }else{
        firstChild.removeChild(firstChild.lastChild);
    }
}

function hotWorkPermit(button){
    var titles = "Ijin Kerja Pekerjaan Dengan Api"; 
    if (button.checked){
        $(".validation-hse").steps('insert', 1, { title: titles, content: 
            `<div class="rounded-lg custom-bg-color" id="perlindunganKebakaran">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">A. Perlindungan Terhadap Bahaya Kebakaran</span>
                </div>
                <div class="p-2" id="perlindunganKebakaranContent">
                    @php 
                        $workTitle = [
                            "1. Ada personil terlatih yang mempunyai wewenang untuk mengehentikan suatu pekerjaan atau terlibat langsung dalam pekerjaan ini, yang melakukan pengawasan terhadap kemungkinan bahaya kebakaran selama periode Hot Work dilakukan dan setidaknya satu jam setelah pekerjaan berhenti pada area kerja dan area sekitar",
                            "2. Menyediakan di dekat tempat kerja sekurang-kurangnya dua buah alat pemadam api (APAR), baik personil yang melakukan pekerjaan maupun pengawasan bahaya kebakaran terlatih untuk menggunakannya",
                            "3. Personil yang melakukan pekerjaan maupun pengawasan bahaya kabakaran mengetahui cara mengevakuasi diri dari tempat kejadian dan menyalakan alarm kebakaran ataupun memanggil bantuan pemadam Kebakaran (ERT)",
                            "4. Peralatan pengelasan dan pemotongan dalam kondisi yang baik dan aman. Tabung gas dilengkapi dengan flashback arrester, dan mempunyai selang flexible dalam kondisi baik pula",
                            "5. Site Watcher / Penjaga Lokasi yang mengawasi pekerjaan di ketinggian ini"
                            ];
                    @endphp
                    @foreach($workTitle as $index => $title)
                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" value="" id="perlindunganKebakaran{{$index}}">
                        <label class="block text-md font-medium" for="perlindunganKebakaran{{$index}}">
                            {{$title}}
                        </label>
                    </div>
                    @endforeach

                    <div class=" flex justify-end">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" name="selanjutnya" id="selanjutnya"onClick="nextClass('perlindunganKebakaranContent', 'pencegahanDalamRadiusContent')">
                            Lanjut
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-lg custom-bg-color" id="pencegahanDalamRadius">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">B. Pencegahan Dalam Radius 12 meter dari Area Pekerjaan</span>
                </div>
                <div class="p-2 hidden" id="pencegahanDalamRadiusContent">
                    <div>
                        @php 
                        $workTitle = [
                            "6. Bahan-bahan yang mudah terbakar telah disingkirkan dari area sekitar. Bilamana bahan tersebut tidak dapat dipindahkan, maka diberi perlindungan dari bahan yang tidak mudah terbakar",
                            "7. Lantai yang mudah terbakar telah dibersihkan terlebih dulu dan dilindungi dengan cara dibasahi air dan ditutup dengan pasir yang lembab ataupun lembaran-lembaran dari bahan yang tidak mudah terbakar. Seluruh lubang di dinding dan lantai dimana percikan api dapat melewatinya ditutup dengan lembaran-lembaran dari bahan yang tidak mudah terbakar.",
                            "8. Bilamana bekerja di ketinggian harus dibawahnya dilindungi dengan bahan atau lembaran yang tidak mudah terbakar untuk menahan percikan api yang timbul",
                            "9. Bahan yang mudah terbakar disingkirkan dari sisi dinding atau partisi bila dapat menghantarkan panas walaupun jauh, terutama bila melibatkan tiang maupun struktur dari logam",
                            "10. Bahan atau lembaran pelindung dari bahan yang tidak mudah terbakar disediakan untuk dinding, partisi langit-langit maupun permukaan yang terbuat dari bahan yang mudah terbakar",
                            "11. Cairan yang mudah terbakar disingkirkan dari area hot work.",
                            "12. Rambu peringatan yang memadai ditempatkan diseluruh titik akses ke lokasi atau area yang berdekatan."

                            ];
                        @endphp
                        @foreach($workTitle as $index => $title)
                        <div class="form-check my-3">
                            <input class="form-check-input" type="checkbox" value="" id="tangga{{$index}}">
                            <label class="block text-md font-medium" for="tangga{{$index}}">
                                {{$title}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class=" flex justify-end mt-5">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="previousClass('pencegahanDalamRadiusContent', 'perlindunganKebakaranContent')">
                            Kembali
                        </div>
                    </div>
                </div>
            </div>`
         });
        // $('#example-manipulation').steps('insert', Number($('#position-3').val()), { title: $('#title2-3').val(), content: $('#text2-3').val() });
        
    }else{
        var steps = 4;
        for (var i = 0; i < steps; i++) {
            var stepTitle = $('.validation-hse').steps('getStep', i);
            if(!stepTitle){
                console.log('tidak ada');
            }else if (stepTitle.title === titles) {
                console.log(i);
                $('.validation-hse').steps('remove', i);
                return; // Hentikan setelah menghapus satu langkah
            }
        }
        alert('Step not found.');
    }
}

function confinedSpacePermit(button){
    var titles = "Ijin Kerja Ruang Terbatas"; 
    if (button.checked){
        var judul = "test content";
        var isi = "test isi";
        $(".validation-hse").steps('insert', 1, { title: titles, content: 
            `<div class="rounded-lg custom-bg-color" id="perlindunganRuangTerbatas">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">A. Perlindungan Di Ruang Terbatas</span>
                </div>
                <div class="p-2" id="perlindunganRuangTerbatasContent">
                    @php 
                        $workTitle = [
                            "1. Pekerja dilengkapi oleh SCBA (Self Contain Breathing Apparatus) dan / atau APD yang sesuai",
                            "2. Pekerja diijinkan bekerja di ruang terbatas jika kadar oksigen di ruang terbatas min 19% dan max 23%",
                            "3. Pekerja tidak diijinkan bekerja di ruang terbatas jika bahan mudah terbakar di dalam ruang terbatas nilainya 5% di atas LEL (Low Explosive Limit)",
                            "4. Pekerjaan di ruang terbatas harus di sertakan Watch men yang terlatih untuk mengawasi pekerjaan yang dilakukan"
                            ];
                    @endphp
                    @foreach($workTitle as $index => $title)
                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" value="" id="perlindunganRuangTerbatas{{$index}}">
                        <label class="block text-md font-medium" for="perlindunganRuangTerbatas{{$index}}">
                            {{$title}}
                        </label>
                    </div>
                    @endforeach

                    <div class=" flex justify-end">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" name="selanjutnya" id="selanjutnya"onClick="nextClass('perlindunganRuangTerbatasContent', 'pengendalianRuangTerbatasContent')">
                            Lanjut
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-lg custom-bg-color" id="pengendalianRuangTerbatas">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">B. Pengendalian Resiko di Ruang Terbatas</span>
                </div>
                <div class="p-2 hidden" id="pengendalianRuangTerbatasContent">
                    <div>
                        @php 
                        $workTitle = [
                            "5. Sebelum memasuki atau memulai pekerjaan di ruang tertutup, Work Permit ditempel / diletakan di tempat",
                            "6. Memastikan pengujian atmosfer di ruang terbatas sudah sesuai dan hasilnya tertulis di izin sebelum memasuki ruang terbatas",
                            "7. Ventilasi yang memadai harus dilakukan sebelum masuk atau mulai pekerjaan, minimal sudah dilakukan blowing 1 x 24 jam sebelum pekerjaan dimulai",
                            "8. Semua alat las dan mesin potong yang mengeluarkan panas / api yang akan digunakan dalam ruang terbatas harus dipastikan dalam kondisi baik",
                            "9. Personil yang akan bekerja di ruang terbatas sudah menerima training terkait termasuk training penyelamatan darurat (emergency rescue)",
                            "10. Pekerjaan lain di daerah dekat pekerjaan ruang terbatas harus ditunda jika menimbulkan resiko atau menambah resiko bagi pekera di dalam ruang terbatas",
                            "11. Pencahayaan yang memadai harus disediakan di ruang terbatas"
                            ];
                        @endphp
                        @foreach($workTitle as $index => $title)
                        <div class="form-check my-3">
                            <input class="form-check-input" type="checkbox" value="" id="pengendalianRuangTerbatas{{$index}}">
                            <label class="block text-md font-medium" for="pengendalianRuangTerbatas{{$index}}">
                                {{$title}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class=" flex justify-end mt-5">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="previousClass('pengendalianRuangTerbatasContent', 'perlindunganRuangTerbatasContent')">
                            Kembali
                        </div>
                    </div>
                </div>
            </div>`
         });
        // $('#example-manipulation').steps('insert', Number($('#position-3').val()), { title: $('#title2-3').val(), content: $('#text2-3').val() });
        
    }else{
        var steps = 4;
        for (var i = 0; i < steps; i++) {
            var stepTitle = $('.validation-hse').steps('getStep', i);
            if(!stepTitle){
                console.log('tidak ada');
            }else if (stepTitle.title === titles) {
                console.log(i);
                $('.validation-hse').steps('remove', i);
                return; // Hentikan setelah menghapus satu langkah
            }
        }
        alert('Step not found.');
    }
}

function heightWorkPermit(button){
    var titles = "Ijin Kerja Di Ketinggian"; 
    if (button.checked){
        $(".validation-hse").steps('insert', 1, { title: titles, content: 
            `<div class="rounded-lg custom-bg-color" id="perlindunganKetinggian">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Perlindungan Tempat Kerja Ketinggian & APD</span>
                </div>
                <div class="p-2" id="perlindunganKetinggianContent">
                    @php 
                        $workTitle = [
                            "1. Permukaan tempat kerja atau akses stabil, kuat, dan mantab",
                            "2. Dimensi tempat kerja dan akses yang cukup dan aman untuk berjalan",
                            "3. Perlindungan pada tepian tempat kerja aman, cocok, dan memadai",
                            "4. Tidak ada gap di mana seorang karyawan atau material atau object bisa jatuh",
                            "5. Memakai APD (Safety Belt, Body Harness, Helmet) yang sesuai dan kondisinya masih bagus",
                            "6. Rambu peringatan yang memadai ditempatkan diseluruh titik akses ke lokasi atau yang berdekatan"
                            ];
                    @endphp
                    @foreach($workTitle as $index => $title)
                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" value="" id="perlindunganKetinggian{{$index}}">
                        <label class="block text-md font-medium" for="perlindunganKetinggian{{$index}}">
                            {{$title}}
                        </label>
                    </div>
                    @endforeach

                    <div class=" flex justify-end">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" name="selanjutnya" id="selanjutnya"onClick="nextClass('perlindunganKetinggianContent', 'pengendalianRisikoTanggaContent')">
                            Lanjut
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-lg custom-bg-color" id="pengendalianRisikoTangga">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Pengendalian risiko untuk Tangga</span>
                </div>
                <div class="p-2 hidden" id="pengendalianRisikoTanggaContent">
                    <div>
                        @php 
                        $workTitle = [
                            "1. Struktur Ladder / Tangga dalam keadaan baik (tidak retak, kropos, dan bengkok)",
                            "2. Site Watcher / Penjaga Lokasi",
                            "3. Terpasang karet antislip",
                            "4. Kondisi engsel, kunci, pengait pada tangga baik (tidak retak, kropos, patah, kendur, dan bengkok)"
                            ];
                        @endphp
                        @foreach($workTitle as $index => $title)
                        <div class="form-check my-3">
                            <input class="form-check-input" type="checkbox" value="" id="tangga{{$index}}">
                            <label class="block text-md font-medium" for="tangga{{$index}}">
                                {{$title}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    
                    
                    <div class="form-check my-6">
                        <input class="form-check-input" type="checkbox" value="" id="checkScaffolding" onclick="checklistScaffolding(this)">
                        <label class="block text-md font-medium" for="checkScaffolding">
                            Apakah menggunakan scaffolding?
                        </label>
                    </div>
                    
                    <div class="flex justify-end mt-5" id="pengendalianRisikoButton">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="previousClass('pengendalianRisikoTanggaContent', 'perlindunganKetinggianContent')">
                            Kembali
                        </div>
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn hidden" name="selanjutnyaScaffolding" id="selanjutnyaScaffolding" onClick="nextClass('pengendalianRisikoTanggaContent', 'pengendalianRisikoScaffoldingContent')">
                            Lanjut
                        </div>
                    </div>
                </div>
            </div>

        `});
    }else{
        var steps = 4;
        for (var i = 0; i < steps; i++) {
            var stepTitle = $('.validation-hse').steps('getStep', i);
            if(!stepTitle){
                console.log('tidak ada');
            }else if (stepTitle.title === titles) {
                console.log(i);
                $('.validation-hse').steps('remove', i);
                return; // Hentikan setelah menghapus satu langkah
            }
        }
        alert('Step not found.');
    }
}

function sistemProteksiKebakaran(button){
    var parentDiv = document.getElementById('peralatanProteksiKebakaran');
    if (button.checked){
        var newDiv = document.createElement('div');
        newDiv.innerHTML = `
        <div class="my-10">
            <div>Peralatan Proteksi Kebakaran</div>
        </div>
        <div class="grid md:grid-cols-4 sm:grid-cols-2">
            @php 
                $workTitle = ["Fire Blanket", "Alat Pemadam Api Ringan (APAR)", "Hydrant"];
            @endphp
            @foreach($workTitle as $title)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="{{$title}}">
                <label class="block text-md font-medium" for="{{$title}}">
                    {{$title}}
                </label>
            </div>
            @endforeach
        </div>
        `;
        parentDiv.appendChild(newDiv);
        
    }else{
        parentDiv.removeChild(parentDiv.lastChild);
    }
}

// Checklist Scaffolding
function checklistScaffolding(button){
    var currDiv = document.getElementById('perlindunganKetinggian');
    var parentDiv = currDiv.parentNode;
    var currButton = document.getElementById('selanjutnyaScaffolding');

    if (button.checked){
        currButton.classList.remove('hidden'); // Menghapus class 'hidden'

        var newDiv = document.createElement('div');
        newDiv.id = 'pengendalianRisikoScaffolding'
        newDiv.innerHTML = `
        <div class="rounded-lg custom-bg-color" id="pengendalianRisikoScaffolding">
            <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                <span class="text-lg text-white">Pengendalian risiko untuk Scaffolding</span>
            </div>

            <div class="p-2 hidden" id="pengendalianRisikoScaffoldingContent">
                <div class="p-1.5 pl-3"><i>Scaffolding</i></div>
                <div>
                    @php 
                    $workTitle = [
                        "1. Struktur Scaffolding / Perancah dalam keadaan baik (tidak retak, kropos, dan bengkok)",
                        "2. Dipasang Safety Line / Barrier & Signs",
                        "3. Underneath area is cleared / Area di bawahnya harus bersih (kosong)",
                        "4. Base plat dan ground harus kuat, rata, dan tidak bergelombang",
                        "5. Terpasang railing dan mengikat pada struktur yang kuat dan stabil",
                        "6. Scaffolding / Perancah didirikan dan dibongkar oleh Petugas kompeten",
                        "7. Terdapat anchor points untuk personal fall arrest sudah ada dan kuat",
                        "8. Rope examined / Tali Pengaman dalam keadaan baik",
                        "9. Peralatan penghubung yang digunakan untuk menghubungkan Anchorage Connector dengan body harness dalam keadaan baik"
                        ];
                    @endphp
                    @foreach($workTitle as $index => $title)
                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" value="" id="scaffolding{{$index}}">
                        <label class="block text-md font-medium" for="scaffolding{{$index}}">
                            {{$title}}
                        </label>
                    </div>
                    @endforeach
                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" value="" id="extraScaffolding">
                        <label class="form-check-label block text-md font-medium" for="extraScaffolding">
                            10. <input type="text" id="extraTool" name="extraScaffolding" class="form-control rounded-lg w-3/4" style="height:100%;" placeholder="Lainnya...">
                        </label>
                    </div>
                </div>
                <div class="flex justify-end mt-5" id="pengendalianRisikoButton">
                    <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="previousClass('pengendalianRisikoScaffoldingContent', 'pengendalianRisikoTanggaContent')">
                        Kembali
                    </div>
                </div>
            </div>
        </div>
        `;
        parentDiv.appendChild(newDiv);
        
    }else{
        currButton.classList.add('hidden'); // Menambahkan class 'hidden'
        parentDiv.removeChild(parentDiv.lastChild);
    }
}


function changeDate() {
    const selectedDate = document.getElementById('dateFilterDropdown').value;
    // Mengubah teks tombol untuk menampilkan tanggal yang dipilih
    const formattedDate = new Date(selectedDate).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });
    const fomattedMonth = new Date(selectedDate).toLocaleDateString('id-ID', {
        month: 'numeric'
    });
    const fomattedYear= new Date(selectedDate).toLocaleDateString('id-ID', {
        year: 'numeric'
    });
    document.getElementById('dateDisplay').innerText = formattedDate;
};


// Function untuk Ijin Kerja 2
const gridTenagaKerja = document.getElementById('tenagaKerjaGrid');
const removeButtonTenagaKerja= document.getElementById('removeButtonTenagaKerja');
const addButtonTenagaKerja = document.getElementById('addButtonTenagaKerja');
let rowCountTenagaKerjaGrid = 1;
addButtonTenagaKerja.addEventListener('click', () => {

    const newRow = document.createElement('div');
    rowCountTenagaKerjaGrid++;

    newRow.classList.add('grid', 'md:grid-cols-16');
    newRow.innerHTML = `
    <div>
        <div class="flex md:justify-center">
            <label for="" class="block text-md font-medium">No. ${rowCountTenagaKerjaGrid}</label>
        </div>
    </div>
    <div class="md:col-span-15 grid md:grid-cols-4 gap-x-4">
        <div class="flex md:justify-center">
            <label for="namaTenagaKerja${rowCountTenagaKerjaGrid}" class="font-medium">Nama Tenaga Kerja :</label>
        </div>
        <div class="col-span-3">
            <input type="text" id="namaTenagaKerja${rowCountTenagaKerjaGrid}" name="namaTenagaKerja${rowCountTenagaKerjaGrid}" class="form-control rounded-lg w-full" placeholder="Input data">
        </div>
    </div>
    `;

    gridTenagaKerja.appendChild(newRow);
});
removeButtonTenagaKerja.addEventListener('click', () => {
    if (rowCountTenagaKerjaGrid > 1) {
        gridTenagaKerja.removeChild(gridTenagaKerja.lastChild);
        rowCountTenagaKerjaGrid--;
    }
});


// Function untuk JSA Form
const grid = document.getElementById('potentialDangerGrid');
const removeButtonPotentialDanger = document.getElementById('removeButtonPotentialDanger');
const addButtonPotentialDanger = document.getElementById('addButtonPotentialDanger');
let rowCountPotentialDanger = 1;
addButtonPotentialDanger.addEventListener('click', () => {
    const newRow = document.createElement('div');
    const newRow2 = document.createElement('div');
    
    rowCountPotentialDanger++;

    newRow.classList.add('grid', 'md:grid-cols-16');
    newRow.innerHTML = `
    <div class="flex md:justify-center">
        <label for="bahayaPotensial" class="block text-md font-medium">No. ${rowCountPotentialDanger}</label>
    </div> 
    <div class="md:col-span-15 grid md:grid-cols-14 md:grid-rows-2 md:grid-flow-col gap-x-4 gap-1">
        <div class="md:col-span-4">
            <div><label for="bahayaPotensial${rowCountPotentialDanger}" class="block text-md font-medium">Bahaya Potensial / Konsekuensi (Apa yang menyebabkan bahaya)</label></div>
        </div>
        <div class="md:col-span-4">
            <input type="text" id="bahayaPotensial${rowCountPotentialDanger}" class="form-control rounded-lg w-full" placeholder="Input data">
        </div>
        <div>
            <div><label for="severityBefore${rowCountPotentialDanger}" class="block text-md font-medium">S</label></div>
        </div>
        <div>
            <div class="relative inline-block text-left" style="min-width:50px;">
                <div>
                    <button type="button" id="severityBefore${rowCountPotentialDanger}Button"  class="dropDownButton inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" aria-expanded="true" aria-haspopup="true" onclick="dropDownToggle(this)">
                    1
                    <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                    </button>
                </div>
                <ul id="severityBefore${rowCountPotentialDanger}" class="hidden dropDownMenu absolute w-full z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" onchange="updateButtonText()">
                    <div class="py-1" role="none">
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">1</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">2</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">3</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">4</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">5</li>
                    </div>
                </ul>
            </div>
        </div>
        <div>
            <div><label for="opportunityBefore${rowCountPotentialDanger}" class="block text-md font-medium">O</label></div>
        </div>
        <div>
            <div class="relative inline-block text-left" style="min-width:50px;">
                <div>
                    <button type="button" id="opportunityBefore${rowCountPotentialDanger}Button"  class="dropDownButton inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" aria-expanded="true" aria-haspopup="true" onclick="dropDownToggle(this)">
                    1
                    <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                    </button>
                </div>
                <ul id="opportunityBefore${rowCountPotentialDanger}" class="hidden dropDownMenu absolute w-full z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" onchange="updateButtonText()">
                    <div class="py-1" role="none">
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">1</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">2</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">3</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">4</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">5</li>
                    </div>
                </ul>
            </div>
        </div>
        <div>
            <div><label for="riskFactorBefore${rowCountPotentialDanger}" class="block text-md font-medium">RF</label></div>
        </div>
        <div>
            <input type="number" id="riskFactorBefore${rowCountPotentialDanger}" class="form-control rounded-lg w-full" value="1" readonly>
        </div>
        <div class="md:col-span-4">
            <div><label for="pengendalianBahayaHirarki${rowCountPotentialDanger}" class="block text-md font-medium">Pengendalian (Gunakan Hirarki Pengendalian Bahaya)</label></div>
        </div>
        <div class="md:col-span-4">
            <input type="text" id="pengendalianBahayaHirarki${rowCountPotentialDanger}" class="form-control rounded-lg w-full" placeholder="Input data">
        </div>
        <div>
            <div><label for="severityAfter${rowCountPotentialDanger}" class="block text-md font-medium">S</label></div>
        </div>
        <div>
            <div class="relative inline-block text-left" style="min-width:50px;">
                <div>
                    <button type="button" id="severityAfter${rowCountPotentialDanger}Button"  class="dropDownButton inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" aria-expanded="true" aria-haspopup="true" onclick="dropDownToggle(this)">
                    1
                    <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                    </button>
                </div>
                <ul id="severityAfter${rowCountPotentialDanger}" class="hidden dropDownMenu absolute w-full z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" onchange="updateButtonText()">
                    <div class="py-1" role="none">
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">1</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">2</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">3</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">4</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">5</li>
                    </div>
                </ul>
            </div>
        </div>
        <div>
            <div><label for="opportunityAfter${rowCountPotentialDanger}" class="block text-md font-medium">O</label></div>
        </div>
        <div>
            <div class="relative inline-block text-left" style="min-width:50px;">
                <div>
                    <button type="button" id="opportunityAfter${rowCountPotentialDanger}Button"  class="dropDownButton inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" aria-expanded="true" aria-haspopup="true" onclick="dropDownToggle(this)">
                    1
                    <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                    </button>
                </div>
                <ul id="opportunityAfter${rowCountPotentialDanger}" class="hidden dropDownMenu absolute w-full z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" onchange="updateButtonText()">
                    <div class="py-1" role="none">
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">1</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">2</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">3</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">4</li>
                    <li class="block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100" tabindex="-1" onclick="changeButtonText(this)">5</li>
                    </div>
                </ul>
            </div>
        </div>
        <div>
            <div><label for="riskFactorAfter${rowCountPotentialDanger}" class="block text-md font-medium">RF</label></div>
        </div>
        <div>
            <input type="number" id="riskFactorAfter${rowCountPotentialDanger}" class="form-control rounded-lg w-full" value="1" readonly>
        </div>
    </div>    
    `;

    grid.appendChild(newRow);
});
removeButtonPotentialDanger.addEventListener('click', () => {
    if (rowCountPotentialDanger > 1) {
        grid.removeChild(grid.lastChild);
        rowCountPotentialDanger--;
    }
});

document.getElementById('Penanggung Jawab Lapangan').addEventListener('input', function() {
    var textbox1Value = this.value; // Ambil nilai dari textbox1
    document.getElementById('JSA dilakukan oleh1').value = textbox1Value; // Set nilai ke textbox2
});

document.getElementById('Penjelasan Pekerjaan').addEventListener('input', function() {
    var textbox1Value = this.value; // Ambil nilai dari textbox1
    document.getElementById('Penjelasan Pekerjaan1').value = textbox1Value; // Set nilai ke textbox2
});

document.getElementById('Lokasi Pekerjaan').addEventListener('input', function() {
    var textbox1Value = this.value; // Ambil nilai dari textbox1
    document.getElementById('Lokasi1').value = textbox1Value; // Set nilai ke textbox2
});

// document.getElementById('Waktu Pelaksanaan').addEventListener('input', function() {
//     var textbox1Value = this.value;
//     document.getElementById('Tanggal1').value = textbox1Value;
// });


// Toggle dropdown visibility
function dropDownToggle(button){
    var dropDownMenu = document.getElementById(button.id.replace('Button', ''));
    dropDownMenu.classList.toggle('hidden');
}

function changeButtonText(list){
    var dropDownMenu = list.parentNode.parentNode;
    var button = document.getElementById(dropDownMenu.id + "Button");
    button.innerHTML = `${list.innerText} 
    <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
        <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
    </svg>`;
    dropDownMenu.classList.toggle('hidden');
    changeRiskFactor(dropDownMenu.id);
}

// Close dropdown when clicking outside
window.addEventListener('click', (event) => {

    const dropdownButtons = document.querySelectorAll('.dropDownButton');
    const dropdownMenus = document.querySelectorAll('.dropDownMenu');
    
    if (![...dropdownButtons].some(button => button.contains(event.target)) &&
        ![...dropdownMenus].some(menu => menu.contains(event.target))) {
        dropdownMenus.forEach(menu => menu.classList.add('hidden'));
    }
});

function changeRiskFactor(dropDownMenu){
    var severity = document.getElementById(dropDownMenu + "Button");
    if (dropDownMenu.includes('severity')) {
        severity = document.getElementById(dropDownMenu + "Button");
        var opportunity = document.getElementById(dropDownMenu.replace('severity', 'opportunity') + "Button");
        var riskFactor = document.getElementById(dropDownMenu.replace('severity', 'riskFactor'));
    }else{
        severity = document.getElementById(dropDownMenu.replace('opportunity', 'severity') + "Button");
        var opportunity = document.getElementById(dropDownMenu + "Button");
        var riskFactor = document.getElementById(dropDownMenu.replace('opportunity', 'riskFactor'));
    }

    riskFactor.value = parseFloat(opportunity.innerText) * parseFloat(severity.innerText);
    console.log('severity :', severity);
    console.log('severity value :', parseFloat(severity.innerText));
    console.log('opportunity :', opportunity);
    console.log('opportunity value :', parseFloat(opportunity.innerText));
    console.log('riskFactor :', riskFactor);
}

function fileChange(input, tipe) {
    const file = input.files[0];
    const previewContainer = document.querySelector('#sioSiloTable tbody');


    const newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td>${tipe}</td>
        <td>${file.name}</td>
    `;
    previewContainer.appendChild(newRow);
    // if (file) {
    //     const reader = new FileReader();
        
    //     // Tampilkan nama file
    //     const fileName = document.createElement('p');
    //     fileName.textContent = `File Name: ${file.name}`;
    //     previewContainer.appendChild(fileName);
        
    //     // Tampilkan preview untuk gambar (jika file adalah gambar)
    //     if (file.type.startsWith('image/')) {
    //         const img = document.createElement('img');
    //         img.src = URL.createObjectURL(file);
    //         img.style.maxWidth = '200px'; // Atur ukuran preview
    //         previewContainer.appendChild(img);
    //     }
    // }
};


</script>
@endpush

</x-app-layout>