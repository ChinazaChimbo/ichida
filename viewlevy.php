<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    if (isset($_GET['name'])) {
        if (isset($_GET['paid']) && $_GET['paid'] == "TRUE" || $_GET['paid'] == "FALSE") {
            $names = mysqli_real_escape_string($con, $_GET['name']);
            $getlevy = mysqli_query($con, "SELECT * FROM levy WHERE name = '".$names."'");
            $status = mysqli_real_escape_string($con, $_GET['paid']);
            if (mysqli_num_rows($getlevy)) {
                if ($status == "TRUE") {
                    $get = mysqli_query($con, "SELECT * FROM levy WHERE name = '".$names."' AND paid = TRUE");
                } elseif($status == "FALSE") {
                    $get = mysqli_query($con, "SELECT * FROM levy WHERE name = '".$names."' AND paid = FALSE");
                }
                
                
            } else {
                header("Location:index.php");
            }
        }else{
            header("Location:index.php");
        }
        
    } else {
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

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
<?php
        require 'includes/header.php';
    ?>
    
  <title>IPU - <?php 
              if ($status == "TRUE") {
                  echo "$names Paid Members";
              } elseif($status == "FALSE") {
                  echo "$names Owing Members";
              }
              
          ?></title>

  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body id="page-top">
    <form>
      <input type="hidden" name="url" value="<?php echo $url?>" id="url">
    </form>
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
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <p class="text-center">
        <?php
            if ($status == "FALSE") {
                echo    "<a href='paylevy.php?name=".$_GET['name']."&status=$status' class='btn btn-success'>Pay Levy</a>";
            }
        ?></p>
            </div>
            <div id="box"> 
            <div class="card-body">
              <h1><img src="images/header.jpg" alt="header" style="width:100%;height:150px;"></h1>
               <h3 class="h3 mb-4 text-gray-800" stlye="color:blue;"></h3>
               <h4> <?php 
               echo $names;
              if ($status == "TRUE") {
                  echo " Paid Members";
              } elseif($status == "FALSE") {
                  echo " Owing Members";
              }
              
          ?></h4>
          
            <?php
              if($status == "FALSE"){
                if(mysqli_num_rows($get)){
                    $p = 1;
                    echo    "<div class='table-responsive'>
                            <table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                                <thead>
                                    <tr>
                                    <th>Membership Number</th>
                                      <th>Name</th>
                                      <th>Group</th>
                                      <th>Amount</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                  <tr>
                                  <th>Membership Number</th>
                                    <th>Name</th>
                                    <th>Group</th>
                                    <th>Amount</th>
                                    </tr>
                                  </tfoot>
                                <tbody>";
                    while ($a = mysqli_fetch_assoc($get)) {
                        $aamount = $a['amount'];
                        $getname = mysqli_query($con, "SELECT * FROM members WHERE id = '".$a['member_id']."'");
                        while ($b = mysqli_fetch_assoc($getname)) {
                            $bfname = $b['fname'];
                            $boname = $b['oname'];
                            $bsname = $b['sname'];
                            $mn = $b['mem_number'];
                            $phone = $b['phone'];
                            $gn = $b['group_no'];
                            $mn = $b['mem_number'];

                            $getgroup = mysqli_query($con, "SELECT * FROM groups WHERE id = '".$gn."'");
                            while ($gotg = mysqli_fetch_assoc($getgroup)) {
                              $gname = $gotg['name'];
                              echo     "<tr>
                                          <td>".$mn."</td>
                                          <td>".$bfname." ".$boname." ".$bsname."</td>
                                          <td>".$gname."</td>
                                          <td>&#8358;".$aamount."</td>
                                        </tr>";
                            }
                        }
                                $p++;
                    }
                    echo        "</tbody>
                            </table>
                            <div class='table-responsive'>";
                }else {
                    echo    "No member is owing this levy";
                }
            }elseif($status == "TRUE"){
                if(mysqli_num_rows($get)){
                    $p = 1;
                    echo    "
                    <div class='table-responsive'>
                      <table class='table table-bordered' id='dataTable' width='100%' cellspacing='0'>
                    <thead>
                        <tr>
                        <th>Membership number</th>
                            <th>Name</th>
                            <th>Paid On</th>
                            <th>Recipt no</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tfoot><tr>
                    <th>Membership number</th>
                      <th>Name</th>
                      <th>Paid On</th>
                      <th>Recipt no</th>
                        <th>Amount</th></tr>
                      </tfoot>
                    <tbody>";
                    while ($a = mysqli_fetch_assoc($get)) {
                        $date = $a['date'];
                        $aamount = $a['amount'];
                        $arecno = $a['recipt_no'];
                        $getname = mysqli_query($con, "SELECT * FROM members WHERE id = '".$a['member_id']."'");
                        while ($b = mysqli_fetch_assoc($getname)) {
                            $bfname = $b['fname'];
                            $boname = $b['oname'];
                            $mn = $b['mem_number'];
                            $bsname = $b['sname'];
                            $phone = $b['phone'];
                        }
                        echo    "<tr>
                                    <td>".$mn."</td>
                                    <td>".$bfname." ".$boname." ".$bsname."</td>
                                    <td>".$date."</td>
                                    <td>".$arecno."</td>
                                    <td>&#8358;".$aamount."</td>
                                </tr>";
                                $p++;
                    }
                    echo        "</tbody>
                            </table>
                            </div>";
                }else {
                    echo    "No member has paid this levy";
                }
            }
        ?>
</div>
              </div></div>
        
        <!-- /.container-fluid -->
            </div>
      </div>
      <!-- End of Main Content -->

        
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
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
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
  <script>
      $(document).ready(function() {
    $('#dataTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
  </script>

</body>

</html>
