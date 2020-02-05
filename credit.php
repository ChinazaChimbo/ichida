<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    $msg = "";
    $date = date('d/m/Y');
    if (isset($_POST['submit'])) {
      if (!empty($_POST['amount'])) {
        $amount = mysqli_real_escape_string($con, $_POST['amount']);
        $member = mysqli_real_escape_string($con, $_POST['member']);
        $getmember2 = mysqli_query($con, "SELECT * FROM members WHERE id = '".$member."'");
        while ($gotmem = mysqli_fetch_assoc($getmember2)) {
          $credit = $gotmem['credit'];
        }
        $checklevy = mysqli_query($con, "SELECT * FROM levy WHERE member_id = '".$member."' AND paid = FALSE");
        if (mysqli_num_rows($checklevy)) {
          while ($glevy = mysqli_fetch_assoc($checklevy)) {
            $levyid = $glevy['id'];
            $levyamount = $glevy['amount'];
            while ($amount > 0) {
              if (($amount - $levyamount) >= 0) {
                $diff = ($amount - $levyamount);
                $in = mysqli_query($con, "UPDATE levy SET paid = TRUE, date = '".$date."' WHERE id = '".$levyid."'");
                $inclog = mysqli_query($con, "INSERT INTO credit_log VALUES ('', '".$levyid."', '".$member."', '".$diff."', FALSE)");
                $in = mysqli_query($con, "UPDATE members SET credit = '".$amount."' WHERE id = '".$member."'");
                $amount = $diff;
              } else {
                $diff = $levyamount - $amount;
                $in = mysqli_query($con, "UPDATE levy SET amount = '".$diff."' WHERE id = '".$levyid."'");
                $inclog = mysqli_query($con, "INSERT INTO credit_log VALUES ('', '".$levyid."', '".$member."', '".$amount."', FALSE)");
                $amount = 0;
              }
            }
          }
        } else {
          $newcredit = $credit + $amount;
          $in = mysqli_query($con, "UPDATE members SET credit = '".$newcredit."' WHERE id = '".$member."'");
        }
        
        $msg = "<div class='alert alert-success'>Credit added successfully</div>";
      } else {
        $msg = "<div class='alert alert-danger'>Please fill all fields</div>";
      }
      
    }
    $get = mysqli_query($con, "SELECT * FROM members WHERE dead = FALSE ORDER BY fname ASC");
    
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | All Members</title>
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
          <h1 class="h3 mb-4 text-gray-800">Members</h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">View Members</h6>
            </div>
            <div class="card-body">
            <?php echo $msg?>
              <div class="table-responsive">
                <?php
                        $i = 1;
                        if(mysqli_num_rows($get)){
                echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                  <thead>
                                        <tr>
                                            <th>Membership No</th>
                                            <th>Member Name</th>
                                            <th>Total Credit</th>
                                            <th>action</th>
                                        </tr>
                                    </thead><tfoot>
                                        <tr>
                                            <th>Membership No</th>
                                            <th>Member Name</th>
                                            <th>Total Credit</th>
                                            <th>action</th>
                                            
                                        </tr>
                                    </tfoot>
                                    <tbody>";
                                    while ($a = mysqli_fetch_assoc($get)) {
                                        $title = $a['title'];
                                        $sname = $a['sname'];
                                        $fname = $a['fname'];
                                        $id = $a['id'];
                                        $wn = $a['phone'];
                                        $gn = $a['group_no'];
                                        $mn = $a['mem_number'];
                                        $credit = $a['credit'];
                                        $getgroup = mysqli_query($con, "SELECT * FROM groups WHERE id = '".$gn."'");
                                        while ($gotg = mysqli_fetch_assoc($getgroup)) {
                                          $gname = $gotg['name'];
                                          echo    "<tr>
                                                        <td>".$mn."</td>
                                                        <td><a href ='user.php?id=".$id."'>".$title." ".$sname." ".$fname."</td>
                                                        <td>".$credit." </td>
                                                        <td><form method='POST' action='credit.php' data-parsley-validate>
                                                        <input type='hidden' name='member' value='".$id."'>
                                                        <input  type='number' id='amount' name='amount' value='0' required>
                                                        <input type='submit' name='submit' value='Add Credit' class='btn btn-success btn-sm'>
                                                        </form></td>
                                                    </tr>";
                                        }
                                            
                                        $i++;
                                    }
                        echo        "</tbody>
                                  </table>";
                        }else{
                            echo "There are no Members yet";
                        }
                    ?>
              </div>
            </div>
            
          </div>

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
        require 'includes/scriptstables.php';
    ?>
<script>

</script>

</body>

</html>
