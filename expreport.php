<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }

    $get = mysqli_query($con, "SELECT * FROM expense ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | Expenses Report</title>
  <meta name="description" content="">
  <meta name="author" content="">
<?php
        require 'includes/header.php';
    ?>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
          <h1 class="h3 mb-4 text-gray-800">Expenses Report</h1>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Expenses</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                  <?php
                    if (mysqli_num_rows($get)) {
                      echo "
                              <table border='0' cellspacing='5' cellpadding='5'>
                              <tbody><tr>
                                  <td>Minimum Date:</td>
                                  <td><div class='col-xs-3'><input class='form-control form-rounded'  type='text' id='min' name='min'></div></td>
                              </tr>
                              <tr>
                                  <td>Maximum Date:</td>
                                  <td><div class='col-xs-3'><input class='form-control form-rounded' type='text' id='max' name='max'></div></td>
                              </tr>
                          </tbody></table>
                                      <table id='myTable' class='table table-striped table-bordered' style='width:100%' pagination='true'>
                              <thead>
                                  <tr>
                                      <th>S/N</th>
                                      <th>Title</th>
                                      <th>By</th>
                                      <th>Date</th>
                                      <th>Amount</th>
                                  </tr>
                              </thead>
                              <tbody>";
                      $i = 1;
                      $total = 0;
                      while ($got = mysqli_fetch_assoc($get)) {
                        $gotid = $got['id'];
                        $gotname = $got['name'];
                        $gothb = $got['handled_by'];
                        $gotamount = $got['amount'];
                        $gotdate = $got['date'];
                        $total += $gotamount;
                        echo "<tr>
                                <td>".$i."</td>
                                <td>".$gotname."</td>
                                <td>".$gothb."</td>
                                <td>".$gotdate."</td>
                                <td>".$gotamount."</td>
                              </tr>";
                        $i ++;
                      }
                      echo "</tbody>
                              <tfoot>
                                  <tr>
                                      <th colspan='4' style='text-align:right'>Total:</th>
                                      <th></th>
                                  </tr>
                              </tfoot>
                          </table>";
                    }else{
                      echo "There are no records yet";
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
       $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#min').datepicker("getDate");
                    var max = $('#max').datepicker("getDate");
                    // need to change str order before making  date obect since it uses a new Date("mm/dd/yyyy") format for short date.
                    var d = data[3].split("/");
                    var startDate = new Date(d[1]+ "/" +  d[0] +"/" + d[2]);

                    if (min == null && max == null) { return true; }
                    if (min == null && startDate <= max) { return true;}
                    if(max == null && startDate >= min) {return true;}
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }
            );
    $('#myTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            { extend: 'copyHtml5', footer: true },
            { extend: 'excelHtml5', footer: true },
            { extend: 'csvHtml5', footer: true }, 
            { extend: 'print', footer: true },
            { extend: 'pdfHtml5', footer: true }
        ],
         "footerCallback": function ( row, data, start, end, display ) {
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
            $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true , dateFormat:"dd/mm/yy"});
            $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true, dateFormat:"dd/mm/yy" });

        var table = $('#myTable').DataTable();
            $('#min, #max').change(function () {
                table.draw();
            });
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
