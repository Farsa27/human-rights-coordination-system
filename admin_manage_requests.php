<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['action'], $_GET['u_id'])) {
    $u_id = intval($_GET['u_id']);
    $action = $_GET['action'];

    if ($action === 'approve') {
        $conn->query("UPDATE underprivileged_user SET Status='approved' WHERE U_ID=$u_id");
    } elseif ($action === 'deny') {
        $conn->query("UPDATE underprivileged_user SET Status='denied' WHERE U_ID=$u_id");
    }
    header("Location: admin_manage_requests.php");
    exit();
}
$result = $conn->query("SELECT * FROM underprivileged_user");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Requests</title>
    <style>
        body { font-family: Arial; background:rgb(240, 240, 240); padding: 40px; text-align: center; }
        table { width: 90%; margin: auto; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border: 1px solid #ccc; }
        th { background: rgb(0, 123, 255); color: white; }
        .btn { padding: 8px 15px; margin: 2px; border-radius: 5px; font-size: 15px; cursor: pointer; }
        .approve { background: rgb(0, 123, 255); color: white; }
        .deny { background:rgb(220, 53, 69); color: white; }
        .status-approved { color: green; font-weight: bold; }
        .status-denied { color: red; font-weight: bold; }
        .status-pending { color: orange; font-weight: bold; }
    </style>
</head>
<body>

<h2>Donation Requests</h2>

<?php if ($result && $result->num_rows > 0): ?>
    <table>
        <tr>
            <th>Request ID</th>
            <th>Amount</th>
            <th>Details</th>
            <th>Document</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['U_ID'] ?></td>
                <td><?= $row['Amount'] ?></td>
                <td><?= $row['Details'] ?></td>
                <td>
                    <?= $row['Documents'] ? "<a href='{$row['Documents']}' target='_blank'>View</a>" : "No Document" ?>
                </td>
                <td class="status-<?= $row['Status'] ?>"><?= ucfirst($row['Status']) ?></td>
                <td>
                    <?php if ($row['Status'] === 'pending'): ?>
                        <a href="?action=approve&u_id=<?= $row['U_ID'] ?>" class="btn approve">Approve</a>
                        <a href="?action=deny&u_id=<?= $row['U_ID'] ?>" class="btn deny">Deny</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No requests found.</p>
<?php endif; ?>

<br><a href="admin_home.php"><button class="btn">Back to Admin Home</button></a>

</body>
</html>


