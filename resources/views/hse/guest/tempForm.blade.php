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
    <div class="table-responsive">
        <table id="myTable" class=" w-full table table-bordered" style="width:100%;">
        <thead>
            <tr>
                <th class="px-2 py-3">No.</th>
                <th class="px-2 py-3">Status</th>
                <th class="px-2 py-3">Action</th>
                <th class="px-2 py-3">Delete</th>
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
        $('#myTable').DataTable({
            processing: true,
            ajax: {
                url: '{{ route("user.dashboard.data") }}', // Endpoint to fetch data
                type: 'GET',
                dataSrc: function (response) {
                    return response;
                }
            },
            columns: [
                { data: null, render: function(data, type, row, meta) { return meta.row + 1; } },
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
                            return `<div class="${statusClass}">${statusText} ${row.count}/3</div>`;
                        } else {
                            return `<div class="${statusClass}">${statusText}</div>`;
                        }
                    }
                },
                { data: null, name: 'view', render: function(data, type, row, meta) {
                        if(row.status === "Draft"){
                            return `
                            <form action="{{ route('view.form.hse') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="value" value="${row.id}">
                                <button type="submit" class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn">
                                    View Form
                                </button>
                            </form>
                            `;
                        }
                        
                        return ``;
                    }
                },
                { data: null, name: 'delete', render: function(data, type, row, meta) {
                        if(row.status === "Draft"){
                            return `
                            <form id="deleteForm${row.id}" action="{{ route('delete.form.hse') }}" method="POST">
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
</script>
@endpush