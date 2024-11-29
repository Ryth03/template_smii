<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets') }}/src/css/vendors_css.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/src/css/tailwind.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/src/css/horizontal-menu.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/src/css/style.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/src/css/skin_color.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/src/css/custom.css">
    <style>
        body {
            background-color: white;
            zoom: 0.8;  /* Mengatur skala zoom ke 80% */
        }
        @media print {
            .print-none {
                display: none;
            }
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-lg ">
    
    <header class="flex p-10 items-center gap-4 relative">
        <img src="{{asset('assets/images/logo/logo.png')}}" alt="Gambar Sinar Meadow" class="h-auto" style="width:20%;">
        <div class="absolute w-full">
            <p class="text-2xl text-center">Report Permit Form HSE</p>
        </div>
    </header>

    
    <div class="my-4 py-4" style="background-color: #A78734"></div>

    <section class="p-2.5">
        <table>
            <tbody class="align-baseline">
                <tr>
                    <td>Company / Department</td>
                    <td class="font-medium">: {{$form->company_department}}</td>
                </tr>
                <tr>
                    <td>Supervisor</td>
                    <td class="font-medium">: {{$form->supervisor}}</td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td class="font-medium">: {{$form->location}}</td>
                </tr>
                <tr>
                    <td>Work Description</td>
                    <td class="font-medium">: {{$form->work_description}}</td>
                </tr>
                <tr>
                    <td>Total Rating</td>
                    <td class="font-medium">: {{$form->total_rating}}</td>
                </tr>
            </tbody>
        </table>
        <div class="text-4xl" style="display: flex; position: relative;">
            <div style="display: flex;">
                <div style="white-space: nowrap; overflow: hidden; width:{{$form->total_rating*20}}%; color:gold;">
                    @for($i=0; $i < 5 ; $i++)&#9733;@endfor
                </div>
            </div>
            <div style="position: absolute; z-index:2; color:black;">
                @for($i=0; $i < 5 ; $i++)&#9734;@endfor
            </div>
        </div>
        <div class="font-medium">Perusahaan ini {{$form->total_rating >= 3 ? 'direkomendasikan' : 'tidak direkomendasikan'}} untuk bekerja lagi di PT Sinar Meadow International Indonesia.</div>
    </section>

    <div class="print-none">
        <div class="my-4 py-4" style="background-color: #A78734"></div>
        
        <button name="action" class="m-2 px-4 py-2 text-xl bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn print-none" onclick="window.print()">
            Print
        </button>
        <button name="action" class="m-2 px-4 py-2 text-xl bg-blue-500 text-white rounded-lg hover:bg-blue-600 btn print-none" onclick="window.history.back()">
            Back
        </button>
    </div>


    

</body>
</html>