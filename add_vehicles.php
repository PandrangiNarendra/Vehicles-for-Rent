<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: user_dashboard.php");
    exit;
}

$conn = new mysqli("localhost", "naren", "naren@2005", "vehicle_rental1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $vehicle_name = $conn->real_escape_string($_POST["vehicle_name"]);
    $price = intval($_POST["price"]);
    
    // Handle Image Upload
    $imagePath = "images/default.png"; // Default Image
    if (isset($_FILES["vehicle_image"]) && $_FILES["vehicle_image"]["error"] === UPLOAD_ERR_OK) {
        $imageName = basename($_FILES["vehicle_image"]["name"]);
        $imagePath = "images/" . $imageName;
        move_uploaded_file($_FILES["vehicle_image"]["tmp_name"], $imagePath);
    }

    $query = "INSERT INTO vehicles (vehicle_name, price, images) VALUES ('$vehicle_name', $price, '$imagePath')";
    if ($conn->query($query)) {
        echo "<script>alert('Vehicle uploaded successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error uploading vehicle!');</script>";
    }
}

$conn->close();
?>
