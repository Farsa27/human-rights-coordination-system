<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM user WHERE User_Id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

if (isset($_POST['update'])) {
    $new_name = $_POST['new_name'];
    $new_password = $_POST['new_password'];
    $new_phone = $_POST['new_phone'];

    $update_sql = "UPDATE user SET User_name='$new_name', Password='$new_password', Phone_Number='$new_phone' WHERE User_Id='$user_id'";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Profile Updated Successfully!'); window.location.href='home.php';</script>";
        exit();
    } else {
        echo "<script>alert('Update Failed. Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:rgb(240, 242, 245);
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .form-container {
            width: 400px;
            margin: 100px auto;
            padding: 30px;
            border: 2px solid #ccc;
            border-radius: 15px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit Your Profile</h2>
    <form method="POST" action="">
        <input type="text" name="user_id" value="<?php echo $user['User_Id']; ?>" disabled><br>
        <input type="text" name="new_name" value="<?php echo $user['User_name']; ?>" required><br>
        <input type="password" name="new_password" placeholder="Enter New Password" required><br>
        <input type="text" name="new_phone" value="<?php echo $user['Phone_Number']; ?>" required><br>
        <button type="submit" name="update">Update Profile</button>
    </form>

    <br>
    <a href="home.php"><button type="button">Back to Home</button></a>
</div>

</body>
</html>
