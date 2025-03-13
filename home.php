<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicles for Rent - Home</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fef9ef;
            color: #333;
        }

        header {
            background-color:rgb(151, 33, 125);
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: yellowgreen;
        }

        .hero {
            background-image: url('vehicles-hero.jpg'); /* Add a relevant image */
            height: 60vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ffffff;
            text-align: center;
            background-size: cover;
            background-position: center;
        }

        .hero h1 {
            font-size: 3em;
            color: #14532d;
        }

        .hero p {
            font-size: 1.5em;
            color: #333;
        }

        .actions {
            margin-top: 20px;
        }

        .actions a {
            background-color:rgb(179, 31, 97);
            color: #fff;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .actions a:hover {
            background-color:rgb(187, 212, 45);
        }

        .footer {
            background-color:rgb(26, 204, 180);
            color: #fff;
            text-align: center;
            padding: 15px 0;
        }

        .footer p {
            margin: 0;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header>
        <div class="logo">Vehicles for Rent</div>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                
                <li><a href="inoo.php">Login</a></li>
                <li><a href="inoo.php">Signup</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div>
            <h1>Rent the Perfect Vehicle for Your Journey</h1>
            <p>Explore our fleet of Bikes, Cars & More.</p>
            
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Vehicles for Rent. All rights reserved.</p>
    </footer>

</body>

</html>
