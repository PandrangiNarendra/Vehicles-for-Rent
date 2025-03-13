<?php
session_start();
if (isset($_SESSION["username"])) {
    header("Location: dashboard.php"); // Redirect to dashboard if logged in
    exit;
}

$successMessage = $errorMessage = "";

// Handle Registration Form Submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = trim($_POST["fullname"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $role = $_POST["role"];

    if (empty($fullname) || empty($username) || empty($password) || empty($cpassword) || empty($role)) {
        $errorMessage = "All fields are required!";
    } elseif ($password !== $cpassword) {
        $errorMessage = "Passwords do not match!";
    } else {
        // Database Connection
        $conn = new mysqli("localhost", "naren", "naren@2005", "db");
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

        // Check if Username Already Exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM temp_users2 WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($userCount);
        $stmt->fetch();
        $stmt->close();

        if ($userCount > 0) {
            $errorMessage = "Username already exists! Choose a different one.";
        } else {
            // Hash Password for Security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert New User into Database
            $stmt = $conn->prepare("INSERT INTO temp_users2 (full_name, username, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $fullname, $username, $hashedPassword, $role);

            if ($stmt->execute()) {
                $successMessage = "User successfully registered! <a href='inoo.php'>Go to Login</a>";
            } else {
                $errorMessage = "Registration failed. Please try again.";
            }

            $stmt->close();
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        .container { width: 40%; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); text-align: center; }
        h2 { color: #1469c0; }
        .form-group { margin-bottom: 15px; text-align: left; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .error { color: red; font-weight: bold; margin-top: 10px; }
        .success { color: green; font-weight: bold; margin-top: 10px; }
        .btn { background-color: rgb(20, 149, 192); color: white; border: none; padding: 10px; width: 100%; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        .btn:hover { background-color: rgb(11, 110, 160); }
        @media (max-width: 600px) { .container { width: 90%; } }
    </style>
</head>
<body>

<div class="container">
    <h2>User Registration</h2>
    
    <?php if ($errorMessage): ?>
        <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <?php if ($successMessage): ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php else: ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="fullname" required>
            </div>
            
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required>
            </div>
            
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label>Confirm Password:</label>
                <input type="password" name="cpassword" required>
            </div>
            
            <div class="form-group">
                <label>Role:</label>
                <select name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            
            <button type="submit" class="btn">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    <?php endif; ?>
</div>

</body>
</html>
