<?php
session_start();
if (isset($_SESSION["username"])) {
    if ($_SESSION["role"] === "admin") {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit;
}

// Capture success or error messages
$success = isset($_GET['success']);
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main">  	
        <input type="checkbox" id="chk" aria-hidden="true">

        <!-- Display Success Message -->
        <?php if ($success): ?>
        <div class="success-message">
            <div class="checkmark">&#10003;</div>
            <p>Registration Successful!</p>
        </div>
        <?php endif; ?>

        <!-- Display Error Message -->
        <?php if ($error): ?>
        <div class="error-message">
            <p><?php echo htmlspecialchars($error); ?></p>
        </div>
        <?php endif; ?>

        <div class="signup">
            <form action="reg.php" method="post">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="fullname" placeholder="Full name" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="cpassword" placeholder="Confirm Password" required>

                <!-- Role Selection (Centered) -->
                <div class="naren" style="color: red">
                    <select name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option> 
                    </select>
                </div>
                <button type="submit">Sign up</button>
            </form>
        </div>

        <div class="login">
            <form action="login.php" method="post">
                <label for="chk" aria-hidden="true">Login</label>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>

                <!-- Role Selection (Centered) -->
                <div class="naren" style="color: red">
                    <select name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
