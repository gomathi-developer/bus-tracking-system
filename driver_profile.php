<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'driver') {
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
$driverUsername = $_SESSION['username'];
$sql = "SELECT * FROM drivers WHERE username = '$driverUsername'";
$result = $conn->query($sql);
$driver = [];
if ($result->num_rows > 0) {
    $driver = $result->fetch_assoc();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Driver Profile</title>
  <link rel="stylesheet" type="text/css" href="driver.css">
</head>
<body>
<div class="header">
  <h1>Profile</h1>
</div>
<div class="sidebar">
  <ul>
    <li class="menu-item"><a href="driver_routes.php">Routes</a></li>
    <li class="menu-item"><a href="driver_schedule.php">Schedule</a></li>
    <li class="menu-item"><a href="#">Notifications</a></li>
    <li class="menu-item"><a href="#">Messages</a></li>
    <li class="menu-item"><a href="driver_profile.php">Profile</a></li>
    <li class="menu-item"><a href="#">Emergency</a></li>
    <li class="menu-item"><a href="index.html">Logout</a></li>
  </ul>
</div>
<div class="main-content">
  <h2>Your Profile</h2>
  <p><strong>Name:</strong> <?php echo $driver['name']; ?></p>
  <p><strong>Bus Number:</strong> <?php echo $driver['bus_number']; ?></p>
  <p><strong>Contact:</strong> <?php echo $driver['contact']; ?></p>
</div>
</body>
</html>
