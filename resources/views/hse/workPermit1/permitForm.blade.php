<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard HSE') }}
        </h2>
    </x-slot>
    @push('css')
    <style>
        [type="checkbox"]+label, [type="radio"]:not(:checked)+label, [type="radio"]:checked+label {
            color: unset;
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
        }
        .justify-self-end{
            justify-self: end;
        }
        .steps { /* Mematikan navigasi lewat header di jquery steps */
            pointer-events: none;
        }
    </style>
    @endpush

<div class="box-body wizard-content">
    <form id="form" name="form" method="POST" class="validation-hse wizard-circle card p-10">
        @csrf
        <!-- Step 1 -->
        <h6 class="text-md font-semibold mb-4">Ijin Kerja 1</h6>
        <section id="ijinKerja1">
            <div id="pelaksanaPekerjaan">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Pelaksana Pekerjaan</span>
                </div>
                <div class="" id="pelaksanaPekerjaanContent">
                    <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2">
                        @php 
                            $workTitle = ["Nama Perusahaan / Dept","Penjelasan Pekerjaan","Waktu Pelaksanaan","No Telp","Penanggung Jawab Lapangan","Lokasi Pekerjaan","Jam Kerja","Jumlah Tenaga Kerja", "Tanggal"];
                        @endphp
                        @foreach($workTitle as $title)
                        <div class="form-group flex flex-col">
                            <label for="department" class="block text-md font-medium">{{$title}}</label>
                            <input type="text" id="{{$title}}" name="{{$title}}" class="form-control rounded-lg w-3/4" placeholder="Input data" required>
                        </div>
                        @endforeach
                    </div>

                    <!-- Button next-->
                    <div class=" flex justify-end">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" name="selanjutnya" id="selanjutnya"onClick="nextClass('pelaksanaPekerjaanContent', 'potensiBahayaContent')">
                            Lanjut
                        </div>
                    </div>
                
                </div>
            </div>

            <div id="potensiBahaya">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Potensi Bahaya di Area Kerja</span>
                </div>
                @php 
                    $workTitle = ["Mudah Terbakar", "Gas Beracun", "Bising", "Benda Berat", "Ledakan", "Listrik", "Ketinggian", "Lantai Licin", "Temperatur Tinggi", "Bahan Kimia", "Ruang Tertutup"];
                @endphp
                <div class="hidden" id="potensiBahayaContent">
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

            <div id="apd">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Alat Pelindung Diri (APD)</span>
                </div>

                <div class="hidden" id="apdContent">
                    <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2">
                        <div>
                            <div class="p-1.5 pl-3"><i>Kepala/Mata/Wajah</i></div>
                            @php 
                                $workTitle = ["Safety Helmet", "Googles (Impact)", "Googles (Chemical)", "Face Shield (Chemical)", "Face Shield (Wielding)"];
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
                                $workTitle = ["Safety Body Herness", "Apron (Hot & Wielding)"];
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
            
            <div id="daftarPeralatan">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Daftar Peralatan Kerja</span>
                </div>
                
                <div class="hidden" id="daftarPeralatanContent">
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

                        <div class="form-check"> <!-- md:row-span-3 md:col-start-4 md:row-start-2 md:row-end-4 -->
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

            <div id="ijinKerjaTambahan">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Ijin Kerja Tambahan Yang Diperlukan</span>
                </div>
                
                <div class="hidden" id="ijinKerjaTambahanContent"> 
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

            <div id="pengendaliBahaya">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Pengendali Bahaya Kebakaran</span>
                </div>
        
                <div class="hidden"  id="pengendaliBahayaContent">
                    <div class="my-10">
                        <div class="font-medium">Apakah pekerjaan memerlukan Sistem Proteksi Kebakaran?</div>
                    </div>
                    <div>
                        <label class="inline-flex items-center cursor-pointer">
                            <span class="ms-3 text-sm font-medium mr-3">Tidak</span>
                            <input type="checkbox" value="" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium ">Ya</span>
                        </label>
                    </div>
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
            <div id="tenagaKerja">
                <!-- <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Informasi</span>
                </div> -->

                <div class="" id="tenagaKerjaContent">
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
                        <!-- Button  -->
                        <div class="flex mt-2">
                            <div id="addButtonTenagaKerja" class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn">
                                <i class="fas fa-plus">
                                </i>
                                Tambah
                            </div>
                            <div id="removeButtonTenagaKerja" class="mx-2 px-4 py-2  text-white rounded-lg hover:bg-red-600 btn bg-red-500 ml-4 btn" >
                                <i class="fas fa-times">
                                </i>
                                Hapus Baris Terakhir
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-5">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="nextClass('tenagaKerjaContent', 'validasiPekerjaanContent')">
                            Lanjut
                        </div>
                    </div>

                </div>
            </div>

            <div id="validasiPekerjaan">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Validasi Pekerjaan</span>
                </div>

                <div class="hidden" id="validasiPekerjaanContent">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3">
                        <div>
                            <div class="font-medium"><i>Apakah Mematuhi Persyaratan K3 & Lingkungan yang telah disetujui selama pekerjaan?</i></div>
                            <div class="my-3">
                                <div class="flex flex-col">
                                    <input class="form-check-input" type="radio" value="ya" id="validasiPekerjaanYa" name="validasiPekerjaanRadio" required>
                                    <label for="validasiPekerjaanYa" style="padding-left:25px;">YA</label>
                                </div>
                                <div class="flex">
                                    <input class="form-check-input" type="radio" value="tidak" id="validasiPekerjaanTidak" name="validasiPekerjaanRadio">
                                    <label for="validasiPekerjaanTidak" style="padding-left:25px;">TIDAK</label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="font-medium"><i>Jelaskan hal yang tidak dipenuhi :</i></div>
                            <div class="w-full my-3">
                                <textarea id="message" class="w-full" style="resize: none;" name="message" rows="4" cols="50" placeholder="Jelaskan..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-5">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="previousClass('validasiPekerjaanContent', 'tenagaKerjaContent')">
                            Kembali
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Step 3 -->
        <h6>Formulir Analisis Keamanan Pekerjaan (JSA)</h6>
        <section id="formJSA">
            <div id="informasi">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Informasi</span>
                </div>

                <div class="" id="informasiContent">
                    <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2">
                        @php 
                            $workTitle = ["JSA dilakukan oleh","Lokasi","Tanggal","Penjelasan Pekerjaan"];
                        @endphp
                        @foreach($workTitle as $title)
                        <div class="form-group flex flex-col">
                            <label for="department" class="block text-md font-medium">{{$title}}</label>
                            <input type="text" id="{{$title}}1" name="{{$title}}1" class="form-control rounded-lg w-3/4" placeholder="Input data">
                        </div>
                        @endforeach
                    </div>
                    <div class="border rounded-lg p-3">
                        <div id="potentialDangerGrid" class="grid gap-y-3">
                            <div class="grid md:grid-cols-16">
                                <div>
                                    <div class="flex md:justify-center">
                                        <label for="bahayaPotensial" class="block text-md font-medium">No. 1</label>
                                    </div>
                                </div>
                                <div class="md:col-span-15 grid md:grid-cols-4 md:grid-rows-2 md:grid-flow-col gap-x-4 gap-1">
                                    <div>
                                        <div><label for="bahayaPotensial1" class="block text-md font-medium">Bahaya Potensial / Konsekuensi (Apa yang menyebabkan bahaya)</label></div>
                                    </div>
                                    <div>
                                        <input type="text" id="bahayaPotensial1" class="form-control rounded-lg w-full" placeholder="Input data">
                                    </div>
                                    <div>
                                        <div><label for="scoreBahayaSebelum1" class="block text-md font-medium">Score Bahaya (Sebelum)</label></div>
                                    </div>
                                    <div>
                                        <input type="text" id="scoreBahayaSebelum1" class="form-control rounded-lg w-full" placeholder="Input data">
                                    </div>
                                    <div>
                                        <div><label for="pengendalianBahayaHirarki1" class="block text-md font-medium">Pengendalian (Gunakan Hirarki Pengendalian Bahaya)</label></div>
                                    </div>
                                    <div>
                                        <input type="text" id="pengendalianBahayaHirarki1" class="form-control rounded-lg w-full" placeholder="Input data">
                                    </div>
                                    <div>
                                        <div><label for="scoreBahayaSesudah1" class="block text-md font-medium">Score Bahaya (Sesudah)</label></div>
                                    </div>
                                    <div>
                                        <input type="text" id="scoreBahayaSesudah1" class="form-control rounded-lg w-full" placeholder="Input data">
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
                            <div id="removeButtonPotentialDanger" class="mx-2 px-4 py-2 text-white rounded-lg hover:bg-red-600 btn bg-red-500 ml-4 btn" >
                                <i class="fas fa-times">
                                </i>
                                Hapus Baris Terakhir
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    

                    <div class="grid sm:grid-cols-2">
                        @php 
                            $tempData = [
                                "Mesin dan Peralatan - Memerlukan Inspeksi dan Perawatan", 
                                "Memerlukan Ijin, Sertifikat dari Otoritas Tertentu",
                                "Memerlukan SOP?",
                                "Memerlukan Skill dan Pelatihan",
                                "Berkaitan dengan standard, kode, peraturan?",
                                "Masuk ke dalam Jadwal Preventive Maintenance?"
                            ]
                        @endphp
                        @foreach($tempData as $data)
                        <div>
                            <div class="my-10">
                                <div class="font-medium">{{$data}}</div>
                            </div>
                            <div>
                                <label class="inline-flex items-center cursor-pointer">
                                    <span class="ms-3 text-sm font-medium mr-3">Tidak</span>
                                    <input type="checkbox" value="" class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ms-3 text-sm font-medium ">Ya</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </section>

        <!-- Step 4 -->
        <h6>Agreement</h6>
        <section id="terms">
            <div id="agreement">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Agreement</span>
                </div>
                <div class="" id="agreementContent">
                    @php 
                        $agreements = [
                            "Ijin kerja dikeluarkan berdasarkan inspeksi perlatan dan keselamatan kerja selama pekerjaan berlangsung.", 
                            "Saya telah mengetahui & mengerti lingkup pekerjaan dan persyaratan HSE yang harus dipenuhi.",
                            "Saya atau perwakilan saya akan mematuhi Peraturan K3 & Lingkungan"
                            ];
                    @endphp
                    @foreach($agreements as $index => $agreement)
                    <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" id="agreement{{$index}}" name="agreement{{$index}}" required>
                        <label class="block text-md font-medium" for="agreement{{$index}}">
                            {{$agreement}}
                        </label>
                    </div>
                    @endforeach
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
        console.log("parent",lastCurrSection);
        console.log("child",childCurrDiv);
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
$("a[href$='previous']").hide()

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
        newDiv.innerHTML = 
        `<div class="form-check">
            <label for="sio">SIO</label>
            <input type="file" name="sio" class="form-control w-3/4" required>
        </div>
        <div class="form-check">
            <label for="silo">SILO</label>
            <input type="file" name="silo" class="form-control w-3/4" required>
        </div>`;
        firstChild.appendChild(newDiv);
        
    }else{
        firstChild.removeChild(firstChild.lastChild);
    }
}

