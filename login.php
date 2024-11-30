<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signin App</title>

    <!-- AdminLTE 3.2.0 CSS -->
    <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="AdminLTE-3.2.0/dist/css/adminlte.min.css">

    <style>
        body {
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            width: 400px;
        }
    </style>
</head>
<body class="hold-transition login-page">
<main class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h1"><b>Sign</b>In</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Sign In</button>
                    </div>
                </div>
            </form>

            <p class="mb-0 mt-3 text-center">
                &copy; 2017–2024
            </p>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        include 'admin/koneksi.php';

        $user_email = $_POST['email'];
        $user_password = md5($_POST['password']); // Encrypt password

        try {
            // Prepare the SQL query
            $stmt = $db->prepare("SELECT * FROM user WHERE email = :email AND password = :password");
            
            // Bind parameters
            $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $user_password, PDO::PARAM_STR);
            
            // Execute the query
            $stmt->execute();
            
            // Check if any rows were returned
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                // Start the session and store user data
                session_start();
                $_SESSION['user'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['level'] = $user['level'];

                header('Location: admin/index.php'); // Redirect to admin dashboard
            } else {
                echo "<script>alert('Email and Password are invalid')</script>";
            }
        } catch (PDOException $e) {
            // Handle any errors
            echo "<script>alert('Error: " . $e->getMessage() . "')</script>";
        }
    }
    ?>
</main>

<!-- AdminLTE 3.2.0 JS -->
<script src="adminlte-3.2.0/plugins/jquery/jquery.min.js"></script>
<script src="AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>
</body>
</html>
