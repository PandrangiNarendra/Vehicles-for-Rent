<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: inoo.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Vehicles for Rent</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f3f3; margin: 0; padding: 0; }
        .header { background-color: #4CAF50; color: white; text-align: center; padding: 10px; }
        .logout { text-align: right; margin: 10px; }
        .logout a { text-decoration: none; color: white; background-color: red; padding: 8px 12px; border-radius: 5px; }
        .section { margin: 15px; padding: 10px; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .vehicle-item { border: 1px solid #ddd; padding: 10px; margin: 10px 0; background-color: #fafafa; border-radius: 5px; }
        .vehicle-item h3 { margin: 0; }
        .vehicle-item p { margin: 5px 0; }
        .vehicle-item form { margin-top: 10px; }
        button { background-color: #4CAF50; color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 4px; }
    </style>
</head>

<body>

    <div class="header">
        <h1>Dashboard - Vehicles for Rent</h1>
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <div class="section">
        <h2>Bikes for Rent</h2>
        <?php
        $bikes = [
            ["name" => "Honda Activa", "price" => 350],
            ["name" => "Royal Enfield", "price" => 550],
            ["name" => "Yamaha R15", "price" => 400]
        ];
        foreach ($bikes as $bike) {
            echo "<div class='vehicle-item'>";
            echo "<h3>{$bike['name']}</h3>";
            echo "<p>₹{$bike['price']} per hour</p>";
            echo "<form action='book.php' method='post'>
                    <input type='hidden' name='vehicle_name' value='{$bike['name']}'>
                    <input type='hidden' name='price' value='{$bike['price']}'>
                    <button type='submit'>Book Now</button>
                  </form>";
            echo "</div>";
        }
        ?>
    </div>

    <div class="section">
        <h2>Cars for Rent</h2>
        <?php
        $cars = [
            ["name" => "Hyundai i10", "price" => 800],
            ["name" => "Toyota Innova", "price" => 1000],
            ["name" => "Maruti Suzuki Swift", "price" => 900]
        ];
        foreach ($cars as $car) {
            echo "<div class='vehicle-item'>";
            echo "<h3>{$car['name']}</h3>";
            echo "<p>₹{$car['price']} per hour</p>";
            echo "<form action='book.php' method='post'>
                    <input type='hidden' name='vehicle_name' value='{$car['name']}'>
                    <input type='hidden' name='price' value='{$car['price']}'>
                    <button type='submit'>Book Now</button>
                  </form>";
            echo "</div>";
        }
        ?>
    </div>

</body>

</html>
