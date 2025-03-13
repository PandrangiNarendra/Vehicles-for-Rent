<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: user_dashboard.php");
    exit;
}

$username = $_SESSION["username"];

// Database connection
$conn1 = new mysqli("localhost", "naren", "naren@2005", "vehicle_rental1");
$conn2 = new mysqli("localhost", "naren", "naren@2005", "exampleDB");

if ($conn1->connect_error || $conn2->connect_error) {
    die("Connection failed: " . $conn1->connect_error . " / " . $conn2->connect_error);
}

// Get total number of bookings
$booking_result = $conn1->query("SELECT COUNT(*) AS total_bookings FROM bookings");
$total_bookings = $booking_result->fetch_assoc()['total_bookings'];

// Handle delete request for bookings
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_booking_id"])) {
    $booking_id = $_POST["delete_booking_id"];
    $conn1->query("DELETE FROM bookings WHERE id = $booking_id");
    echo "<script>alert('Booking deleted successfully!'); window.location.href='admin_dashboard.php';</script>";
}

// Handle delete request for vehicles
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_vehicle_id"])) {
    $vehicle_id = $_POST["delete_vehicle_id"];
    $conn2->query("DELETE FROM vehicles WHERE id = $vehicle_id");
    echo "<script>alert('Vehicle deleted successfully!'); window.location.href='admin_dashboard.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f3f3; margin: 0; padding: 0; }
        .header { background-color: #333; color: white; text-align: center; padding: 15px; font-size: 20px; }
        .logout { text-align: right; padding: 10px; }
        .logout a { text-decoration: none; color: white; background-color: red; padding: 10px; border-radius: 5px; }
        .container { width: 80%; margin: 20px auto; }
        .section { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 20px; }
        .add a { background:rgb(74, 16, 146); color: white; padding: 10px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 0; }
        .delete-button { background-color: red; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($username); ?>!</p>
        <p>Total Bookings: <?php echo $total_bookings; ?></p>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <div class="container">
        <div class="section add">
            <a href="AddVehiclesForm.php">Upload Vehicles</a>
        </div>

        <h2>Vehicles Uploaded by Admin</h2>
        <div class="section">
            <table>
                <tr>
                    <th>Make</th>
                    <th>Model</th>
                    <th>Vehicle Type</th>
                    <th>Mileage</th>
                    <th>Fuel Type</th>
                    <th>Transmission</th>
                    <th>Seats</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
                <?php
                $result = $conn2->query("SELECT * FROM vehicles");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['make']}</td>";
                        echo "<td>{$row['model']}</td>";
                        echo "<td>{$row['vehicle_type']}</td>";
                        echo "<td>{$row['mileage']}</td>";
                        echo "<td>{$row['fuel_type']}</td>";
                        echo "<td>{$row['transmission']}</td>";
                        echo "<td>{$row['seats']}</td>";
                        echo "<td>{$row['contact_number']}</td>";
                        echo "<td>
                                <form method='post'>
                                    <input type='hidden' name='delete_vehicle_id' value='{$row['id']}'>
                                    <button type='submit' class='delete-button' onclick='return confirm(\"Are you sure you want to delete this vehicle?\")'>Delete</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No vehicles available.</td></tr>";
                }
                ?>
            </table>
        </div>

        <h2>Booking Details</h2>
        <div class="section">
            <table>
                <tr>
                    <th>Username</th>
                    <th>Vehicle Booked</th>
                    <th>Booking Time</th>
                    <th>Actions</th>
                </tr>
                <?php
                $bookings_result = $conn1->query("SELECT id, username, vehicle_name, booking_time FROM bookings");
                if ($bookings_result->num_rows > 0) {
                    while ($row = $bookings_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['username']}</td>";
                        echo "<td>{$row['vehicle_name']}</td>";
                        echo "<td>{$row['booking_time']}</td>";
                        echo "<td>
                                <form method='post'>
                                    <input type='hidden' name='delete_booking_id' value='{$row['id']}'>
                                    <button type='submit' class='delete-button' onclick='return confirm(\"Are you sure you want to delete this booking?\")'>Delete</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No bookings available.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
