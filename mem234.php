<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }

    $get = mysqli_query($con, "SELECT * FROM members ORDER BY fname ASC");
    $paytotal = 0;
    $totaldebts = 0;
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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
  <style>
      table tfoot {
    display: table-row-group;
}

  </style>

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
              <div class="table-responsive">
             <br>
              <?php
                $i = 1;
                if(mysqli_num_rows($get)){
                echo "<table id='myTable' class='table table-bordered' style='width:100%' pagination='true'>
                  <thead>
                                        <tr>
                                          <th>Membership Number</th>
                                          <th>Full Name</th>
                                          <th>Group</th>
                                          <th>Status</th>
                                          <th>Debts (₦)</th>
                                          <th>Amount Paid(₦)</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>";
                                    $paid = 0;
                                    while ($a = mysqli_fetch_assoc($get)) {
                                        $title = $a['title'];
                                        $sname = $a['sname'];
                                        $fname = $a['fname'];
                                        $oname = $a['oname'];
                                        $id = $a['id'];
                                        $gn = $a['group_no'];
                                        $mn = $a['mem_number'];
                                        $dead = $a['dead'];
                                        $credit = $a['credit'];
                                        $exempted = $a['exempted'];
                                        if ($dead == TRUE) {
                                          $status = "Dead";
                                        }elseif ($dead == FALSE) {
                                          if ($exempted == True) {
                                            $status = "Inactive";
                                          } else {
                                            $status = "Active";
                                          }
                                          
                                        }
                                        $getpaid = mysqli_query($con, "SELECT * FROM levy WHERE member_id = '".$id."' AND paid = TRUE");
                                        while ($gp = mysqli_fetch_assoc($getpaid)) {
                                          $gpamount = $gp['amount'];
                                          $paid += $gpamount;
                                        }
                                        $getgroup = mysqli_query($con, "SELECT * FROM groups WHERE id = '".$gn."'");
                                        while ($gotg = mysqli_fetch_assoc($getgroup)) {
                                          $gname = $gotg['name'];
                                          $getdebts = mysqli_query($con, "SELECT * FROM levy WHERE member_id = '".$id."' AND paid = FALSE");
                                          $debt = 0;

                                          while ($gotdebts = mysqli_fetch_assoc($getdebts)) {
                                            $debt += $gotdebts['amount'];
                                          }

                                          $alias = 0;
                                          $sub = -1;
                                          if ($debt == 0) {
                                            $alias = $sub * $credit;
                                          }
                                          else{
                                            $alias = $debt;
                                          }
                                          echo    "<tr>
                                                        <td>".$mn."</td>
                                                        <td><a href ='user.php?id=".$id."'>".$title." ".$sname."  ".$oname." ".$fname."</td>
                                                        <td>".$gname."</td>
                                                        <td>".$status."</td>
                                                        <td>".$debt."</td>
                                                        <td>".$paid."</td>
                                                        
                                                    </tr>";
                                        }
                                            $paytotal += $paid;
                                            $totaldebts += $debt;
                                            $debt = 0;
                                            $paid = 0;
                                        $i++;
                                    }
                        echo        "</tbody>
                         <tfoot>
            <tr>
            <th></th>
            <th></th>
            <th></th>
                <th>Total:</th>
                <th>₦".$totaldebts."</th>
                <th>₦".$paytotal."</th>
            </tr>
        </tfoot>
        
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
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
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
    $('#myTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true }, 
            { extend: 'print',footer: true},
            { extend: 'pdfHtml5', footer: true }
        ],
        rowCallback: function(row, data, index, start, end, display){
  	  if(data[4]< -1){
    	$(row).find('td:eq(4)').css('color', 'red');
    }
    if(data[3] == 'Dead' ){
    	$(row).find('td:eq(3)').css('color', 'red');
    }
    if(data[3] == 'Inactive' ){
    	$(row).find('td:eq(3)').css('color', 'red');
    }
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, {filter:'applied'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                
 
            // Update footer
            $( api.column( 4 ).footer() ).html(
                '₦'+pageTotal +''
            );
            
        }
    } );
} );
  </script>
  
  <!--<script type="text/javascript">
  
  </script>-->
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="js/parsley.min.js"></script>
  <script src="js/wow.min.js"></script>



</body>

</html>
