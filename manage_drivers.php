<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'admin') {
    header("Location: index.html");
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userlog";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $bus_number = $_POST['bus_number'];
    $contact = $_POST['contact'];
    $route = $_POST['route'];
    $sql = "INSERT INTO drivers (username, password, name, bus_number, contact, route) VALUES ('$username', '$password', '$name', '$bus_number', '$contact', '$route')";
    if ($conn->query($sql) === TRUE) {
        echo "New driver added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$sql = "SELECT * FROM drivers";
$result = $conn->query($sql);
$drivers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $drivers[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Drivers</title>
  <link rel="stylesheet" type="text/css" href="manage_drivers.css">
</head>
<body>
<div class="header">
  <h1>Manage Drivers</h1>
</div>
<div class="sidebar">
  <ul>
    <li class="menu-item"><a href="admin_dashboard.php">Dashboard</a></li>
    <li class="menu-item"><a href="manage_buses.php">Manage Buses</a></li>
    <li class="menu-item"><a href="#">Manage Drivers</a></li>
    <li class="menu-item"><a href="#">Reports</a></li>
    <li class="menu-item"><a href="#">Settings</a></li>
    <li class="menu-item"><a href="index.html">Logout</a></li>
  </ul>
</div>
<div class="main-content">
  <h2>Driver List</h2>
  <ul>
    <?php foreach ($drivers as $driver): ?>
    <li><?php echo $driver['name'] . ' - ' . $driver['bus_number'] . ' - ' . $driver['route']; ?></li>
    <?php endforeach; ?>
  </ul>
  <h2>Add New Driver</h2>
  <form action="manage_drivers.php" method="POST">
    <div class="form-label">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br>
    </div>
    <div class="form-label">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>
    </div>
<div class="form-label">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br>
</div>
<div class="form-label">
    <label for="bus_number">Bus Number:</label>
    <input type="text" id="bus_number" name="bus_number" required><br>
</div>
<div class="form-label">
    <label for="contact">Contact:</label>
    <input type="text" id="contact" name="contact" required><br>
</div>
<div class="form-label">
    <label for="route">Route:</label>
    <input type="text" id="route" name="route" required><br>
</div>
    <button type="submit">Add Driver</button>
  </form>
</div>
</body>
</html>
