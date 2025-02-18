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
            table.dataTable thead .sorting_desc:after {
                bottom: 0.5em !important;
            }

            .bg-modal {
                background-color: #00000094;
                height: 100%;
            }

            table.dataTable th,
            table.dataTable td {
                width: auto !important;
                min-width: 20px;
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
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

        <script>
            window.addEventListener('load', () => {
                getSecurityData();
            });

            var table = $('#myTable').DataTable({

            });

            function getSecurityData() {
                $.ajax({
                    url: '{{ route('security.dashboard.data') }}', // Route untuk mencari ide
                    type: 'GET',
                    success: function(response) {
                        console.log(response);

                        // Bersihkan DataTable sebelum menambahkan data baru
                        table.clear();

                        const hasFileList = response.hasFileList;
                        const files = response.files;
                        const assetBaseUrl = "{{ asset('') }}";

                        // Tambahkan data baris ke DataTable
                        response.forms.forEach((form, index) => {
                            console.log(form.status, hasFileList.includes(form.id));

                            // Menambahkan baris ke DataTable
                            table.row.add([
                                index + 1, // Kolom pertama: nomor urut
                                form.project_executor.company_department, // Kolom kedua: departemen perusahaan
                                form.project_executor.supervisor, // Kolom ketiga: supervisor
                                form.project_executor.location, // Kolom keempat: lokasi
                                `${moment(form.project_executor.start_date).format('DD MMM YY')} - ${moment(form.project_executor.end_date).format('DD MMM YY')}`, // Kolom kelima: tanggal mulai - tanggal selesai
                                form.project_executor.workers_count, // Kolom keenam: jumlah pekerja
                                // Kolom ketujuh: status dengan tombol SIO/SILO jika Approved dan ada file
                                `
                                <div class="btn btn-sm text-center ${form.status === 'Approved' ? 'btn-success' :
                                    form.status === 'Rejected' ? 'btn-danger' :
                                    form.status === 'In Review' ? 'btn-warning' :
                                    form.status === 'In Approval' ? 'btn-info' :
                                    'btn-secondary'}" style="cursor: default;">
                                    ${form.status}
                                </div>
                                ${form.status === 'Approved' && hasFileList.includes(form.id) ? `
                                    <div class="flex space-x-2 my-2">
                                        <button class="flex-1 px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600"
                                        onClick="toggleModal('viewSioFile${index}')">
                                            <label for="SIO">
                                                SIO
                                                <i class="fa-solid fa-file"></i>
                                            </label>
                                        </button>
                                        <button class="flex-1 px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600"
                                        onClick="toggleModal('viewSiloFile${index}')">
                                            <label for="SILO">
                                                SILO
                                                <i class="fa-solid fa-file"></i>
                                            </label>
                                        </button>
                                    </div>
                                    <div id="viewSioFile${index}" class="hidden bg-modal bg-opacity-50 fixed inset-0 z-50 flex justify-center items-center" style="z-index:1002">
                                        <div class="relative w-full max-w-lg bg-dark rounded-lg shadow">
                                            <div class="p-4 border-b flex justify-between">
                                                <h3 class="text-lg font-semibold">File SIO</h3>
                                                <button class="text-gray-400 hover:text-gray-600" onClick="toggleModal('viewSioFile${index}')">✖</button>
                                            </div>
                                            <div class="p-4">
                                                <div class="swiper-container" style="width: 100%; height: 400px;">
                                                    <div class="swiper-wrapper">
                                                        ${files
                                                            .filter(file => file.form_id === form.id && file.type === 'SIO')
                                                            .map(file => {
                                                                const fileUrl = `${assetBaseUrl}storage/hseFile/${file.form_id}/${file.type}/${file.file_name}`;
                                                                const fileExtension = file.file_name.split('.').pop().toLowerCase();
                                                                return `
                                                                    <div class="swiper-slide">
                                                                        ${fileExtension === 'pdf' ? `
                                                                            <embed src="${fileUrl}" width="100%" height="400">
                                                                        ` : `
                                                                            <img src="${fileUrl}" width="100%" height="100%">
                                                                        `}
                                                                        <p class="text-center">${file.file_name}</p>
                                                                    </div>`;
                                                            })
                                                            .join('')}
                                                    </div>
                                                    ${files.filter(file => file.form_id === form.id && file.type === 'SIO').length > 1 ? `
                                                        <div class="swiper-button-next"></div>
                                                        <div class="swiper-button-prev"></div>
                                                    ` : ''}
                                                    <div class="swiper-pagination"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="viewSiloFile${index}" class="hidden bg-modal bg-opacity-50 fixed inset-0 z-50 flex justify-center items-center" style="z-index:1002">
                                        <div class="relative w-full max-w-lg bg-dark rounded-lg shadow">
                                            <div class="p-4 border-b flex justify-between">
                                                <h3 class="text-lg font-semibold">File SILO</h3>
                                                <button class="text-gray-400 hover:text-gray-600" onClick="toggleModal('viewSiloFile${index}')">✖</button>
                                            </div>
                                            <div class="p-4">
                                                <div class="swiper-container" style="width: 100%; height: 400px;">
                                                    <div class="swiper-wrapper">
                                                        ${files
                                                            .filter(file => file.form_id === form.id && file.type === 'SILO')
                                                            .map(file => {
                                                                const fileUrl = `${assetBaseUrl}storage/hseFile/${file.form_id}/${file.type}/${file.file_name}`;
                                                                const fileExtension = file.file_name.split('.').pop().toLowerCase();
                                                                return `
                                                                    <div class="swiper-slide">
                                                                        ${fileExtension === 'pdf' ? `
                                                                            <embed src="${fileUrl}" width="100%" height="400">
                                                                        ` : `
                                                                            <img src="${fileUrl}" width="100%" height="100%">
                                                                        `}
                                                                        <p class="text-center">${file.file_name}</p>
                                                                    </div>`;
                                                            })
                                                            .join('')}
                                                    </div>
                                                    ${files.filter(file => file.form_id === form.id && file.type === 'SILO').length > 1 ? `
                                                        <div class="swiper-button-next"></div>
                                                        <div class="swiper-button-prev"></div>
                                                    ` : ''}
                                                    <div class="swiper-pagination"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ` : ''}
                                `
                            ]).draw();
                        });

                        // Inisialisasi Swiper setelah data dimuat
                        var swiper = new Swiper('.swiper-container', {
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev',
                            },
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true,
                            },
                            loop: true,
                        });
                    }
                });
            }

            function toggleModal(id) {
                var modal = document.getElementById(id);
                modal.classList.toggle('hidden');
            }
        </script>
    @endpush
</x-app-layout>
