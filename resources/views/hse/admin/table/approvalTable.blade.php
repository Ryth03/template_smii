<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Approval HSE') }}
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
        }
    </style>
    @endpush

<div class="box">
    <div class="box-header flex justify-center items-center">
        <div class="text-3xl font-medium">
            Approval Dashboard {{$approver->name}} {{$approver->level}}
        </div>
    </div>
    <div class="box-body overflow-x-auto">
        <table id="myTable" class=" w-full table table-bordered">
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
                @foreach ($forms as $index => $form)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$form->company_department}}</td>
                    <td>{{$form->supervisor}}</td>
                    <td>{{$form->location}}</td>
                    <td>{{$form->hp_number}}</td>
                    <td>{{$form->start_date}} - {{$form->end_date}}</td>
                    <td>{{$form->start_time}} - {{$form->end_time}}</td>
                    <td>{{$form->workers_count}}</td>
                    <td>
                        <form action="{{ route('approval.form') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="value" value="{{ $form->form_id }}">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                Awaiting Approval
                            </button>
                        </form>
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