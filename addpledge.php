<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    $msg = "";
    $date = date("d/m/Y");
    $getmembers = mysqli_query($con, "SELECT * FROM members WHERE dead = FALSE ORDER BY fname ASC");
    if (isset($_POST['submit'])) {
      if (!empty($_POST['name']) && !empty($_POST['amount']) && !empty($_POST['for']) && !empty($_POST['phone'])) {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $amount = mysqli_real_escape_string($con, $_POST['amount']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $for = mysqli_real_escape_string($con, $_POST['for']);
        $member = mysqli_real_escape_string($con, $_POST['member']);
        if (is_numeric($amount)) {
          if (is_numeric($phone)) {
            $in = mysqli_query($con, "INSERT INTO pledge VALUES('', '".$name."', '".$phone."', '".$member."', '".$for."', '".$amount."', FALSE, NULL)");
            $msg = $msg = "<div class='alert alert-success'>Plegde has been added successfully</div>";
          } else {
            $msg = "<div class='alert alert-danger'>Phone must be numeric</div>";
          }
        } else {
          $msg = "<div class='alert alert-danger'>Amount must be numeric</div>";
        }
      } else {
        $msg = "<div class='alert alert-danger'>Please fill all fields</div>";
      }
      
    }
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | Add Pledge</title>
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
          <h1 class="h3 mb-4 text-gray-800">Create New Pledge</h1>

         <div class="card mb-4">
                <div class="card-header py-3">
                  <p>Create New Pledge</p></div>
                  <div class="card-body">
                 <form action="addpledge.php" method="post" data-parsley-validate>      
<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                  <label>Non-Member Name:</label>
                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Non-member name">
                  </div></div>
                  <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                  <label>Non-Member Phone No</label>
                    <input type="number" class="form-control form-control-user" id="phone" name="phone" placeholder="Phone Number">
                  </div></div>
                  <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                  <label>On Behalf of:</label>
                    <select name="member" class="form-control">
                      <?php
                        while ($got = mysqli_fetch_assoc($getmembers)) {
                          $gfname = $got['fname'];
                          $gsname = $got['sname'];
                          $gid = $got['id'];

                          echo  "<option value='".$gid."'>".$gfname." ".$gsname."</option>";
                        }
                      ?>
                    </select>
                  </div></div>
                  <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                  <label>For:</label>
                    <input type="text" class="form-control form-control-user" id="for" name="for" placeholder="Lauching New Car">
                  </div></div>
                  <div class="form-group row">
                  <div class="col-sm-6">
                  <label>Amount</label>
                    <input type="number" class="form-control form-control-user" id="amount" name="amount" placeholder="Amount">
                  </div>
                </div>
                                            <?php echo $msg?><br>
                        <div class="field text-center">
                            <input type="submit" value="Add" name="submit" class="btn btn-success">
                      
                  </div></form></div>
</div></div>

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
