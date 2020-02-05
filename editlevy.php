<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    if (!isset($_GET['name'])) {
        header("Location:index.php");
    }
    $levyname = urldecode(mysqli_real_escape_string($con, $_GET['name']));
    $getlevy = mysqli_query($con, "SELECT * FROM levy WHERE name='".$levyname."' LIMIT 1");
    while ($gotlevy = mysqli_fetch_assoc($getlevy)) {
        $gotid = $gotlevy['id'];
        $gotname = $gotlevy['name'];
        $gotcat = $gotlevy['category'];
        $gotamount = $gotlevy['amount'];
    }
    $getcategories = mysqli_query($con, "SELECT * FROM levy_categories ORDER BY name ASC");
    $msg = "";
    $date = date("d/m/Y");
    if (isset($_POST['submit'])) {
      if (!empty($_POST['title']) && !empty($_POST['amount'])) {
        $ltitle = mysqli_real_escape_string($con, $_POST['title']);
        $lcategory = mysqli_real_escape_string($con, $_POST['category']);
        $lamount = mysqli_real_escape_string($con, $_POST['amount']);
        if (is_numeric($lamount)) {
          $change = mysqli_query($con, "UPDATE levy SET name = '".$ltitle."', category = '".$lcategory."', amount = '".$lamount."' WHERE name = '".$levyname."'");
          $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Admin edited levy', '".$date."')");
          $getlevy2 = mysqli_query($con, "SELECT * FROM levy WHERE name='".$ltitle."' ORDER BY id LIMIT 1");
          while ($g2 = mysqli_fetch_assoc($getlevy2)) {
            $g2id = $g2['id'];
          }
          header("Location:alllevies.php?status=true");
        }else{
          $msg = "<div class='alert alert-danger'>Amount must be a number</div>";
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
    <title>Ichida Progress Union | Edit <?php echo $gotname?></title>
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
          <h1 class="h3 mb-4 text-gray-800"><?php echo $gotname?></h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Edit</h6>
            </div>
            <div class="card-body">
              <form action="editlevy.php?name=<?php echo $levyname?>" method="post" data-parsley-validate>
                <div class="form-group">
                  <label for="title">Title:</label>
                  <input type="text" name="title" id="title" class="form-control" value="<?php echo $gotname?>" required>
                </div>
                <div class="form-group">
                  <label for="category">Category:</label>
                  <select name="category" id="category" class="form-control">
                  <?php 
                    while ($gcat = mysqli_fetch_assoc($getcategories)) {
                      $gid = $gcat['id'];
                      $gname = $gcat['name'];

                      if ($gid == $gotcat) {
                        echo "<option selected value='".$gid."'>".$gname."</option>";
                      }else{
                        echo "<option value='".$gid."'>".$gname."</option>";
                      }
                    }
                  ?>
                  </select>
                </div>
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="number" name="amount" id="amount" value="<?php echo $gotamount ?>" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" value="Change" class="btn btn-success" name="submit">
                </div>
              </form>
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
