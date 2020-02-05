<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['member'])) {
        header('Location:index.php');
    }
    $getmember = mysqli_query($con, "SELECT * FROM members WHERE id = '".$_SESSION['member']."'");
    while ($got = mysqli_fetch_assoc($getmember)) {
        $pass = $got['password'];
        $title = $got['title'];
        $fname = $got['fname'];
        $sname = $got['sname'];
        $oname = $got['oname'];
        $dob = $got['dob'];
        $ms = $got['marital_status'];
        $village = $got['village'];
        $la = $got['lagos_address'];
        $email = $got['email'];
        $phone = $got['phone'];
        $wn = $got['wa_number'];
        $id = $got['id'];
        if ($got['challenge'] == "") {
            $challenge = "NONE";
        }
        $username = $got['username'];
        $yoe = $got['yoe'];
        $gn = $got['group_no'];
        $mn = $got['mem_number'];
        $chkgroup = mysqli_query($con, "SELECT * FROM groups WHERE id = '".$gn."'");
        while ($g = mysqli_fetch_assoc($chkgroup)) {
            $gname = $g['name'];
        }
    }
    $getnok = mysqli_query($con, "SELECT * FROM next_of_kin WHERE member_id = '".$_SESSION['member']."'");
    while ($nok = mysqli_fetch_assoc($getnok)) {
        $nokn = $nok['name'];
        $noka = $nok['address'];
        $nokp = $nok['phone'];
        $nokr = $nok['relationship'];
    }
    if ($pass == "12345") {
        header("Location:memchpass.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progressive Union | Profile</title>
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
        require 'includes/memsidebar.php';
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
          <h1 class="h3 mb-4 text-gray-800"><?php echo $title." ".$fname." ".$oname." ".$sname;?></h1>
<div class="row">
<div class="col-lg-6">
         <div class="card mb-4">
                <div class="card-header py-3">
User Peronal Details

</div>
<div class="card-body"><p><b>Village:</b> <?php echo $village?></p><br>
                        <p><b>Lagos Address:</b> <?php echo $la?></p><br>
                        <p><b>Date of Birth:</b> <?php echo $dob?></p><br>
                        <p><b>Marital Status:</b> <?php echo $ms?></p><br>
                        <p><b>Health/Physical Challenge:</b> <?php echo $challenge?></p><br>
                        <p><b>Membership Number:</b> <?php echo $mn?></p><br></div>
</div>
<div class="card mb-4">
                <div class="card-header py-3">
Contacts & Info

</div>
<div class="card-body"><p><b>Email:</b> <?php echo $email?></p><br>
                        <p><b>Telephone Number:</b> <?php echo $phone?></p><br>
                        <p><b>Whatsapp Number:</b> <?php echo $wn?></p><br>
                        <p><b>Username:</b> <?php echo $username?></p><br>
                        <p><b>Year of Entry:</b> <?php echo $yoe?></p><br>
                        <p><b>Group:</b> <?php echo $gname?></p><br><br></div>

</div>
<div class="card mb-4">
                <div class="card-header py-3">
Next of Kin Information

</div>
<div class="card-body"><p><b>Full Name:</b> <?php echo $nokn?></p><br>
                        <p><b>Address:</b> <?php echo $noka?></p><br>
                        <p><b>Telephone Number:</b> <?php echo $nokp?></p><br>
                        <p><b>Relationship:</b> <?php echo $nokr?></p><br>

                      </div>
                        
</div>
</div></div>
        </div>
        <!-- /.container-fluid -->

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
