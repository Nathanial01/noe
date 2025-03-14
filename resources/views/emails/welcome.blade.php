<!DOCTYPE html>
<html>
<head>
    <title>Welcome to {{ config('app.name') }}</title>
</head>
<body>
<h2>Hello {{ $user->first_name }},</h2>
<p>Welcome to {{ config('app.name') }}! We are excited to have you.</p>
<p>Feel free to explore and let us know if you have any questions.</p>
<p>Best regards,<br>{{ config('app.name') }} Team</p>
</body>
</html>
