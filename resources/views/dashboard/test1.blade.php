<x-app-layout>
    @push('css')
    <style>
        [type="checkbox"]+label{
            color: unset;
        }
        [type="radio"]:not(:checked)+label, [type="radio"]:checked+label{
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
    </style>
    @endpush

<div class="box-body wizard-content">
    <form id="form" name="form" method="POST" class="validation-hse wizard-circle card p-10">
        @csrf
        <!-- Step 1 -->
        <h6 class="text-md font-semibold mb-4">Form - HSE Dept</h6>
        <section>
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
                            <div id="addButtonTenagaKerja" class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn flex flex-row">
                                <i class="fas fa-plus">
                                </i>
                                Tambah
                            </div>
                            <div id="removeButtonTenagaKerja" class="mx-2 px-4 py-2  text-white rounded-lg hover:bg-red-600 btn bg-red-500 ml-4 btn flex flex-row" >
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
        <!-- <section>
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

        </section> -->
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
        error.insertAfter(element)
    }
    , rules: {
        email: {
            email: !0
        }
    }
});



function hotWorkPermit(panas){
    if (panas.checked){
        var judul = "test content";
        var isi = "test isi";
        $(".validation-hse").steps('insert', 1, { title: 'Hot Work Permit', content: 'blablalbalblabla' });
        // $('#example-manipulation').steps('insert', Number($('#position-3').val()), { title: $('#title2-3').val(), content: $('#text2-3').val() });
        
    }else{
        var titles = "Hot Work Permit"; 
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
    if (panas.checked){
        var judul = "test content";
        var isi = "test isi";
        $(".validation-hse").steps('insert', 1, { title: 'Confined Space Permit', content: 'blablalbalblabla' });
        // $('#example-manipulation').steps('insert', Number($('#position-3').val()), { title: $('#title2-3').val(), content: $('#text2-3').val() });
        
    }else{
        var titles = "Confined Space Permit"; 
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
    if (panas.checked){
        var judul = "test content";
        var isi = "test isi";
        $(".validation-hse").steps('insert', 1, { title: 'Height Work Permit', content: 'blablalbalblabla' });
        // $('#example-manipulation').steps('insert', Number($('#position-3').val()), { title: $('#title2-3').val(), content: $('#text2-3').val() });
        
    }else{
        var titles = "Height Work Permit"; 
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
        console.log('ini submit');
        const tempElement = document.getElementById(input.id + '-error');
        // Kondisi ketika element yang required tidak diisi
        if (input.value.trim() == '') {
            allFilled = false;
            console.log(input);
            // Membuat label baru untuk error
            if(tempElement){
                console.log('ada nih:');
                tempElement.style.display='none';
            }else{
                const newLabel = document.createElement('label');
                newLabel.id = input.id + '-error'; // Set ID
                newLabel.setAttribute('for', input.id);
                newLabel.textContent = 'This field is required'; // Isi teks
                newLabel.classList.add('text-danger'); 
                input.parentNode.insertBefore(newLabel, input.nextSibling);
            }
        }else{
            if(tempElement){
                tempElement.remove();
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
                            <label class="block text-md font-medium" for="penyimpanan{{$index}}">
                                {{$title}}
                            </label>
                        </div>
                        <div class="mt-1 grid grid-cols-3">
                            <div class="flex relative">
                                <input class="form-check-input" type="radio" value="ya" id="penyimpanan{{$index}}ya" name="penyimpanan{{$index}}" required>
                                <label for="penyimpanan{{$index}}ya" class="md:hidden" style="padding-left:25px;">Ya</label>
                            </div>
                            <div class="flex relative">
                                <input class="form-check-input" type="radio" value="tidak" id="penyimpanan{{$index}}tidak" name="penyimpanan{{$index}}">
                                <label for="penyimpanan{{$index}}tidak" style="padding-left:25px;">Tidak</label>
                            </div>
                            <div class="flex relative">
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
                            <div class="flex relative">
                                <input class="form-check-input" type="radio" value="ya" id="operasional{{$index}}ya" name="operasional{{$index}}" required>
                                <label for="operasional{{$index}}ya" class="md:hidden" style="padding-left:25px;">Ya</label>
                            </div>
                            <div class="flex relative">
                                <input class="form-check-input" type="radio" value="tidak" id="operasional{{$index}}tidak" name="operasional{{$index}}">
                                <label for="operasional{{$index}}tidak" style="padding-left:25px;">Tidak</label>
                            </div>
                            <div class="flex relative">
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


// Function untuk Step 2
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

</script>
@endpush

</x-app-layout>