<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Course Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-image: url('./img/nacest.jpg');
            /* Add the path to your background image */
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .login-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .login-card {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
        }

        .logo {
            width: 150px;
            margin-bottom: 20px;
        }

        .login-button {
            margin: 10px;
            width: 150px;
        }
    </style>
</head>

<body>
    <div class="container-fluid login-container">
        <div class="login-card">
            <!-- Logo -->
            <img src="./img/nacest logo png.png" alt="Logo" class="logo img-fluid"> <!-- Add the path to your logo image -->

            <!-- Admin and Student Login Buttons -->
            <div>
                <a href="admin/login.php" class="btn btn-primary login-button">Admin Login</a>
                <a href="students/login.php" class="btn btn-secondary login-button">Student Login</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/bootstrap.bundle.min.js"></script>
</body>

</html>