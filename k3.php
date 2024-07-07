<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userlog";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['bus_number']) && !empty($_POST['bus_number'])) {
    $busNumber = $_POST['bus_number'];
    $stmt = $conn->prepare("SELECT * FROM bus WHERE bus_number = ?");
    $stmt->bind_param("s", $busNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $_SESSION['bus_number'] = $busNumber;
        error_log("Redirecting to the page for bus number: $busNumber");
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
    } else {
        echo "Invalid Bus Number";
        error_log("Invalid Bus Number: $busNumber");
    }
    $stmt->close();
} else {
    echo "Please provide a bus number.";
    error_log("Bus number not provided or empty.");
}

$conn->close();
?>
