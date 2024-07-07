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
$sql = "SELECT COUNT(*) as bus_count FROM bus";
$busResult = $conn->query($sql);
$busCount = $busResult->fetch_assoc()['bus_count'];
$sql = "SELECT COUNT(*) as driver_count FROM drivers";
$driverResult = $conn->query($sql);
$driverCount = $driverResult->fetch_assoc()['driver_count'];
$sql = "SELECT * FROM bus";
$busListResult = $conn->query($sql);
$sql = "SELECT DISTINCT bus_number, route FROM bus"; 
$busNumbersResult = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="admindashboard1.css">
</head>
<body>
<div class="header">
  <h1>Admin Dashboard</h1>
</div>
<div class="sidebar">
  <ul>
    <li class="menu-item"><a href="#">Dashboard</a></li>
    <li class="menu-item"><a href="manage_buses.php">Manage Buses</a></li>
    <li class="menu-item"><a href="manage_drivers.php">Manage Drivers</a></li>
    <li class="menu-item"><a href="#">Reports</a></li>
    <li class="menu-item"><a href="#">Settings</a></li>
    <li class="menu-item"><a href="index.html">Logout</a></li>
  </ul>
</div>
<div class="main-content">
  <div class="overview">
    <h2>Overview</h2>
    <p>Total Buses: <?php echo $busCount; ?></p>
    <p>Total Drivers: <?php echo $driverCount; ?></p>
  </div>
  <div class="bus-list">
    <h2>Current  Bus Location</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"> <!--                        -->
      <select name="select_bus_number">
        <?php
        if ($busNumbersResult->num_rows > 0) {
            while ($row = $busNumbersResult->fetch_assoc()) {
                echo "<option value='" . $row['bus_number'] . "'>" . $row['bus_number'] . " - " . $row['route'] . "</option>";
            }
        } else {
            echo "<option value=''>No buses found</option>";
        }
        ?>
      </select>
      <button type="submit">View Details</button>
    </form>
  </div>

  <!--                                  -->
  <div class="additional-bus-list">
    <h2>Bus List</h2>
    <ul>
      <?php
      $sql = "SELECT bus_number, route FROM bus";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<li>" . $row['bus_number'] . " - " . $row['route'] . "</li>";
          }
      } else {
          echo "<li>No buses found.</li>";
      }
      ?>
    </ul>
  </div>
</div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select_bus_number']) && !empty($_POST['select_bus_number'])) {
    $busNumber = $_POST['select_bus_number'];
switch ($busNumber) {
        case '15':
            header("Location: home.html");
            exit();
        case '10':
            header("Location: home2.html");
            exit();
        case '1':
            header("Location: home3.html");
            exit();
        case '7':
            header("Location: home4.html");
            exit();
        case '11':
            header("Location: home5.html");
            exit();
        default:
            echo "Unknown bus type.";
            exit();
    }
}
?>
