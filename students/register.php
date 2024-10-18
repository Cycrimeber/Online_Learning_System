<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate form data
    if ($_POST['studpass'] !== $_POST['confirmpass']) {
        echo "<div class='alert alert-danger'>Passwords do not match.</div>";
    } elseif (empty($_FILES['photo']['name'])) {
        echo "<div class='alert alert-danger'>Please upload a profile picture.</div>";
    } else {
        // All form data is sent to the register method
        include 'classes/users.php';
        $users = new Users();
        $result = $users->register($_POST, $_FILES);

        if ($result === true) {
            $msg = "<script>Registration successful!</script>";
            header("Location: login.php");
        } else {
            // Display specific error returned from the register method
            $msg = "<div class='alert alert-danger'>$result</div>";
        }
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
    <title>Register - CMS</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url('../img/nacest.jpg');
            /* Replace with your background image path */
            background-size: cover;
            background-position: center;
        }

        .logo {
            width: 100px;
            /* Adjust size as needed */
            margin: 20px auto;
            /* Center logo */
        }

        /* Adding opacity to the card */
        .card {
            background-color: rgba(255, 255, 255, 0.8);
            /* White with 80% opacity */
        }
    </style>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow-lg border-0 rounded-lg my-5">
                                <div class="card-header text-center">
                                    <img src="../img/nacest logo png.png" alt="Logo" class="logo"> <!-- Replace with your logo path -->
                                    <h3 class="font-weight-light my-4">Create Account</h3>
                                    <?php if (isset($msg)) {
                                        echo $msg;
                                    } ?>
                                </div>
                                <div class="card-body">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName" name="fname" type="text" placeholder="Enter your first name" required />
                                                    <label for="inputFirstName">First name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="inputLastName" name="lname" type="text" placeholder="Enter your last name" required />
                                                    <label for="inputLastName">Last name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputMatricNo" name="matricno" type="text" placeholder="Matric No" required />
                                            <label for="inputMatricNo">Matric No</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputAddress" name="address" type="text" placeholder="Address" required />
                                            <label for="inputAddress">Address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputMobileNo" name="mobile" type="text" placeholder="Mobile No" required />
                                            <label for="inputMobileNo">Mobile No</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPhoto" name="photo" type="file" placeholder="Upload Profile Picture" />
                                            <label for="inputPhoto">Profile Picture</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-control" id="inputDepartment" name="department" required>
                                                <option value="">Select Department</option>
                                                <option value="Computer Science">Computer Science</option>
                                                <option value="Banking and Finance Science">Banking and Finance</option>
                                                <option value="SLT">Science Laboratory Technology</option>
                                                <option value="BAM">Business Administration and Management</option>
                                                <option value="Computer Engineering">Computer Engineering</option>
                                                <option value="building tech">Building Technology</option>
                                                <option value="estate mgt">Estate Management</option>
                                                <!-- Other departments... -->
                                            </select>
                                            <label for="inputDepartment">Department</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-control" id="inputLevel" name="level" required>
                                                <option value="">Select Level</option>
                                                <option value="nd1">ND 1</option>
                                                <option value="nd2">ND 2</option>
                                                <option value="hnd1">HND 1</option>
                                                <option value="hnd2">HND 2</option>
                                                <!-- Other levels... -->
                                            </select>
                                            <label for="inputLevel">Level</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputStudUsername" name="studusername" type="text" placeholder="Username" required />
                                            <label for="inputStudUsername">Username</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPassword" name="studpass" type="password" placeholder="Password" required />
                                                    <label for="inputPassword">Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPasswordConfirm" name="confirmpass" type="password" placeholder="Confirm Password" required />
                                                    <label for="inputPasswordConfirm">Confirm Password</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><button type="submit" class="btn btn-primary btn-block">Create Account</button></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
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