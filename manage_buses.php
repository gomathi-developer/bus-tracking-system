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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bus_number']) && isset($_POST['route'])) {
    $bus_number = $_POST['bus_number'];
    $route = $_POST['route'];
    $sql = "INSERT INTO bus (bus_number, route) VALUES ('$bus_number', '$route')";
    if ($conn->query($sql) === TRUE) {
        header("Location: manage_buses.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_bus_number'])) {
    $delete_bus_number = $_POST['delete_bus_number'];
        $sql = "DELETE FROM bus WHERE bus_number='$delete_bus_number'";
    if ($conn->query($sql) === TRUE) {
        header("Location: manage_buses.php");
        exit();
    } else {
        echo "Error deleting bus: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Buses</title>
  <link rel="stylesheet" type="text/css" href="manage_buses.css">
</head>
<body>
<div class="header">
  <h1>Manage Buses</h1>
</div>
<div class="sidebar">
  <ul>
    <li class="menu-item"><a href="admin_dashboard.php">Dashboard</a></li>
    <li class="menu-item"><a href="#">Manage Buses</a></li>
    <li class="menu-item"><a href="manage_drivers.php">Manage Drivers</a></li>
    <li class="menu-item"><a href="#">Reports</a></li>
    <li class="menu-item"><a href="#">Settings</a></li>
    <li class="menu-item"><a href="index.html">Logout</a></li>
  </ul>
</div>
<div class="main-content">
  <h2>Bus List</h2>
  <ul>
<?php
$sql = "SELECT * FROM bus ORDER BY route";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<form action='manage_buses.php' method='POST'>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row['route'];
        echo "<select name='bus_routes[" . $row['bus_number'] . "]'>";
        echo "<option value='none'>Assign Route</option>";
        $sql_bus = "SELECT DISTINCT bus_number FROM bus";
        $busNumbersResult = $conn->query($sql_bus);
        if ($busNumbersResult->num_rows > 0) {
            while ($bus_row = $busNumbersResult->fetch_assoc()) {
                echo "<option value='" . $bus_row['bus_number'] . "'";
                if ($bus_row['bus_number'] == $row['bus_number']) echo " selected"; 
                echo ">" . $bus_row['bus_number'] . "</option>";
            }
        }
        echo "</select>";
        echo "</li>";
    }
    echo "<button type='submit'>Submit</button>";
    echo "</form>";
} else {
    echo "<li>No buses found.</li>";
}
?>
  </ul>

  <hr> <!--                                                        -->

  <h2>Add New Bus</h2>
  <form action="manage_buses.php" method="POST">
    <label for="bus_number">Bus Number:</label>
    <input type="text" id="bus_number" name="bus_number" required>
    <label for="route">Route:</label>
    <input type="text" id="route" name="route" required>
    <button type="submit">Add Bus</button>
  </form>

  <hr> <!--                                                        -->

  <h2>Delete Bus</h2>
  <form action="manage_buses.php" method="POST">
    <label for="delete_bus_number">Bus Number to Delete:</label>
    <input type="text" id="delete_bus_number" name="delete_bus_number" required>
    <button type="submit">Delete Bus</button>
  </form>

  <hr> <!--                                                        -->

  <h2>Select Bus Numbers</h2>
  <?php
  $sql = "SELECT DISTINCT bus_number, route FROM bus";
  $busNumbersResult = $conn->query($sql);

  if ($busNumbersResult->num_rows > 0) {
      echo "<form action='manage_buses.php' method='POST'>";
      echo "<select name='select_bus_number'>";
      echo "<option value='none'>None</option>";
      while ($row = $busNumbersResult->fetch_assoc()) {
          echo "<option value='" . $row['bus_number'] . "'>" . $row['bus_number'] . " - " . $row['route'] . "</option>";
      }
      echo "</select>";
      echo "<button type='submit'>View Details</button>";
      echo "</form>";
  } else {
      echo "<p>No buses found.</p>";
  }
  ?>
</div>
</body>
</html>
