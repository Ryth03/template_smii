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
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn"
            data-modal-target="createNewForm" data-modal-toggle="createNewForm">
                Create New Form
            </button>
        <!-- </a> -->
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

    {{-- Modal Terms --}}
    <div id="createNewForm" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
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
                    <label class="text-justify self-center block mt-4 text-gray-900 dark:text-white">
                        Choose One
                    </label>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <div class="flex items-center justify-center text-xl space-x-4">
                        <a href="{{route('permit.form')}}">
                            <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn">
                                New Form
                            </button>
                        </a>
                        <form action="{{route('extend.form')}}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" value="{{$extendValue}}" name="value">
                            <button  class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn">
                                Extend Form
                            </button>
                        </form>
                    </div>
                </div>
            </div>
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