<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user_name'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE User_name = '$username' AND Password = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($row['is_admin'] == 1) {
            $_SESSION['admin_name'] = $row['User_name'];
            header("Location: admin_home.php");
            exit();
        } else {
            $_SESSION['user_id'] = $row['User_Id'];
            $_SESSION['user_name'] = $row['User_name'];
            header("Location: home.php");
            exit();
        }
    } else {
        echo "<script>alert('Invalid username or password.'); window.location.href='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial; background-color: #f0f2f5; text-align: center; padding-top: 100px; }
        .login-box {
            background: white; width: 400px; margin: auto; padding: 30px;
            border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        input {
            width: 90%; padding: 12px; margin: 10px 0;
            font-size: 16px; border-radius: 8px; border: 1px solid #ccc;
        }
        button {
            width: 95%; padding: 12px; background: #007bff;
            color: white; font-size: 18px; border: none; border-radius: 8px;
            cursor: pointer;
        }
        button:hover { background: #0056b3; }
        a {
            display: block; margin-top: 20px; color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>
    <form method="POST">
        <input type="text" name="user_name" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <a href="signup.php">Don't have an account? Sign up</a>
</div>

</body>
</html>
