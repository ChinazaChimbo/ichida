<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }

    if (!isset($_GET['name']) ) {
        header("Location:index.php");
    }
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $aname = urldecode(mysqli_real_escape_string($con, $_GET['name']));
    $getlevy = mysqli_query($con, "SELECT * FROM levy WHERE name = '".$aname."' AND paid = FALSE");
    if (isset($_POST['submit'])) {
      $levies =  $_POST['levy'];
      foreach ($levies as $levy) {
        $getlevy = mysqli_query($con, "SELECT * FROM levy WHERE id = '".$levy."'");
      while ($gotlevy = mysqli_fetch_assoc($getlevy)) {
        $levyid = $gotlevy['id'];
        $checkcredit = mysqli_query($con, "SELECT * FROM credit_log WHERE levy_id = '".$levyid."'");
        if (mysqli_num_rows($checkcredit)) {
          while ($gotcredit = mysqli_fetch_assoc($checkcredit)) {
            $credid = $gotcredit['id'];
            $credmem = $gotcredit['member_id'];
            $credamount = $gotcredit['amount'];
            $getmember = mysqli_query($con, "SELECT * FROM members WHERE id = '".$credmem."'");
            while ($gotmember = mysqli_fetch_assoc($getmember)) {
              $memid = $gotmember['id'];
              $memcredit = $gotmember['credit'];
              $newbal = $memcredit + $credamount;
              $in = mysqli_query($con, "UPDATE members SET credit = '".$newbal."' WHERE id = '".$memid."'");
              $in2 = mysqli_query($con, "UPDATE credit_log SET reversed = TRUE WHERE id = '".$credid."'");
            }
          }
        }
      }
      $del = mysqli_query($con, "DELETE FROM levy WHERE id = '".$levy."'");
      }
      header("Location:category.php?success&id=$id");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progressive Union | Delete Levy</title>
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
          <h1 class="h3 mb-4 text-gray-800">Delete levy for selected members</h1>
          <div class="card shadow mb-4">
              <form action="delsel.php?name=<?php echo $aname?>&id=<?php echo $id ?>" method="post">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Select Members</h6>
              <div class="text-right"><input type="submit" value="Proceed" name="submit" class="btn btn-success"></div>
            </div>
            <div class="card-body">
              
              <div class="table-responsive">
                  <table border="0" cellspacing="5" cellpadding="5">
        <tbody><tr>
            <td>Select All:</td>
            <td><input type="checkbox" onclick="toggle(this);" /></td>
        </tr>
<?php
                            if(mysqli_num_rows($getlevy)){
                                $i = 1;
                echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0' paging='false'>
                  <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Membership Number</th>
                                                <th>Name</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Membership Number</th>
                                                <th>Name</th>
                                                <th>Amount</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>";
                                while ($a = mysqli_fetch_assoc($getlevy)) {
                                  $aid = $a['id'];
                                  $aamount = $a['amount'];
                                  $amid = $a['member_id'];
                                  $getmember = mysqli_query($con, "SELECT * FROM members WHERE id = '".$amid."'");
                                  while ($gotm = mysqli_fetch_assoc($getmember)) {
                                  $mfname = $gotm['fname'];
                                  $msname = $gotm['sname'];
                                  $mmn = $gotm['mem_number'];
                                  echo     "<tr>
                                              <td>                                                    <label class='checkbox'>
                                                        <input type='checkbox' name='levy[]' value='".$aid."'></label></td>
                                             <td>".$mmn."</td>
                                              <td>
                                                        ".$mfname." ".$msname."
                                                </td>
                                                <td>&#8358;".$aamount."</td>
                                              </tr>";
                                  
                                  }
                                            $i ++;
                                }
                                echo    "</tbody>
                                        </table>";
                            }else {
                                echo "There are no members who owe this levy";
                            }
                        ?>
              </div>
              <div class="text-center">
                            <input type="submit" value="Proceed" name="submit" class="btn btn-success">
                    </div>
            
            </div>
            </form>
          </div>

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
        require 'scriptstables1.php';
    ?>
<script>
    function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}
</script>

</body>

</html>
