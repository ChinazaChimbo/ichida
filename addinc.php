<?php
  require 'includes/conn.php';
  if (!isset($_SESSION['admin'])) {
      header('Location:index.php');
  }
  $getbanks = mysqli_query($con, "SELECT * FROM account ORDER BY ac_name ASC");
  $msg = "";
  $date = date("d/m/Y");

  if (isset($_POST['cashbtn'])) {
    if (!empty($_POST['catitle']) && !empty($_POST['caby']) && !empty($_POST['caamount'])) {
      $title = mysqli_real_escape_string($con, $_POST['catitle']);
      $by = mysqli_real_escape_string($con, $_POST['caby']);
      $amount = mysqli_real_escape_string($con, $_POST['caamount']);
      
      if (is_numeric($amount)) {
        $in = mysqli_query($con, "INSERT INTO cash VALUES('', '".$title."', '".$by."', '".$amount."', '".$date."')");
        $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', '".$title."', '".$by."', 'Income', '".$amount."', 'Cash', '".$date."')");
        $msg = "<div class='alert alert-success'>
                  Income added successfully.
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

  if (isset($_POST['chequebtn'])) {
    if (!empty($_POST['chby']) && !empty($_POST['chno']) && !empty($_POST['chamo'])) {
      $by = mysqli_real_escape_string($con, $_POST['chby']);
      $no = mysqli_real_escape_string($con, $_POST['chno']);
      $amount = mysqli_real_escape_string($con, $_POST['chamo']);
      
      if (is_numeric($amount)) {
        if(is_numeric($no)){
          $in = mysqli_query($con, "INSERT INTO cheque VALUES('', '".$by."', '".$no."', '".$amount."', '".$date."', FALSE)");
          $incash = mysqli_query($con, "INSERT INTO cash VALUES('', 'Cheque', '".$no."', '".$amount."', '".$date."')");
          $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Cheque Payment ".$no."', '".$by."', 'Income', '".$amount."', 'Cheque', '".$date."')");
          $msg = "<div class='alert alert-success'>
                    Income added successfully.
                  </div>";
        }else{
          $msg = "<div class='alert alert-danger'>
                Cheque number must be numeric.
              </div>";
        }
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

  if (isset($_POST['transbtn'])) {
    if (!empty($_POST['tby']) && !empty($_POST['tamo'])) {
      $by = mysqli_real_escape_string($con, $_POST['tby']);
      $amount = mysqli_real_escape_string($con, $_POST['tamo']);
      $account = mysqli_real_escape_string($con, $_POST['tbank']);
      
      if (is_numeric($amount)) {
        $in = mysqli_query($con, "INSERT INTO transfer VALUES('', '".$by."', '".$account."', '".$amount."', '".$date."')");
        $getaccount = mysqli_query($con, "SELECT * FROM account WHERE id = '".$account."'");
        while ($a = mysqli_fetch_assoc($getaccount)) {
          $bamount = $a['balance'];
          $bname = $a['ac_name'];
        }
        $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Bank Transfer', '".$by."', 'Income', '".$amount."', '".$bname."', '".$date."')");
        $newbamount = $bamount + $amount;
        $updateamo = mysqli_query($con, "UPDATE account SET balance = '".$newbamount."' WHERE id = '".$account."'");
        $msg = "<div class='alert alert-success'>
                  Income added successfully.
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
  <title>IPU - Add Income</title>

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
          <h1 class="h3 mb-4 text-gray-800">Ichida Progress Union | Add Income</h1>

        
        <!-- /.container-fluid -->
        <div class="row">
        <div class="col-lg-6">
          <div class="card mb-4">
            <div class="card-header py-3">
              <p>Create Income</p></div>
              <div class="card-body">
                <div class="form-group">
                  <label>Select income type:</label>
                  <select name="type" id="itype" class="form-control" onchange="show()">
                    <option value="none">Choose</option>
                    <option value="cash">Cash</option>
                    <option value="cheque">Cheque</option>
                    <option value="transfer">Bank Transfer</option>
                  </select>
                </div>

                <div class = "animated fadeIn" id="cashform" style="display:none;"> 
                  <form action="" method="post" data-parsley-validate>
                    <div class="form-group">
                      <label for="catitle">Title:</label>
                      <input type="text" name="catitle" id="catitle" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="caby">By:</label>
                      <input type="text" name="caby" id="caby" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="caby">Amount:</label>
                      <input type="number" name="caamount" id="caamount" class="form-control" required>
                    </div>
                    <div class="form-group text-center">
                      <input type="submit" value="Create" name="cashbtn" class="btn btn-outline-success">
                    </div>
                  </form>
                </div>

                <div class="animated fadeIn" id="chequeform" style="display:none;">
                  <form action="" method="post" data-parsley-validate>
                    <div class="form-group">
                      <label for="chby">By:</label>
                      <input type="text" name="chby" id="chby" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="chno">Cheque Number:</label>
                      <input type="number" name="chno" id="chno" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="chamo">Amount:</label>
                      <input type="number" name="chamo" id="chamo" class="form-control" required>
                    </div>
                    <div class="form-group text-center">
                      <input type="submit" value="Create" name="chequebtn" class="btn btn-outline-success">
                    </div>
                  </form>
                </div>

                <div class="animated fadeIn" id="transform" style="display:none;">
                  <form action="" method="post" data-parsley-validate>
                    <div class="form-group">
                      <label for="tby">By:</label>
                      <input type="text" name="tby" id="tby" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="chno">Account:</label>
                      <?php
                        if (mysqli_num_rows($getbanks)) {
                          echo  "<select class='form-control' name='tbank'>";
                          while ($a = mysqli_fetch_assoc($getbanks)) {
                            $aname = $a['ac_name'];
                            $aid = $a['id'];

                            echo  "<option value='".$aid."'>".$aname."</option>";
                          }
                          echo  "</select>";
                        } else {
                          echo "Please add banck accounts first";
                        }
                        
                      ?>
                    </div>
                    <div class="form-group">
                      <label for="tamo">Amount:</label>
                      <input type="number" name="tamo" id="tamo" class="form-control" required>
                    </div>
                    <div class="form-group text-center">
                      <input type="submit" value="Create" name="transbtn" class="btn btn-outline-success">
                    </div>
                  </form>
                </div>
                <?php echo $msg;?>
              </div>
            </div>
          </div>
        </div>
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
