@push('css')
    <style>
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc:after {
            bottom: 0.5em !important;
            /* Menghapus margin-bottom */
            /* padding-bottom: 0px; Menyesuaikan padding jika diperlukan */
        }
    </style>
@endpush

<div class="card mt-20 p-2">
    @can('create form hse')
        <div class="mx-2 my-4 flex justify-between">
            <button type="button" data-modal-target="guideModal" data-modal-toggle="guideModal"
                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Form Filling Guide</button>
        @endcan
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn"
            data-modal-target="createNewForm" data-modal-toggle="createNewForm">
            Create New Form
        </button>
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
                    <a href="{{ route('permit.form') }}" class="self-center">
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn">
                            Buat form baru
                        </button>
                    </a>
                </div>
                <div class="form-group w-full">
                    <label class="text-white">Extend Form</label>
                    <form action="{{ route('extend.form') }}" method="POST" class="flex flex-col">
                        @csrf
                        <select name="value" id="value" class="form-select rounded-lg" required>
                        </select>
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn self-center">
                            Perpanjang formulir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Guide --}}
<div id="guideModal" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 m-auto z-50 p-4 overflow-x-hidden overflow-y-auto bg-black bg-opacity-50 items-start justify-center hidden"
    aria-modal="true" role="dialog" style="z-index: 1002">
    <div class="relative w-full max-w-lg max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex flex-col p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Tutorial Video
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="guideModal" onclick="stopVideo()">
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
                <div class="form-group w-full mt-4">
                    <video id="tutorialVideo" controls class="w-full h-auto rounded-lg">
                        <source src="{{ asset('assets/video/tutorHSE.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Extended Modal -->
