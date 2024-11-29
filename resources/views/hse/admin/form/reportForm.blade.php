<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets') }}/src/css/vendors_css.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/src/css/tailwind.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/src/css/horizontal-menu.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/src/css/style.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/src/css/skin_color.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/src/css/custom.css">
    <style>
        body {
            background-color: white;
            zoom: 0.8;  /* Mengatur skala zoom ke 80% */
        }
        [type="checkbox"]+label, [type="radio"]:not(:checked)+label, [type="radio"]:checked+label, [type="date"] {
            color: unset;
            background-color: unset;
        }
        
        [type="checkbox"]:not(:checked):disabled+label:before{
            border: 2px solid #a1a4b5;
            background-color: unset;
        }
        [type="checkbox"]:checked:disabled+label:before{
            border-right: 2px solid #3596f7;
            border-bottom: 2px solid #3596f7;
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
            .md\:grid-cols-12 {
                grid-template-columns: repeat(12, minmax(0, 1fr));
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
            .md\:col-span-2 {
                grid-column: span 2 / span 2;
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
        }
        @media print {
            .print-none {
                display: none;
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
        .page-break{
            page-break-before: auto;
            page-break-after: auto;
            page-break-inside: avoid;
        }
        .img-box{
            display:flex;
            justify-content:center;
        }
        .img-item{
            width:200px;
            height:200px;
        }
        .comment{
            padding: 10px;
        }
        th, td {
            width: 33%;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    
            <div class="flex p-10 items-center gap-4 relative">
                <img src="{{asset('assets/images/logo/logo.png')}}" alt="Gambar Sinar Meadow" class="h-auto" style="width:20%;">
                <div class="absolute w-full">
                    <p class="text-2xl text-center">Report Permit Form HSE</p>
                </div>
            </div>
            <!-- Step 1 -->
            <h6 class="text-2xl font-medium mb-4 p-4 rounded-lg bg-blue-700 text-white">Ijin Kerja 1</h6>
            <section id="ijinKerja1">
                <div class="rounded-lg custom-bg-color page-break" id="pelaksanaPekerjaan">
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
                                    <input type="number" id="{{$title}}" name="{{$title}}" value="{{$form->hp_number}}" class="form-control rounded-lg w-3/4" placeholder="Input data" readonly>
                                </div>
                                @elseif($title == "Tanggal Mulai Pelaksanaan")
                                <div class="form-group flex flex-col">
                                    <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                    <input type="date" id="{{$title}}" name="{{$title}}" value="{{$form->start_date}}" class="form-control flex rounded-lg w-3/4" readonly>

                                </div>
                                @elseif($title == "Tanggal Berakhir Pelaksanaan")
                                <div class="form-group flex flex-col">
                                    <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                    <input type="date" id="{{$title}}" name="{{$title}}" value="{{$form->end_date}}" class="form-control flex rounded-lg w-3/4" readonly>
                                </div>
                                @elseif($title == "Jam Mulai Kerja" || $title == "Jam Berakhir Kerja")
                                <div class="form-group flex flex-col">
                                    <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                    <input type="time" id="{{$title}}" name="{{$title}}" class="form-control flex rounded-lg w-3/4" value="{{$title == 'Jam Mulai Kerja' ? $form->start_time : $form->end_time}}"  readonly>                                    
                                </div>
                                @elseif($title == "Penjelasan Pekerjaan")
                                <div class="form-group flex flex-col md:col-span-3">
                                    <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                    <textarea name="{{$title}}" id="{{$title}}" class="form-control w-3/4" style="resize: none;" rows="4" readonly>{{$form->work_description}}</textarea>
                                </div>
                                @elseif($title == "Jumlah Tenaga Kerja")
                                <div class="form-group flex flex-col">
                                    <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                    <div class="flex w-3/4 items-center">
                                        <input type="number" id="{{$title}}" name="{{$title}}" value="{{$form->workers_count}}" class="form-control rounded-lg w-3/4" placeholder="Input data" readonly>
                                        <label for="{{$title}}" class="p-2">orang</label>
                                    </div>
                                </div>
                                @else
                                <div class="form-group flex flex-col">
                                    <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                    <input type="text" id="{{$title}}" name="{{$title}}" value="{{$title == 'Nama Perusahaan / Departemen' ? $form->company_department : ($title == 'Penanggung Jawab Lapangan' ? $form->supervisor : $form->location )}}" class="form-control rounded-lg w-3/4" placeholder="Input data" readonly>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="rounded-lg custom-bg-color page-break" id="potensiBahaya">
                    <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                        <span class="text-lg text-white">Potensi Bahaya di Area Kerja</span>
                    </div>
                    @php 
                        $workTitle = ["Mudah Terbakar", "Gas Beracun", "Bising", "Benda Berat", "Ledakan", "Listrik", "Ketinggian", "Lantai Licin", "Temperatur Tinggi", "Bahan Kimia", "Ruang Tertutup"];
                    @endphp
                    <div class="p-2" id="potensiBahayaContent">
                        <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2" >
                            @foreach($potentialHazards as $index => $hazard)
                                @if(in_array($hazard->name, $workTitle))
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="potentialHazards[]" value="{{$hazard->id}}" id="hazard {{$hazard->id}}" disabled
                                        @if(in_array($hazard->id, $potentialHazards_data))
                                            checked
                                        @endif>
                                        <label class="block text-md font-medium" for="hazard {{$hazard->id}}">
                                            {{$hazard->name}}
                                        </label>
                                    </div>
                                @else
                                    @if(in_array($hazard->id, $potentialHazards_data))
                                        @php
                                            $newHazardId = $hazard->id;
                                            $newHazardName = $hazard->name;
                                        @endphp
                                    @endif
                                @endif
                            @endforeach
                            <div class="form-check flex items-center">
                                <input class="form-check-input" type="checkbox" name="newHazard" id="newHazard" disabled
                                @if(isset($newHazardId))
                                    checked
                                @endif>
                                <label class="form-check-label block text-md font-medium" for="newHazard">
                                    <input type="text" id="newHazardItem" name="newHazardItem" class="form-control rounded-lg w-3/4" style="height:100%;" readonly
                                    @if(isset($newHazardName))
                                        value="{{$newHazardName}}"
                                    @endif>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg custom-bg-color page-break" id="apd">
                    <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                        <span class="text-lg text-white">Alat Pelindung Diri (APD)</span>
                    </div>

                    <div class="p-2" id="apdContent">
                        <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2">
                            <div>
                                <div class="p-1.5 pl-3"><i>Kepala/Mata/Wajah</i></div>
                                @php 
                                    $workTitle = ["Safety Helmet", "Goggles (Impact)", "Goggles (Chemical)", "Face Shield (Chemical)", "Face Shield (Welding)", "Face Shield (Grinding)"];
                                @endphp
                                @foreach($personalProtectEquipments as $equipment)
                                    @if(in_array($equipment->name, $workTitle))
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="personalProtectEquipments[]" value="{{$equipment->id}}" id="head {{$equipment->id}}" disabled
                                        @if(in_array($equipment->id, $personalProtectEquipments_data))
                                            checked
                                        @endif>
                                        <label class="block text-md font-medium" for="head {{$equipment->id}}">
                                            {{$equipment->name}}
                                        </label>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            <div>
                                <div class="p-1.5 pl-3"><i>Pernapasan</i></div>
                                @php 
                                    $workTitle = ["Respirator", "Dust Mask"];
                                @endphp
                                @foreach($personalProtectEquipments as $equipment)
                                    @if(in_array($equipment->name, $workTitle))
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="personalProtectEquipments[]" value="{{$equipment->id}}" id="respiratory {{$equipment->id}}" disabled
                                        @if(in_array($equipment->id, $personalProtectEquipments_data))
                                            checked
                                        @endif>
                                        <label class="block text-md font-medium" for="respiratory {{$equipment->id}}">
                                            {{$equipment->name}}
                                        </label>
                                    </div>
                                    @endif
                                @endforeach
                                
                                <div class="p-1.5 pl-3"><i>Badan</i></div>
                                @php 
                                    $workTitle = ["Safety Body Harness", "Apron (Hot & Welding)"];
                                @endphp
                                @foreach($personalProtectEquipments as $equipment)
                                    @if(in_array($equipment->name, $workTitle))
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="personalProtectEquipments[]" value="{{$equipment->id}}" id="respiratory {{$equipment->id}}" disabled
                                        @if(in_array($equipment->id, $personalProtectEquipments_data))
                                            checked
                                        @endif>
                                        <label class="block text-md font-medium" for="respiratory {{$equipment->id}}">
                                            {{$equipment->name}}
                                        </label>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            <div>
                                <div class="p-1.5 pl-3"><i>Kaki</i></div>
                                @php 
                                    $workTitle = ["Safety Shoes (Impact)", "Rubber / PVC Shoes"];
                                @endphp
                                @foreach($personalProtectEquipments as $equipment)
                                    @if(in_array($equipment->name, $workTitle))
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="personalProtectEquipments[]" value="{{$equipment->id}}" id="respiratory {{$equipment->id}}" disabled
                                        @if(in_array($equipment->id, $personalProtectEquipments_data))
                                            checked
                                        @endif>
                                        <label class="block text-md font-medium" for="respiratory {{$equipment->id}}">
                                            {{$equipment->name}}
                                        </label>
                                    </div>
                                    @endif
                                @endforeach

                                <div class="p-1.5 pl-3"><i>Telinga</i></div>
                                @php 
                                    $workTitle = ["Ear Plug", "Ear Muff"];
                                @endphp
                                @foreach($personalProtectEquipments as $equipment)
                                    @if(in_array($equipment->name, $workTitle))
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="personalProtectEquipments[]" value="{{$equipment->id}}" id="respiratory {{$equipment->id}}" disabled
                                        @if(in_array($equipment->id, $personalProtectEquipments_data))
                                            checked
                                        @endif>
                                        <label class="block text-md font-medium" for="respiratory {{$equipment->id}}">
                                            {{$equipment->name}}
                                        </label>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            <div>
                                <div class="p-1.5 pl-3"><i>Tangan</i></div>
                                @php 
                                    $workTitle = ["Cotton Gloves", "Rubber/PVC" , "Leather Gloves"];
                                @endphp
                                @foreach($personalProtectEquipments as $equipment)
                                    @if(in_array($equipment->name, $workTitle))
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="personalProtectEquipments[]" value="{{$equipment->id}}" id="respiratory {{$equipment->id}}" disabled
                                        @if(in_array($equipment->id, $personalProtectEquipments_data))
                                            checked
                                        @endif>
                                        <label class="block text-md font-medium" for="respiratory {{$equipment->id}}">
                                            {{$equipment->name}}
                                        </label>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="rounded-lg custom-bg-color page-break" id="daftarPeralatan">
                    <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                        <span class="text-lg text-white">Daftar Peralatan Kerja</span>
                    </div>
                    
                    <div class="p-2" id="daftarPeralatanContent">
                        <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2">
                            @php 
                                $workTitle = ["Power Tools", "Tangga (Ladder)" , "Bahan Kimia", "Hand Tools", "Stagger (Scaffolds)", "Tabung Gas & Fittings", "Welding Set", "Alat angkat & Angkut", "Air Compressor", "Gerinda / Cutting Tools"];
                            @endphp
                            @foreach($workEquipments as $equipment)
                                @if(in_array($equipment->name, $workTitle))
                                    <div class="form-check">
                                    @if($equipment->name == "Alat angkat & Angkut")
                                        <input class="form-check-input" type="checkbox" name="workEquipments[]" value="{{$equipment->id}}" id="Alat angkat & Angkut" disabled
                                        @if(in_array($equipment->id, $workEquipments_data))
                                            checked
                                        @endif>
                                        <label class="block text-md font-medium" for="workEquips {{$equipment->id}}">
                                            {{$equipment->name}} </br> (Forklift, Crane, Hoise, Boomlift)
                                        </label>
                                        
                                    @else
                                        <input class="form-check-input" type="checkbox" name="workEquipments[]" value="{{$equipment->id}}" id="workEquips {{$equipment->id}}" disabled
                                        @if(in_array($equipment->id, $workEquipments_data))
                                            checked
                                        @endif>
                                        <label class="block text-md font-medium" for="workEquips {{$equipment->id}}">
                                            {{$equipment->name}}
                                        </label>
                                    @endif
                                    </div>
                                @else
                                    @if(in_array($equipment->id, $workEquipments_data))
                                        @php
                                            $newEquipmentId = $equipment->id;
                                            $newEquipmentName = $equipment->name;
                                        @endphp
                                    @endif
                                @endif
                            @endforeach
                            <div class="form-check"> 
                                <input class="form-check-input" type="checkbox" name="newEquipment" id="newEquipment" disabled
                                @if(isset($newEquipmentId))
                                    checked
                                @endif>
                                <label class="form-check-label block text-md font-medium" for="newEquipment">
                                    <input type="text" id="newEquipmentText" name="newEquipmentText" class="form-control rounded-lg w-3/4" style="height:100%;" readonly
                                    @if(isset($newEquipmentName))
                                        value="{{$newEquipmentName}}"
                                    @endif>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg custom-bg-color page-break" id="ijinKerjaTambahan">
                    <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                        <span class="text-lg text-white">Ijin Kerja Tambahan yang Diperlukan</span>
                    </div>
                    
                    <div class="p-2" id="ijinKerjaTambahanContent"> 
                        <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2">
                            @php 
                                $workTitle = ["Ijin Pekerjaan Panas", "Ijin Kerja Di Ruang Terbatas" , "Ijin Kerja Di Ketinggian"];
                            @endphp
                            @foreach($additionalWorkPermits as $permit)
                                @if(in_array($permit->name, $workTitle))
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{$permit->name}}" disabled
                                        @if(in_array($permit->id, $additionalWorkPermits_data))
                                            checked
                                        @endif>
                                        <label class="block text-md font-medium" for="{{$permit->name}}">
                                            <p class="">{{$permit->name}}</p>
                                        </label>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="rounded-lg custom-bg-color page-break" id="pengendaliBahaya">
                    <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                        <span class="text-lg text-white">Pengendali Bahaya Kebakaran</span>
                    </div>
            
                    <div class="p-2" id="pengendaliBahayaContent">
                        <div id="peralatanProteksiKebakaran">
                            <div class="my-10">
                                <div class="font-medium">Apakah pekerjaan memerlukan Sistem Proteksi Kebakaran?</div>
                            </div>
                            <div>
                                <label class="inline-flex items-center cursor-pointer">
                                    <span class="ms-3 text-sm font-medium mr-3">Tidak</span>
                                    <input type="checkbox" value="" id="sistemProteksiKebakaran" class="sr-only peer" disabled
                                    @if(!empty($fireHazardControls_data))
                                        checked
                                    @endif>
                                    <div class="relative w-11 h-6 bg-gray-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ms-3 text-sm font-medium ">Ya</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

            <!-- Ijin Kerja Hot Work -->
            @if(in_array(1, $additionalWorkPermits_data))
            <div id="ijinKerjaApi" class="hidden page-break">
                <h6 class="text-2xl font-medium mb-4 mt-8 p-4 rounded-lg bg-blue-700 text-white">Ijin Kerja Pekerjaan Dengan Api</h6>
                <section>
                    <div class="rounded-lg custom-bg-color page-break" id="perlindunganKebakaran">
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
                                <input class="form-check-input" type="checkbox" value="" id="perlindunganKebakaran{{$index}}" disabled checked>
                                <label class="block text-md font-medium" for="perlindunganKebakaran{{$index}}">
                                    {{$title}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-lg custom-bg-color page-break" id="pencegahanDalamRadius">
                        <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                            <span class="text-lg text-white">B. Pencegahan Dalam Radius 12 meter dari Area Pekerjaan</span>
                        </div>
                        <div class="p-2" id="pencegahanDalamRadiusContent">
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
                                    <input class="form-check-input" type="checkbox" value="" id="tangga{{$index}}" disabled checked>
                                    <label class="block text-md font-medium" for="tangga{{$index}}">
                                        {{$title}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            @endif

            <!-- Ijin Kerja Confined Space Work -->
            @if(in_array(2, $additionalWorkPermits_data))
            <div id="ijinKerjaRuangTerbatas" class="hidden page-break">
                <h6 class="text-2xl font-medium mb-4 mt-8 p-4 rounded-lg bg-blue-700 text-white">Ijin Kerja Ruang Terbatas</h6>
                <section>
                    <div class="rounded-lg custom-bg-color page-break" id="perlindunganRuangTerbatas">
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
                                <input class="form-check-input" type="checkbox" value="" id="perlindunganRuangTerbatas{{$index}}" disabled checked>
                                <label class="block text-md font-medium" for="perlindunganRuangTerbatas{{$index}}">
                                    {{$title}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-lg custom-bg-color page-break" id="pengendalianRuangTerbatas">
                        <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                            <span class="text-lg text-white">B. Pengendalian Resiko di Ruang Terbatas</span>
                        </div>
                        <div class="p-2" id="pengendalianRuangTerbatasContent">
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
                                    <input class="form-check-input" type="checkbox" value="" id="pengendalianRuangTerbatas{{$index}}" disabled checked>
                                    <label class="block text-md font-medium" for="pengendalianRuangTerbatas{{$index}}">
                                        {{$title}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="rounded-lg custom-bg-color page-break" id="tesSuhu">
                        <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                            <span class="text-lg text-white">Hasil Tes Kadar</span>
                        </div>
                        <div class="p-2" id="tesSuhuContent">
                            <div class="flex flex-col justify-center">
                                <div class="flex items-center flex-wrap">
                                    <div class="p-1.5 pl-3 font-medium"><strong><i>Kadar <span class="ml-2"> {{$testResult->test_date}}</span></i></strong></div>
                                </div>
                                <div class="flex">
                                    <div class="grid grid-cols-1 md:grid-cols-2">
                                        <div class="form-group flex items-center">
                                            <label for="LEL" class="block text-md font-medium">Kadar Low Explosive Level (LEL)</label>
                                        </div>
                                        <div class="form-group flex items-center">
                                            <input type="number" id="LEL" name="LEL" class="form-control rounded-lg w-3/4" disabled value="{{$testResult->lel}}">
                                            <label for="LEL" class="block text-md font-medium ml-2">%</label>
                                        </div>
                                        <div class="form-group flex items-center">
                                            <label for="CO" class="block text-md font-medium">Kadar Carbon Monoxide (CO)</label>
                                        </div>
                                        <div class="form-group flex items-center">
                                            <input type="number" id="CO" name="CO" class="form-control rounded-lg w-3/4" disabled value="{{$testResult->co}}">
                                            <label for="CO" class="block text-md font-medium ml-2">ppm</label>
                                        </div>
                                        <div class="form-group flex items-center">
                                            <label for="O2" class="block text-md font-medium">Kadar Oxygen (O₂)</label>
                                        </div>
                                        <div class="form-group flex items-center">
                                            <input type="number" id="O2" name="O2" class="form-control rounded-lg w-3/4" disabled value="{{$testResult->o2}}">
                                            <label for="O2" class="block text-md font-medium ml-2">%</label>
                                        </div>
                                        <div class="form-group flex items-center">
                                            <label for="H2S" class="block text-md font-medium">Kadar Hydrogen Sulfide (H₂S)</label>
                                        </div>
                                        <div class="form-group flex items-center">
                                            <input type="number" id="H2S" name="H2S" class="form-control rounded-lg w-3/4" disabled value="{{$testResult->h2s}}">
                                            <label for="H2S" class="block text-md font-medium ml-2">ppm</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            @endif

            <!-- Ijin Kerja Height Work -->
            @if(in_array(3, $additionalWorkPermits_data))
            <div id="ijinKerjaKetinggian" class="hidden page-break">
                <h6 class="text-2xl font-medium mb-4 mt-8 p-4 rounded-lg bg-blue-700 text-white">Ijin Kerja Di Ketinggian</h6>
                <section>
                    <div class="rounded-lg custom-bg-color page-break" id="perlindunganKetinggian">
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
                                <input class="form-check-input" type="checkbox" value="" id="perlindunganKetinggian{{$index}}" disabled checked>
                                <label class="block text-md font-medium" for="perlindunganKetinggian{{$index}}">
                                    {{$title}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-lg custom-bg-color page-break" id="pengendalianRisikoTangga">
                        <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                            <span class="text-lg text-white">Pengendalian risiko untuk Tangga</span>
                        </div>
                        <div class="p-2" id="pengendalianRisikoTanggaContent">
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
                                    <input class="form-check-input" type="checkbox" value="" id="tangga{{$index}}" disabled checked>
                                    <label class="block text-md font-medium" for="tangga{{$index}}">
                                        {{$title}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            
                            
                            <div class="form-check my-6">
                                @php
                                    $workTitle = ["Menggunakan Scaffolding"];
                                @endphp
                                @foreach($additionalWorkPermits as $permit)
                                    @if(in_array($permit->name, $workTitle))
                                    <input class="form-check-input" type="checkbox" value="" id="checkScaffolding" disabled
                                    @if(in_array($permit->id, $additionalWorkPermits_data))
                                            checked
                                    @endif>
                                    <label class="block text-md font-medium" for="checkScaffolding">
                                        Apakah menggunakan scaffolding?
                                    </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg custom-bg-color hidden page-break" id="pengendalianRisikoScaffolding">
                        <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                            <span class="text-lg text-white">Pengendalian risiko untuk Scaffolding</span>
                        </div>

                        <div class="p-2" id="pengendalianRisikoScaffoldingContent">
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
                                    <input class="form-check-input" type="checkbox" value="" id="scaffolding{{$index}}" disabled checked>
                                    <label class="block text-md font-medium" for="scaffolding{{$index}}">
                                        {{$title}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            
                            @if(in_array(4, $additionalWorkPermits_data))
                            <div class="p-1.5 pl-3"><strong><i>Penyimpanan</i></strong></div>
                            <div class="grid md:grid-cols-4">
                                @php 
                                    $workTitle = [
                                        "Bracing tidak bengkok / retak / karat",
                                        "Kondisi frame tidak bengkok / retak / karat",
                                        "Kondisi Cat Walk atau Plank tidak bengkok / retak / karat",
                                        "Kondisi join pin tidak bengkok / retak / karat",
                                        "Tidak terdapat material / cairan di dekat tempat penyimpanan yang berpotensi mengakibatkan karat pada frame / bagian lain",
                                        "Penyimpanan scaffolding tidak terpapar langsung dengan hujan / panas secara terus menerus",
                                        "Tumpukan frame / bagian lain saat disimpan tidak mengakibatkan kerusakan / perubahaan bentuk"
                                        ];
                                @endphp
                                @foreach($scaffs as $index => $scaff)
                                    @if(in_array($scaff->name, $workTitle))
                                    <div class="form-check my-3 md:col-span-3">
                                        <label class="block text-md font-medium">
                                        {{$index+1}}. {{$scaff->name}}
                                        </label>
                                    </div>
                                    <div class="mt-1 grid grid-cols-3">
                                        <div class="flex flex-col">
                                            <input class="form-check-input" type="checkbox" value="yes" id="penyimpanan{{$index}}ya" name="scaff{{$index}}" disabled
                                            @if($scaff->status === 'yes')
                                                checked
                                            @endif>
                                            <label for="penyimpanan{{$index}}ya" style="padding-left:25px;">Ya</label>
                                        </div>
                                        <div class="flex">
                                            <input class="form-check-input" type="checkbox" value="no" id="penyimpanan{{$index}}tidak" name="scaff{{$index}}" disabled
                                            @if($scaff->status === 'no')
                                                checked
                                            @endif>
                                            <label for="penyimpanan{{$index}}tidak" style="padding-left:25px;">Tidak</label>
                                        </div>
                                        <div class="flex">
                                            <input class="form-check-input" type="checkbox" value="na" id="penyimpanan{{$index}}n/a" name="scaff{{$index}}" disabled
                                            @if($scaff->status === 'na')
                                                checked
                                            @endif>
                                            <label for="penyimpanan{{$index}}n/a" style="padding-left:25px;">N/A</label>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="p-1.5 pl-3"><strong><i>Operasional / Penggunaan</i></strong></div>
                            <div class="grid md:grid-cols-4">
                                @php 
                                    $workTitle = [
                                        "Bracing terpasang pada frame",
                                        "Koneksi bracing dengan frame dalam kondisi aman / terkunci",
                                        "Semua bagian frame terkunci seluruhnya dengan join pin",
                                        "Cat Walk / Plank terpasang pada frame",
                                        "Scaffolding didirikan oleh petugas yang berkompeten",
                                        "Minimal 2 tumpuk frame harus menggunakan railing atau pekerja menggunakan Safety body harness",
                                        "Pada saat bekerja harus menggunakan barikade, untuk mencegah orang melewati kolong frame",
                                        "Frame harus terikat di srtuktur yang kuat",
                                        "Kaki frame tidak boleh berada pada struktur yang tidak stabil / lembek / mudah patah / pecah"
                                        ];
                                @endphp
                                @foreach($scaffs as $index => $scaff)
                                    @if(in_array($scaff->name, $workTitle))
                                    <div class="form-check my-3 md:col-span-3">
                                        <label class="block text-md font-medium" for="operasional{{$index}}">
                                        {{$index+1}}. {{$scaff->name}}
                                        </label>
                                    </div>
                                    <div class="mt-1 grid grid-cols-3">
                                        <div class="flex">
                                            <input class="form-check-input" type="checkbox" value="yes" id="operasional{{$index}}ya" name="scaff{{$index}}" disabled
                                            @if($scaff->status === 'yes')
                                                checked
                                            @endif>
                                            <label for="operasional{{$index}}ya" style="padding-left:25px;">Ya</label>
                                        </div>
                                        <div class="flex">
                                            <input class="form-check-input" type="checkbox" value="no" id="operasional{{$index}}tidak" name="scaff{{$index}}" disabled
                                            @if($scaff->status === 'no')
                                                checked
                                            @endif>
                                            <label for="operasional{{$index}}tidak" style="padding-left:25px;">Tidak</label>
                                        </div>
                                        <div class="flex">
                                            <input class="form-check-input" type="checkbox" value="na" id="operasional{{$index}}n/a" name="scaff{{$index}}" disabled
                                            @if($scaff->status === 'na')
                                                checked
                                            @endif>
                                            <label for="operasional{{$index}}n/a" style="padding-left:25px;">N/A</label>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>
            @endif

            <!-- Step 2 -->
            <section id="ijinKerja2" class="page-break">
            <h6 class="text-2xl font-medium mb-4 mt-8 p-4 rounded-lg bg-blue-700 text-white">Ijin Kerja 2</h6>
                <div class="rounded-lg custom-bg-color page-break" id="tenagaKerja">
                    <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                        <span class="text-lg text-white">Fit to Work</span>
                    </div>
                    <div class="p-2" id="tenagaKerjaContent">
                        <div class="border rounded-lg p-3">
                            <div id="tenagaKerjaGrid" class="grid gap-y-3">
                                <div class="grid md:grid-cols-16">
                                    <div>
                                        <div class="flex md:justify-center">
                                            <label for="" class="block text-md font-bold">No.</label>
                                        </div>
                                    </div>
                                    <div class="md:col-span-15 grid md:grid-cols-4 gap-x-4">
                                        <div class="flex md:justify-center">
                                            <div class="font-bold">
                                                Nama Tenaga Kerja
                                            </div>
                                                
                                        </div>
                                        <div class="col-span-3 grid md:grid-cols-5">
                                            <div class="col-span-2 grid md:grid-cols-3">
                                                <div class="font-bold">
                                                    OK
                                                </div>
                                                <div class="font-bold">
                                                    Not OK
                                                </div>
                                                <div class="font-bold">
                                                    Cek Klinik
                                                </div>
                                            </div>
                                            <div class="col-span-3">
                                                <div class="font-bold">
                                                    Rekomendasi Klinik
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach($workers as $id => $worker)
                                <div class="grid md:grid-cols-16">
                                    <div>
                                        <div class="flex md:justify-center">
                                            <label for="" class="block text-md font-medium">{{$id+1}}</label>
                                        </div>
                                    </div>
                                    <div class="md:col-span-15 grid md:grid-cols-4 gap-x-4">
                                        <div class="flex md:justify-center">
                                            <label for="namaTenagaKerja1" class="font-medium">{{$worker->worker_name}}</label>
                                        </div>
                                        <div class="col-span-3 grid md:grid-cols-5">

                                            <div class="col-span-2 grid md:grid-cols-3">
                                                <div>
                                                    <input type="checkbox" name="tenagaKerja{{$id}}" id="ok{{$id}}" value="ok" disabled
                                                    @if($worker->ok)
                                                        checked
                                                    @endif>
                                                    <label for="ok{{$id}}"><span class="md:hidden">OK</span></label>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="tenagaKerja{{$id}}" id="notOk{{$id}}" value="notOk" disabled
                                                    @if($worker->not_ok)
                                                        checked
                                                    @endif>
                                                    <label for="notOk{{$id}}"><span class="md:hidden">NOT OK</span></label>
                                                </div>
                                                <div>
                                                    <input type="checkbox" name="tenagaKerja{{$id}}" id="cekKlinik{{$id}}" value="cekKlinik" disabled
                                                    @if($worker->clinic_check)
                                                        checked
                                                    @endif>
                                                    <label for="cekKlinik{{$id}}"><span class="md:hidden">Cek Klinik</span></label>
                                                </div>
                                            </div>
                                            <div class="col-span-3">
                                                <input type="text" id="clinicRecomendation{{$id}}" name="clinicRecomendation{{$id}}" class="form-control rounded-lg w-full" readonly
                                                @if($worker->clinic_check)
                                                    value="{{$worker->clinic_recomendation}}"
                                                @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </section>


            <!-- Step 3 -->
            
            <section id="formJSA"  class="page-break">
            <h6 class="text-2xl font-medium mb-4 mt-8 p-4 rounded-lg bg-blue-700 text-white ">Formulir Analisis Keamanan Pekerjaan (JSA)</h6>
                <div class="rounded-lg custom-bg-color page-break" id="jsa">
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

                        <div class="border rounded-lg p-3">
                            <div id="potentialDangerGrid" class="grid gap-y-3">
                            @foreach($jsas as $index => $jsa)
                                <div class="grid md:grid-cols-16">
                                    <div>
                                        <div class="flex md:justify-center">
                                            <label for="namaPekerjaan{{$index+1}}" class="block text-md font-bold">No. {{$index+1}}</label>
                                        </div>
                                    </div>
                                    <div class="md:col-span-15 grid md:grid-cols-12 md:grid-rows-2 md:grid-flow-col gap-x-4 gap-1">
                                        <div class="md:col-span-4">
                                            <div><label for="workStep{{$index+1}}" class="block text-md font-medium">Uraian Langkah Pekerjaan</label></div>
                                        </div>
                                        <div class="md:col-span-4">
                                            <input type="text" id="workStep{{$index+1}}" class="form-control rounded-lg w-full" value="{{$jsa->work_step}}" readonly>
                                        </div>
                                        <div class="md:col-span-4">
                                            <div><label for="bahayaPotensial{{$index+1}}" class="block text-md font-medium">Bahaya</label></div>
                                        </div>
                                        <div class="md:col-span-4">
                                            <input type="text" id="bahayaPotensial{{$index+1}}" class="form-control rounded-lg w-full" value="{{$jsa->potential_danger}}" readonly>
                                        </div>
                                        <div class="md:col-span-4">
                                            <div><label for="riskChance{{$index+1}}" class="block text-md font-medium">Risiko Yang Bisa Timbul</label></div>
                                        </div>
                                        <div class="md:col-span-4">
                                            <input type="text" id="riskChance{{$index+1}}" class="form-control rounded-lg w-full" value="{{$jsa->risk_chance}}" readonly>
                                        </div>
                                        <div class="md:col-span-4">
                                            <div><label for="pengendalianBahayaHirarki{{$index+1}}" class="block text-md font-medium">Tindakan Pencegahan / Pengendalian</label></div>
                                        </div>
                                        <div class="md:col-span-4">
                                            <input type="text" id="pengendalianBahayaHirarki{{$index+1}}" class="form-control rounded-lg w-full" value="{{$jsa->danger_control}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>

            <div class="my-4 py-4" style="background-color: #A78734"></div>
            <div class="">
                <table style="width:100%; table-layout: fixed;">
                    <tbody>
                        <tr>
                            @foreach($approvalDetail as $detail)
                            @if($detail->name=="HSE")
                            <td class="">
                                <img src="{{asset('assets/images/hse/hse-'.strtolower($detail->status).'.png')}}" alt="hse-approved" class="img-item">
                            </td>
                            @elseif($detail->name=="Engineering Manager")
                            <td class="">       
                                <img src="{{asset('assets/images/hse/engineering-'.strtolower($detail->status).'.png')}}" alt="engineering-manager-approved"class="img-item">
                            </td>
                            @elseif($detail->name=="PIC Location")
                            <td class="">       
                                <img src="{{asset('assets/images/hse/pic-location-'.strtolower($detail->status).'.png')}}" alt="pic-location-approved"class="img-item">
                            </td>
                            @endif
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($approvalDetail as $detail)
                                <td class="comment">
                                    <p>{{$detail->comment}}</p>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
                <button name="action" value="approve" class="m-2 px-4 py-2 text-xl bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn print-none" onclick="window.print()">
                    Print
                </button>
                
                <button name="action" class="m-2 px-4 py-2 text-xl bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn print-none" onclick="window.history.back()">
                    Back
                </button>
            </div>

    

<script>

document.addEventListener('DOMContentLoaded', function() {
    sioSilo();
    sistemProteksiKebakaran();
    hotWorkPermit();
    confinedSpacePermit();
    heightWorkPermit();
});

function sioSilo(){
    var button = document.getElementById('Alat angkat & Angkut');
    if(button.checked){
        var parentDiv = document.getElementById('daftarPeralatanContent');
        var firstChild = parentDiv.firstElementChild;
        var newDiv = document.createElement('div');
        newDiv.innerHTML = `
        <div>
            <table id="sioSiloTable">
                <thead>
                    <tr>
                        <th>Tipe</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($files as $file)
                    <tr style="border-top: 1px solid black">
                        <th>{{$file->type}}</th>
                        <td>
                            <a href="{{ asset('storage/hseFile/' . $file->form_id . '/' . $file->type . '/' . $file->file_name) }}" target="_blank">
                            {{$file->file_name}}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        `;
        firstChild.appendChild(newDiv);
    }
}

function hotWorkPermit(){
    var button = document.getElementById("Ijin Pekerjaan Panas");
    if(button.checked){
        var section = document.getElementById("ijinKerjaApi");
        section.classList.toggle('hidden');
    }
}

function confinedSpacePermit(){
    var button = document.getElementById("Ijin Kerja Di Ruang Terbatas");
    if(button.checked){
        var section = document.getElementById("ijinKerjaRuangTerbatas");
        section.classList.toggle('hidden');
    }
}

function heightWorkPermit(){
    var button = document.getElementById("Ijin Kerja Di Ketinggian");
    if(button.checked){
        var section = document.getElementById("ijinKerjaKetinggian");
        section.classList.toggle('hidden');
        
        checklistScaffolding();
    }
}

function sistemProteksiKebakaran(){
    var parentDiv = document.getElementById('peralatanProteksiKebakaran');
    var button = document.getElementById('sistemProteksiKebakaran');
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
            @foreach($fireHazardControls as $equipment)
                @if(in_array($equipment->name, $workTitle))
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="fireHazardControls[]" value="{{$equipment->id}}" id="fireControl {{$equipment->id}}" disabled
                    @if(in_array($equipment->id, $fireHazardControls_data))
                        checked
                    @endif>
                    <label class="block text-md font-medium" for="fireControl {{$equipment->id}}">
                        {{$equipment->name}}
                    </label>
                </div>
                @endif
            @endforeach
        </div>
        `;
        parentDiv.appendChild(newDiv);   
    }
}

// Checklist Scaffolding
function checklistScaffolding(button){
    var button = document.getElementById("checkScaffolding");
    if(button.checked){
        var div = document.getElementById('pengendalianRisikoScaffolding');
        div.classList.toggle('hidden');
    }
}

function dropDownToggle(button){
    var dropDownMenu = document.getElementById(button.id.replace('Button', ''));
    dropDownMenu.classList.toggle('hidden');
}

function toggleCheckbox(checkbox) {
    const name = checkbox.name;
    const checkboxes = document.querySelectorAll(`input[name="${name}"]:checked`);
    checkboxes.forEach((cb) => {
        if (cb !== checkbox) {
            cb.checked = false; // Uncheck all other checkboxes
        }
    });
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

document.addEventListener('DOMContentLoaded', function() {
    var textbox1Value = document.getElementById('Penanggung Jawab Lapangan').value; // Ambil nilai dari textbox1
    document.getElementById('JSA dilakukan oleh1').value = textbox1Value; // Set nilai ke textbox2

    var textbox1Value = document.getElementById('Penjelasan Pekerjaan').value; // Ambil nilai dari textbox1
    document.getElementById('Penjelasan Pekerjaan1').value = textbox1Value; // Set nilai ke textbox2

    var textbox1Value = document.getElementById('Lokasi Pekerjaan').value; // Ambil nilai dari textbox1
    document.getElementById('Lokasi1').value = textbox1Value; // Set nilai ke textbox2

    var startYear = document.getElementById("Tanggal Mulai Pelaksanaan").value;
    var endYear = document.getElementById("Tanggal Berakhir Pelaksanaan").value;
    document.getElementById('Tanggal1').value = `${startYear} - ${endYear}`;
});

function validateForm(event) {
    var comment = document.getElementById('comment').value.trim();
    var warning = document.getElementById('textarea-warning');
    if (comment === '') {
        event.preventDefault(); // Mencegah form dikirim
        warning.classList.remove('hidden'); 
    }else{
        warning.classList.add('hidden'); 
    }
}
</script>

</body>
</html>