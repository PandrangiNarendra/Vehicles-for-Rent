<?php
$servername = "localhost";
$username = "naren"; // your MySQL username
$password = "naren@2005"; // your MySQL password
$dbname = "exampleDB"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle image upload
$imagePaths = [];
if (!empty($_FILES['images']['name'][0])) {
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $imageName = basename($_FILES['images']['name'][$key]);
        $imagePath = $uploadDir . $imageName;

        if (move_uploaded_file($tmpName, $imagePath)) {
            $imagePaths[] = $imagePath;
        }
    }
}

$make = $_POST['make'];
$model = $_POST['model'];
$year = $_POST['year'];
$type = $_POST['type'];
$price = $_POST['price'];
$mileage = $_POST['mileage'];
$fuel_type = $_POST['fuel_type'];
$transmission = $_POST['transmission'];
$seats = $_POST['seats'];
$features = $_POST['features'];
$description = $_POST['description'];
$contact_number = $_POST['contact_number'];
$images = implode(',', $imagePaths);

$sql = "INSERT INTO vehicles (make, model, year, vehicle_type, price_per_day, mileage, fuel_type, transmission, seats, features, images, contact_number)
        VALUES ('$make', '$model', '$year', '$type', '$price', '$mileage', '$fuel_type', '$transmission', '$seats', '$features', '$images', '$contact_number')";

if ($conn->query($sql) === TRUE) {
    echo "New vehicle added successfully.";
    header("Location: admin_dashboard.php"); // Redirect back to dashboard
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
