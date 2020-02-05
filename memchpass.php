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
                    $msg = "<div class='alert alert-danger'role='alert'>
                            <button class='delete'></button>
                            Password could not be changed.
                        </div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'role='alert'>
                            <button class='delete'></button>
                            The new password entered does not match with the confirmation.
                        </div>";
            }
        }else {
            $msg = "<div class='alert alert-danger'role='alert'>
                        <button class='delete'></button>
                        Please fill all fields.
                    </div>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Member| Change Password</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="chpass/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="chpass/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="chpass/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="chpass/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="chpass/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="chpass/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="chpass/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="chpass/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="chpass/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="chpass/css/util.css">
	<link rel="stylesheet" type="text/css" href="chpass/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-b-160 p-t-50">
				<form class="login100-form validate-form" action="memchpass.php" method="post">
					<span class="login100-form-title p-b-43">
						Change Password
					</span>
					
					<div class="wrap-input100 rs1 validate-input" data-validate = "Username is required">
						<input class="input100" type="password" name="npass" id="npass">
						<span class="label-input100">New password</span>
					</div>
					
					
					<div class="wrap-input100 rs2 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="cnpass" id="cnpass">
						<span class="label-input100">Confirm New Password</span>
					</div>
					<br>
					<?php echo $msg;?>

					<div class="container-login100-form-btn">
						<input type="submit" value="Change Password" class="btn btn-primary btn-user btn-block" name="submit">
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
	
<!--===============================================================================================-->
	<script src="chpass/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="chpass/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="chpass/vendor/bootstrap/js/popper.js"></script>
	<script src="chpass/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="chpass/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="chpass/vendor/daterangepicker/moment.min.js"></script>
	<script src="chpass/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="chpass/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="chpass/js/main.js"></script>

</body>
</html>