<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    if (!isset($_GET['id'])) {
        header("Location:index.php");
    }
    $member = mysqli_real_escape_string($con, $_GET['id']);
    $get = mysqli_query($con, "SELECT * FROM members WHERE id = '".$member."'");
    if(mysqli_num_rows($get)){
        while ($mem = mysqli_fetch_assoc($get)) {
            $pass = $mem['password'];
            $title = $mem['title'];
            $fname = $mem['fname'];
            $sname = $mem['sname'];
            $oname = $mem['oname'];
            $status = $mem['dead'];
            if ($status == TRUE) {
              $dead = "Deceased";
            } else {
              $dead = "Alive";
            }
            
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

    if (isset($_GET['action'])) {
      $action = mysqli_real_escape_string($con, $_GET['action']);
      if ($action == 'exempt') {
        $exe = mysqli_query($con, "UPDATE members SET exempted = TRUE WHERE id = '".$member."'");
        header("Location:user.php?id=$member");
      } else {
        $exe = mysqli_query($con, "UPDATE members SET exempted = FALSE WHERE id = '".$member."'");
        header("Location:user.php?id=$member");
      }
      
    }
    $msg = "";
    if (isset($_GET['success'])) {
      $msg = "<div class='alert alert-success'>Credit added successfully</div>";
    }
    if (isset($_GET['status'])){
      $statusa = mysqli_real_escape_string($con, $_GET['status']);
      if ($statusa == "dead") {
        $change = mysqli_query($con, "UPDATE members SET dead = TRUE WHERE id='".$member."'");
        header("Location:user.php?id=$member");
      } elseif($statusa == "alive") {
        $change = mysqli_query($con, "UPDATE members SET dead = FALSE WHERE id='".$member."'");
        header("Location:user.php?id=$member");
      }
      
    }
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
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
            <div class="card-header py-3"><div class="text-center"> <a href="adminpaid.php?id=<?php echo $_GET['id']?>" class="btn btn-success btn-icon-split btn-sm"><span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">View paid levies</span></a> <a href="adminunpaid.php?id=<?php echo $_GET['id'];?>" class="btn btn-danger btn-icon-split btn-sm"><span class="icon text-white-50">
                      <i class="fas fa-exclamation-triangle"></i>
                    </span>
                    <span class="text">View Unpaidpaid Levies</span></a> <a href="edituser.php?id=<?php echo $id?>" class="btn btn-warning btn-icon-split btn-sm"><span class="icon text-white-50">
                      <i class="fas fa-wrench"></i>
                    </span>
                    <span class="text">Edit </span></a>
                    <?php 
  if ($exempted == TRUE) {
    echo "<a class='btn btn-danger btn-sm' href='user.php?id=$member&action=unexempt'>Active Account</a>";
  } else {
    echo "<a class='btn btn-warning btn-sm' href='user.php?id=$member&action=exempt '>Inactive Account</a>";
  }
  
?>
 <a href="#" class="btn btn-sm btn-primary btn-icon-split " data-toggle="modal" data-target="#report"><span class="icon text-white-50">
                      <i class="fas fa-plus"></i>
                    </span><span class="text"> ₦<?php echo $credit;?></span></a>
 <div class="modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ADD/EDIT CREDIT </h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form>
        <div class="modal-body align-items-center">
            <p class="text-center">
        <div class="form-group row">
  <div class="col-xs-2">
    <label for="ex1">Current Balance</label>
    <input class="form-control" id="credit" type="text" value="<?php echo $credit;?>">
  </div>
    <div class="col-xs-2">
    <label for="ex1">Add to Balance</label>
    <input class="form-control" id="credit" type="text" value="0">
  </div>
  </p>
        <br>
        </div>
        
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <input type="submit" value="Edit" name="submit" class="btn btn-success"></form>
        </div>
      </div>
    </div>
  </div></div>
  
 
 <?php 
  if ($status == TRUE) {
    echo "<a href='user.php?id=$member&status=alive' class='btn btn-success btn-sm'>Click if member is alive</a>";
  } else {
    echo "<a href='user.php?id=$member&status=dead' class='btn btn-danger btn-sm'>Click if member is dead</a>";
  }
  
 ?>
                    </div>

                    </div>
            <div class="card-body">
          <div class="text-center">
            <h2 class="m-0 font-weight-bold text-primary"> <?php echo $title." ".$fname." ".$oname." ".$sname;?></h2>
          </div><br>
<div class="row">
    
<div class="col-xl-3 col-md-6 mb-4">
    <h1><img src="img/users/<?php echo $pic?>" alt="profile picture" style="height:150px;width:150px;"></h1></div>
    <div class="col-xl-3 col-md-6 mb-4">
    <?php echo $msg;?>
    <h4>Member Details</h4>
    <br>
    <p><b>Membership Number:</b> <?php echo $mn?></p>
    <p><b>Group:</b> <?php echo $gname?></p><br>
                <p><b>Village:</b> <?php echo $village?></p><br>
                        <p><b>Lagos Address:</b> <?php echo $la?></p><br>
                        <p><b>Date of Birth:</b> <?php echo $dob?></p><br>
                        <p><b>Marital Status:</b> <?php echo $ms?></p><br>
                        <p><b>Health/Physical Challenge:</b> <?php echo $challenge?></p><br>
                        <p><b>Membership Number:</b> <?php echo $mn?></p><br>
                        <p><b>Credit: &#8358;<?php echo $credit;?></b></p>
                        <p><b>Status: </b><?php echo $dead?></p>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <h4>Contacts</h4><br>
<p><b>Email:</b> <?php echo $email?></p><br>
                        <p><b>Telephone Number:</b> <?php echo $phone?></p><br>
                        <p><b>Whatsapp Number:</b> <?php echo $wn?></p><br>
                        <p><b>Username:</b> <?php echo $username?></p><br>
                        <p><b>Year of Entry:</b> <?php echo $yoe?></p><br>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <h4>Next of Kin Information</h4><br>
<p><b>Full Name:</b> <?php echo $nokn?></p><br>
                        <p><b>Address:</b> <?php echo $noka?></p><br>
                        <p><b>Telephone Number:</b> <?php echo $nokp?></p><br>
                        <p><b>Relationship:</b> <?php echo $nokr?></p><br>
                        </div>
<div class="text-center">

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
