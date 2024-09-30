<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard HSE') }}
        </h2>
    </x-slot>
    @push('css')
    <style>
        [type="checkbox"]+label {
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
        }
        .justify-self-end{
            justify-self: end;
        }
    </style>
    @endpush

<div class="box-body wizard-content">
    <form id="form" name="form" method="POST" class="validation-hse wizard-circle card p-10">
        @csrf
        <!-- Step 1 -->
        <h6 class="text-md font-semibold mb-4">Ijin Kerja 1</h6>
        <section>
            <div id="pelaksanaPekerjaan">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Pelaksana Pekerjaan</span>
                </div>
                <div class="" id="pelaksanaPekerjaanContent">
                    <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2">
                        @php 
                            $workTitle = ["Nama Perusahaan / Dept","Jenis Pekerjaan","Waktu Pelaksanaan","No Telp","Penanggung Jawab Lapangan","Lokasi Pekerjaan","Jam Kerja","Jumlah Tenaga Kerja"];
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
                            $workTitle = ["Power Tools", "Tangga (Ladder)" , "Bahan Kimia", "Hand Tools", "Stagger (Scaffolds)", "Tabung Gas & Fittings", "Welding Set", "Alat Angkat", "Air Compressor"];
                        @endphp
                        @foreach($workTitle as $title)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="{{$title}}">
                            <label class="block text-md font-medium" for="{{$title}}">
                                {{$title}}
                            </label>
                        </div>
                        @endforeach

                        <div class="form-check flex items-center md:row-span-4 md:col-start-4 md:row-start-1 md:row-end-4">
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
        <h6 class="text-md font-semibold mb-4">Step 2 </h6>
        <section>
            <div class="form-group">
                <label for="data" class="block text-md font-medium">Data ke 2</label>
                <input type="text" id="data" name="data" class="form-control w-full" required>
            </div>
        </section>
        <h6>Confirmation</h6>
        <section>
            <div class="form-group">
                <label for="data" class="block text-md font-medium">Data ke 3</label>
                <input type="text" id="data" name="data" class="form-control w-full" required>
            </div>
        </section>
    </form>
</div>


@push('scripts')
<script>
var form = $(".validation-hse").show();

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
    , onFinishing: function (event, currentIndex) {
        return form.validate().settings.ignore = ":disabled", form.valid()
    }
    , onFinished: function (event, currentIndex) {
        swal("Success", "Your PR Submitted!.");
        $("#form").submit();
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
        error.insertAfter(element)
    }
    , rules: {
        email: {
            email: !0
        }
    }
});



