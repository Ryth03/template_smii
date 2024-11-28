<x-app-layout>
    @section('title')
        List Approvers
    @endsection
    <div class="content-header">
        <div class="flex items-center justify-between">
            <h4 class="page-title text-3xl font-lg"></h4>
            <div class="inline-flex items-center">
                <nav>
                    <ol class="breadcrumb flex items-center">
                        <li class="breadcrumb-item pr-1"><a href="{{ route('dashboard') }}"><i
                                    class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item pr-1" aria-current="page">Approver</li>
                        <li class="breadcrumb-item active" aria-current="page">List Approvers</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="content">
        <!-- Add Role Button -->
        <div class="card">
            <div class="card-header">
                <h1 class="card-title text-3xl font-medium">List Approvers</h1>
            </div>
            <div class="card-body">
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table id="approversTable" class="table table-striped w-full  text-left rtl:text-right table-bordered">
                        <thead class="uppercase border-b">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-lg">#</th>
                                <th scope="col" class="px-6 py-3 text-lg">Approver</th>
                                <th scope="col" class="px-6 py-3 text-lg">Level</th>
                                <th class="px-6 py-3 text-lg text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($approvers as $index => $approver)
                                <tr>
                                    <td class="px-6 py-4 text-xl">
                                        {{ $index+1 }}
                                    </td>
                                    <td class="px-6 py-4 text-xl">
                                        {{ $approver->name }}
                                    </td>
                                    <td class="px-6 py-4 text-xl">
                                        {{ $approver->level }}
                                    </td>
                                    <td class="flex items-center justify-center text-xl space-x-4">
                                        <button type='button' data-modal-target="updateApproverModal-{{ $approver->id }}"
                                            data-modal-toggle="updateApproverModal-{{ $approver->id }}"
                                            class="text-fade btn btn-warning"><i
                                                class="fa-solid fa-pencil text-white"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            $(document).ready(function() {
                var table = $('#approversTable').DataTable({
                    "lengthChange": false,
                    "pagingType": "simple_numbers",
                    "dom": 'Bfrtip',
                    "buttons": ['copy', 'csv', 'excel', 'pdf', 'print'],
                    "drawCallback": function(settings) {
                        // Function to reposition modal in the viewport
                        function repositionModal(modalId) {
                            var modal = $('#' + modalId);
                            var modalDialog = modal.find('.modal-dialog');

                            // Calculate top position based on viewport and scroll
                            var modalTop = Math.max(0, ($(window).height() - modalDialog.outerHeight()) /
                                2) + $(window).scrollTop();
                            var modalLeft = Math.max(0, ($(window).width() - modalDialog.outerWidth()) / 2);

                            modalDialog.css({
                                'margin-top': modalTop,
                                'margin-left': modalLeft
                            });
                        }

                        // Trigger reposition on modal show event
                        $('[data-modal-toggle]').off('click').on('click', function() {
                            var target = $(this).data('modal-target');
                            $('#' + target).removeClass('hidden').addClass('flex').attr(
                                'aria-modal', 'true').attr('role', 'dialog');
                            repositionModal(target); // Reposition modal when shown
                        });

                        $('[data-modal-hide]').off('click').on('click', function() {
                            var target = $(this).data('modal-hide');
                            $('#' + target).addClass('hidden').removeClass('flex').removeAttr(
                                'aria-modal').removeAttr('role');
                        });
                    }
                });

                @if (session()->has('success'))
                    Swal.fire({
                        icon: 'success',
                        title: '{{ session()->get('success') }}',
                        text: '{{ session()->get('message') }}',
                    });
                @endif
            });
        </script>
    @endpush
    

{{-- Modal Edit --}}
@foreach ($approvers as $approver)
    <div id="updateApproverModal-{{ $approver->id }}" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">
                        Edit Approver
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="updateApproverModal-{{ $approver->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewbox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="{{ route('approver.update.hse',$approver->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name" class="block mb-2 text-xl font-medium text-gray-900 dark:text-white">
                                Approver Name
                            </label>
                            <input type="text" name="name" id="name"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white text-md"
                                placeholder="Approver Name" required="" value="{{ $approver->name }}" readonly disabled>
                        </div>
                        <div>
                            <label for="level" class="block mb-2 text-xl font-medium text-gray-900 dark:text-white">
                                Approver Level
                            </label>
                            <input type="text" name="level" id="level"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white text-md"
                                placeholder="level" required="" value="{{ $approver->level }}">
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

    
</x-app-layout>
