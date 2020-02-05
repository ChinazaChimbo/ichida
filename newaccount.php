<?php
  require 'includes/conn.php';
  if (!isset($_SESSION['admin'])) {
      header('Location:index.php');
  }
$msg = "";
$date = date("d/m/Y");
  if (isset($_POST['submit'])) {
    if (!empty($_POST['name']) && !empty($_POST['bname']) && !empty($_POST['acnumber']) && !empty($_POST['accounttype']) && !empty($_POST['balance'])) {
      $name = mysqli_real_escape_string($con, $_POST['name']);
      $bname = mysqli_real_escape_string($con, $_POST['bname']);
      $accounttype = mysqli_real_escape_string($con, $_POST['accounttype']);
      $balance = mysqli_real_escape_string($con, $_POST['balance']);
      $acnumber = mysqli_real_escape_string($con, $_POST['acnumber']);

      if (is_numeric($acnumber)) {
        if (is_numeric($balance)) {
          if($accounttype != "none"){
            if($bname != "none"){
              $in = mysqli_query($con, "INSERT INTO account VALUES('', '".$name."', '".$acnumber."', '".$bname."', '".$accounttype."', '".$balance."')");
                $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Added new bank account', '".$date."')");
            $msg = "<div class='alert alert-success'>
                      Account created successfully
                </div>";
            }else{
              $msg = "<div class='alert alert-success'>
                      Select bank name type
                </div>";
            }
          }else{
            $msg = "<div class='alert alert-success'>
                      Select account type
                </div>";
          }
            
        } else {
          $msg = "<div class='alert alert-danger'>
                    Balance must be numeric
              </div>";
        }
        
      } else {
        $msg = "<div class='alert alert-danger'>
                Account number must be numeric
              </div>";
      }
      
    } else {
      $msg = "<div class='alert alert-danger'>
                Please fill all fields
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
<?php
        require 'includes/header.php';
    ?>
  <title>IPU - Create Accounts</title>

  <!-- Custom fonts for this template-->
  
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php
        require 'includes/sidebar.php';
    ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php
        require 'includes/topbar.php';
    ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Ichida Progress Union | Banking</h1>

        
        <!-- /.container-fluid -->
        <div class="row">
<div class="col-lg-6">
         <div class="card mb-4">
                <div class="card-header py-3">
                  <p>Create New Account</p></div>
                  <div class="card-body">
<form action="" method="post" data-parsley-validate>
                <div class="form-group row">
                      <label for="name">Account Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="eg. Ichida Progress union" required>
                    </div>
                    <div class="form-group row">
                      <label for="name">Account Number</label>
                    <input type="number" class="form-control" id="acnumber" name="acnumber" required>
                    </div>
                    <div class="form-group row">
                      <div class="form-group">
                        <label for="bank">Bank name</i></label>
                        <select type="text" class="form-control " id="bank" name="bname">
                          <option selected value="none">Choose</option>
                          <option value="access">Access Bank</option>
                          <option value="citibank">Citibank</option>
                          <option value="diamond">Diamond Bank</option>
                          <option value="ecobank">Ecobank</option>
                          <option value="fidelity">Fidelity Bank</option>
                          <option value="fcmb">First City Monument Bank (FCMB)</option>
                          <option value="fsdh">FSDH Merchant Bank</option>
                          <option value="gtb">Guarantee Trust Bank (GTB)</option>
                          <option value="heritage">Heritage Bank</option>
                          <option value="Keystone">Keystone Bank</option>
                          <option value="rand">Rand Merchant Bank</option>
                          <option value="skye">Skye Bank</option>
                          <option value="stanbic">Stanbic IBTC Bank</option>
                          <option value="standard">Standard Chartered Bank</option>
                          <option value="sterling">Sterling Bank</option>
                          <option value="suntrust">Suntrust Bank</option>
                          <option value="union">Union Bank</option>
                          <option value="uba">United Bank for Africa (UBA)</option>
                          <option value="unity">Unity Bank</option>
                          <option value="wema">Wema Bank</option>
                          <option value="zenith">Zenith Bank</option>
                        </select> </div>
<div class="form-group">
  <label for="accounttype"> Account Type</label>
  <select type="text" class="form-control" id="accounttype" name="accounttype">
    <option selected value="none">choose</option>
    <option value="Savings">Savings</option>
    <option value="Current">Current</option>
    <option value="Fixed">Fixed Deposit</option>
    <option value="credit">credit</option>
  </select>
</div></div>


                    <div class="form-group row">
                        <label for="name">Current Balance</label>
                    <input type="number" class="form-control" id="balance" name="balance" placeholder="eg. 3000">
                    </div>

                    <?php echo $msg;?><br>
                        <div class="text-center">
                            <input type="submit" value="Create" name="submit" class="btn btn-success">
                        </div>
</form></div></div></div></div>
     </div>             
</div>


      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; IPU 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal--
 <?php
    require 'includes/logoutmodal.php';
?>
  <!-- Bootstrap core JavaScript-->
  <?php
    require 'includes/scripts.php';
?>
</body>
</html>
