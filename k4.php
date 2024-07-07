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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];
    $inputUserType = $_POST['user_type'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ? AND user_type = ?");
    $stmt->bind_param("sss", $inputUsername, $inputPassword, $inputUserType);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['username'] = $inputUsername;
        $_SESSION['user_type'] = $inputUserType;
        switch ($inputUserType) {
            case 'admin':
                header("Location: admin.html");
                break;
            case 'student':
                header("Location: front.html");
                break;
            case 'faculty':
                header("Location: front.html");
                break;
            case 'driver':
                header("Location: driver.html");
                break;
            default:
                echo "Invalid user type.";
                exit();
        }
        exit();
    } else {
        echo "Invalid username, password, or user type.";
    }
    $stmt->close();
}
$conn->close();
?>
