<!DOCTYPE html>
<html>
<head>
    <title>Form detail</title>
    <style>
        .header-style{
            background-color: yellow;
            padding: 5px;
            padding-left: 15px;
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
<body>
    <table style="border: 1px solid black; width:100%; max-width:1000px; margin:auto;">
        <thead>
            <tr class="header-style">
                <td colspan="2" style="padding:5px 5px 5px 15px;">
                    <h2>Work Permit Form HSE</h2>
                    <h5>PT Sinar Meadow International Indonesia</h5>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>Dear <strong>{{$user}}</strong>,</p>
                    <p>We would like to remind you that your work permit is almost expire. If the work is not yet completed, we kindly encourage you to initiate the permit extension process before the expiration to avoid any disruptions.</p>
                    <p>To extend your work permit, please visit the following link:
                        <a href="{{ route('hse.dashboard') }}" class="link">
                            Click here to visit.
                        </a>
                    </p>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding-left: 5px;">Company</td>
                <td>: {{ $detail->company_department }}</td>
            </tr>
            <tr>
                <td style="padding-left: 5px;">Supervisor</td>
                <td>: {{ $detail->supervisor }}</td>
            </tr>
            <tr>
                <td style="padding-left: 5px;">Location</td>
                <td>: {{ $detail->location }}</td>
            </tr>
            <tr>
                <td style="padding-left: 5px;">Date</td>
                <td>: {{ $detail->start_date }} - {{$detail->end_date}}</td>
            </tr>
            <tr>
                <td style="padding-left: 5px;">Time</td>
                <td>: {{ $detail->start_time }} - {{$detail->end_time}}</td>
            </tr>
            <tr>
                <td style="padding-left: 5px;">Employee Amount</td>
                <td>: {{ $detail->workers_count }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <p>If you have any questions or need assistance, feel free to reach out to us. Thank you for your attention to this matter.</p>
                    <br>
                    <p>Best regards,</p>
                    <p>PT Sinar Meadow International Indonesia</p>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>