<x-app-layout>
    @section('title')
        Security Dashboard
    @endsection

@push('css')
<style>
    table.dataTable thead .sorting:before, 
    table.dataTable thead .sorting:after, 
    table.dataTable thead .sorting_asc:before, 
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_desc:after  {
        bottom: 0.5em !important; 
    }
    .bg-modal{
        background-color: #00000094;
        height :100%;
    }
    table.dataTable th,
    table.dataTable td {
    width: auto !important;
    min-width: 20px; /* menambahkan lebar minimal kolom */
    }
</style>
@endpush
    <!-- <button class="btn bg-blue-500" onClick="getSecurityData()">Refresh Data</button> -->
<div class="box">
    <div class="box-header flex justify-center items-center">
        <div class="text-3xl font-medium">
            Today's Schedule
        </div>
    </div>
    <div class="box-body overflow-x-auto">
        <table id="myTable" class="w-full table table-bordered bg-opacty-50">
            <thead>
                <tr>
                    <th class="py-3">No.</th>
                    <th class="py-3">Company / Department</th>
                    <th class="py-3">Supervisor</th>
                    <th class="py-3">Location</th>
                    <th class="py-3">Date</th>
                    <th class="py-3">Workers</th>
                    <th class="py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
@push('scripts')
<script>
    
    window.addEventListener('load', () => {
        getSecurityData();
    });
    // $(document).ready(function() {
    //     getSecurityData();
    // });

    var table = $('#myTable').DataTable({
        
    });
    function getSecurityData(){
        $.ajax({
        url: '{{ route('security.dashboard.data') }}', // Route untuk mencari ide
        type: 'GET',
        data: { 
        category: 'test'
    },
    success: function(response) {
        // Bersihkan DataTable sebelum menambahkan data baru
        table.clear();

        console.log(response);
        const hasFileList = response.hasFileList;
        const files = response.files;
        const assetBaseUrl = "{{ asset('') }}";

        // Tambahkan data baris ke DataTable
        response.forms.forEach((form, index) => {
            // Menambahkan baris ke DataTable
            table.row.add([
                index + 1,                                  // Kolom pertama: nomor urut
                form.company_department,                     // Kolom kedua: departemen perusahaan
                form.supervisor,                             // Kolom ketiga: supervisor
                form.location,                               // Kolom keempat: lokasi
                `${form.start_date} - ${form.end_date}`,     // Kolom kelima: tanggal mulai - tanggal selesai
                form.workers_count,                          // Kolom keenam: jumlah pekerja
                // Kolom ketujuh: status dengan tombol SIO/SILO jika Approved dan ada file
                `
                    <div class="${form.status === 'Approved' ? 'text-green-400' :
                        form.status === 'Rejected' ? 'text-red-400' :
                        form.status === 'In Review' ? 'text-yellow-400' :
                        form.status === 'In Approval' ? 'text-blue-400' :
                        'text-gray-400'}">
                        ${form.status}
                        ${form.status === 'Approved' && hasFileList.includes(form.form_id) ? `
                            <button class="px-4 py-2 my-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600"
                            onClick="toggleModal('viewSioFile${index}')">
                                <label for="SIO" style="cursor: pointer;">
                                    SIO
                                    <i class="fa-solid fa-file"></i>
                                </label>
                            </button>
                            <div id="viewSioFile${index}" tabindex="-1" aria-hidden="false"
                                class="hidden bg-modal bg-opacity-50 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full flex" role="dialog">
                                <!-- Modal content SIO -->
                                <div class="relative  p-4 w-full max-w-lg max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex items-center justify-between  p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                File Sio
                                            </h3>
                                            <button type="button"
                                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                onClick="toggleModal('viewSioFile${index}')">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewbox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <div class="p-4 md:p-5">
                                            <ol class="p-2.5 space-y-4 list-decimal">
                                                ${files.map(file => (file.form_id === form.form_id && file.type === "SIO") ? `
                                                    <li>
                                                        <a href="${assetBaseUrl}storage/hseFile/${file.form_id}/${file.type}/${file.file_name}" target="_blank">
                                                            ${file.file_name}
                                                        </a>
                                                    </li>
                                                ` : '').join('')}
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600"
                            onClick="toggleModal('viewSiloFile${index}')">
                                <label for="SILO">
                                    SILO
                                    <i class="fa-solid fa-file"></i>
                                </label>
                            </button>
                            <div id="viewSiloFile${index}" tabindex="-1" aria-hidden="false"
                                class="hidden bg-modal bg-opacity-50 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full flex" role="dialog">
                                <!-- Modal content SILO -->
                                <div class="relative  p-4 w-full max-w-lg max-h-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="flex items-center justify-between  p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                File Silo
                                            </h3>
                                            <button type="button"
                                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                onClick="toggleModal('viewSiloFile${index}')">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewbox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <div class="p-4 md:p-5">
                                            <ol class="p-2.5 space-y-4 list-decimal">
                                                ${files.map(file => (file.form_id === form.form_id && file.type === "SILO") ? `
                                                    <li>
                                                        <a href="${assetBaseUrl}storage/hseFile/${file.form_id}/${file.type}/${file.file_name}" target="_blank">
                                                            ${file.file_name}
                                                        </a>
                                                    </li>
                                                ` : '').join('')}
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ` : ''}
                    </div>
                `
            ]).draw();
        });


        
    }
});

    }


function toggleModal(id){
    var modal = document.getElementById(id);
    modal.classList.toggle('hidden');
}
                            
</script>
@endpush
</x-app-layout>