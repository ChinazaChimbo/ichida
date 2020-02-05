<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    $msg = "";
    $get = mysqli_query($con, "SELECT * FROM levy_categories ORDER BY name ASC");
    if (isset($_GET['success'])) {
       $msg = "<div class='alert alert-success' role='alert'>
                    <button class='delete'></button>
                    Levy has been created and successfuly added to all selected members.
                </div>";
    }
    $date = date("d/m/Y");
    if (isset($_POST['submit'])) {
        if (!empty($_POST['name']) && !empty($_POST['amount'])) {
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $amount = mysqli_real_escape_string($con, $_POST['amount']);
            $category = $_POST['category'];
            if (is_numeric($amount)) {
                if ($_POST['cat'] == "all") {
                    $getmem = mysqli_query($con, "SELECT * FROM members WHERE dead=FALSE");
                    $i = 1;
                    while ($a = mysqli_fetch_assoc($getmem)) {
                        $aid = $a['id'];
                        $getmem2 = mysqli_query($con, "SELECT * FROM members WHERE id = '".$aid."'");
                        while ($ab = mysqli_fetch_assoc($getmem2)) {
                            $credit = $ab['credit'];
                            if ($credit > 0) {
                                $diff = $amount - $credit;
                                if ($diff <= 0) {
                                    $in = mysqli_query($con, "INSERT INTO levy VALUES('', '".$name."', '".$category."', '".$amount."', '".$a['id']."', TRUE, '".$date."', NULL)");
                                    $newcredit = $credit - $amount;
                                    $getlevy = mysqli_query($con, "SELECT * FROM levy WHERE name = '".$name."' LIMIT 1");
                                    while ($gotlevy = mysqli_fetch_assoc($getlevy)) {
                                        $levyid = $gotlevy['id'];
                                    }
                                    $incredlog = mysqli_query($con, "INSERT INTO credit_log VALUES('', '".$levyid."', '".$aid."', '".$amount."', FALSE)");
                                    $up = mysqli_query($con, "UPDATE members SET credit = '".$newcredit."' WHERE id = '".$aid."'");
                                } else {
                                    $adiff = $amount - $diff;
                                    $in = mysqli_query($con, "INSERT INTO levy VALUES('', '".$name."', '".$category."', '".$diff."', '".$a['id']."', TRUE, '".$date."', NULL)");
                                    $getlevy = mysqli_query($con, "SELECT * FROM levy WHERE name = '".$name."' LIMIT 1");
                                    while ($gotlevy = mysqli_fetch_assoc($getlevy)) {
                                        $levyid = $gotlevy['id'];
                                    }
                                    $up = mysqli_query($con, "UPDATE members SET credit = 0 WHERE id = '".$aid."'");
                                    $incredlog = mysqli_query($con, "INSERT INTO credit_log VALUES('', '".$levyid."', '".$aid."', '".$adiff."', FALSE)");
                                }
                            } else {
                                $in = mysqli_query($con, "INSERT INTO levy VALUES('', '".$name."', '".$category."', '".$amount."', '".$a['id']."', FALSE, NULL, NULL)");
                            }
                        }
                        
                        $i ++;
                    }
                    $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Created new levy for ".$i." members', '".$date."')");
                    $msg = "<div class='alert alert-success'>
                                <button class='delete'></button>
                                Levy has been created and successfuly added to all members.
                            </div>";
                }elseif($_POST['cat'] == "some") {
                    setcookie("levy_name", $name, time() + (86400 * 30), "/");
                    setcookie("amount", $amount, time() + (86400 * 30), "/");
                    setcookie("category", $category, time() + (86400 * 30), "/");
                    header("Location:selectmem.php");
                }elseif ($_POST['cat'] == "exempted") {
                    $getmem = mysqli_query($con, "SELECT * FROM members WHERE exempted = FALSE AND dead=FALSE");
                    $i = 1;
                    while ($a = mysqli_fetch_assoc($getmem)) {
                        $aid = $a['id'];
                        $credit = $a['credit'];
                        if ($credit > 0) {
                            $diff = $amount - $credit;
                            if ($diff <= 0) {
                                $in = mysqli_query($con, "INSERT INTO levy VALUES('', '".$name."', '".$category."', '".$amount."', '".$a['id']."', TRUE, '".$date."', NULL)");
                                $newcredit = $credit - $amount;
                                $up = mysqli_query($con, "UPDATE members SET credit = '".$newcredit."' WHERE id = '".$aid."'");
                            } else {
                                $in = mysqli_query($con, "INSERT INTO levy VALUES('', '".$name."', '".$category."', '".$diff."', '".$a['id']."', TRUE, '".$date."', NULL)");
                                $up = mysqli_query($con, "UPDATE members SET credit = 0 WHERE id = '".$aid."'");
                            }
                        } else {
                            $in = mysqli_query($con, "INSERT INTO levy VALUES('', '".$name."', '".$category."', '".$amount."', '".$a['id']."', FALSE, NULL, NULL)");
                        }
                        $i ++;
                    }
                    $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Created new levy for ".$i." members', '".$date."')");
                    $msg = "<div class='alert alert-success'>
                                <button class='delete'></button>
                                Levy has been created and successfuly added to all members except exempted.
                            </div>";
                }
            }else{
                $msg = "<div class='alert alert-danger' role='alert'>
                        <button class='delete'></button>
                        Amount must be numeric.
                    </div>";
            }
        }else {
            $msg = "<div class='alert alert-danger' role='alert'>
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
  <title>IPU - Add Levy</title>

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
          <h1 class="h3 mb-4 text-gray-800">Ichida Progress Union | Add New Levy</h1>

        
        <!-- /.container-fluid -->
        <div class="row">
<div class="col-lg-6">
         <div class="card mb-4">
                <div class="card-header py-3">
                  <p>Create levy</p></div>
                  <div class="card-body">
<form action="" method="post" data-parsley-validate>
                <div class="form-group row">
                      <label for="name">Levy name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="eg. burial levy" required>
                    </div>
                    <div class="form-group row">
                        <label for="name">Amount to be Paid</label>
                    <input type="number" class="form-control" id="amount" name="amount" placeholder="eg. 3000" required>
                    </div>
                  
                  <?php
                            if(mysqli_num_rows($get)){
                                echo    "<div class='form-group row'>";
                                    echo    "<label for='category'>Category:</label>";
                                    
                                        echo    "<select class='form-control' name='category'>";
                                            while ($a = mysqli_fetch_assoc($get)) {
                                                echo    "<option value='".$a['id']."'>".$a['name']."</option>";
                                            }
                                        echo    "</select>";
                                    echo    "</div>";
                            }else{
                                echo "<p>Please create levy categories before creating the levy</p>";
                            }
                        ?>
                  <div class="form-group row">
                  <label for="cat">Add Levy For:</label>
                                <select class="form-control" name="cat" id="cat" onchange="showbtn()">
                                    <option value="none">Please Select...</option>
                                    <option value="all">All members</option>
                                    <option value="exempted">All members except exempted</option>
                                    <option value="some">Some members</option>
                                </select>
                               </div> 
                  
                  <br>
                        <?php
                            echo $msg;
                        ?>
                        <div class="text-center animated fadeIn field" style="display:none" id="show">
                            <input type="submit" value="Proceed" name="submit" class="btn btn-success">
                        </div>
</form></div></div></div></div>
     </div>             
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

  <!-- Logout Modal--
 <?php
    require 'includes/logoutmodal.php';
?>
  <!-- Bootstrap core JavaScript-->
  <?php
    require 'includes/scripts.php';
?>
</body>
<script>
    function showbtn() {
        var btn = document.getElementById("cat");
        var show = document.getElementById("show")
        if (btn.value == "none") {
            show.style.display = 'none';
        }else{
            show.style.display = "block";
        }
    }
</script>

</html>
