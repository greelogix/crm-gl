<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reminder Follow Up Mail</title>
</head>
<body>
<p>Dear {{$negotiation->user->name}},</p>

<p>This is a reminder that a follow-up: has been created over 24 hours ago and still has a status of.</p>

<p>Please take action as needed.</p>

<p>Follow-up created at:{{ Carbon\Carbon::parse($followup->created_at)->format('d M, h:i A') }}</p>

<p>Thank you!</p>

</body>
</html>