function hotWorkPermit(button){
    var titles = "Ijin Kerja Pekerjaan Dengan Api"; 
    if (button.checked){
        $(".validation-hse").steps('insert', 1, { title: titles, content: 
            `<div id="perlindunganKebakaran">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">A. Perlindungan Terhadap Bahaya Kebakaran</span>
                </div>
                <div class="" id="perlindunganKebakaranContent">
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

            <div id="pencegahanDalamRadius">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">B. Pencegahan Dalam Radius 12 meter dari Area Pekerjaan</span>
                </div>
                <div class="hidden" id="pencegahanDalamRadiusContent">
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
            `<div id="perlindunganRuangTerbatas">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">A. Perlindungan Di Ruang Terbatas</span>
                </div>
                <div class="" id="perlindunganRuangTerbatasContent">
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

            <div id="pengendalianRuangTerbatas">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">B. Pengendalian Resiko di Ruang Terbatas</span>
                </div>
                <div class="hidden" id="pengendalianRuangTerbatasContent">
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
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" name="selanjutnya" id="selanjutnya"onClick="nextClass('pengendalianRuangTerbatasContent', 'hasilTestContent')">
                            Lanjut
                        </div>
                    </div>
                </div>
            </div>

            <div id="hasilTest" >
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">C. Hasil Test</span>
                </div>
                <div class="hidden" id="hasilTestContent">
                    <div class="flex flex-col justify-center">

                        <div class="flex items-center flex-wrap">
                            <div class="p-1.5 pl-3 font-medium"><i>Kadar</i></div>
                            <ul class="m-0" style="list-style: none;">
                                <li class="dropdown">
                                    <button id="dateDisplay" class="waves-effect waves-light btn btn-outline dropdown-toggle btn-md font-medium"
                                        data-bs-toggle="dropdown" href="#" aria-expanded="false">
                                        {{ date('d F Y') }}
                                    </button>
                                    <div class="dropdown-menu" style="will-change: transform;">
                                        <div class="px-3 py-2">
                                            <input type="date" id="dateFilterDropdown" class="bg-gray-200 text-black" value="{{ date('Y-m-d') }}">
                                            <div class="flex">
                                                <div id="applyDateFilterDropdown" class="bg-blue-500 text-white px-2 py-1 mt-2 btn" onClick="changeDate()">
                                                    Terapkan
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="flex">
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <div class="form-group flex items-center">
                                    <label for="LEL" class="block text-md font-medium">Kadar Low Explosive Level (LEL)</label>
                                </div>
                                <div class="form-group flex items-center">
                                    <input type="number" id="LEL" name="LEL" class="form-control rounded-lg w-3/4">
                                    <label for="LEL" class="block text-md font-medium ml-2">%</label>
                                </div>
                                <div class="form-group flex items-center">
                                    <label for="CO" class="block text-md font-medium">Kadar Carbon Monoxide (CO)</label>
                                </div>
                                <div class="form-group flex items-center">
                                    <input type="number" id="CO" name="CO" class="form-control rounded-lg w-3/4">
                                    <label for="CO" class="block text-md font-medium ml-2">ppm</label>
                                </div>
                                <div class="form-group flex items-center">
                                    <label for="O2" class="block text-md font-medium">Kadar Oxygen (O₂)</label>
                                </div>
                                <div class="form-group flex items-center">
                                    <input type="number" id="O2" name="O2" class="form-control rounded-lg w-3/4">
                                    <label for="O2" class="block text-md font-medium ml-2">%</label>
                                </div>
                                <div class="form-group flex items-center">
                                    <label for="H2S" class="block text-md font-medium">Kadar Hydrogen Sulfide (H₂S)</label>
                                </div>
                                <div class="form-group flex items-center">
                                    <input type="number" id="H2S" name="H2S" class="form-control rounded-lg w-3/4">
                                    <label for="H2S" class="block text-md font-medium ml-2">ppm</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class=" flex justify-end mt-5">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="previousClass('hasilTestContent', 'pengendalianRuangTerbatasContent')">
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
            `<div id="perlindunganKetinggian">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Perlindungan Tempat Kerja Ketinggian & APD</span>
                </div>
                <div class="" id="perlindunganKetinggianContent">
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

            <div id="pengendalianRisikoTangga">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Pengendalian risiko untuk Tangga</span>
                </div>
                <div class="hidden" id="pengendalianRisikoTanggaContent">
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
        <div id="pengendalianRisikoScaffolding">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Pengendalian risiko untuk Scaffolding</span>
                </div>

                <div class="hidden" id="pengendalianRisikoScaffoldingContent">
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
                    <div class="p-1.5 pl-3"><i>Penyimpanan</i></div>
                    <div class="grid md:grid-cols-4">
                        @php 
                            $workTitle = [
                                "1. Bracing tidak bengkok / retak / karat",
                                "2. Kondisi frame tidak bengkok / retak / karat",
                                "3. Kondisi Cat Walk atau Plank tidak bengkok / retak / karat",
                                "4. Kondisi join pin tidak bengkok / retak / karat",
                                "5. Tidak terdapat material / cairan di dekat tempat penyimpanan yang berpotensi mengakibatkan karat pada frame / bagian lain",
                                "6. Penyimpanan scaffolding tidak terpapar langsung dengan hujan / panas secara terus menerus",
                                "7. Tumpukan frame / bagian lain saat disimpan tidak mengakibatkan kerusakan / perubahaan bentuk"
                                ];
                        @endphp
                        @foreach($workTitle as $index => $title)
                        <div class="form-check my-3 md:col-span-3">
                            <label class="block text-md font-medium">
                                {{$title}}
                            </label>
                        </div>
                        <div class="mt-1 grid grid-cols-3">
                            <div class="flex flex-col">
                                <input class="form-check-input" type="radio" value="ya" id="penyimpanan{{$index}}ya" name="penyimpanan{{$index}}" required>
                                <label for="penyimpanan{{$index}}ya" style="padding-left:25px;">Ya</label>
                            </div>
                            <div class="flex">
                                <input class="form-check-input" type="radio" value="tidak" id="penyimpanan{{$index}}tidak" name="penyimpanan{{$index}}">
                                <label for="penyimpanan{{$index}}tidak" style="padding-left:25px;">Tidak</label>
                            </div>
                            <div class="flex">
                                <input class="form-check-input" type="radio" value="n/a" id="penyimpanan{{$index}}n/a" name="penyimpanan{{$index}}">
                                <label for="penyimpanan{{$index}}n/a" style="padding-left:25px;">N/A</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="p-1.5 pl-3"><i>Operasional / Penggunaan</i></div>
                    <div class="grid md:grid-cols-4">
                        @php 
                            $workTitle = [
                                "1. Bracing terpasang pada frame",
                                "2. Koneksi bracing dengan frame dalam kondisi aman / terkunci",
                                "3. Semua bagian frame terkunci seluruhnya dengan join pin",
                                "4. Cat Walk / Plank terpasang pada frame",
                                "5. Scaffolding didirikan oleh petugas yang berkompeten",
                                "6. Minimal 2 tumpuk frame harus menggunakan railing atau pekerja menggunakan Safety body harness",
                                "7. Pada saat bekerja harus menggunakan barikade, untuk mencegah orang melewati kolong frame",
                                "8. Frame harus terikat di srtuktur yang kuat",
                                "9. Kaki frame tidak boleh berada pada struktur yang tidak stabil / lembek / mudah patah / pecah"
                                ];
                        @endphp
                        @foreach($workTitle as $index => $title)
                        <div class="form-check my-3 md:col-span-3">
                            <label class="block text-md font-medium" for="operasional{{$index}}">
                                {{$title}}
                            </label>
                        </div>
                        <div class="mt-1 grid grid-cols-3">
                            <div class="flex flex-col">
                                <input class="form-check-input" type="radio" value="ya" id="operasional{{$index}}ya" name="operasional{{$index}}" required>
                                <label for="operasional{{$index}}ya" style="padding-left:25px;">Ya</label>
                            </div>
                            <div class="flex">
                                <input class="form-check-input" type="radio" value="tidak" id="operasional{{$index}}tidak" name="operasional{{$index}}">
                                <label for="operasional{{$index}}tidak" style="padding-left:25px;">Tidak</label>
                            </div>
                            <div class="flex">
                                <input class="form-check-input" type="radio" value="n/a" id="operasional{{$index}}n/a" name="operasional{{$index}}">
                                <label for="operasional{{$index}}n/a" style="padding-left:25px;">N/A</label>
                            </div>
                        </div>
                        @endforeach
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
    <div class="md:col-span-15 grid md:grid-cols-4 md:grid-rows-2 md:grid-flow-col gap-x-4 gap-1">
        <div>
            <div><label for="bahayaPotensial${rowCountPotentialDanger}" class="block text-md font-medium">Bahaya Potensial / Konsekuensi (Apa yang menyebabkan bahaya)</label></div>
        </div>
        <div>
            <input type="text" id="bahayaPotensial${rowCountPotentialDanger}" class="form-control rounded-lg w-full" placeholder="Input data">
        </div>
        <div>
            <div><label for="scoreBahayaSebelum${rowCountPotentialDanger}" class="block text-md font-medium">Score Bahaya (Sebelum)</label></div>
        </div>
        <div>
            <input type="text" id="scoreBahayaSebelum${rowCountPotentialDanger}" class="form-control rounded-lg w-full" placeholder="Input data">
        </div>
        <div>
            <div><label for="pengendalianBahayaHirarki${rowCountPotentialDanger}" class="block text-md font-medium">Pengendalian (Gunakan Hirarki Pengendalian Bahaya)</label></div>
        </div>
        <div>
            <input type="text" id="pengendalianBahayaHirarki${rowCountPotentialDanger}" class="form-control rounded-lg w-full" placeholder="Input data">
        </div>
        <div>
            <div><label for="scoreBahayaSesudah${rowCountPotentialDanger}" class="block text-md font-medium">Score Bahaya (Sesudah)</label></div>
        </div>
        <div>
            <input type="text" id="scoreBahayaSesudah${rowCountPotentialDanger}" class="form-control rounded-lg w-full" placeholder="Input data">
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

document.getElementById('Tanggal').addEventListener('input', function() {
    var textbox1Value = this.value; // Ambil nilai dari textbox1
    document.getElementById('Tanggal1').value = textbox1Value; // Set nilai ke textbox2
});
</script>

<!-- <div id="wizard">
    <h3>Main Step 1</h3>
    <section>
        <p>Content for Main Step 1</p>
        <button id="showSubStep1">Go to Sub Step 1</button>
        <div class="sub-step" id="subStep1">
            <h4>Sub Step 1.1</h4>
            <p>Details for Sub Step 1.1</p>
            <button class="nextSubStep">Next</button>
            <button class="backSubStep">Back</button>
        </div>
        <div class="sub-step" id="subStep2">
            <h4>Sub Step 1.2</h4>
            <p>Details for Sub Step 1.2</p>
            <button class="nextSubStep">Next</button>
            <button class="backSubStep">Back</button>
        </div>
    </section>
    
    <h3>Main Step 2</h3>
    <section>
        <p>Content for Main Step 2</p>
        <button id="showSubStep2">Go to Sub Step 2</button>
        <div class="sub-step" id="subStep3">
            <h4>Sub Step 2.1</h4>
            <p>Details for Sub Step 2.1</p>
            <button class="nextSubStep">Next</button>
            <button class="backSubStep">Back</button>
        </div>
    </section>
</div> -->
<!-- <script>
    $(document).ready(function() {
        $("#wizard").steps({
            // Konfigurasi langkah di sini
        });

        // Navigasi untuk Sub Step 1
        $("#showSubStep1").click(function() {
            $("#subStep1").show().siblings('.sub-step').hide(); // Tampilkan sub step 1
        });

        $(".nextSubStep").click(function() {
            $(this).closest('.sub-step').hide().next('.sub-step').show(); // Pindah ke sub step berikutnya
        });

        $(".backSubStep").click(function() {
            $(this).closest('.sub-step').hide().prev('.sub-step').show(); // Kembali ke sub step sebelumnya
        });

        // Navigasi untuk Sub Step 2
        $("#showSubStep2").click(function() {
            $("#subStep3").show().siblings('.sub-step').hide(); // Tampilkan sub step 2
        });
    });
</script> -->
@endpush

</x-app-layout>