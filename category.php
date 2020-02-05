<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    if (!isset($_GET['id'])) {
        header("Location:index.php");
    }
    $id = mysqli_real_escape_string($con, $_GET['id']);
    if ($id == 1) {
        header("Location:viewlevy.php?name=Old Debts");
    }
    $getcat = mysqli_query($con, "SELECT * FROM levy_categories WHERE id = '".$id."'");
    if (mysqli_num_rows($getcat)) {
        while ($cats = mysqli_fetch_assoc($getcat)) {
            $catname = $cats['name'];
        }
    } else {
        header("Location:index.php");
    }
    
    $levies = mysqli_query($con, "SELECT DISTINCT name FROM levy WHERE category='".$id."' ORDER BY name ASC");
    if (isset($_GET['delete'])) {
      $name = urldecode(mysqli_real_escape_string($con, $_GET['delete']));
      $getlevy = mysqli_query($con, "SELECT * FROM levy WHERE name = '".$name."'");
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
      $delete = mysqli_query($con, "DELETE FROM levy WHERE name = '".$name."'");
      header("Location:category.php?id=$id");
    }
    $msg = "";
    if (isset($_GET['success'])) {
      $msg = "<div class='alert alert-success'>Levy successfully deleted for selected members</div>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | <?php echo $catname?></title>
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
          <h1 class="h3 mb-4 text-gray-800"><?php echo $catname?></h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Levies</h6>
            </div>
            <div class="card-body">
            <?php echo $msg?>
              <div class="table-responsive">
                <?php
                        $i = 1;
                        if(mysqli_num_rows($levies)){
                echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                                                      <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Levy Name</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead><tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Levy Name</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>";
                                    while ($a = mysqli_fetch_assoc($levies)) {
                                        $aname = $a['name'];
                                        $getamount = mysqli_query($con, "SELECT * FROM levy WHERE name = '".$aname."' LIMIT 1");
                                        while ($name2 = mysqli_fetch_assoc($getamount)) {
                                            $amount = $name2['amount'];
                                        }
                                        echo    "<tr>
                                                    <td>".$i."</td>
                                                    <td>".$aname."</td>
                                                    <td>&#8358;".$amount."</td>
                                                    <td><a class='btn btn-primary btn-sm' href='viewlevy.php?name=$aname&paid=FALSE'>View owing members</a> <a class='btn btn-success btn-sm' href='viewlevy.php?name=$aname&paid=TRUE'>View paid mambers</a> <a class='btn btn-info btn-sm' href='editlevy.php?name=$aname'>Edit Levy</a> <a href='category.php?id=$id&delete=$aname' class='btn btn-danger btn-sm'>Delete Levy</a> <a class='btn btn-danger btn-sm' href='delsel.php?name=$aname&id=$id'>Remove from members</a></td>
                                                </tr>";
                                        $i++;
                                    }
                        echo        "</tbody>
                                  </table>";
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


</body>

</html>
