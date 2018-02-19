
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Support Ticket Information</title>
</head>
<body>
<p>
    Thank you {{ ucfirst($first_name) }} for contacting our support team. A support ticket has been opened for you. You will be notified when a response is made by email. The details of your ticket are shown below:
</p>

<p>Title: {{ $title }}</p>
<p>Priority: {{ $priority }}</p>
<p>Status: {{ $status }}</p>

<p>
    You can view the ticket at any time at {{ url(config('app.support_ticket_url')).'/home/tickets'. $ticket_id }}
</p>

</body>
</html>