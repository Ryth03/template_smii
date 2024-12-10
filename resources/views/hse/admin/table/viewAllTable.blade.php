<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('List Forms HSE') }}
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
            List of Forms
        </div>
    </div>
    <div class="box-body overflow-x-auto">
        <table id="myTable" class="w-full table">
            <thead>
                <tr>
                    <th class="px-2 py-3">No.</th>
                    <th class="px-2 py-3">Supervisor</th>
                    <th class="px-2 py-3">Location</th>
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
                        {{ $form->location }}
                    </td>
                    <td>
                        {{ $form->updated_at }}
                    </td>
                    <td>
                        <div class="{{$form->status == 'Approved' ? 'text-green-400' : ($form->status == 'Rejected' ? 'text-red-400' : ($form->status == 'In Review' ? 'text-yellow-400' : ($form->status == 'In Approval' ? 'text-blue-400' : 'text-gray-400')))}} flex justify-between items-center">
                            {{ $form->status }}
                            @if($form->status == "In Approval")
                                {{ $form->count }}/3
                            @endif
                            @if($form->status == "Rejected")
                                <form action="{{ route('report.hse') }}" method="POST" style="display: inline;">
                                @csrf
                                    <input type="hidden" name="value" value="{{$form->id}}">
                                    <button class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                        <div>Report</div>
                                    </button>
                                </form>
                            @elseif($form->status == "Approved")
                                @php
                                    $tanggal = \Carbon\Carbon::parse($form->start_date); // Mengambil tanggal dari model
                                @endphp
                                @if($tanggal->diffInDays(now()) >= 3) <!-- Cek apakah hari ini adalah h+5 dari tanggal mulai kerja -->
                                    <form action="{{ route('reminder.send') }}" method="POST" style="display: inline;">
                                    @csrf
                                        <input type="hidden" name="formId" value="{{$form->id}}">
                                        <button type="button" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600" onClick="sendEmail(this)">
                                            <div>Send Email Reminder</div>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('finished.work') }}" method="POST" style="display: inline;">
                                @csrf
                                    <input type="hidden" name="formId" value="{{$form->id}}">
                                    <button type="button" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600" onClick="isWorkFinished(this)">
                                        <div>Finished</div>
                                    </button>
                                </form>
                            @elseif($form->status == "In Evaluation")
                                <form action="{{ route('jobEvaluate.form') }}" method="POST" style="display: inline;">
                                @csrf
                                    <input type="hidden" name="formId" value="{{$form->id}}">
                                    <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                        <div>Evaluate</div>
                                    </button>
                                </form>
                            @elseif($form->status == "Finished")
                                <form action="{{ route('jobEvaluateReport.form') }}" method="POST" style="display: inline;">
                                @csrf
                                    <input type="hidden" name="formId" value="{{$form->id}}">
                                    <button class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                        <div>View Report</div>
                                    </button>
                                </form>
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
                console.log(button.parentNode);
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
                console.log(button.parentNode);
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