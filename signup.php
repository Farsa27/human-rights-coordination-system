<?php
include 'db_connect.php';
session_start();

if (isset($_POST['signup'])) {
    $password = $_POST['password'];
    $user_name = $_POST['user_name'];
    $phone_number = $_POST['phone_number'];

    $sql = "INSERT INTO user (Password, User_name, Phone_Number)
            VALUES ('$password', '$user_name', '$phone_number')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Signup Successful! Please Login Now.'); window.location.href='login.php';</script>";
        exit();
    } else {
        echo "<script>alert('Signup Failed. Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:rgb(240, 242, 245);
            margin: 0;
            padding: 0;
        }
        .form-container {
            width: 400px;
            margin: 100px auto;
            padding: 30px;
            border: 2px solid #ccc;
            border-radius: 15px;
            background: white;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        input, button {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            font-size: 18px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        button {
            background-color: rgb(0, 123, 255);
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: rgb(0, 123, 255);
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Create New Account</h2>
    <form method="POST" action="">
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="user_name" placeholder="Full Name" required><br>
        <input type="text" name="phone_number" placeholder="Phone Number" required><br>
        <button type="submit" name="signup">Sign Up</button>
    </form>

    <br>
    <a href="index.php"><button type="button">Back to Portal</button></a>
</div>

</body>
</html>
