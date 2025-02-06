<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reminder</title>
</head>
<body>
    <p>Hello, {{$negotiation->user->name}}</p>
    <p>This is a reminder to update the negotiation status for the lead: <strong>{{$negotiation->lead->proposal_name}}</strong> (Follow-up {{$followUpCount}}). Please make sure to update the status for the lead created by you, <strong>{{$negotiation->lead->client_name}}</strong>.</p>
    <p>If no update is made, the status will automatically be marked as 'Loss' after seven days.</p>
    <p>Thank you!</p>
</body>
</html>
