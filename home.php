<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Home - Human Rights Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:hsl(216, 20.00%, 95.10%);
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .option-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 50px;
        }
        .option-box {
            width: 200px;
            height: 150px;
            margin: 20px;
            padding: 20px;
            background: white;
            border: 2px solid rgb(0, 123, 255);
            border-radius: 15px;
            box-shadow: 0 4px 8px hsla(0, 0.00%, 0.00%, 0.10);
            font-size: 20px;
            font-weight: bold;
            color: rgb(0, 123, 255);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            cursor: pointer;
        }
        .option-box:hover {
            background-color: rgb(0, 123, 255);
            color: white;
        }
    </style>
</head>
<body>

<p style="font-size: 50px; color:rgb(0, 123, 255)">Select a Service:</p>

<div class="option-container">
    <div class="option-box" onclick="location.href='food.php'">Food</div>
    <div class="option-box" onclick="location.href='clothes.php'">Clothes</div>
    <div class="option-box" onclick="location.href='health_care.php'">Health Care</div>
    <div class="option-box" onclick="location.href='education.php'">Education</div>
    <div class="option-box" onclick="location.href='shelter.php'">Shelter</div>
    <div class="option-container">

    <div class="option-box" onclick="location.href='edit_user.php'">User Info</div>
    <div class="option-box" onclick="location.href='donator.php'">Donator</div>
    <div class="option-box" onclick="location.href='underprivileged_request.php'">Get Help</div>
    <div class="option-box" onclick="location.href='logout.php'">Log out</div>

</div>

</body>
</html>
