<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard HSE') }}
        </h2>
    </x-slot>
    @push('css')
    <style>
        table.dataTable thead .sorting:before, 
        table.dataTable thead .sorting:after, 
        table.dataTable thead .sorting_asc:before, 
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc:after  {
            bottom: 0.5em !important; 
            /* Menghapus margin-bottom */
            /* padding-bottom: 0px; Menyesuaikan padding jika diperlukan */
        }
    </style>
    @endpush

<div class="box">
    <div class="box-header flex justify-center items-center">
        <div class="text-3xl font-medium">
            Today's Schedule
        </div>
    </div>
    <div class="box-body overflow-x-auto">
        <table id="myTable" class="w-full table">
            <thead>
                <tr>
                    <th class="py-3">No.</th>
                    <th class="py-3">Perusahaan / Departemen</th>
                    <th class="py-3">Penanggung Jawab Lapangan</th>
                    <th class="py-3">Tanggal</th>
                    <th class="py-3">Jam Kerja</th>
                    <th class="py-3">Jumlah Tenaga Kerja</th>
                    <th class="py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($forms as $index => $form)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$form->company_department}}</td>
                    <td>{{$form->supervisor}}</td>
                    <td>{{$form->start_date}} - {{$form->end_date}}</td>
                    <td>{{$form->start_time}} - {{$form->end_time}}</td>
                    <td>{{$form->workers_count}}</td>
                    <td>
                        <div class="{{$form->status == 'Approved' ? 'text-green-400' : ($form->status == 'Rejected' ? 'text-red-400' : ($form->status == 'In Review' ? 'text-yellow-400' : ($form->status == 'In Approval' ? 'text-blue-400' : 'text-gray-400')))}}">
                            {{ $form->status }}
                            @if($form->status == "Approved" && $idList->contains($form->form_id))
                                <button class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600"
                                data-modal-target="viewSioFile" data-modal-toggle="viewSioFile">
                                    <label for="SIO">
                                        SIO
                                        <i class="fa-solid fa-file"></i>
                                    </label>
                                </button>
                                {{-- Modal Sio --}}
                                <div id="viewSioFile" tabindex="-1" aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-lg max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div class="flex flex-col p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        File Sio
                                                    </h3>
                                                    <button type="button"
                                                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="viewSioFile">
                                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewbox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="p-4 md:p-5">
                                                <div class="text-justify  text-gray-900 dark:text-white">
                                                    <ol class="p-2.5 space-y-4 list-decimal">
                                                        @foreach($files as $file)
                                                            @if($file->form_id === $form->form_id && $file->type === "SIO")
                                                            <li>
                                                                <a href="{{ asset('storage/hseFile/' . $file->form_id . '/' . $file->type . '/' . $file->file_name) }}" target="_blank">
                                                                {{$file->file_name}}
                                                                </a>
                                                            </li>
                                                            @endif
                                                        @endforeach
                                                    </ol>
                                                    <div class="flex items-center justify-center">
                                                        <button type="button" data-modal-hide="viewSioFile" class="bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 transition duration-200">
                                                            <span>Close</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600"
                                data-modal-target="viewSiloFile" data-modal-toggle="viewSiloFile">
                                    <label for="SILO">
                                        SILO
                                        <i class="fa-solid fa-file"></i>
                                    </label>
                                </button>
                                {{-- Modal Silo --}}
                                <div id="viewSiloFile" tabindex="-1" aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-lg max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div class="flex flex-col p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        File Silo
                                                    </h3>
                                                    <button type="button"
                                                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="viewSiloFile">
                                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewbox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="p-4 md:p-5">
                                                <div class="text-justify  text-gray-900 dark:text-white">
                                                    <ol class="p-2.5 space-y-4 list-decimal">
                                                        @foreach($files as $file)
                                                            @if($file->form_id === $form->form_id && $file->type === "SILO")
                                                            <li>
                                                                <a href="{{ asset('storage/hseFile/' . $file->form_id . '/' . $file->type . '/' . $file->file_name) }}" target="_blank">
                                                                {{$file->file_name}}
                                                                </a>
                                                            </li>
                                                            @endif
                                                        @endforeach
                                                    </ol>
                                                    <div class="flex items-center justify-center">
                                                        <button type="button" data-modal-hide="viewSiloFile" class="bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 transition duration-200">
                                                            <span>Close</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
           
        });
    });
</script>
@endpush
</x-app-layout>