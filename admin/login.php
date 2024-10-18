<?php
session_start(); // Start the session

// Include the Users class
include_once './classes/Users.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create an instance of the Users class
    $user = new Users();

    try {
        // Attempt to log in the user using the login method
        $loggedInUser = $user->login($username, $password);

        if ($loggedInUser) {
            // Login successful, set session variables
            $_SESSION['admin_username'] = $loggedInUser['UEMAIL'];
            $_SESSION['admin_id'] = $loggedInUser['USERID'];
            $_SESSION['user_type'] = $loggedInUser['Administrator'];
            $_SESSION['admin_logged_in'] = true;

            // Redirect to a protected page (e.g., dashboard)
            header("Location: index.php");
            exit();
        } else {
            // Login failed
            $error = "Invalid username or password.";
        }
    } catch (Exception $e) {
        // Handle exceptions
        $error = "Error logging in: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CMS NACEST</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-image: url('../img/nacest.jpg');
            /* Path to the background image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            /* filter: blur(5px); */
        }

        .login-container {
            height: 100vh;

            justify-content: center;
            align-items: center;
        }

        .login-card {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* backdrop-filter: blur(5px); */
            position: relative;
            z-index: 1;
        }

        .logo {
            width: 100px;
            display: block;
            margin: 0 auto 20px auto;
        }

        .login-card h3 {
            font-size: 24px;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        /* Ensure the background image isn't blurred on the login card */
        main {
            filter: none;
        }
    </style>
</head>

<body>
    <div class="container login-container pt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6  ">
                <div class="login-card">
                    <!-- Logo at the top of the login form -->
                    <img src="../img/nacest logo png.png" alt="Logo" class="logo"> <!-- Path to your logo image -->

                    <!-- Login Form Header -->
                    <h3 class="text-center">Admin Login</h3>

                    <!-- Show error message if login failed -->
                    <?php if (isset($error)) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>

                    <!-- Login Form -->
                    <form action="login.php" method="POST">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="inputUsername" name="username" type="text" placeholder="Username" required />
                            <label for="inputUsername">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" required />
                            <label for="inputPassword">Password</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="remember" />
                            <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <!-- <a class="small" href="password.html">Forgot Password?</a> -->
                            <button class="btn btn-primary" name="student_login" type="submit">Login</button>
                        </div>
                    </form>
                    <!-- <div class="card-footer text-center py-3">
                <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
            </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/bootstrap.bundle.min.js"></script>
</body>

</html>