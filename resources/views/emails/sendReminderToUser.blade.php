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
        <p>Dear <strong>{{$user}}</strong>,</p>
        <p>We would like to remind you that your work permit is almost expire. If the work is not yet completed, we kindly encourage you to initiate the permit extension process before the expiration to avoid any disruptions.</p>
        <p>To extend your work permit, please visit the following link:
            <a href="{{ route('hse.dashboard') }}" class="link">
                Click here to visit.
            </a>
        </p>
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
            </tbody>
        </table>
        <p>If you have any questions or need assistance, feel free to reach out to us. Thank you for your attention to this matter.</p>
        <br>
        <p>Best regards,</p>
        <p>PT Sinar Meadow International Indonesia</p>
    </main>
</body>
</html>