<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    $msg = "";
    $date = date("d/m/Y");
    if (isset($_GET['success'])) {
       $msg = "<div class='notification is-success'>
                    <button class='delete'></button>
                    Levy category has been created successfully.
                </div>";
    }
    if (isset($_POST['submit'])) {
        if (!empty($_POST['name'])) {
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $check = mysqli_query($con, "SELECT * FROM levy_categories WHERE name = '".$name."'");
            if (mysqli_num_rows($check) < 1) {
                $in = mysqli_query($con, "INSERT INTO levy_categories VALUES('', '".$name."')");
                $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Created new levy group', '".$date."')");
                $msg = "<div class='notification is-success'>
                            <button class='delete'></button>
                            Category has been created.
                        </div>";
            } else {
                $msg = "<div class='notification is-danger'>
                            <button class='delete'></button>
                            Category already exists.
                        </div>";
            }
        }else {
            $msg = "<div class='notification is-danger'>
                        <button class='delete'></button>
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
  <title>IPU - Add user</title>

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
          <h1 class="h3 mb-4 text-gray-800">Ichida Progress Union | Add New Levy/Fines Category</h1>

      <div class="row">
<div class="col-lg-6">
         <div class="card mb-4">
                <div class="card-header py-3">
                  <p>Create Group</p></div>
                  <div class="card-body">
                    <form action="newlevygroup.php" method="post" data-parsley-validate>
<div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Category Name">
                  </div>
                <br>
                    
                                            <?php echo $msg?>
                        <div class="field text-center">
                            <input type="submit" value="Create" name="submit" class="btn btn-success">
                        </div></div></form>
                  </div></div>
</div></div></div>
        

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
  

  <!-- Bootstrap core JavaScript-->
  <?php
        require 'includes/scripts.php';
    ?>

</body>

</html>
