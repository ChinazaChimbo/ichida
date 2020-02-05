<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    $msg = "";
    if (isset($_GET['id'])) {
        $ids = mysqli_real_escape_string($con, $_GET['id']);
        $getlevy = mysqli_query($con, "SELECT * FROM levy WHERE member_id = '".$ids."' AND paid = false");
        $getlevy2 = mysqli_query($con, "SELECT * FROM levy WHERE member_id = '".$ids."' AND paid = false");
        if (mysqli_num_rows($getlevy)) {
            while($gt = mysqli_fetch_assoc($getlevy2)){
                $amount = $gt['amount'];
            }
        } else {
            $msg = "No Members are owing this debt";
        }
        
    } else {
        header("Location:index.php");
    }

    if (isset($_GET['status'])) {
        $status = mysqli_real_escape_string($con, $_GET['status']);
    } else {
        header("Location:index.php");
    }
    

    if (isset($_POST['submit'])) {
            $levys = $_POST['levys'];
            $date = date('d/m/Y');
            foreach ($levys as $levy) {
                $recno = mysqli_real_escape_string($con, $_POST[$levy]);
                $pay = mysqli_query($con, "UPDATE levy SET paid = TRUE WHERE id = '".$levy."'");
                $indate = mysqli_query($con, "UPDATE levy SET `date` = '".$date."' WHERE id = '".$levy."'");
                $inrec = mysqli_query($con, "UPDATE levy SET recipt_no = '".$recno."' WHERE id = '".$levy."'");
            }
            $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Paid Levy', '".$date."')");
            header("Location:adminunpaid.php?id=$ids");
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
  <title>IPU - Pay levy</title>

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

        <!-- /.container-fluid -->
<form action="paymemberlevy.php?id=<?php echo $ids?>&status=FALSE" method="post" style="width:100%;">
                <div class="card shadow mb-4">
        <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Select Levies</h6></div>
                <div class="card-body">
              <div class="table-responsive">
<?php
                            $i = 1;
                            echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Levy/Fine Name</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Levy/Fine Name</th>
                                            <th>Amount</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>";
                            while ($a = mysqli_fetch_assoc($getlevy)) {
                                $aid = $a['id'];
                                $aname = $a['name'];
                                $aamount = $a['amount'];
                                echo    "<tr>
                                            <td><label class='checkbox'>
                                                    <input type='checkbox' name='levys[]' onchange='showRecipt($aid)' value='".$aid."'></label></td>
                                            <td>
                                                    ".$aname."<br>
                                                <input style='display:none;' class='form-control animated fadeIn' name='".$aid."' id='".$aid."' type='text' placeholder='Enter recipt number'>
                                            </td>
                                            <td>&#8358;".$aamount."</td>
                                        </tr>";
                                $i++;
                            }

                            echo   "</tbody>
                                </table>";
                        ?>

                  
                  <br>
                        <?php
                            echo $msg;
                        ?>
                        <div class="column text-center">
                            <input type="submit" name="submit" value="Pay" class="btn btn-success"> <a href="paymemberlevy.php?id=<?php echo $ids?>" class="btn btn-danger">Cancel</a>
                        </div>
</form>
</div>
</div></div>
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

  
 <?php
    require 'includes/logoutmodal.php';
?>
  <!-- Bootstrap core JavaScript-->
  <?php
    require 'includes/scriptstables.php';
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

    function showRecipt(inid, bfname){
        var inid = inid;
        var input = document.getElementById(inid);
        if (input.style.display === "none") {
            input.style.display = "block";
        }else{
            input.style.display = "none";
        }
    }
</script>

</html>
