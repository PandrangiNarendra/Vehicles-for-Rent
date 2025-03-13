<?php
session_start();
if(isset($_SESSION["username"]))
{
    header("Location:dashboard.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"]==="POST")
{
    $username = $_POST["username"];
    $password = $_POST["password"]; 
    $role = $_POST["role"];  // Capture the role from the form
    $conn = new mysqli("localhost", "naren", "naren@2005", "db");

    // Check connection
    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    // Secure query with prepared statement
    $stmt = $conn->prepare("SELECT password, role FROM temp_users2 WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];
        $dbRole = $row['role']; // Fetch role from DB

        if (password_verify($password, $storedPassword)) 
        {
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $dbRole;  // Store role in session

            // Redirect based on role
            if ($dbRole === "admin") {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit;
        } 
        else 
        {
            echo "Invalid password ";
        }
    }
    else
    {
        echo "Invalid username or password";
    }

    echo '<br><a href="inoo.php">back to login</a>';
    $conn->close();
}
?>