function hotWorkPermit(panas){
    var titles = "Ijin Kerja Pekerjaan Dengan Api"; 
    if (panas.checked){
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
                    <div class="form-check">
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
                        <div class="form-check">
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

function confinedSpacePermit(panas){
    var titles = "Ijin Kerja Ruang Terbatas"; 
    if (panas.checked){
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
                    <div class="form-check">
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
                        <div class="form-check">
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

            <div id="hasilTest">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">C. Hasil Test</span>
                </div>
                <div class="hidden" id="hasilTestContent">
                    <div>
                        <table class="table table-bordered" style="width:100%; table-layout: fixed;">
                            <thead>
                                <tr>
                                    <th rowspan="2">Parameter</th>
                                    <th colspan="2">Tgl.</th>
                                    <th colspan="2">Tgl.</th>
                                    <th colspan="2">Tgl.</th>
                                    <th colspan="2">Tgl.</th>
                                    <th colspan="2">Tgl.</th>
                                    <th colspan="2">Tgl.</th>
                                </tr>
                                <tr>
                                    <th>I</th>
                                    <th>II</th>
                                    <th>I</th>
                                    <th>II</th>
                                    <th>I</th>
                                    <th>II</th>
                                    <th>I</th>
                                    <th>II</th>
                                    <th>I</th>
                                    <th>II</th>
                                    <th>I</th>
                                    <th>II</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Kadar LEL</td>
                                </tr>
                                <tr>
                                    <td>Kadar O₂</td>
                                </tr>
                                <tr>
                                    <td>Kadar H₂S</td>
                                </tr>
                                <tr>
                                    <td>Kadar CO</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <table class="table table-bordered " style="width:100%; table-layout: fixed;">
                            <thead>
                                <tr>
                                    <th rowspan="4">Tanggal</th></tr>
                                    <th colspan="8">
                                        <div  class="flex justify-center">
                                            Parameter
                                        </div>
                                    </th>
                                <tr>
                                    <th colspan="2" class="flex">Kadar LEL</th>
                                    <th colspan="2">Kadar O₂</th>
                                    <th colspan="2">Kadar H₂S</th>
                                    <th colspan="2">Kadar CO</th>
                                </tr>
                                <tr>
                                    <th>I</th>
                                    <th>II</th>
                                    <th>I</th>
                                    <th>II</th>
                                    <th>I</th>
                                    <th>II</th>
                                    <th>I</th>
                                    <th>II</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tgl.</td>
                                </tr>
                                <tr>
                                    <td>Tgl.</td>
                                </tr>
                                <tr>
                                    <td>Tgl.</td>
                                </tr>
                                <tr>
                                    <td>Tgl.</td>
                                </tr>
                            </tbody>
                        </table>
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

function heightWorkPermit(panas){
    var titles = "Ijin Kerja Di Ketinggian"; 
    if (panas.checked){
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
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="perlindunganKetinggian{{$index}}">
                        <label class="block text-md font-medium" for="perlindunganKetinggian{{$index}}">
                            {{$title}}
                        </label>
                    </div>
                    @endforeach

                    <div class=" flex justify-end">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" name="selanjutnya" id="selanjutnya"onClick="nextClass('perlindunganKetinggianContent', 'pengendalianRisikoContent')">
                            Lanjut
                        </div>
                    </div>
                </div>
            </div>

            <div id="pengendalianRisiko">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Pengendalian risiko untuk Tangga / Scaffolding</span>
                </div>
                <div class="hidden" id="pengendalianRisikoContent">
                    <div>
                        <div class="p-1.5 pl-3"><i>Tangga</i></div>
                        @php 
                        $workTitle = [
                            "1. Struktur Ladder / Tangga dalam keadaan baik (tidak retak, kropos, dan bengkok)",
                            "2. Site Watcher / Penjaga Lokasi",
                            "3. Terpasang karet antislip",
                            "4. Kondisi engsel, kunci, pengait pada tangga baik (tidak retak, kropos, patah, kendur, dan bengkok)"
                            ];
                        @endphp
                        @foreach($workTitle as $index => $title)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="tangga{{$index}}">
                            <label class="block text-md font-medium" for="tangga{{$index}}">
                                {{$title}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div>
                        <div class="p-1.5 pl-3"><i>Scaffolding</i></div>
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
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="scaffolding{{$index}}">
                            <label class="block text-md font-medium" for="scaffolding{{$index}}">
                                {{$title}}
                            </label>
                        </div>
                        @endforeach
                        <div class="form-check flex items-center md:row-span-4 md:col-start-4 md:row-start-1 md:row-end-4">
                            <input class="form-check-input" type="checkbox" value="" id="extraScaffolding">
                            <label class="form-check-label block text-md font-medium" for="extraScaffolding">
                                10. <input type="text" id="extraTool" name="extraScaffolding" class="form-control rounded-lg w-3/4" style="height:100%;" placeholder="Lainnya...">
                            </label>
                        </div>
                    </div>
                    
                    <div class=" flex justify-end mt-5">
                        <div class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn" onClick="previousClass('pengendalianRisikoContent', 'perlindunganKetinggianContent')">
                            Kembali
                        </div>
                    </div>
                </div>
            </div>`
         });
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
            console.log(input);
            // Membuat label baru untuk error
            if(tempElement){
                tempElement.removeAttribute('style');
            }else{
                const newLabel = document.createElement('label');
                newLabel.id = input.id + '-error'; // Set ID
                newLabel.textContent = 'This field is required'; // Isi teks
                newLabel.classList.add('text-danger'); 
                input.parentNode.insertBefore(newLabel, input.nextSibling);
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
            $("a[href$='previous']").show()
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
    }
}


$(".validation-hse h6").on("click", function(e) {
    e.preventDefault();
});
</script>


@endpush

</x-app-layout>