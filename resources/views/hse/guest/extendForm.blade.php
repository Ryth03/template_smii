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
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <input type="number" id="{{$title}}" name="{{$title}}" placeholder="Input data" value="{{$form->hp_number}}" class="form-control rounded-lg w-3/4" required disabled>
                            </div>
                            @elseif($title == "Tanggal Mulai Pelaksanaan")
                            <div class="form-group flex flex-col">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <input type="date" id="{{$title}}" name="{{$title}}" value="{{$form->start_date}}" class="form-control flex rounded-lg w-3/4"  onchange="ubahTanggal()" required>

                            </div>
                            @elseif($title == "Tanggal Berakhir Pelaksanaan")
                            <div class="form-group flex flex-col">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <input type="date" id="{{$title}}" name="{{$title}}" value="{{$form->end_date}}" class="form-control flex rounded-lg w-3/4" readonly required>
                            </div>
                            @elseif($title == "Jam Mulai Kerja" || $title == "Jam Berakhir Kerja")
                            <div class="form-group flex flex-col">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <input type="time" id="{{$title}}" name="{{$title}}" value="{{$title == 'Jam Mulai Kerja' ? $form->start_time : $form->end_time}}" class="form-control flex rounded-lg w-3/4" required>                                    
                            </div>
                            @elseif($title == "Penjelasan Pekerjaan")
                            <div class="form-group flex flex-col md:col-span-3">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <textarea name="{{$title}}" id="{{$title}}" class="form-control w-3/4" style="resize: none;" rows="4" placeholder="Penjelasaan..." required disabled>{{$form->work_description}}</textarea>
                            </div>
                            @elseif($title == "Jumlah Tenaga Kerja")
                            <div class="form-group flex flex-col">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <div class="flex w-3/4 items-center">
                                    <input type="number" id="{{$title}}" name="{{$title}}" value="{{$form->workers_count}}" class="form-control rounded-lg w-3/4" placeholder="Input data" required disabled>
                                    <label for="{{$title}}" class="p-2">orang</label>
                                </div>
                            </div>
                            @elseif($title == "Lokasi Pekerjaan")
                            <div class="form-group flex flex-col">
                                <label for="{{$title}}" class="block text-md font-medium">{{$title}}</label>
                                <select name="{{$title}}" id="{{$title}}" class="form-select rounded-lg w-3/4" required disabled>
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
                                <input type="text" id="{{$title}}" name="{{$title}}" value="{{$title == 'Nama Perusahaan / Departemen' ? $form->company_department : ($title == 'Penanggung Jawab Lapangan' ? $form->supervisor : '')}}" class="form-control rounded-lg w-3/4" placeholder="Input data" required disabled>
                            </div>
                            @endif
                        @endforeach
                    </div>
                
                </div>
            </div>
        </section>
    </form>
</div>


@push('scripts')
<script>
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