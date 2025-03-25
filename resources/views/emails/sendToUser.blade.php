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
                    @if($form->status === "Approved")
                        <p>We are pleased to inform you that your work permit has been approved.</p>
                    @elseif($form->status === "Rejected")
                        <p>We regret to inform you that your work permit has been rejected.</p>
                    @elseif($form->status === "Extended")
                        <p>We are pleased to inform you that your request has been approved.</p>
                    @endif
                </td>
            </tr>
        </thead>
        <tbody>
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
                    <td style="padding-left: 5px;">Status</td>
                    @if($form->status === 'Rejected')
                        <td class="text-red">: {{ $form->status }}</td>
                    @elseif($form->status ==='Approved')
                        <td class="text-green">: {{ $form->status }}</td>
                    @elseif($form->status ==='Extended')
                        <td class="text-green">: Approved</td>
                    @endif
                </tr>
                @if($form->status === 'Rejected')
                <tr>
                    <td style="padding-left: 5px;">Comment</td>
                    <td>: {{ $comment }}</td>
                </tr>
                @endif

                <tr>
                    <td colspan="2">
                        @if($form->status === 'Rejected')
                            <p>We appreciate your understanding and look forward to your revised submission.</p>
                        @elseif($form->status === 'Approved' || $form->status === 'Extended')
                            <p>Thank you for your cooperation, and we wish you a safe and successful completion of your tasks.</p>
                        @endif
                        <br>
                        <p>Best regards,</p>
                        <p>PT Sinar Meadow International Indonesia</p>
                    </td>
                </tr>
            </tbody>
        </tbody>
    </table>
</body>
</html>