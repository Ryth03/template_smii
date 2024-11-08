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

<div class="card p-10">
    @can('create form hse')
    <div class="mx-2 my-4">
        <a href="{{route('permit.form')}}">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn">
                Create New Form
            </button>
        </a>
    </div>
    @endcan
    <div class="table-responsive">
        <table id="myTable" class=" w-full display table table-bordered">
        <thead>
            <tr>
                <th class="px-2 py-3">No.</th>
                <th class="px-2 py-3">Status</th>
                <th class="px-2 py-3">Action</th>
                <th class="px-2 py-3">Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($forms as $index => $form)
                <tr>
                    <td>
                        {{ $index +1 }}
                    </td>
                    <td>
                        <div class="{{$form->status == 'Approved' ? 'text-green-400' : ($form->status == 'Rejected' ? 'text-red-400' : ($form->status == 'In Review' ? 'text-yellow-400' : ($form->status == 'In Approval' ? 'text-blue-400' : 'text-gray-400')))}}">
                            {{ $form->status }}
                            @if($form->status == "In Approval")
                                {{ $form->count }}/3
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($form->status==="Draft")
                        <form action="{{ route('view.form.hse') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="value" value="{{ $form->id }}">
                            <button type="submit" class="mx-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn">
                                Lihat Form
                            </button>
                        </form>
                        @endif
                    </td>
                    <td class="">
                        @if($form->status==="Draft")
                        <form action="{{ route('delete.form.hse') }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="value" value="{{ $form->id }}">
                            <button type="submit" class="text-red-600">
                                <i class="fas fa-trash">
                                </i>
                            </button>
                        </form>
                        @endif
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