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
            .md\:grid-cols-5 {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }
            .md\:grid-cols-16 {
                grid-template-columns: repeat(16, minmax(0, 1fr));
            }
            .md\:col-span-15 {
                grid-column: span 15 / span 15;
            }
            .md\:justify-center {
                justify-content: center
            }
            .md\:col-span-3 {
                grid-column: span 3/span 3
            }
        }
        .table-bordered, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th, 
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th{
            border: 1px solid black !important;
        }
    </style>
    @endpush

<div class="box-body wizard-content">
    
    <div class="card p-10">
        <div class="box-body">
            <table class="w-full table table-bordered" style="border-color:black !important;">
                <thead>
                    <tr>
                        <th class="text-center">Perusahaan / Departemen</th>
                        <th class="text-center">Penanggung Jawab Lapangan</th>
                        <th class="text-center">Lokasi Pekerjaan</th>
                        <th class="text-center">No. Hp</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Jam Kerja</th>
                        <th class="text-center">Jumlah Tenaga Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$form->company_department}}</td>
                        <td>{{$form->supervisor}}</td>
                        <td>{{$form->location}}</td>
                        <td>{{$form->hp_number}}</td>
                        <td>{{$form->start_date}} - {{$form->end_date}}</td>
                        <td>{{$form->start_time}} - {{$form->end_time}}</td>
                        <td>{{$form->workers_count}}</td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <p class="text-justify">
                                <strong>Penjelasan Pekerjan :</strong>
                                {{$form->work_description}}
                            </p> 
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <form action="{{ route('update.form.hse') }}" id="form" name="form" method="POST" class="validation-hse wizard-circle card py-10">
        @csrf
        @if ($permits->contains('master_id', 4))
        <!-- Step 1 -->
        <h6 class="">Scaffolding</h6>
        <section id="scaffolding">
            <div id="pengendalianRisikoScaffolding">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Pengendalian risiko untuk Scaffolding</span>
                </div>

                <div class="" id="pengendalianRisikoScaffoldingContent">
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
                                    <input class="form-check-input" type="checkbox" value="yes" id="penyimpanan{{$index}}ya" name="scaff{{$index}}" onclick="toggleCheckbox(this)" required>
                                    <label for="penyimpanan{{$index}}ya" style="padding-left:25px;">Ya</label>
                                </div>
                                <div class="flex">
                                    <input class="form-check-input" type="checkbox" value="no" id="penyimpanan{{$index}}tidak" name="scaff{{$index}}" onclick="toggleCheckbox(this)">
                                    <label for="penyimpanan{{$index}}tidak" style="padding-left:25px;">Tidak</label>
                                </div>
                                <div class="flex">
                                    <input class="form-check-input" type="checkbox" value="na" id="penyimpanan{{$index}}n/a" name="scaff{{$index}}" onclick="toggleCheckbox(this)">
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
                                    <input class="form-check-input" type="checkbox" value="yes" id="operasional{{$index}}ya" name="scaff{{$index}}" onclick="toggleCheckbox(this)" required>
                                    <label for="operasional{{$index}}ya" style="padding-left:25px;">Ya</label>
                                </div>
                                <div class="flex">
                                    <input class="form-check-input" type="checkbox" value="no" id="operasional{{$index}}tidak" name="scaff{{$index}}" onclick="toggleCheckbox(this)">
                                    <label for="operasional{{$index}}tidak" style="padding-left:25px;">Tidak</label>
                                </div>
                                <div class="flex">
                                    <input class="form-check-input" type="checkbox" value="na" id="operasional{{$index}}n/a" name="scaff{{$index}}" onclick="toggleCheckbox(this)">
                                    <label for="operasional{{$index}}n/a" style="padding-left:25px;">N/A</label>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

        </section>
        @endif

        @if ($permits->contains('master_id', 2))
        <!-- Step 2 -->
        <h6 class="">Tes Kadar</h6>
        <section id="suhu">
            <div id="tesSuhu">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Hasil Tes Kadar</span>
                </div>
                <div class="" id="tesSuhuContent">
                <div class="flex flex-col justify-center">
                    <div class="flex items-center flex-wrap">
                        <div class="p-1.5 pl-3 font-medium"><strong><i>Kadar <span class="ml-2">{{ date('d F Y') }}</span></i></strong></div>
                    </div>
                    <div class="flex">
                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <div class="form-group flex items-center">
                                <label for="LEL" class="block text-md font-medium">Kadar Low Explosive Level (LEL)</label>
                            </div>
                            <div class="form-group flex items-center">
                                <input type="number" id="LEL" name="LEL" class="form-control rounded-lg w-3/4" required>
                                <label for="LEL" class="block text-md font-medium ml-2">%</label>
                            </div>
                            <div class="form-group flex items-center">
                                <label for="CO" class="block text-md font-medium">Kadar Carbon Monoxide (CO)</label>
                            </div>
                            <div class="form-group flex items-center">
                                <input type="number" id="CO" name="CO" class="form-control rounded-lg w-3/4" required>
                                <label for="CO" class="block text-md font-medium ml-2">ppm</label>
                            </div>
                            <div class="form-group flex items-center">
                                <label for="O2" class="block text-md font-medium">Kadar Oxygen (O₂)</label>
                            </div>
                            <div class="form-group flex items-center">
                                <input type="number" id="O2" name="O2" class="form-control rounded-lg w-3/4" required>
                                <label for="O2" class="block text-md font-medium ml-2">%</label>
                            </div>
                            <div class="form-group flex items-center">
                                <label for="H2S" class="block text-md font-medium">Kadar Hydrogen Sulfide (H₂S)</label>
                            </div>
                            <div class="form-group flex items-center">
                                <input type="number" id="H2S" name="H2S" class="form-control rounded-lg w-3/4" required>
                                <label for="H2S" class="block text-md font-medium ml-2">ppm</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        @endif

        <h6 class="">Tenaga Kerja</h6>
        <section id="ijinKerja1">
            <div id="statusTenagaKerja">
                <div class="p-1.5 pl-3 border rounded-lg my-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Surat Ijin Kerja</span>
                </div>
                <div class="" id="statusTenagaKerjaContent">
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
                                                <input type="checkbox" name="tenagaKerja{{$id}}" id="ok{{$id}}" value="ok" onclick="toggleCheckbox(this)" required>
                                                <label for="ok{{$id}}"><span class="md:hidden">OK</span></label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="tenagaKerja{{$id}}" id="notOk{{$id}}" value="notOk" onclick="toggleCheckbox(this)" required>
                                                <label for="notOk{{$id}}"><span class="md:hidden">NOT OK</span></label>
                                            </div>
                                            <div>
                                                <input type="checkbox" name="tenagaKerja{{$id}}" id="cekKlinik{{$id}}" value="cekKlinik" onclick="toggleCheckbox(this)" required>
                                                <label for="cekKlinik{{$id}}"><span class="md:hidden">Cek Klinik</span></label>
                                            </div>
                                        </div>
                                        <div class="col-span-3">
                                            <input type="text" id="clinicRecomendation{{$id}}" name="clinicRecomendation{{$id}}" class="form-control rounded-lg w-full" placeholder="Input data">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
             
            <input type="hidden" name="value" value="{{ $form->form_id }}">                   
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
    , enableAllSteps: true
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
        // SweetAlert2 confirmation dialog for submit action
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#26D639',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#form").submit();
            }
        });
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

function toggleCheckbox(checkbox) {
    const name = checkbox.name;
    const checkboxes = document.querySelectorAll(`input[name="${name}"]:checked`);
    checkboxes.forEach((cb) => {
        if (cb !== checkbox) {
            cb.checked = false; // Uncheck all other checkboxes
        }
    });
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

</script>
@endpush

</x-app-layout>