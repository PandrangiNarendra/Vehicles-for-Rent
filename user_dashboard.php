<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "user") {
    header("Location: user_dashboard.php");
    exit;
}
$username = $_SESSION["username"];

$conn = new mysqli("localhost", "naren", "naren@2005", "exampleDB");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Vehicles for Rent</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        .header { background-color: rgb(20, 149, 192); color: white; text-align: center; padding: 15px; font-size: 20px; }
        .logout { text-align: right; padding: 10px; }
        .logout a { text-decoration: none; color: white; background-color: red; padding: 10px; border-radius: 5px; }
        .container { width: 80%; margin: 20px auto; }
        .section { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 20px; }
        .vehicle-item { display: flex; align-items: center; border: 1px solid #ddd; padding: 15px; background-color: #fafafa; border-radius: 5px; margin-bottom: 15px; }
        .vehicle-item img { width: 100px; height: auto; object-fit: cover; border-radius: 5px; margin-right: 15px; }
        .book-button { background-color: rgb(11, 153, 196); color: white; border: none; padding: 10px; cursor: pointer; border-radius: 4px; transition: background 0.3s ease-in-out; }
        .book-button:hover { background-color: rgb(41, 172, 205); }
        .time-select, .duration-select { padding: 5px; margin: 10px 0; width: 100%; border: 1px solid #ddd; border-radius: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>User Dashboard - Vehicles for Rent</h1>
        <p>Hi, <?php echo htmlspecialchars($username); ?>! Welcome to your dashboard.</p>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <div class="container">

        <?php
        // Array of vehicle categories
        $categories = ["Bike", "Car", "Truck"];

        foreach ($categories as $category) {
            echo "<div class='section'>";
            echo "<h2>{$category}s for Rent</h2>";

            $stmt = $conn->prepare("SELECT * FROM vehicles WHERE vehicle_type = ?");
            $stmt->bind_param("s", $category);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $image = !empty($row['images']) ? $row['images'] : 'images/default.png';
                    echo "<div class='vehicle-item'>";
                    echo "<img src='{$image}' alt='{$row['make']} {$row['model']}'>";
                    echo "<div>";
                    echo "<h3>{$row['make']} {$row['model']} ({$row['year']})</h3>";
                    echo "<p>₹<span class='hourly-price'>{$row['price_per_day']}</span> per hour</p>";
                    echo "<form action='book.php' method='post'>
                            <input type='hidden' name='vehicle_id' value='{$row['id']}'>
                            <input type='hidden' name='vehicle_name' value='{$row['make']} {$row['model']}'>
                            <input type='hidden' name='price_per_hour' value='{$row['price_per_day']}'>
                            
                            <label>Select Time:</label>
                            <input type='datetime-local' name='booking_time' required class='time-select'>

                            <label>Select Duration (Hours):</label>
                            <select name='duration' class='duration-select' onchange='updateTotal(this, {$row['price_per_day']})'>
                                <option value='1'>1 Hour</option>
                                <option value='2'>2 Hours</option>
                                <option value='3'>3 Hours</option>
                                <option value='4'>4 Hours</option>
                                <option value='5'>5 Hours</option>
                            </select>

                            <p>Total Price: ₹<span class='total-price'>{$row['price_per_day']}</span></p>

                            <button type='submit' class='book-button'>Book Now</button>
                          </form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No {$category}s available.</p>";
            }
            echo "</div>";
        }

        $conn->close();
        ?>

    </div>

<script>
    function updateTotal(select, pricePerHour) {
        let selectedHours = select.value;
        let totalPrice = selectedHours * pricePerHour;
        select.parentNode.querySelector('.total-price').innerText = totalPrice;
    }
</script>

</body>
</html>
