<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            padding: 20px;
        }
        .header {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Your Upcoming Appointment Reminder</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>This is a reminder about your upcoming appointment for the <strong>{{ $serviceName }}</strong> service.</p>
            <p>Your appointment is scheduled for <strong>{{ $appointmentDate->format('l, F jS, Y') }}</strong>.</p>
            <p>Please make sure to arrive on time and bring any necessary documents or items required for your appointment.</p>
            <p>If you have any questions or need to reschedule, please contact us as soon as possible.</p>
            <p>Thank you for choosing our services. We look forward to seeing you!</p>
            <p>Best Regards,</p>
            <p><em>Your Service Team</em></p>
        </div>
    </div>
</body>
</html>