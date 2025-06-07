<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="./css/admin.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </header>
</body>
</html>