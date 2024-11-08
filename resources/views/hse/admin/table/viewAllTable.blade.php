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
            Forms List
        </div>
    </div>
    <div class="box-body overflow-x-auto">
        <table id="myTable" class="w-full table">
            <thead>
                <tr>
                    <th class="px-2 py-3">No.</th>
                    <th class="px-2 py-3">Penanggung Jawab Lapangan</th>
                    <th class="px-2 py-3">Date Created</th>
                    <th class="px-2 py-3">Date Updated</th>
                    <th class="px-2 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($forms as $index => $form)
                <tr>
                    <td>
                        {{ $index +1 }}
                    </td><td>
                        {{ $form->supervisor}}
                    </td>
                    <td>
                        {{ $form->created_at }}
                    </td>
                    <td>
                        {{ $form->updated_at }}
                    </td>
                    <td>
                        <div class="{{$form->status == 'Approved' ? 'text-green-400' : ($form->status == 'Rejected' ? 'text-red-400' : ($form->status == 'In Review' ? 'text-yellow-400' : ($form->status == 'In Approval' ? 'text-blue-400' : 'text-gray-400')))}}">
                            {{ $form->status }}
                            @if($form->status == "In Approval")
                                {{ $form->count }}/3
                            @endif
                            @if($form->status == "Approved")
                                <form action="{{ route('report.hse') }}" method="POST" style="display: inline;">
                                @csrf
                                    <input type="hidden" name="value" value="{{$form->id}}">
                                    <button class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                        <div>Report</div>
                                    </button>
                                </form>
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