<?php
include 'db_connect.php';
session_start();

$sql = "SELECT donator.D_Id, user.User_name AS Name, donator.Amount
        FROM donator
        JOIN user ON donator.D_Id = user.User_Id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Donation Records</title>
    <style>
        body { font-family: Arial; background:rgb(240, 242, 245); padding: 40px; }
        h2 { text-align: center; margin-bottom: 30px; }
        table {
            width: 80%; margin: auto; border-collapse: collapse;
            background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
        tr:hover {
            background-color:rgb(241, 241, 241);
        }
        .back-button {
            display: block;
            width: fit-content;
            margin: 30px auto;
            padding: 12px 24px;
            background-color:rgb(0, 123, 255);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
        }
        .back-button:hover {
            background-color:rgb(0, 86, 179);
        }
    </style>
</head>
<body>

<h2>All Donator Records</h2>

<table>
    <tr>
        <th>D_Id</th>
        <th>Name</th>
        <th>Amount (Taka)</th>
    </tr>
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['D_Id'] ?></td>
                <td><?= htmlspecialchars($row['Name']) ?></td>
                <td><?= $row['Amount'] ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="3" style="text-align:center;">No donation records found.</td></tr>
    <?php endif; ?>
</table>

<a class="back-button" href="admin_home.php">Back to Admin Home</a>

</body>
</html>

