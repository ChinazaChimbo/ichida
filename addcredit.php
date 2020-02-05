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
            $dob = $mem['dob'];
            $ms = $mem['marital_status'];
            $village = $mem['village'];
            $la = $mem['lagos_address'];
            $exempted = $mem['exempted'];
            $email = $mem['email'];
            $credit = $mem['credit'];
            $phone = $mem['phone'];
            $wn = $mem['wa_number'];
            $pic = $mem['pro_pic'];
            $id = $mem['id'];
            if ($mem['challenge'] == "" || $mem['challenge'] == "NONE") {
                $challenge = "NONE";
            }
            $username = $mem['username'];
            $yoe = $mem['yoe'];
            $gn = $mem['group_no'];
            $mn = $mem['mem_number'];
            $chkgroup = mysqli_query($con, "SELECT * FROM groups WHERE id = '".$gn."'");
            while ($g = mysqli_fetch_assoc($chkgroup)) {
                $gname = $g['name'];
            }
        }
        $getnok = mysqli_query($con, "SELECT * FROM next_of_kin WHERE member_id = '".$member."'");
        while ($nok = mysqli_fetch_assoc($getnok)) {
            $nokn = $nok['name'];
            $noka = $nok['address'];
            $nokp = $nok['phone'];
            $nokr = $nok['relationship'];
        }
    }else{
        header("Location:index.php");
    }

    $msg = "";

    if (isset($_POST['submit'])) {
        if (!empty($_POST['amount'])) {
            $amount = mysqli_real_escape_string($con, $_POST['amount']);
            if (is_numeric($amount)) {
                $newamount = $credit + $amount;
                $in = mysqli_query($con, "UPDATE members SET credit = '".$newamount."' WHERE id = '".$member."'");
                header("Location:user.php?id=$member&success");
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
    <title>Ichida Progress Union | Member Information</title>
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
        <div class="container-fluid" >

          <!-- Page Heading -->
          
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="text-center">
            <h2 class="m-0 font-weight-bold">Add credit to <?php echo $title." ".$fname." ".$oname." ".$sname;?></h2>
        </div>    
    </div>
</div>

<div class="card-body">
    <div class="row">   
        <form action="addcredit.php?member=<?php echo $member?>" method="post" data-parsley-validate>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" required name="amount" id="amount" class="form-control">
            </div>
            <input type="submit" value="Add" class="btn btn-success" name="submit">
        </form>
    </div>
</div>
</div></div></div></div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php
        require 'includes/footer.php';
    ?>
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
