<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: inoo.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_name = $_POST['vehicle_name'];
    $price_per_hour = $_POST['price_per_hour']; // Fix: Use price_per_hour
    $duration = $_POST['duration']; // New: Get duration from form
    $total_price = $price_per_hour * $duration; // Calculate total price
    $username = $_SESSION["username"];

    $conn = new mysqli("localhost", "naren", "naren@2005", "vehicle_rental1");

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO bookings (username, vehicle_name, price, booking_time) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("ssi", $username, $vehicle_name, $total_price);

    if ($stmt->execute()) {
        echo "<p>Booking successful for $vehicle_name at ₹$total_price.</p>";
        echo "<a href='user_dashboard.php'>Back to Dashboard</a>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>
