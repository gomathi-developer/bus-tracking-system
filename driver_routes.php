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

$driver_username = $_SESSION['username'];
$sql = "SELECT * FROM routes WHERE driver_username='$driver_username'";
$result = $conn->query($sql);

$routes = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $routes[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Routes</title>
    <link rel="stylesheet" type="text/css" href="driver.css">
</head>
<body>
    <div class="header">
        <h1>Driver Routes</h1>
    </div>
    <div class="sidebar">
        <ul>
            <li class="menu-item"><a href="driver.html">Dashboard</a></li>
            <li class="menu-item"><a href="driver_routes.php">My Routes</a></li>
            <li class="menu-item"><a href="driver_schedule.php">Schedule</a></li>
            <li class="menu-item"><a href="#">Notifications</a></li>
            <li class="menu-item"><a href="#">Messages</a></li>
            <li class="menu-item"><a href="driver_profile.php">Profile</a></li>
            <li class="menu-item"><a href="#">Emergency</a></li>
            <li class="menu-item"><a href="index.html">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2>My Routes</h2>
        <ul>
            <?php foreach ($routes as $route): ?>
                <li><?php echo $route['route_time'] . ' - ' . $route['route_description']; ?></li>
            <?php endforeach; ?>
            <?php if (empty($routes)): ?>
                <li>No routes assigned.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
