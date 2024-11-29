<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Job Evaluate') }}
        </h2>
    </x-slot>
    @push('css')
    <style>
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
<form action="{{ route('evaluate')}}" id="form" method="POST">
@csrf
<input type="hidden" name="formId" value="{{$formId}}">
    <div>
        Perusahaan / Departemen : {{$form->company_department}}
    </div>
    <div>
        Lokasi : {{$form->location}}
    </div>
    <div>
        Tanggal Kerja : {{$form->start_date}} - {{$form->end_date}}
    </div>
    <div>
        Penjelasan Pekerjaan : {{$form->work_description}}
    </div>

    @php
        $questions = [
            "Kepatuhan penggunaan APD",
            "Kepatuhan terhadap rambu yang dipasang di area",
            "Peralatan kerja / perlengkapan kerja yang digunakan",
            "Kesesuaian pekerjaan dengan JSA",
            "Kedisiplinan dalam menjaga area pekerjaan tetap bersih"
            ]
    @endphp

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
    <button class="btn btn-primary btn-block rounded-md text-white"
    type="submit">Submit</button>
</form>
</x-app-layout>