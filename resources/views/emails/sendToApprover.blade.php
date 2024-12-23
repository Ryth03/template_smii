<!DOCTYPE html>
<html>
<head>
    <title>Form detail</title>
    <style>
        .header{
            background-color: yellow;
            line-height: 0.5;
            padding: 5px;
            padding-left: 15px;
        }
        .table{
            border: 0;
            margin-left:5%;
        }
        .link{
            text-decoration:none;
            color: #B30D0D;
        }
        .link:hover{
            color: #911C1C;
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
        <p>Dear <strong>{{$role}}</strong>,</p>
        @if($form->status === "In Review")
            <p>There is a Work Permit that requires your review.
                <a href="{{ route('review.table') }}" class="link">
                    Click here to review.
                </a>
            </p>
        @elseif($form->status === "In Approval" || $form->status === "In Approval (Extend)")
            <p>There is a Work Permit that requires your approval. 
                <a href="{{ route('approval.table') }}" class="link">
                    Click here to approve.
                </a>
            </p>
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
                    <td>{{ $form->status }}</td>
                </tr>
            </tbody>
        </table>
        @if($form->status === "In Review")
            <p>Kindly review it at your earliest convenience so we can proceed.</p>
        @elseif($form->status === "In Approval" || $form->status === "In Approval (Extend)")
            <p>Kindly approve it at your earliest convenience so we can proceed.</p>
        @endif
        <p>Thank you for your attention.</p>
        <br>
        <p>Best regards,</p>
        <p>PT Sinar Meadow International Indonesia</p>
    </main>
    
</body>
</html>