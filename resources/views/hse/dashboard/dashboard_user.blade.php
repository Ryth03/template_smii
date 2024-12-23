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

<div class="card mt-20 p-2">
    @can('create form hse')
    <div class="mx-2 my-4">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn"
            data-modal-target="createNewForm" data-modal-toggle="createNewForm">
                Create New Form
            </button>
    </div>
    @endcan
    <div class="mx-2 my-4">
        <a href="{{ route('tutorial.hse')}}" style="text-decoration: underline;">Panduan pengisian form</a>
    </div>
    <div class="box-body overflow-x-auto">
        <table id="myTable" class=" w-full table table-bordered" style="width:100%;">
            <thead>
                <tr>
                    <th class="px-2 py-3">Company / Department</th>
                    <th class="px-2 py-3">Location</th>
                    <th class="px-2 py-3">Date</th>
                    <th class="px-2 py-3">Status</th>
                    <th class="px-2 py-3">Action</th>
                </tr>
            </thead>
        <tbody>
        </tbody>
        </table>
    </div>
</div>

    {{-- Modal Terms --}}
    <div id="createNewForm" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full" style="margin-top: 5%">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex flex-col p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Create Form
                        </h3>
                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="createNewForm">
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
                <div class="p-4 md:p-5 flex flex-col items-center text-xl">
                    <div class="form-group flex flex-col w-full">
                        <label class="text-white">Create New Form</label>
                        <a href="{{route('permit.form')}}" class="self-center">
                            <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn">
                                Buat form baru
                            </button>
                        </a>
                    </div>
                    <div class="form-group w-full">
                        <label class="text-white">Extend Form</label>
                        <form action="{{route('extend.form')}}" method="POST" class="flex flex-col">
                            @csrf
                            <select name="value" id="value" class="form-select rounded-lg" required>
                            </select>
                            <button  class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn self-center">
                                Perpanjang formulir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>
    window.addEventListener('load', () => {
        getExtendForms();
    });
    $(document).ready(function() {
        var userId = @json(auth()->user()->id);
        var userRole = @json(auth()->user()->roles->pluck('name')->toArray());
        $('#myTable').DataTable({
            responsive: true,
            processing: true,
            ajax: {
                url: '{{ route("user.dashboard.data") }}', // Endpoint to fetch data
                type: 'GET',
                dataSrc: function (response) {
                    console.log(response);
                    return response;
                }
            },
            columns: [
                { data: 'company_department', name: 'company_department' },
                { data: 'location', name: 'location' },
                { data: null, name: 'date', render: function(data, type, row) {
                        return `${row.start_date} - ${row.end_date}`;
                    }
                },
                { data: 'status', name: 'status', render: function(data, type, row) {
                        let statusClass = '';
                        let statusText = data;
                        
                        if (data === 'Approved') {
                            statusClass = 'text-green-400';
                        } else if (data === 'Rejected') {
                            statusClass = 'text-red-400';
                        } else if (data === 'In Review') {
                            statusClass = 'text-yellow-400';
                        } else if (data === 'In Approval') {
                            statusClass = 'text-blue-400';
                        } else if (data === 'In Evaluation') {
                            statusClass = 'text-yellow-600';
                        }else if (data === 'Finished') {
                            statusClass = 'text-green-600';
                        } else {
                            statusClass = 'text-gray-400';
                        }

                        if (data === 'In Approval') {
                            return `<span class="${statusClass}">${statusText} ${row.count}/3</span>`;
                        } else {
                            return `<span class="${statusClass}">${statusText}</span>`;
                        }
                    }
                },
                { data: null, name: 'delete', render: function(data, type, row, meta) {
                        if(row.status === "Draft" && row.user_id === userId){
                            return `
                            <form action="{{ route('view.form.hse') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="value" value="${row.id}">
                                <button type="submit" class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn">
                                    View Form
                                </button>
                            </form>
                            <form id="deleteForm${row.id}" action="{{ route('delete.form.hse') }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="value" value="${row.id}">
                                <button type="button" class="text-red-600" onClick="confirmDelete(${row.id})">
                                    <i class="fas fa-trash">
                                    </i>
                                </button>
                            </form>
                            `;
                        }

                        if(userRole.includes('hse')){
                            if(row.status == "Rejected"){
                                return `
                                <form action="{{ route('report.hse') }}" method="POST" style="display: inline;">
                                @csrf
                                    <input type="hidden" name="value" value="${row.id}">
                                    <button class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                        <div>Report</div>
                                    </button>
                                </form>
                                `;
                            }else if(row.status == "Approved"){
                                let result = '';
                                let tanggal = new Date(row.start_date);
                                let now = new Date(); // Mendapatkan tanggal sekarang
                                let diffInMs = now - tanggal; // Menghitung selisih dalam milidetik
                                let diffInDays = diffInMs / (1000 * 3600 * 24); // Mengonversi milidetik menjadi hari
                                
                                if(diffInDays >= 3){ // Cek apakah hari ini adalah h+5 dari tanggal mulai kerja
                                    result = `
                                        <form action="{{ route('reminder.send') }}" method="POST" style="display: inline;">
                                        @csrf
                                            <input type="hidden" name="formId" value="${row.id}">
                                            <button type="button" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600" onClick="sendEmail(this)">
                                                <div>Send Reminder</div>
                                            </button>
                                        </form>
                                    `;
                                }
                                result += ` 
                                <form action="{{ route('finished.work') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="formId" value="${row.id}">
                                    <button type="button" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600" onClick="isWorkFinished(this)">
                                        <div>Finish</div>
                                    </button>
                                </form>
                                `;
                                return result;
                            }else if(row.status == "In Evaluation"){
                                return `
                                    <form action="{{ route('jobEvaluate.form') }}" method="POST" style="display: inline;">
                                    @csrf
                                        <input type="hidden" name="formId" value="${row.id}">
                                        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                            <div>Evaluate</div>
                                        </button>
                                    </form>
                                `;
                            }else if(row.status == "Finished"){
                                return `
                                <form action="{{ route('jobEvaluateReport.form') }}" method="POST" style="display: inline;">
                                @csrf
                                    <input type="hidden" name="formId" value="${row.id}">
                                    <button class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                        <div>View Report</div>
                                    </button>
                                </form>
                                <form action="{{ route('report.hse') }}" method="POST" style="display: inline;">
                                @csrf
                                    <input type="hidden" name="value" value="${row.id}">
                                    <button class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                        <div>Report</div>
                                    </button>
                                </form>
                                `;
                            }
                        }
                        else if(userRole.includes('engineering manager')){
                            if(row.status == "In Evaluation"){
                                return `
                                    <form action="{{ route('jobEvaluate.form') }}" method="POST" style="display: inline;">
                                    @csrf
                                        <input type="hidden" name="formId" value="${row.id}">
                                        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                            <div>Evaluate</div>
                                        </button>
                                    </form>
                                `;
                            }else if(row.status == "Finished"){
                                return `
                                <form action="{{ route('jobEvaluateReport.form') }}" method="POST" style="display: inline;">
                                @csrf
                                    <input type="hidden" name="formId" value="${row.id}">
                                    <button class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                        <div>View Report</div>
                                    </button>
                                </form>
                                `;
                            }
                        }
                        return ``;
                    }
                }
            ]
        });
    });

    function confirmDelete(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + id).submit();
            }
        });
    }

    function getExtendForms(){
        $.ajax({
            url: '{{ route('user.dashboard.extends') }}', // Route untuk mencari ide
            type: 'GET',
            success: function(response) {
                var select = document.getElementById('value');
                select.innerHTML+=`<option value="" selected disabled>Pilih Lokasi</option>`;
                response.forEach(function(data, index){
                    select.innerHTML += `
                        <option value="${data.id}">${data.location} (${data.start_date} - ${data.end_date})</option>
                    `;
                });
            }
        });
    }

    
    function isWorkFinished(button) {
        // SweetAlert2 confirmation dialog for finished work
        Swal.fire({
            title: "Confirmation",
            text: "Has the work been completed?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#26D639',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'Not yet'
        }).then((result) => {
            if (result.isConfirmed) {
                button.parentNode.submit();
                console.log(button.parentNode);
            }
        });
    }

    function sendEmail(button) {
        // SweetAlert2 confirmation dialog for send reminder email
        Swal.fire({
            title: "Confirmation",
            text: "Send the reminder email to user?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#26D639',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                button.parentNode.submit();
                console.log(button.parentNode);
            }
        });
    }
</script>
@endpush