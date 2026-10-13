<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit();
}

// create
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $range = $_POST['range'];
    $city = $_POST['city'];

    $sql = "INSERT INTO human_rights_institution (Id, Institution_Name, Price_Range, City_corporation)
            VALUES ('$id', '$name', '$range', '$city')";
    $conn->query($sql);
}

// Delete 
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM human_rights_institution WHERE Id = '$id'");
    header("Location: manage_institution.php");
    exit();
}

// Update 
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $range = $_POST['range'];
    $city = $_POST['city'];

    $sql = "UPDATE human_rights_institution 
            SET Institution_Name='$name', Price_Range='$range', City_corporation='$city'
            WHERE Id='$id'";
    $conn->query($sql);
    header("Location: manage_institution.php");
    exit();
}

$data = ['F' => [], 'C' => [], 'M' => [], 'E' => [], 'S' => []];
$result = $conn->query("SELECT * FROM human_rights_institution");

while ($row = $result->fetch_assoc()) {
    $prefix = strtoupper(substr($row['Id'], 0, 1));
    if (isset($data[$prefix])) {
        $data[$prefix][] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Institutions</title>
    <style>
        body { font-family: Arial; background:rgb(240, 242, 245); padding: 40px; text-align: center; }
        table {
            width: 90%; margin: auto; border-collapse: collapse; background: white;
            margin-bottom: 40px;
        }
        th, td {
            padding: 12px; border: 1px solid #ccc; font-size: 16px;
        }
        th {
            background-color:rgb(0, 123, 255); color: white;
        }
        input[type=text] {
            padding: 8px; width: 90%; border-radius: 6px; border: 1px solid #ccc;
        }
        .btn, button {
            padding: 8px 14px; border: none; border-radius: 6px; font-size: 14px; cursor: pointer;
        }
        .add-btn { background:rgb(0, 123, 255); color: white; margin-top: 10px; }
        .edit-btn { background:rgb(255, 193, 7); color: black; }
        .delete-btn { background:rgb(220, 53, 69); color: white; }
        .section-title { font-size: 22px; margin-top: 50px; color: #333; }
        .back-btn {
            background:rgb(108, 117, 125); color: white; padding: 10px 20px;
            margin-top: 40px; border-radius: 8px;
        }
    </style>
</head>
<body>

<h2>Manage Human Rights Institutions</h2>

<form method="POST">
    <h3>Add New Institution</h3>
    <input type="text" name="id" placeholder="Institution ID (e.g. F001, C002)" required>
    <input type="text" name="name" placeholder="Institution Name" required>
    <input type="text" name="range" placeholder="Price Range" required>
    <input type="text" name="city" placeholder="City Corporation" required><br>
    <button type="submit" name="add" class="btn add-btn">Add Institution</button>
</form>

<?php
$type_names = ['F' => 'Food', 'C' => 'Clothes', 'M' => 'Health Care', 'E' => 'Education', 'S' => 'Shelter'];

foreach ($data as $key => $institutions):
?>
    <h3 class="section-title"><?= $type_names[$key] ?> Institutions</h3>
    <?php if (count($institutions) > 0): ?>
        <table>
            <tr><th>ID</th><th>Name</th><th>Price Range</th><th>City</th><th>Actions</th></tr>
            <?php foreach ($institutions as $inst): ?>
                <form method="POST">
                    <tr>
                        <td>
                            <?= $inst['Id'] ?>
                            <input type="hidden" name="id" value="<?= $inst['Id'] ?>">
                        </td>
                        <td><input type="text" name="name" value="<?= $inst['Institution_Name'] ?>"></td>
                        <td><input type="text" name="range" value="<?= $inst['Price_Range'] ?>"></td>
                        <td><input type="text" name="city" value="<?= $inst['City_corporation'] ?>"></td>
                        <td>
                            <button name="update" class="btn edit-btn">Update</button>
                            <a href="?delete=<?= $inst['Id'] ?>" class="btn delete-btn"
                               onclick="return confirm('Delete this institution?')">Delete</a>
                        </td>
                    </tr>
                </form>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No institutions in this category.</p>
    <?php endif; ?>
<?php endforeach; ?>

<br>
<a href="admin_home.php"><button class="back-btn">Back to Admin Home</button></a>

</body>
</html>
