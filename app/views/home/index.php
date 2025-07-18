<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <?php
    date_default_timezone_set('America/Toronto');
    $currentDateTime = date("l, F j, Y - h:i A");
    ?>

    <h1>Welcome, <?= $_SESSION['username'] ?? 'User' ?>!</h1>
    <p>You are logged in.</p>
    <p><strong>Current Date and Time:</strong> <?= $currentDateTime ?></p>

    <a href="/reminders" class="btn btn-primary">Go to Reminders</a>
    <a href="/login/logout" class="btn btn-danger ms-2">Logout</a>
</body>
</html>
