<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $vehicle_type = $_POST['type'];
    $price = $_POST['price'];
    $mileage = $_POST['mileage'];
    $fuel_type = $_POST['fuel_type'];
    $transmission = $_POST['transmission'];
    $seats = $_POST['seats'];
    $features = $_POST['features'];
    $description = $_POST['description'];
    $contact_number = $_POST['contact_number'];

    // File upload handling
    $image_paths = [];
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
            $file_name = basename($_FILES['images']['name'][$key]);
            $target_path = $upload_dir . $file_name;
            if (move_uploaded_file($tmp_name, $target_path)) {
                $image_paths[] = $target_path;
            } else {
                echo "Failed to upload: " . $file_name . "<br>";
            }
        } else {
            echo "File upload error: " . $_FILES['images']['error'][$key] . "<br>";
        }
    }
    
    $images = implode(",", $image_paths);
    
    // Database connection
    $conn = new mysqli("localhost", "naren", "naren@2005", "exampleDB");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "INSERT INTO vehicles (make, model, year, vehicle_type, price_per_day, mileage, fuel_type, transmission, seats, features, description, images, contact_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("ssisidssissss", $make, $model, $year, $vehicle_type, $price, $mileage, $fuel_type, $transmission, $seats, $features, $description, $images, $contact_number);
    
    if (!$stmt->execute()) {
        echo "Error executing query: " . $stmt->error;
    } else {
        echo "Vehicle added successfully.";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle for Rent</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Add Vehicle for Rent</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="make">Make:</label>
            <input type="text" name="make" id="make" required>

            <label for="model">Model:</label>
            <input type="text" name="model" id="model" required>

            <label for="year">Year:</label>
            <input type="number" name="year" id="year" min="1900" max="2099" required>

            <label for="type">Vehicle Type:</label>
            <select name="type" id="type" required>
                <option value="Car">Car</option>
                <option value="Truck">Truck</option>
                <option value="Bike">Bike</option>
            </select>

            <label for="price">Rental Price per Day ($):</label>
            <input type="number" name="price" id="price" step="0.01" required>

            <label for="mileage">Mileage (km):</label>
            <input type="number" name="mileage" id="mileage" step="1">

            <label for="fuel_type">Fuel Type:</label>
            <select name="fuel_type" id="fuel_type" required>
                <option value="Petrol">Petrol</option>
                <option value="Diesel">Diesel</option>
                <option value="Electric">Electric</option>
                <option value="Hybrid">Hybrid</option>
            </select>

            <label for="transmission">Transmission:</label>
            <select name="transmission" id="transmission" required>
                <option value="Automatic">Automatic</option>
                <option value="Manual">Manual</option>
            </select>

            <label for="seats">Number of Seats:</label>
            <input type="number" name="seats" id="seats" min="1" required>

            <label for="features">Features (comma-separated):</label>
            <input type="text" name="features" id="features">

            <label for="description">Vehicle Description:</label>
            <textarea name="description" id="description"></textarea>

            <label for="images">Upload Images:</label>
            <input type="file" name="images[]" id="images" multiple>

            <label for="contact_number">Contact Number:</label>
            <input type="tel" name="contact_number" id="contact_number" required>
            
            <button type="button" onclick="window.location.href='admin_dashboard.php'" style="background-color: #dc3545;">Go Back</button>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}
.container {
    width: 50%;
    margin: 0 auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px 0px #aaa;
}
label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
}
input, select, textarea {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
button {
    background-color: #28a745;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
}
button:hover {
    background-color: #218838;
}
</style>
