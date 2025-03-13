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
    // ✅ Validate form data
    if (empty($_POST["vehicle_name"]) || empty($_POST["make"]) || empty($_POST["model"]) || empty($_POST["price"])) {
        die("Error: All fields are required.");
    }

    $vehicle_name = $_POST["vehicle_name"];
    $make = $_POST["make"];
    $model = $_POST["model"];
    $price = floatval($_POST["price"]);

    // ✅ Image Upload
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $imageName = basename($_FILES["image"]["name"]);
    $imagePath = $targetDir . $imageName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
        // ✅ Insert into database
        $stmt = $conn->prepare("INSERT INTO vehicles (vehicle_name, make, model, price, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssds", $vehicle_name, $make, $model, $price, $imagePath);

        if ($stmt->execute()) {
            echo "<script>alert('Vehicle uploaded successfully!'); window.location.href='admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error uploading vehicle');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error uploading image');</script>";
    }
}

$conn->close();
?>
