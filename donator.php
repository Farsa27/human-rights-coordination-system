<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amount = $_POST['amount'];

    $check = $conn->query("SELECT * FROM donator WHERE D_Id = '$user_id'");
    if ($check && $check->num_rows > 0) {
        $sql = "UPDATE donator SET Amount = '$amount' WHERE D_Id = '$user_id'";
    } else {
        $sql = "INSERT INTO donator (D_Id, Amount) VALUES ('$user_id', '$amount')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Donation saved successfully.'); window.location.href='donator.php';</script>";
        exit();
    } else {
        echo "<script>alert('Database error: " . $conn->error . "');</script>";
    }
}

$result = $conn->query("SELECT D_Id, Amount FROM donator");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donate</title>
    <style>
        body { font-family: Arial; background:rgb(240, 242, 245); padding: 40px; text-align: center; }
        .form-box {
            width: 400px; background: white; padding: 30px; margin: auto;
            border-radius: 12px; box-shadow: 0 0 12px rgba(0,0,0,0.2); margin-bottom: 40px;
        }
        input, button {
            width: 90%; padding: 12px; margin: 10px;
            font-size: 16px; border-radius: 8px; border: 1px solid #ccc;
        }
        button {
            background: rgb(0, 123, 255); color: white; border: none; cursor: pointer;
        }
        button:hover { background:rgb(0, 123, 255); }
        table {
            width: 80%; margin: auto; border-collapse: collapse; background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 16px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color:rgb(0, 123, 255);
            color: white;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Make or Update Donation</h2>
    <form method="POST">
        <input type="number" name="amount" placeholder="Enter Donation Amount" required>
        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>