<div id="extendModal" tabindex="-1" aria-hidden="false"
    class="hidden bg-modal bg-opacity-50 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full flex"
    role="dialog">
    <!-- Modal content SIO -->
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
                layout: {
                    top1: 'searchBuilder'
                },
                order: [7, 'desc'],
                responsive: true,
                processing: true,
                ajax: {
                    url: '{{ route('user.dashboard.data') }}', // Endpoint to fetch data
                    type: 'GET',
                    dataSrc: function(response) {
                        return response;
                    }
                },
                columns: [{
                        data: 'company_department',
                        name: 'company_department',
                        render: function(data, type, row) {
                            return `${row.company_department}`;
                        }
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: null,
                        name: 'date',
                        render: function(data, type, row) {
                            return `${row.start_date} - ${row.end_date}`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            let statusClass = '';
                            let statusText = data;

                            if (data === 'Approved') {
                                statusClass = 'bg-green-400';
                            } else if (data === 'Rejected') {
                                statusClass = 'bg-red-400';
                            } else if (data === 'In Review') {
                                statusClass = 'bg-yellow-400';
                            } else if (data === 'In Approval') {
                                statusClass = 'bg-blue-600';
                            } else if (data === 'In Evaluation') {
                                statusClass = 'bg-yellow-600';
                            } else if (data === 'Finished') {
                                statusClass = 'bg-green-600';
                            } else {
                                statusClass = 'bg-gray-900';
                            }

                            if (data === 'In Approval') {
                                return `<span class="${statusClass} text-white px-2 py-1 rounded"> ${statusText}</span>`;
                            }else if (data === 'In Evaluation') {
                                return `<span class=" text-white px-2 py-1 rounded ${statusClass}">${statusText}</span>`;
                            } else {
                                return `<span class="${statusClass} text-white px-2 py-1 rounded">${statusText}</span>`;
                            }

                        }
                    },
                    {
                        data: null,
                        name: 'delete',
                        render: function(data, type, row, meta) {
                            if (row.status === "Draft" && row.user_id === userId) {
                                const route = "{{ route('view.form.hse', ':formId') }}";
                                const url = route.replace(':formId', row.id);
                                return `
                                <a href="${url}" class="btn btn-sm btn-primary tooltip" title="Look and Edit Draft"> 
                                    <i class="fas fa-eye"></i>
                                </a>
                            <form id="deleteForm${row.id}" action="{{ route('delete.form.hse') }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="value" value="${row.id}">
                                <button type="button" class="btn btn-sm btn-danger tooltip" title="Delete Draft" onClick="confirmDelete(${row.id})">
                                    <i class="fas fa-trash">
                                    </i>
                                </button>
                            </form>
                            `;
                            }

                            if (row.status === "In Approval") {
                                return `<span class="btn btn-sm bg-blue-600 text-white text-lg tooltip" title="Approval Tracking ${row.count}/3" style="pointer-events: none;">${row.count}/3</span>`;
                            }

                            if (userRole.includes('hse')) {
                                const route = "{{ route('report.hse', ':formId') }}";
                                const url = route.replace(':formId', row.id);
                                let result = '';
                                
                                if (row.status == "Rejected") {
                                    result += `
                                <form action="${url}" method="POST" style="display: inline;">
                                @csrf
                                    <input type="hidden" name="value" value="${row.id}">
                                    <button class="btn btn-sm btn-danger tooltip" title="Download Report">
                                        <i class="fas fa-file-alt"></i>
                                    </button>
                                </form>
                                `;
                                } else if (row.status == "Approved") {
                                    let tanggal = new Date(row.start_date);
                                    let now = new Date();
                                    let diffInMs = now - tanggal;
                                    let diffInDays = diffInMs / (1000 * 3600 * 24);

                                    if (diffInDays >= 3) {
                                        result = `
                                        <form action="{{ route('reminder.send') }}" method="POST" style="display: inline;">
                                        @csrf
                                            <input type="hidden" name="formId" value="${row.id}">
                                            <button type="button" class="btn btn-sm btn-warning tooltip" title="Send Reminder" onClick="sendEmail(this)">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                        </form>
                                    `;
                                    }
                                    result += `
                                <form action="{{ route('finished.work') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="formId" value="${row.id}">
                                    <button type="button" class="btn btn-sm btn-success tooltip" title="Finish Work" onClick="isWorkFinished(this)">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                `;
                                } else if (row.status == "In Evaluation") {
                                    const route = "{{ route('jobEvaluate.form', ':formId') }}";
                                    const url = route.replace(':formId', row.id);
                                    result += `
                                    <div class="flex items-center">
                                        <span class="badge bg-yellow-600 text-white text-lg tooltip items-center justify-center" title="Evaluation Tracking ${row.count_rating}/2" style="pointer-events: none;">${row.count_rating}/2</span>
                                        <a href="${url}">
                                            <button class="px-3 py-1 ml-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 tooltip" title="Evaluate">
                                                <i class="fas fa-list"></i>
                                            </button>
                                        </a>
                                    </div>
                                `;

                                } else if (row.status == "Finished") {
                                    const route = "{{ route('jobEvaluateReport.form', ':formId') }}";
                                    const url = route.replace(':formId', row.id);
                                    
                                    const route2 = "{{ route('report.hse', ':formId') }}";
                                    const url2 = route2.replace(':formId', row.id);

                                    result += `
                                    <a href="${url}" class="btn btn-sm btn-primary tooltip" title="View Report">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                    <form action="${url2}" method="POST" style="display: inline;">
                                    @csrf
                                        <input type="hidden" name="value" value="${row.id}">
                                        <button class="btn btn-sm btn-secondary tooltip" title="Download Report">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </form>
                                    `;
                                }

                                if (row.extendedCounts > 0) {
                                    result += `
                                    <label for="modal" style="cursor: pointer;" onClick="toggleModal(${row.id})">
                                        <i class="fa fa-eye fa-lg"></i>
                                    </label>
                                `;
                                }
                                return result;
                            } else if (userRole.includes('engineering manager')) {
                                if (row.status == "In Evaluation") {
                                    const route = "{{ route('jobEvaluate.form', ':formId') }}";
                                    const url = route.replace(':formId', row.id);

                                    return `
                                    <div class="flex items-center ">
                                        <span class="badge bg-yellow-600 text-white text-lg tooltip items-center justify-center" title="Evaluation Tracking ${row.count_rating}/2" style="pointer-events: none;">${row.count_rating}/2</span>
                                        <a href="${url}">
                                            <button class="px-3 py-1 ml-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 tooltip" title="Evaluate">
                                                <i class="fas fa-list"></i>
                                            </button>
                                        </a>
                                    </div>
                                `;
                                } else if (row.status == "Finished") {
                                    const route = "{{ route('jobEvaluateReport.form', ':formId') }}";
                                    const url = route.replace(':formId', row.id);
                                    return `
                                    <a href="${url}" class="btn btn-sm btn-primary tooltip" title="View Report">
                                        <i class="fas fa-file-alt"></i>
                                    </a>
                                    `;
                                }
                            }
                            return ``;
                        }
                    }
                ]
            });
        });

        function confirmDelete(id) {
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

        function getExtendForms() {
            $.ajax({
                url: '{{ route('user.dashboard.extends') }}', // Route untuk mencari ide
                type: 'GET',
                success: function(response) {
                    var select = document.getElementById('value');
                    select.innerHTML += `<option value="" selected disabled>Pilih Lokasi</option>`;
                    response.forEach(function(data, index) {
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
                }
            });
        }

        function toggleModal(id) {
            var modal = document.getElementById('extendModal');
            $.ajax({
                url: '{{ route('user.dashboard.extend.history') }}', // Route untuk mencari ide
                type: 'GET',
                data: {
                    formId: id
                },
                success: function(response) {
                    modal.innerHTML = `
                    <div class="relative  p-4 w-full max-w-4xl max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <div class="flex items-center justify-between  p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Extend Form History
                                </h3>
                                <button type="button"
                                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    onClick="closeModal()">
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
                                    ${response.map((form) => {
                                        return `
                                                    <li class="text-white">
                                                       Start Date: ${form.start_date_before} - ${form.end_date_before}, End Date: ${form.start_date_after} - ${form.end_date_after}
                                                    </li>
                                                    `;
                                    }).join('')}
                                </ol>
                            </div>
                        </div>
                    </div>
                `;
                    modal.classList.toggle('hidden');
                }
            });

        }

        function closeModal() {
            var modal = document.getElementById('extendModal');
            modal.classList.toggle('hidden');
        }

        function stopVideo() {
            var video = document.getElementById('tutorialVideo');
            video.pause();
            video.currentTime = 0;
        }

        // document.getElementById('guideModal').addEventListener('show.bs.modal', function() {
        //     var video = document.getElementById('tutorialVideo');
        //     video.play();
        // });
    </script>
@endpush
