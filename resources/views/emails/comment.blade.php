
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Suppor Ticket</title>
</head>
<body>
    <p>
{{ $comment }}
</p>

---
<p>Replied by: {{ $replied_by }}</p>

<p>Title: {{ $ticket_title }}</p>
<p>Title: {{ $ticket_id }}</p>
<p>Status: {{ $ticket_status }}</p>

<p>
    You can view the ticket at any time at {{ url(config('app.support_ticket_url')).'/home/tickets'. $ticket_id }}
</p>

</body>
</html>