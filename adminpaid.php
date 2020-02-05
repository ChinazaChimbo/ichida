<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    if (!isset($_GET['id'])) {
        header("Location:index.php");
    }
    $member = mysqli_real_escape_string($con, $_GET['id']);
    $get = mysqli_query($con, "SELECT * FROM members WHERE id = '".$member."'");
    if(mysqli_num_rows($get)){
        while ($mem = mysqli_fetch_assoc($get)) {
            $pass = $mem['password'];
            $title = $mem['title'];
            $fname = $mem['fname'];
            $sname = $mem['sname'];
            $oname = $mem['oname'];
            $dob = $mem['dob'];
            $ms = $mem['marital_status'];
            $village = $mem['village'];
            $la = $mem['lagos_address'];
            $email = $mem['email'];
            $phone = $mem['phone'];
            $wn = $mem['wa_number'];
            $id = $mem['id'];
            if ($mem['challenge'] == "") {
                $challenge = "NONE";
            }
            $username = $mem['username'];
            $yoe = $mem['yoe'];
            $gn = $mem['group_no'];
            $mn = $mem['mem_number'];
            $chkgroup = mysqli_query($con, "SELECT * FROM groups WHERE id = '".$gn."'");
            while ($g = mysqli_fetch_assoc($chkgroup)) {
                $gname = $g['name'];
            }
        }
    }else{
        header("Location:index.php");
    }
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $url = "https://";
    }else{
        $url = "http://";
    }
    
    $url.= $_SERVER['HTTP_HOST'];
    $url.= $_SERVER['REQUEST_URI']; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | Member Information</title>

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
          
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6><p class="text-center"><input type="button" class="btn btn-primary" onclick="printDiv('box')" value="Print" /></p></h6>
            </div>
            <div id="box">
            <div class="card-body">
              
          <!-- Page Heading -->
          <h1> <img src="images/header.jpg" alt="header" style="width:100%;height:150px;"></h1>
          <h2><?php echo $title." ".$fname." ".$oname." ".$sname;?></h2>
          <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
    <h4>Member Details</h4>
    <br>
    <p><b>Membership Number:</b> <?php echo $mn?></p>
    <p><b>Group:</b> <?php echo $gname?></p><br>
                <p><b>Village:</b> <?php echo $village?></p><br>
                        <p><b>Lagos Address:</b> <?php echo $la?></p><br>
                        <p><b>Date of Birth:</b> <?php echo $dob?></p><br>
                        <p><b>Marital Status:</b> <?php echo $ms?></p><br>
                        <p><b>Health/Physical Challenge:</b> <?php echo $challenge?></p><br>
                        <p><b>Membership Number:</b> <?php echo $mn?></p><br>
                        
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <h4>Contacts</h4><br>
<p><b>Email:</b> <?php echo $email?></p><br>
                        <p><b>Telephone Number:</b> <?php echo $phone?></p><br>
                        <p><b>Whatsapp Number:</b> <?php echo $wn?></p><br>
                        <p><b>Username:</b> <?php echo $username?></p><br>
                        <p><b>Year of Entry:</b> <?php echo $yoe?></p><br>
                        </div>
          </div>  
          
            <div class="text-center">
              <h3> <u>PAID LEVIES</u></h3>
            </div>
            
              <div class="table-responsive">
                <?php
                    $checklevy = mysqli_query($con, "SELECT * FROM levy WHERE member_id = '".$id."' AND paid = true");
                    $i = 1;
                    if (mysqli_num_rows($checklevy)) {
                        echo    "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>";
                  echo    "<thead>";
                                echo    "<tr>";
                                    echo    "<th>no</th>";
                                    echo    "<th>Levy Name</th>";
                                    echo    "<th>Category</th>";
                                    echo    "<th>Amount</th>";
                                    echo    "<th>Recipt Number</th>";
                                    echo    "<th>Date Paid</th>";
                                echo    "</tr>";
                            echo    "</thead>";
                            echo    "<tfoot>";
                                echo    "<tr>";
                                echo    "<th>no</th>";
                                    echo    "<th>Levy Name</th>";
                                    echo    "<th>Category</th>";
                                    echo    "<th>Amount</th>";
                                    echo    "<th>Recipt Number</th>";
                                    echo    "<th>Date Paid</th>";
                                echo    "</tr>";
                            echo    "</tfoot>";
                            echo    "<tbody>";
                                while ($l = mysqli_fetch_assoc($checklevy)) {
                                    $lid = $l['id'];
                                    $lname = $l['name'];
                                    $lcat = $l['category'];
                                    $lamount = $l['amount'];
                                    $lmid = $l['member_id'];
                                    $lpaid = $l['paid'];
                                    $ldate = $l['date'];
                                    $lrec_no = $l['recipt_no'];

                                    $getcatname = mysqli_query($con, "SELECT * FROM levy_categories WHERE id = '".$lcat."'");
                                    while ($gc = mysqli_fetch_assoc($getcatname)) {
                                        $cname = $gc['name'];
                                    }

                                    echo    "<tr>";
                                        echo    "<td>".$i."</td>";
                                        echo    "<td>".$lname."</td>";
                                        echo    "<td>".$cname."</td>";
                                        echo    "<td>&#8358;".$lamount."</td>";
                                        echo    "<td>".$lrec_no."</td>";
                                        echo    "<td>".$ldate."</td>";
                                    echo    "</tr>";
                                    $i++;
                                }
                            echo    "</tbody>";
                        echo    "</table>";
                    } else {
                        echo "This member has not paid any levy yet";
                    }
                    
                ?>
                
              </div>
            

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
        require 'includes/scripts.php';
    ?>


</body>

</html>
