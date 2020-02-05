<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin']) || !isset($_SESSION['user'])) {
        header('Location:index.php');
    }
    $msg = "";
    if (isset($_GET['name'])) {
        $names = mysqli_real_escape_string($con, $_GET['name']);
        $getlevy = mysqli_query($con, "SELECT * FROM levy WHERE name = '".$names."' AND paid = false");
        $getlevy2 = mysqli_query($con, "SELECT * FROM levy WHERE name = '".$names."' AND paid = false");
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
        $members = $_POST['member'];
        $date = date('d/m/Y');
        foreach ($members as $member) {
            $getmem = mysqli_query($con, "SELECT * FROM members WHERE id = '".$member."'");
            while ($a = mysqli_fetch_assoc($getmem)) {
                $fname = $a['fname'];
                $sname = $a['sname'];
                $by = $fname." ".$sname;
            }
            $pay = mysqli_query($con, "UPDATE levy SET paid = true WHERE member_id = '".$member."' AND name = '".$names."'");
            $indate = mysqli_query($con, "UPDATE levy SET `date` = '".$date."' WHERE member_id = '".$member."' AND name = '".$names."'");
            $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', '".$names."', '".$by."', 'Income', '".$amount."', 'Cash', '".$date."')");
        }

        header("Location:viewlevy.php?name=$names&paid=FALSE");
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
        require 'includes/usersidebar.php';
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
          <h1 class="h3 mb-4 text-gray-800">Ichida Progress Union | Payment of <?php echo $names?></h1>
<h6>Select paying Members</h6>
        </div>
        <!-- /.container-fluid -->
<form action="paylevy.php?name=<?php echo $names?>&status=FALSE" method="post" style="width:100%;">
                <div class="card-body">
              <div class="table-responsive">
<?php
                            $i = 1;
                            echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>";
                            while ($a = mysqli_fetch_assoc($getlevy)) {
                                $memid = $a['member_id'];
                                $getname = mysqli_query($con, "SELECT * FROM members WHERE id = '".$memid."'");
                                while ($b = mysqli_fetch_assoc($getname)) {
                                    $bfname = $b['fname'];
                                    $bsname = $b['sname'];
                                    $boname = $b['oname'];

                                    echo    "<tr>
                                                <td>".$i."</td>
                                                <td>
                                                    <label class='checkbox'>
                                                        <input type='checkbox' name='member[]' value='".$memid."'>
                                                        ".$bfname." ".$boname." ".$bsname."
                                                    </label><br>
                                                </td>
                                            </tr>";
                                }
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
                            <input type="submit" name="submit" value="Pay" class="btn btn-success"> <a href="userviewlevies.php?name=<?php echo $name?>&paid=<?php echo $status?>" class="btn btn-danger">Cancel</a>
                        </div>
</form>
                  
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
</script>

</html>
