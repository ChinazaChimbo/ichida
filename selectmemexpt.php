<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }

    if (!isset($_COOKIE['levy_name']) || !isset($_COOKIE['amount'])) {
        header("Location:index.php");
    }
    $date = date("d/m/Y");
    $getusers = mysqli_query($con, "SELECT * FROM members WHERE exempted = FALSE AND dead=FALSE ORDER BY fname ASC");
    if (isset($_POST['submit'])) {
        $members =  $_POST['member'];
        $i = 1;
        foreach ($members as $member) {
          $getmem = mysqli_query($con, "SELECT * FROM members WHERE mem_number = '".$member."'");
          while ($ab = mysqli_fetch_assoc($getmem)) {
            $mid = $ab['id'];
            $credit = $ab['credit'];
            if ($credit > 0) {
                $diff = $_COOKIE['amount'] - $credit;
                if ($diff <= 0) {
                    $in = mysqli_query($con, "INSERT INTO levy VALUES('', '".$_COOKIE['levy_name']."', '".$_COOKIE['category']."', '".$_COOKIE['amount']."', '".$mid."', TRUE, '".$date."', NULL)");
                    $newcredit = $credit - $_COOKIE['amount'];
                    $up = mysqli_query($con, "UPDATE members SET credit = '".$newcredit."' WHERE id = '".$mid."'");
                } else {
                    $in = mysqli_query($con, "INSERT INTO levy VALUES('', '".$_COOKIE['levy_name']."', '".$_COOKIE['category']."', '".$diff."', '".$mid."', FALSE, NULL, NULL)");
                    $up = mysqli_query($con, "UPDATE members SET credit = 0 WHERE id = '".$mid."'");
                }
            } else {
              $in = mysqli_query($con, "INSERT INTO levy VALUES('', '".$_COOKIE['levy_name']."', '".$_COOKIE['category']."', '".$_COOKIE['amount']."', '".$mid."', false, NULL, NULL)");
            }
          }
            $i ++;
        }
        $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Created new levy for ".$i." members', '".$date."')");
        setcookie("levy_name", $name, time() - 3600);
        setcookie("amount", $amount, time() - 3600);
        setcookie("category", $category, time() - 3600);
        header("Location:newlevy.php?success");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progressive Union | Dashboard</title>
  <meta name="description" content="">
  <meta name="author" content="">
<?php
        require 'includes/header.php';
    ?>

  <!-- Custom fonts for this template-->
  
</head>

<body id="page-top" >

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
              <form action="selectmem.php" method="post">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Select Members</h6>
              <div class="text-right"><input type="submit" value="Proceed" name="submit" class="btn btn-success"></div>
            </div>
            <div class="card-body">
              
              <div class="table-responsive">
                  <table border="0" cellspacing="5" cellpadding="5">
        <tbody><tr>
            <td>Select All:</td>
            <td><input type="checkbox" onclick="toggle(this);" /></td>
        </tr>
<?php
                            if(mysqli_num_rows($getusers)){
                                $i = 1;
                echo "<table class='table table-bordered' id='dataTable' width='100%' cellspacing='0' paging='false'>
                  <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Membership Number</th>
                                                <th>Name</th>
                                                <th>Group</th>
                                                <th>Telphone Number</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Membership Number</th>
                                                <th>Name</th>
                                                <th>Group</th>
                                                <th>Telphone Number</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>";
                                while ($a = mysqli_fetch_assoc($getusers)) {
                                  $phone = $a['phone'];
                                  $gn = $a['group_no'];
                                  $mn = $a['mem_number'];

                                  $getgroup = mysqli_query($con, "SELECT * FROM groups WHERE id = '".$gn."'");
                                  while ($gotg = mysqli_fetch_assoc($getgroup)) {
                                  $gname = $gotg['name'];
                                  echo     "<tr>
                                              <td>                                                    <label class='checkbox'>
                                                        <input type='checkbox' name='member[]' value='".$mn."'></label></td>
                                             <td>".$a['id']."</td>
                                              <td>
                                                        ".$a['fname']." ".$a['oname']." ".$a['sname']."
                                                </td>
                                                <td>".$gname."</td>
                                                
                                                <td>".$phone."</td>
                                              </tr>";
                                  }
                                            $i ++;
                                }
                                echo    "</tbody>
                                        </table>";
                            }else {
                                echo "There are no members registered";
                            }
                        ?>
              </div>
              <div class="text-center">
                            <input type="submit" value="Proceed" name="submit" class="btn btn-success">
                    </div>
            
            </div>
            </form>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php
        require 'includes/footer.php';
    ?>
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
        require 'scriptstables1.php';
    ?>
<script>
    function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}
</script>
<script type="text/javascript">
function idleTimer() {
    var t;
    //window.onload = resetTimer;
    window.onmousemove = resetTimer; // catches mouse movements
    window.onmousedown = resetTimer; // catches mouse movements
    window.onclick = resetTimer;     // catches mouse clicks
    window.onscroll = resetTimer;    // catches scrolling
    window.onkeypress = resetTimer;  //catches keyboard actions

    function logout() {
        window.location.href = 'logout.php';  //Adapt to actual logout script
    }

   function reload() {
          window.location = self.location.href;  //Reloads the current page
   }

   function resetTimer() {
        clearTimeout(t);
        t = setTimeout(logout, 7000000);  // time is in milliseconds (1000 is 1 second)
        t= setTimeout(reload, 6000000);  // time is in milliseconds (1000 is 1 second)
    }
}
idleTimer();
</script>

</body>

</html>
