<x-app-layout>
    @section('title')
        Evaluate Job
    @endsection
    @push('css')
    <style>
        @media (max-width: 430px) {
            table {
                display: block;
                width: 100%;
            }
            thead {
                display: none;
            }
            tbody tr, tbody th, tbody td {
                display: block;
            }
        }
        @media (min-width: 640px) {
            .sm\:grid-cols-7 {
                grid-template-columns: repeat(7, minmax(0, 1fr));
            }
        }
        [type="radio"]:not(:checked)+label, [type="radio"]:checked+label{
            color: unset;
        }
    </style>
    @endpush
    <div class="card mt-20 p-2">
        <form action="{{ route('evaluate')}}" id="form" method="POST">
        @csrf
        <input type="hidden" name="formId" value="{{$form->id}}">
        <div class="card card-title p-2">
            <table class="table table-responsive table-bordered">
                <tbody>
                    <tr>
                        <th class="text-medium">Perusahaan / Departemen</th>
                        <td style="white-space: normal;">{{$form->company_department}}</td>
                    </tr>
                    <tr>
                        <th class="text-medium">Lokasi</th>
                        <td style="white-space: normal;">{{$form->location}}</td>
                    </tr>
                    <tr>
                        <th class="text-medium">Tanggal Kerja:</th>
                        <td style="white-space: normal;">{{$form->start_date}} - {{$form->end_date}}</td>
                    </tr>
                    <tr>
                        <th class="text-medium">Penjelasan Pekerjaan</th>
                        <td style="white-space: normal;">{{$form->work_description}}</td>
                    </tr>
                    <tr>
                        <th class="text-medium">HSE Rating</th>
                        <td style="white-space: normal;">{{$ratings->hse_rating}}</td>
                    </tr>
                    <tr>
                        <th class="text-medium">Engineering Rating</th>
                        <td style="white-space: normal;">{{$ratings->engineering_rating}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card card-body p-2">
                <ol class="pl-5 list-outside list-decimal space-y-4 my-10">
                    @foreach($questions as $index => $question)
                    <li>
                        <span class="mb-1 font-medium">{{$question}}</span>
                        <div class="grid sm:grid-cols-7">
                            <div>
                                Kurang Baik
                            </div>
                            @for ($i = 1; $i <= 5; $i++)
                            <div>
                                <input type="radio" id="{{$index+1}}input{{$i}}" name="{{$index+1}}" value="{{$i}}" required>
                                <label for="{{$index+1}}input{{$i}}">{{$i}}</label>
                            </div>
                            @endfor
                            <div>
                                Baik
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ol>
        </div>
            <div class="flex justify-end">
                <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
                type="submit">Submit</button>
                <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 ml-3" onClick="window.history.back()">Back</button>
            </div>
        </form>
    </div>
</x-app-layout>