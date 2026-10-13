<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$check = $conn->query("SELECT * FROM underprivileged_user WHERE U_ID = '$user_id'");
$existing = $check && $check->num_rows > 0 ? $check->fetch_assoc() : null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amount = $_POST['amount'];
    $details = $_POST['details'] ?? null;
    $document = null;

    if ($amount > 1000) {
        echo "<script>alert('You cannot request more than 1000 Taka.'); window.location.href='underprivileged_request.php';</script>";
        exit();
    }

    if ($existing && $existing['Status'] === 'pending') {
        echo "<script>alert('Your previous request is still pending. You cannot submit a new one yet.'); window.location.href='underprivileged_request.php';</script>";
        exit();
    }

    if (isset($_FILES['document']) && $_FILES['document']['error'] === 0) {
        $path = "uploads/" . basename($_FILES['document']['name']);
        move_uploaded_file($_FILES['document']['tmp_name'], $path);
        $document = $path;
    }

    if ($existing) {
        $sql = "UPDATE underprivileged_user 
                SET Amount = '$amount', Details = '$details', Documents = '$document', Status = 'pending'
                WHERE U_ID = '$user_id'";
    } else {
        $sql = "INSERT INTO underprivileged_user (U_ID, Amount, Details, Documents, Status)
                VALUES ('$user_id', '$amount', '$details', '$document', 'pending')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Request submitted successfully.'); window.location.href='underprivileged_request.php';</script>";
    } else {
        echo "<script>alert('Database error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Help</title>
    <style>
        body { font-family: Arial; background:rgb(240, 242, 245); padding-top: 60px; text-align: center; }
        .form-box {
            width: 480px; background: white; padding: 30px; margin: auto;
            border-radius: 12px; box-shadow: 0 0 12px rgba(0,0,0,0.2);
        }
        input, textarea {
            width: 90%; padding: 12px; margin: 10px 0;
            font-size: 16px; border-radius: 8px; border: 1px solid #ccc;
        }
        button {
            width: 95%; padding: 12px; background:rgb(0, 123, 255);
            color: white; border: none; font-size: 18px; border-radius: 8px;
            cursor: pointer;
        }
        button:hover { background:rgb(0, 86, 179); }
        .info-box {
            background:rgb(233, 236, 239); padding: 20px; margin-top: 20px;
            border-radius: 8px; text-align: left;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2>Request Financial Help</h2>

    <?php if ($existing): ?>
        <div class="info-box">
            <p><strong>Previous Request Details:</strong></p>
            <p><strong>Status:</strong> <?= ucfirst($existing['Status']) ?></p>
            <p><strong>Amount:</strong> <?= $existing['Amount'] ?> Taka</p>
            <p><strong>Details:</strong> <?= nl2br(htmlspecialchars($existing['Details'])) ?></p>
            <?php if ($existing['Documents']): ?>
                <p><strong>Document:</strong> <a href="<?= $existing['Documents'] ?>" target="_blank">View File</a></p>
            <?php endif; ?>
        </div>

        <?php if ($existing['Status'] === 'pending'): ?>
            <p style="margin-top: 20px; color:rgb(220, 53, 69);"><strong>Your request is pending. You cannot submit another until it's approved or denied.</strong></p>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!$existing || $existing['Status'] !== 'pending'): ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="number" name="amount" placeholder="Amount Needed (Max 1000)" required>
            <textarea name="details" placeholder="Explain your need (optional)"></textarea>
            <input type="file" name="document">
            <button type="submit">Submit Request</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>

