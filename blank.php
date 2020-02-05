<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['member'])) {
        header('Location:index.php');
    }
    
    $msg = "";
    if (isset($_POST['submit'])) {
        if (!empty($_POST['npass']) && !empty($_POST['cnpass'])) {
            $npass = mysqli_real_escape_string($con, $_POST['npass']);
            $cnpass = mysqli_real_escape_string($con, $_POST['cnpass']);
            if ($npass == $cnpass) {
                if($in = mysqli_query($con, "UPDATE members SET password = '".$npass."' WHERE id = '".$_SESSION['member']."'")){
                    header("Location:memberdashboard.php");
                }else{
                    $msg = "<div class='notification is-danger'>
                            <button class='delete'></button>
                            Password could not be changed.
                        </div>";
                }
            } else {
                $msg = "<div class='notification is-danger'>
                            <button class='delete'></button>
                            The new password entered does not match with the confirmation.
                        </div>";
            }
        }else {
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | Dashboard</title>
  <meta name="description" content="">
  <meta name="author" content="">
<?php
        require 'includes/header.php';
    ?>

  <!-- Custom fonts for this template-->
  
</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                    <p class="mb-4">We get it, stuff happens. Just fill the form below to reset your password!</p>
                  </div>
                  <form action="memchpass.php" method="post" data-parsely-validate>
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id='npass' name='npass' placeholder="New Password">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id='cnpass' name='cnpass' placeholder="Repeat Password">
                  </div>
                </div>
                <?php echo $msg;?><br>
                    <a href="login.html" class="btn btn-primary btn-user btn-block">
                      Change Password
                    </a>
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
  <!-- End of Page Wrapper -->
  

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
</body>

</html>
