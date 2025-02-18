<x-app-layout>
    @section('title')
        Approval
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
        </style>
    @endpush

    <div class="box">
        <div class="box-header flex justify-center items-center">
            <div class="text-3xl font-medium">
                Approval Dashboard {{ $approver->name }} {{ $approver->level }}
            </div>
        </div>
        <div class="box-body overflow-x-auto">
            <table id="myTable" class=" w-full table table-bordered">
                <thead>
                    <tr>
                        <th>Perusahaan / Departemen</th>
                        <th>Penanggung Jawab Lapangan</th>
                        <th>Lokasi Pekerjaan</th>
                        <th>No. Hp</th>
                        <th>Tanggal</th>
                        <th>Jam Kerja</th>
                        <th>Jml. Pekerja</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($forms as $index => $form)
                        <tr>
                            <td>{{ $form->company_department }}</td>
                            <td>{{ $form->supervisor }}</td>
                            <td>{{ $form->location }}</td>
                            <td>{{ $form->hp_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($form->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($form->end_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($form->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($form->end_time)->format('H:i') }}</td>
                            <td>{{ $form->workers_count }}</td>
                            <td>
                                <a href="{{ route('approval.form', $form->id) }}" style="display: inline;">
                                    <button type="submit" class="btn btn-sm btn-info tooltip"
                                        title="Awaiting Approval">
                                        <i class="fas fa-calendar-check"></i>
                                    </button>
                                </a>
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
                var table = $('#myTable').DataTable({
                    lengthMenu: [10, 25, 50, {
                        label: 'All',
                        value: -1
                    }],
                    dom: 'Qlfrtip',
                    buttons: ['searchBuilder'],
                    searchBuilder: true,
                    responsive: true
                });
            });
        </script>
    @endpush
</x-app-layout>
