<!DOCTYPE html>
<html>
<head>
    <title>Form detail</title>
    <style>
        .text-red{
            color: red;
        }
        .text-green{
            color: green;
        }
    </style>
</head>
<body>
    <h4>Perusahaan : {{ $detail->company_department }}</h4>
    <h4>Penanggung Jawab : {{ $detail->supervisor }}</h4>
    <h4>Lokasi Kerja : {{ $detail->location }}</h4>
    <h4>Tanggal Kerja : {{ $detail->start_date }} - {{$detail->end_date}}</h4>
    <h4>Jam Kerja : {{ $detail->start_time }} - {{$detail->end_time}}</h4>
    <h4>Jumlah Pekerja : {{ $detail->workers_count }}</h4>
    @if($form->status === 'Rejected')
        <h4 class="text-red">Status : {{ $form->status }}</h4>
        <h4>Komentar : {{ $comment }}</h4>
    @else
        <h4 class="text-green">Status : {{ $form->status }}</h4>
    @endif
</body>
</html>