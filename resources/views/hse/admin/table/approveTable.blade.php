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
        .col-start-1 {
            grid-column-start: 1;
        }
        
    </style>
    @endpush

<div class="box">
    <div class="box-header flex justify-center items-center">
        <div class="text-3xl font-medium">
            Approve List
        </div>
    </div>
    <div class="box-body overflow-x-auto">
        <table class="w-full table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Perusahaan / Departemen</th>
                    <th>Penanggung Jawab Lapangan</th>
                    <th>Lokasi Pekerjaan</th>
                    <th>No. Hp</th>
                    <th>Tanggal</th>
                    <th>Jam Kerja</th>
                    <th>Jumlah Tenaga Kerja</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $datas = [
                        ["Departemen", "Zaki", "Kantor", "0818123456", "10-10-2024 - 18-10-2024", "08:00 - 17:00", "8", "InApprove"],
                        ["Departemen", "Zaki", "Kantor", "0818123456", "10-10-2024 - 18-10-2024", "08:00 - 17:00", "8", "Approved"]
                    ];
                @endphp
                @foreach($datas as $index => $data)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$data[0]}}</td>
                    <td>{{$data[1]}}</td>
                    <td>{{$data[2]}}</td>
                    <td>{{$data[3]}}</td>
                    <td>{{$data[4]}}</td>
                    <td>{{$data[5]}}</td>
                    <td>{{$data[6]}}</td>
                    <td>
                    @if($data[7] == "Approved")
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 cursor-not-allowed">
                            <div>Approved</div>
                        </button>
                    @else
                        <a href="{{ route('approve.form') }}">
                            <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                <div>Approve</div>
                            </button>
                        </a>
                    @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</x-app-layout>