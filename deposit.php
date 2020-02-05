<?php
  require 'includes/conn.php';
  if (!isset($_SESSION['admin'])) {
      header('Location:index.php');
  }

  
  $msg = "";
  $date = date("d/m/Y");
  if (isset($_POST['submit'])) {
    if (!empty($_POST['by']) && !empty($_POST['amount'])) {
      $by = mysqli_real_escape_string($con, $_POST['by']);
      $account = $_POST['account'];
      $amount = mysqli_real_escape_string($con, $_POST['amount']);
      if (is_numeric($amount)) {
        $getaccount = mysqli_query($con, "SELECT * FROM account WHERE id = '".$account."'");
        while ($b = mysqli_fetch_assoc($getaccount)) {
          $bname = $b['ac_name'];
          $bid = $b['id'];
          $bbalance = $b['balance'];
        }
        $newbalance = $bbalance + $amount;
        $innew = mysqli_query($con, "UPDATE account SET balance = '".$newbalance."' WHERE id = '".$bid."'");
        $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Bank Deposit', '".$by."', 'Income', '".$amount."', '".$bname."', '".$date."')");
        $inacclog = mysqli_query($con, "INSERT INTO acc_log VALUES('', 'Bank Deposit', '".$by."', 'Income', '".$amount."', '".$bname."', '".$date."')");
        $inexpense = mysqli_query($con, "INSERT INTO expense VALUES('', 'Bank Withdrawal', 'Admin', '".$amount."', '".$date."')");
        $msg = "<div class='alert alert-success'>
                  Deposit Completed successfully. 
                </div>";
      } else {
        $msg = "<div class='alert alert-danger'>
                  Amount must be numeric. 
                </div>";
      }
      
    } else {
      $msg = "<div class='alert alert-danger'>
                Please fill all fields. 
              </div>";
    }
    
  }
  $getaccounts = mysqli_query($con, "SELECT * FROM account ORDER BY ac_name ASC");
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
  <title>IPU - Banking| Withdrawal</title>

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
                  <p>Deposit</p></div>
                  <div class="card-body">
<form action="" method="post" data-parsley-validate>
  <div class="form-group">
    <label for="by">By:</label>
    <input type="text" name="by" id="by" class="form-control" required>
  </div>    
  <div class="form-group">
    <label>Select account:</label>
    <?php
      if (mysqli_num_rows($getaccounts)) {
        echo "<select class='form-control' name='account'>";
        while ($a = mysqli_fetch_assoc($getaccounts)) {
          $ac_name = $a['ac_name'];
          $aid = $a['id'];
          $abalance = $a['balance'];

          echo "<option value='".$aid."'>".$ac_name." (Balance:#".$abalance.")</option>";
        }
        echo "</select>";
      } else {
        echo "Please create an account first";
      }
      
    ?>
  </div>
  <div class="form-group">
    <label for="amount">Amount:</label>
    <input type="number" name="amount" id="amount" class="form-control" required>
  </div>
  <div class="text-center">
      <input type="submit" value="Deposit" name="submit" class="btn btn-info">
  </div>
  <?php echo $msg;?>
</form></div></div></div></div>
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
