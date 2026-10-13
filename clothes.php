<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_connect.php'; 

$sql = "SELECT * FROM human_rights_institution WHERE Id LIKE 'C%'";

if (isset($_POST['filter'])) {
    $price_range = $_POST['price_range'];
    $city_corporation = $_POST['city_corporation'];

    $sql = "SELECT * FROM human_rights_institution WHERE Id LIKE 'C%'";

    if (!empty($price_range)) {
        $sql .= " AND Price_Range = '$price_range'";
    }
    if (!empty($city_corporation)) {
        $sql .= " AND City_corporation = '$city_corporation'";
    }
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clothes Institutions</title>
   
    <style>
        body {
            font-family: Arial, sans-serif;
            background:rgb(240, 242, 245);
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .filter-form {
            margin-top: 30px;
        }
        .filter-form select, .filter-form button {
            padding: 10px;
            font-size: 16px;
            margin: 5px;
            border-radius: 8px;
            background-color:rgb(0, 123, 255);
            color: white;
        }
        table {
            margin: 30px auto;
            width: 80%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 15px;
            border: 1px solid #ccc;
            font-size: 18px;
        }
        th {
            background-color:rgb(0, 123, 255);
            color: white;
        }
    </style>
</head>
<body>

<h1>Clothes Related Institutions</h1>

<form method="POST" class="filter-form">
    <select name="price_range">
        <option value="">Select Price Range</option>
        <option value="Low">Low</option>
        <option value="Medium">Medium</option>
        <option value="High">High</option>
        <option value="High to medium">High to medium</option>
        <option value="medium to low">Medium to low</option>
    </select>

    <select name="city_corporation">
        <option value="">Select City Corporation</option>
        <option value="North">Dhaka North</option>
        <option value="South">Dhaka South</option>
        <option value="Both">Both</option>
    </select>

    <button type="submit" name="filter">Apply Filter</button>
</form>



<?php
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Institution ID</th><th>Institution Name</th><th>Price Range</th><th>City Corporation</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Id'] . "</td>";
        echo "<td>" . $row['Institution_Name'] . "</td>";
        echo "<td>" . $row['Price_Range'] . "</td>";
        echo "<td>" . $row['City_corporation'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No Institutions Found.</p>";
}
?>
<br>
<a href="home.php" style="display:block; margin: 25px auto; width: fit-content; background: rgb(147, 177, 211);padding: 15px 30px;">Back to Home</a>
</body>
</html>
