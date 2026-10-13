<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial; background:rgb(240, 242, 245); text-align: center; padding-top: 80px;
        }
        .container {
            width: 450px; margin: auto; background: white; padding: 40px;
            border-radius: 15px; box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        h2 {
            color: rgb(0, 123, 255); margin-bottom: 30px;
        }
        .btn {
            display: block; margin: 15px auto; padding: 15px;
            background:rgb(0, 123, 255); color: white; font-size: 18px;
            border: none; border-radius: 10px; width: 90%; text-decoration: none;
        }
        .btn:hover { background:rgb(0, 86, 179); }
        .logout-btn {
            background:rgb(220, 53, 69); margin-top: 20px; font-size: 16px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome, Admin <?= $_SESSION['admin_name'] ?>!</h2>

    <a href="admin_manage_requests.php" class="btn">Manage Donation Requests</a>
    <a href="admin_donations.php" class="btn">View Donation Information</a>
    <a href="manage_institution.php" class="btn">Manage Institutions</a>

    <form method="POST" action="logout.php">
        <button type="submit" class="btn logout-btn">Logout</button>
    </form>
</div>
</body>
</html>


