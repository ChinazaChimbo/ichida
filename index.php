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
            }elseif ($username == "user" && $password == "user") {
              $_SESSION['admin'] = $username;
              $_SESSION['user'] = $username;
              header("Location:userdashboard.php");
            } else {
                $check = mysqli_query($con, "SELECT * FROM members WHERE username = '".$username."' AND password = '".$password."'");
                if (mysqli_num_rows($check)) {
                    while ($a = mysqli_fetch_assoc($check)) {
                        $id = $a['id'];
                    }
                    $_SESSION['member'] = $id; 
                    $_SESSION['success'] = "You are now logged in";
                    if ($password == "$mn") {
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
	<title>Login V18</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="login/images/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login/vendor/daterangepicker/daterangepicker.css">
<!--=============================================login/==================================================-->
	<link rel="stylesheet" type="text/css" href="login/css/util.css">
	<link rel="stylesheet" type="text/css" href="login/css/main.css">
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="index.php" method="post">
					<span class="login100-form-title p-b-43">
					    <h4><font color="red">Town Union Mangement System</font></h4>
					    <div class="text-center"><h5>for</h5></div>
					    <h4><font color="green">Ichida Progress Union Lagos Branch</font></h4>
						<img src="login/images/icons/logo.png">
						<h6 style="color=black;">Members Login</h6>
					</span>
					<div class="wrap-input100 validate-input" data-validate = "Valid usernasme is required">
						<input class="input100" type="text" id="username" name="username">
						<span class="focus-input100"></span>
						<span class="label-input100">Username</span>
					</div>
					
					
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" id="password">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								login/Remember me
							</label>
						</div>
					</div>
			

					<div class="container-login100-form-btn">
						 <input type="submit" value="Login" class="btn btn-primary btn-user btn-block" name="submit">
					</div>
          <br>
					<?php
                            echo $msg;
                        ?>
					
				</form>

				<div class="login100-more">
					<div id="demo" class="carousel slide" data-ride="carousel">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
    <li data-target="#demo" data-slide-to="3"></li>
  </ul>

  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="login/images/bg-11.jpg" alt="ipu">
      <div class="carousel-caption">
    <h2>ICHIDA PROGRESS UNION</h2>
    <h5><font color="white">Ichida town Hall</font></h5>
  </div>
    </div>
    <div class="carousel-item">
      <img src="login/images/bg-02.jpg" alt="log">
      <div class="carousel-caption">
    <h2>ICHIDA PROGRESS UNION</h2>
    <h5><font color="black">IPU at Anambra Cultural Day, Lagos</font></h5>
  </div>
    </div>
    <div class="carousel-item">
      <img src="login/images/bg-01.jpg" alt="New York">
      <div class="carousel-caption">
    <h2>ICHIDA PROGRESS UNION</h2>
    <h5><font color="black">IPU at Anambra Cultural Day, Lagos</font></h5>
  </div>
    </div>
    <div class="carousel-item">
      <img src="login/images/bg-04.jpg" alt="New York">
      <div class="carousel-caption">
    <h2>ICHIDA PROGRESS UNION</h2>
    <h5><font color="black">IPU at Anambra Cultural Day, Lagos</font></h5>
  </div>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>

</div>
				</div>
			</div>
		</div>
	</div>
	
	

	
	
<!--===============================================================================================-->
	<script src="login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/bootstrap/js/popper.js"></script>
	<script src="login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/daterangepicker/moment.min.js"></script>
	<script src="login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="login/js/main.js"></script>

</body>
</html>