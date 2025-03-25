<!DOCTYPE html>
<html>
<head>
    <title>Form detail</title>
    <style>
        .header-style{
            background-color: yellow;
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
                <td style="padding-left: 5px;">Status</td>
                <td>: {{ $form->status }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    @if($form->status === "In Review")
                        <p>Kindly review it at your earliest convenience so we can proceed.</p>
                    @elseif($form->status === "In Approval" || $form->status === "In Approval (Extend)")
                        <p>Kindly approve it at your earliest convenience so we can proceed.</p>
                    @endif
                    <p>Thank you for your attention.</p>
                    <br>
                    <p>Best regards,</p>
                    <p>PT Sinar Meadow International Indonesia</p>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>