<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notification Email</title>
</head>
<body>
<h1>Hello, {{ $user->getNameAttribute() }}</h1>
<p>{{ $customMessage }}</p>
</body>
</html>
