<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    if (!isset($_GET['member'])) {
        header("Location:index.php");
    }
    $member = mysqli_real_escape_string($con, $_GET['member']);
    $get = mysqli_query($con, "SELECT * FROM members WHERE id = '".$member."'");
    if(mysqli_num_rows($get)){
        while ($mem = mysqli_fetch_assoc($get)) {
            $pass = $mem['password'];
            $title = $mem['title'];
            $fname = $mem['fname'];
            $sname = $mem['sname'];
            $oname = $mem['oname'];
            
        }
    }else{
        header("Location:index.php");
    }
    $god = mysqli_query($con, "SELECT * FROM levy WHERE name = 'Old Debts' AND paid = false AND member_id = '".$member."'");
    if (mysqli_num_rows($god)) {
      while ($ggod = mysqli_fetch_assoc($god)) {
        $gid = $ggod['id'];
        $gamount = $ggod['amount'];
      }
    }else{
      header("Location:adminunpaid.php?id=$member");
    }

    $msg = "";
    $date = date("d/m/Y");
    if (isset($_POST['submit'])) {
      if (!empty($_POST['amount']) && !empty($_POST['recipt'])) {
        $amount = mysqli_real_escape_string($con, $_POST['amount']);
        $recipt = mysqli_real_escape_string($con, $_POST['recipt']);
        if (is_numeric($amount)) {
          if (is_numeric($recipt)) {
            if ($amount <= $gamount) {
              if ($amount == $gamount) {
                $up = mysqli_query($con, "UPDATE levy SET paid = true, date = '".$date."', recipt_no = '".$recipt."' WHERE id = '".$gid."'");
                $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Paid Levy', '".$date."')");
                header("Location:adminunpaid.php?id=$member");
              } else {
                $newamount = $gamount - $amount;
                $up = mysqli_query($con, "UPDATE levy SET amount = '".$newamount."' WHERE id = '".$gid."'");
                $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Paid Levy', '".$date."')");
                $inrecipt = mysqli_query($con, "INSERT INTO old_recipts VALUE('', '".$recipt."', '".$date."', '".$gid."')");
                header("Location:adminunpaid.php?id=$member");
              }
              
            }else{
              $msg = "<div class='alert alert-danger'>Amount paid must not be greater than the amount owed</div>";
            }
          } else {
            $msg = "<div class='alert alert-danger'>Recipt must be numeric</div>";
          }
        }else{
          $msg = "<div class='alert alert-danger'>Amount must be numeric</div>";
        }
      } else {
        $msg = "<div class='alert alert-danger'>Please fill all fields</div>";
      }
      
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | Pay old debt</title>
  <meta name="description" content="">
  <meta name="author" content="">
<?php
        require 'includes/header.php';
    ?>

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

        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          
          <div class="card shadow mb-4">
            
            <div class="card-body">
                   <div id="box">
          <!-- Page Heading -->
          <h1> <img src="images/header.jpg" alt="header" style="width:100%;height:150px;"></h1>
          <h3>Pay old debt for <?php echo $title." ".$fname." ".$oname." ".$sname;?></h3>
          <div class="row">
              <p><b class="text-center">Amount owing: &#8358;<?php echo $gamount?></b></p>
              
          </div>
              <form action="payolddebt.php?member=<?php echo $member ?>" method="post" data-parsley-validate>
                <div class="form-group">
                  <label for="amount" class="label">Enter amount paid by the member:</label>
                  <input type="number" name="amount" id="amount" class="form-control" required>
                </div>

                <div class="form-group">
                  <label for="reciept">Enter Recipt Number:</label>
                  <input type="number" name="recipt" id="recipt" class="form-control" required>
                </div>
                <?php echo $msg?>

                <div class="text-center">
                  <input type="submit" value="Pay" name="submit" class="btn btn-info">
                </div>
              </form>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->


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

  <!-- Logout Modal-->
  <?php
        require 'includes/logoutmodal.php';
    ?>

  <!-- Bootstrap core JavaScript-->
 <?php
        require 'includes/scripts.php';
    ?>


</body>

</html>
