<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Job Evaluation') }}
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
            Job Evaluation
        </div>
    </div>
    <div class="box-body overflow-x-auto">
        <table id="myTable" class="w-full table">
            <thead>
                <tr>
                    <th class="px-2 py-3">No.</th>
                    <th class="px-2 py-3">Company / Department</th>
                    <th class="px-2 py-3">Location</th>
                    <th class="px-2 py-3">Date</th>
                    <th class="px-2 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($forms as $index => $form)
                <tr>
                    <td>
                        {{ $index +1 }}
                    </td>
                    <td>
                        {{ $form->company_department }}
                    </td>
                    <td>
                        {{ $form->location }}
                    </td>
                    <td>
                        {{ $form->start_date }} - {{ $form->end_date }}
                    </td>
                    <td>
                        
                        <form action="{{ route('jobEvaluate.form') }}" id="form" method="POST" style="display: inline;">
                        @csrf
                            <input type="hidden" name="formId" value="{{$form->id}}">
                            <button type="button" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600" onClick="submitForm(this)">
                                Evaluate
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

    function submitForm(button) {
        // SweetAlert2 confirmation dialog for submit action
        Swal.fire({
            title: "Konfirmasi",
            text: "Apakah pekerjaan sudah selesai?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#26D639',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sudah!',
            cancelButtonText: 'Belum'
        }).then((result) => {
            if (result.isConfirmed) {
                button.parentNode.submit();
            }
        });
    }

    $(document).ready(function() {
        $('#myTable').DataTable({
           
        });
    });
</script>
@endpush

</x-app-layout>