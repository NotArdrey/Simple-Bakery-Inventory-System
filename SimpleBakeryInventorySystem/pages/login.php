<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css1/design1.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cakeshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../style/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <div class="container">
        <div class="form-container">
            <form action="../function/login.php" method="POST">
                <h2>Login</h2>
                <label for="username">Username</label>
                <input type="text" name="username" required>
                <label for="password">Password</label>
                <input type="password" name="password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
session_start();
if (isset($_SESSION['alert'])) {
    echo $_SESSION['alert'];
    unset($_SESSION['alert']);
}
?>