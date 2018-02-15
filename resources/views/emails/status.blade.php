<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Suppor Ticket Status</title>
</head>
<body>
<p>
    Hello {{ ucfirst($first_name) }},
</p>
<p>
    Your support ticket with ID #{{ $ticket->ticket_id }} status has been changed to "{{$status}}".
</p>
</body>
</html>