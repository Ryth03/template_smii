<!DOCTYPE html>
<html>
<head>
    <title>Form detail</title>
    <style>
        .header{
            background-color: yellow;
            line-height: 0.5;
            padding: 5px;
            padding-left:15px;
        }
        .table{
            border: 0;
            margin-left:5%;
        }
        .text-red{
            color: red;
        }
        .text-green{
            color: green;
        }
    </style>
</head>
<body style="border: 1px solid black; ">
    <header class="header">
        <h2>Work Permit Form HSE</h2>
        <h5>PT Sinar Meadow International Indonesia</h5>
    </header>
    <main style="padding: 5px;">
        <br>
        <p>Dear <strong>{{$user}}</strong>,</p>
        @if($form->status === "Approved")
            <p>We are pleased to inform you that your work permit has been approved.</p>
        @elseif($form->status === "Rejected")
            <p>We regret to inform you that your work permit has been rejected.</p>
        @elseif($form->status === "Extended")
            <p>We are pleased to inform you that your request has been approved.</p>
        @endif
        <table class="table">
            <tbody>
                <tr>
                    <td>Company </td>
                    <td>:</td>
                    <td>{{ $detail->company_department }}</td>
                </tr>
                <tr>
                    <td>Supervisor </td>
                    <td>:</td>
                    <td>{{ $detail->supervisor }}</td>
                </tr>
                <tr>
                    <td>Location </td>
                    <td>:</td>
                    <td>{{ $detail->location }}</td>
                </tr>
                <tr>
                    <td>Date </td>
                    <td>:</td>
                    <td>{{ $detail->start_date }} - {{$detail->end_date}}</td>
                </tr>
                <tr>
                    <td>Time </td>
                    <td>:</td>
                    <td>{{ $detail->start_time }} - {{$detail->end_time}}</td>
                </tr>
                <tr>
                    <td>Employee Amount </td>
                    <td>:</td>
                    <td>{{ $detail->workers_count }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    @if($form->status === 'Rejected')
                        <td class="text-red">{{ $form->status }}</td>
                    @elseif($form->status ==='Approved')
                        <td class="text-green">{{ $form->status }}</td>
                    @elseif($form->status ==='Extended')
                        <td class="text-green">Approved</td>
                    @endif
                </tr>
                @if($form->status === 'Rejected')
                <tr>
                    <td>Comment</td>
                    <td>:</td>
                    <td>{{ $comment }}</td>
                </tr>
                @endif
            </tbody>
        </table>
        @if($form->status === 'Rejected')
            <p>We appreciate your understanding and look forward to your revised submission.</p>
        @elseif($form->status === 'Approved' || $form->status === 'Extended')
            <p>Thank you for your cooperation, and we wish you a safe and successful completion of your tasks.</p>
        @endif
        <br>
        <p>Best regards,</p>
        <p>PT Sinar Meadow International Indonesia</p>
    </main>
</body>
</html>