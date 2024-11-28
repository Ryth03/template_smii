<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Review HSE') }}
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
            Review Dashboard
        </div>
    </div>
    <div class="box-body overflow-x-auto">
        <table id="myTable" class=" w-full table table-bordered">
            <thead>
                <tr>
                    <th class="py-3">No.</th>
                    <th class="py-3">Perusahaan / Departemen</th>
                    <th class="py-3">Penanggung Jawab Lapangan</th>
                    <th class="py-3">Lokasi Pekerjaan</th>
                    <th class="py-3">No. Hp</th>
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
                    <td>{{$form->location}}</td>
                    <td>{{$form->hp_number}}</td>
                    <td>{{$form->start_date}} - {{$form->end_date}}</td>
                    <td>{{$form->start_time}} - {{$form->end_time}}</td>
                    <td>{{$form->workers_count}}</td>
                    <td>
                        <form action="{{ route('review.form') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="value" value="{{ $form->form_id }}">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                Awaiting Review
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