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
            $_SESSION['studusername'] = $loggedInUser['STUDUSERNAME'];
            $_SESSION['studentid'] = $loggedInUser['StudentID'];
            $_SESSION['logged_in'] = true;

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
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - CMS NACEST</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url('../img/nacest.jpg');
            background-size: cover;
            background-position: center;
            /* filter: blur(5px); */
        }

        #layoutAuthentication {
            position: relative;
            z-index: 1;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 150px;
        }
    </style>
</head>

<body>
    <div id="layoutAuthentication">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="login-container shadow-lg border-0 rounded-lg mt-5">
                            <div class="logo">
                                <img src="../img/nacest logo png.png" alt="Logo"> <!-- Update the logo source accordingly -->
                            </div>
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4">Login</h3>
                            </div>
                            <div class="card-body">
                                <!-- Show error message if login failed -->
                                <?php if (isset($error)) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
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
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Precious Bankok <?= date('Y'); ?></div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="../assets/bootstrap.bundle.min.js"></script>
</body>

</html>