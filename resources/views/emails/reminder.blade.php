<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reminder</title>
</head>
<body>
    <p>Hello,{{$negotiation->user->name}}</p>
    <p>This is a reminder to update the negotiation status for the lead: Please update the status of the lead created by you, {{$negotiation->lead->client_name}}.</p>
    <p>Please update your status before it is automatically marked as 'Loss' after seven days.</p>
    <p>Thank you!</p>
</body>
</html>