<x-app-layout>
    @section('title')
        Extend Form
    @endsection
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
            .md\:grid-cols-12 {
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
    <form action="{{ route('hse.form.extend')}}" id="form" name="form" method="POST" class="validation-hse wizard-circle card py-10"  enctype="multipart/form-data">
        @csrf
        <!-- Step 1 -->
        <h6 class="text-md font-semibold mb-4">Ijin Kerja 1</h6>
        <section id="ijinKerja1">
            <div class="rounded-lg custom-bg-color" id="pelaksanaPekerjaan">
                <div class="p-1.5 pl-3 border rounded-lg mt-10" style="background-color: #A78734">
                    <span class="text-lg text-white">Pelaksana Pekerjaan</span>
                </div>
                <div class="p-2" id="pelaksanaPekerjaanContent">
                    <input type="hidden" name="formId" value="{{ $form->form_id }}">
                    <div class="grid flex justify-center md:grid-cols-4 sm:grid-cols-2">
                        @php 
                            $workTitle = ["Nama Perusahaan / Departemen","No HP","Tanggal Mulai Pelaksanaan", "Tanggal Berakhir Pelaksanaan","Penanggung Jawab Lapangan","Lokasi Pekerjaan","Jam Mulai Kerja","Jam Berakhir Kerja","Jumlah Tenaga Kerja", "Penjelasan Pekerjaan"];
                        @endphp
                        @foreach($workTitle as $title)
                            @if($title == "No HP")
                            <div class="form-group flex flex-col">
                                <label class="block text-md font-medium">{{$title}}</label>
                                <input type="number" placeholder="Input data" value="{{$form->hp_number}}" class="form-control rounded-lg w-3/4 text-gray-500" required disabled>
                            </div>
                            @elseif($title == "Tanggal Mulai Pelaksanaan")
                            <div class="form-group flex flex-col">
                                <label class="block text-md font-medium">{{$title}}</label>
                                <input type="date" value="{{$form->start_date}}" class="form-control flex rounded-lg w-3/4 text-gray-500"  readonly required>

                            </div>
                            @elseif($title == "Tanggal Berakhir Pelaksanaan")
                            <div class="form-group flex flex-col">
                                <label class="block text-md font-medium">{{$title}}</label>
                                <input type="date" value="{{$form->end_date}}" class="form-control flex rounded-lg w-3/4 text-gray-500" readonly required>
                            </div>
                            @elseif($title == "Jam Mulai Kerja" || $title == "Jam Berakhir Kerja")
                            <div class="form-group flex flex-col">
                                <label class="block text-md font-medium">{{$title}}</label>
                                <input type="time" value="{{$title == 'Jam Mulai Kerja' ? $form->start_time : $form->end_time}}" class="form-control flex rounded-lg w-3/4 text-gray-500" readonly required>                                    
                            </div>
                            @elseif($title == "Penjelasan Pekerjaan")
                            <div class="form-group flex flex-col md:col-span-3">
                                <label class="block text-md font-medium">{{$title}}</label>
                                <textarea class="form-control w-3/4 text-gray-500" style="resize: none;" rows="4" placeholder="Penjelasaan..." required disabled>{{$form->work_description}}</textarea>
                            </div>
                            @elseif($title == "Jumlah Tenaga Kerja")
                            <div class="form-group flex flex-col">
                                <label class="block text-md font-medium">{{$title}}</label>
                                <div class="flex w-3/4 items-center">
                                    <input type="number" value="{{$form->workers_count}}" class="form-control rounded-lg w-3/4 text-gray-500" placeholder="Input data" required disabled>
                                    <label class="p-2">orang</label>
                                </div>
                            </div>
                            @elseif($title == "Lokasi Pekerjaan")
                            <div class="form-group flex flex-col">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <select name="{{$title}}" id="{{$title}}" class="form-select rounded-lg w-3/4 text-gray-500" required disabled>
                                    <option value="" disabled>Pilih Lokasi</option>
                                    @foreach($locations as $location)
                                    <option value="{{$location}}" class="w-3/4"
                                        @if($location === $form->location )
                                            selected
                                        @endif>
                                        {{$location}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                            <div class="form-group flex flex-col">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <input type="text" value="{{$title == 'Nama Perusahaan / Departemen' ? $form->company_department : ($title == 'Penanggung Jawab Lapangan' ? $form->supervisor : '')}}" class="form-control rounded-lg w-3/4 text-gray-500" placeholder="Input data" required disabled>
                            </div>
                            @endif
                        @endforeach
                        <div class="form-group flex flex-col">
                            <label for="Tanggal Mulai Pelaksanaan" class="block text-md font-medium">Tanggal Mulai Pelaksanaan Baru</label>
                            <input type="date" id="Tanggal Mulai Pelaksanaan" name="Tanggal Mulai Pelaksanaan" class="form-control flex rounded-lg w-3/4" onchange="ubahTanggal()" readonly required>
                        </div>
                        <div class="form-group flex flex-col">
                            <label class="block text-md font-medium">Tanggal Berakhir Pelaksanaan Baru</label>
                            <input type="date" id="Tanggal Berakhir Pelaksanaan" name="Tanggal Berakhir Pelaksanaan" class="form-control flex rounded-lg w-3/4" readonly required>
                        </div>
                        
                        <div class="flex" style="justify-content: space-around;">
                            <div class="form-check flex flex-col p-1">
                                <input type="file" name="uploadSIO[]" id="SIO" class="form-control w-3/4 hidden" onchange="fileChange(this,'SIO')" multiple/>
                                <label for="SIO" style="cursor: pointer;">
                                    Input file SIO
                                    <i class="fa-solid fa-file-arrow-up"></i>
                                </label>
                            </div>
                            <div class="form-check flex flex-col p-1" >
                                <input type="file" name="uploadSILO[]" id="SILO" class="form-control w-3/4 hidden" onchange="fileChange(this,'SILO')" multiple/>
                                <label for="SILO" style="cursor: pointer;">
                                    Input file SILO
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
                                    <tr id="sioFile" style="border-top: 1px solid black">
                                        <th>Sio</th>
                                        <td class="break-all whitespace-normal p-2"></td>
                                    </tr>
                                    <tr id="siloFile" style="border-top: 1px solid black">
                                        <th>Silo</th>
                                        <td class="break-all whitespace-normal p-2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                
                </div>
            </div>
        </section>
    </form>
</div>


@push('scripts')
<script>
    window.onload = function() {
        var endDate = "<?php echo $form->end_date; ?>";
        var date = new Date(endDate);
        date.setDate(date.getDate() + 1); // Menambahkan 1 hari
        
        // Format tanggal baru (YYYY-MM-DD) untuk disetel ke input
        endDate = date.toISOString().split('T')[0];  // Mengambil hanya bagian YYYY-MM-DD
        document.getElementById("Tanggal Mulai Pelaksanaan").value = endDate; // Asign date ke element
        ubahTanggal(); // Jalankan untuk mengubah tanggal end_date
    };
var form = $(".validation-hse").show();

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

        document.getElementById("Tanggal Berakhir Pelaksanaan").value = nextDate.toISOString().split('T')[0];
    } else {
        document.getElementById('Tanggal Berakhir Pelaksanaan').value = '';
    }
};

function fileChange(input, tipe) {
    const files = input.files;
    const sioFile = document.getElementById('sioFile');
    const siloFile = document.getElementById('siloFile');
    var text = "";
    var count = 1;
    for (const file of files) {
        if(count==1){
            text += `<li>${file.name}</li>`;
        }
        else{
            text += `<li>${file.name}</li>`;
        }
        count++;
    }
    if(tipe=="SIO"){
        sioFile.innerHTML=`
            <th>Sio</th>
            <td class="break-all whitespace-normal p-2">
                ${text}
            </td>
        `;
    }else if(tipe=="SILO"){
        siloFile.innerHTML=`
            <th>Silo</th>
            <td class="break-all whitespace-normal p-2">
                ${text}
            </td>
        `;
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

</script>
@endpush

</x-app-layout>