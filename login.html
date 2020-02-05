<?php
    require 'includes/conn.php';
    if (isset($_SESSION['admin'])) {
        header('Location:dashboard.php');
    }elseif (isset($_SESSION['member'])) {
        header('Location:memberdashboard.php');
    }
    //login code
    $msg = "";
    if (isset($_POST['submit'])) {
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $username = mysqli_real_escape_string($con, $_POST['username']);
            $password = mysqli_real_escape_string($con, $_POST['password']);

            if ($username == "admin") {
                $check = mysqli_query($con, "SELECT * FROM admin WHERE username = '".$username."' AND password = '".$password."'");
                if (mysqli_num_rows($check)) {
                    $_SESSION['admin'] = $username; 
                    $_SESSION['success'] = "You are now logged in";
                    header("Location:dashboard.php");
                }else{
                    $msg = "<div class='notification is-danger'>
                            <button class='delete'></button>
                            Incorrect username or password.
                        </div>";
                }
            } else {
                $check = mysqli_query($con, "SELECT * FROM members WHERE username = '".$username."' AND password = '".$password."'");
                if (mysqli_num_rows($check)) {
                    while ($a = mysqli_fetch_assoc($check)) {
                        $id = $a['id'];
                    }
                    $_SESSION['member'] = $id; 
                    $_SESSION['success'] = "You are now logged in";
                    if ($password == "12345") {
                        header("Location:memchpass.php");
                    } else {
                        header("Location:dashboard.php");
                    }
                }else{
                    $msg = "<div class='notification is-danger'>
                            <button class='delete'></button>
                            Incorrect username or password.
                        </div>";
                }
            }
        }else{
            $msg = "<div class='notification is-danger'>
                        <button class='delete'></button>
                        Please fill all fields.
                    </div>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>IPU - Login</title>
<link rel="icon" type="image/png" href="login/images/icons/favicon.ico"/>
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body background="bg_1.jpg">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <div class="logo-img">
                                <a href="index.html">
                                    <img src="img/logo.png" alt="">
                                </a>
                            </div>
                    <a class="navbar-brand" href="index.html">ICHIDA PROGRESS UNION<span>Motto: Peace, Unity& Progress</span></a>
                  </div>
                  <form action="index.php" method="post" data-parsley-validate>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="username" name="username"  placeholder="Username....">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    <?php
                            echo $msg;
                        ?>
                    <input type="submit" value="Login" class="btn btn-primary btn-user btn-block" name="submit">
                      
                  
                    <hr>
                  </form>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
