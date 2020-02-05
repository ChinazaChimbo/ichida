<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }

    $getgroup = mysqli_query($con, "SELECT * FROM groups");
    $date = date("d/m/Y");
    $msg = "";
    if (isset($_POST['submit'])) {
        if (!empty($_POST['title']) &&!empty($_POST['fname']) && !empty($_POST['sname']) && !empty($_POST['oname']) && !empty($_POST['mart']) && !empty($_POST['village']) && !empty($_POST['lga']) && !empty($_POST['phone']) && !empty($_POST['mn']) && !empty($_POST['fn']) && !empty($_POST['noka']) && !empty($_POST['nokp']) && !empty($_POST['nokr'])) {
            $title = mysqli_real_escape_string($con, $_POST['title']);
            $fname = mysqli_real_escape_string($con, $_POST['fname']);
            $sname = mysqli_real_escape_string($con, $_POST['sname']);
            $exempted = mysqli_real_escape_string($con, $_POST['exempted']);
            $oname = mysqli_real_escape_string($con, $_POST['oname']);
            if (empty($_POST['dob'])) {
              $dob = "NONE";
            }else{
              $dob = mysqli_real_escape_string($con, $_POST['dob']);
            }
            $mart = mysqli_real_escape_string($con, $_POST['mart']);
            $village = mysqli_real_escape_string($con, $_POST['village']);
            if (empty($_POST['hp'])) {
                $hp = "NONE";
            }
            $lga = mysqli_real_escape_string($con, $_POST['lga']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $phone = mysqli_real_escape_string($con, $_POST['phone']);
            if (empty($_POST['wn'])) {
              $wn = 0000;
            } else {
              $wn = mysqli_real_escape_string($con, $_POST['wn']);
            }
            $hp = mysqli_real_escape_string($con, $_POST['hp']);
            if (empty($_POST['yoe'])) {
              $yoe = 0000;
            } else {
              $yoe = mysqli_real_escape_string($con, $_POST['yoe']);
            }
            if (empty($_POST['credit'])) {
              $credit = 0;
            } else {
              $credit = mysqli_real_escape_string($con, $_POST['credit']);
            }
            
            $mn = mysqli_real_escape_string($con, $_POST['mn']);
            $fn = mysqli_real_escape_string($con, $_POST['fn']);
            $noka = mysqli_real_escape_string($con, $_POST['noka']);
            $nokp = mysqli_real_escape_string($con, $_POST['nokp']);
            $nokr = mysqli_real_escape_string($con, $_POST['nokr']);
            if (is_numeric($phone)) {
                if (is_numeric($wn)) {
                    if (is_numeric($yoe)) {
                      if(is_numeric($credit)){
                        if (is_numeric($mn)) {
                            if (is_numeric($nokp)) {
                                $check = mysqli_query($con, "SELECT * FROM members WHERE mem_number = '".$mn."'");
                                if (mysqli_num_rows($check) < 1) {
                                  if ($_FILES["pic"]["size"] > 0) {
                                    if($_FILES["pic"]["type"]=="image/jpeg" ||$_FILES["pic"]["type"]=="image/png" ||$_FILES["pic"]["type"]=="image/JPG"){
                                      move_uploaded_file($_FILES['pic']['tmp_name'],"img/users/".$_FILES['pic']['name']);//this moves the file to the specified location
                                      $in = mysqli_query($con, "INSERT INTO members VALUES('', '".$title."', '".$fname."', '".$sname."', '".$oname."', '".$dob."', '".$mart."', '".$village."', '".$lga."', '".$email."', '".$phone."', '".$wn."', '".$hp."', '".$mn."', 12345, '".$yoe."', '".$_POST['group']."', '".$mn."', '".$_FILES['pic']['name']."', '".$exempted."', '".$credit."', FALSE)");
                                    $getid = mysqli_query($con, "SELECT * FROM members WHERE mem_number = '".$mn."'");
                                    while($got = mysqli_fetch_assoc($getid)){
                                        $gid = $got['id'];
                                    }
                                    $innext = mysqli_query($con, "INSERT INTO next_of_kin VALUES('', '".$fn."', '".$noka."', '".$nokp."', '".$nokr."', '".$gid."')");
                                    $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Admin added new member', '".$date."')");
                                    if (!empty($_POST['olddebt'])) {
                                        if(is_numeric($_POST['olddebt'])){
                                            $olddebt = mysqli_real_escape_string($con, $_POST['olddebt']);
                                            $in = mysqli_query($con, "INSERT INTO levy VALUES('', 'Old Debts', 1, '".$olddebt."', '".$gid."', false, NULL, NULL)");
                                        }else{
                                            $msg = "<div class='notification is-danger'>
                                                        <button class='delete'></button>
                                                        Old debt must be numeric.
                                                    </div>";
                                        }
                                    }
                                    $msg = "<div class='alert alert-success'>
                                                <button class='delete'></button>
                                                Member has been added successfully
                                                <p>Username is ".$mn." and Password is ".$mn."</p>
                                            </div>"; 
                                    }else{
                                      $msg="<div class='alert alert-danger'>Select a valid Filetype to upload</div>";
                                    }
                                  }else{
                                    $in = mysqli_query($con, "INSERT INTO members VALUES('', '".$title."', '".$fname."', '".$sname."', '".$oname."', '".$dob."', '".$mart."', '".$village."', '".$lga."', '".$email."', '".$phone."', '".$wn."', '".$hp."', '".$mn."', 12345, '".$yoe."', '".$_POST['group']."', '".$mn."', 'default.png', '".$exempted."', '".$credit."', FALSE)");
                                    $getid = mysqli_query($con, "SELECT * FROM members WHERE mem_number = '".$mn."'");
                                    while($got = mysqli_fetch_assoc($getid)){
                                        $gid = $got['id'];
                                    }
                                    $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Admin added new member', '".$date."')");
                                    $innext = mysqli_query($con, "INSERT INTO next_of_kin VALUES('', '".$fn."', '".$noka."', '".$nokp."', '".$nokr."', '".$gid."')");
                                    if (!empty($_POST['olddebt'])) {
                                        if(is_numeric($_POST['olddebt'])){
                                            $olddebt = mysqli_real_escape_string($con, $_POST['olddebt']);
                                            $in = mysqli_query($con, "INSERT INTO levy VALUES('', 'Old Debts', 1, '".$olddebt."', '".$gid."', false, NULL, NULL)");
                                        }else{
                                            $msg = "<div class='notification is-danger'>
                                                        <button class='delete'></button>
                                                        Old debt must be numeric.
                                                    </div>";
                                        }
                                    }
                                    $msg = "<div class='alert alert-success'>
                                                <button class='delete'></button>
                                                Member has been added successfully
                                                <p>Username is ".$mn." and Password is ".$mn."</p>
                                            </div>"; 
                                  }
                                }else{
                                    $msg = "<div class='alert alert-danger'>
                                            <button class='delete'></button>
                                            Membership number already exists please select another
                                        </div>";
                                }
                            }else{
                                $msg = "<div class='alert alert-danger'>
                                            <button class='delete'></button>
                                            Next of Kin telephone number should be numeric
                                        </div>";
                            }
                        }else{
                            $msg = "<div class='alert alert-danger'>
                                        <button class='delete'></button>
                                        Membership Number should be numeric
                                    </div>";
                        }
                    }else{
                      $msg = "<div class='notification is-danger'>
                                <button class='delete'></button>
                                Credit must be numeric
                            </div>";
                    }
                  }else{
                      $msg = "<div class='notification is-danger'>
                              <button class='delete'></button>
                              Year of entry should be numeric
                          </div>"; 
                  }
                }else{
                    $msg = "<div class='notification is-danger'>
                                <button class='delete'></button>
                                Member Whatsapp number should be numeric
                            </div>";
                }
            }else{
                $msg = "<div class='notification is-danger'>
                        <button class='delete'></button>
                        Member Phone number should be numeric
                    </div>";
            }
        }else{
            $msg = "<div class='notification is-danger'>
                        <button class='delete'></button>
                        Please fill all fields.
                    </div>";
        }
    }
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
  <title>IPU - Add user</title>

  <!-- Custom fonts for this template-->
  <script>
      function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
  </script>
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
          <h1 class="h3 mb-4 text-gray-800">Add New Members</h1>
         <form action="newuser.php" method="post" enctype="multipart/form-data" data-parsely-validate>
      <div class="row">

            <div class="col-lg-6">

              <!-- Default Card Example -->
              <div class="card mb-4 border-bottom-primary" >
                  <div class="card shadow mb-4">
                <div class="card-header">
                  Personal Details
                </div>
                <div class="card-body">
                    <br>
                        <?php
                            echo $msg;
                        ?>
                    <div class="form-group">
                        <style>
    #imgContainer {
width: 100%;
text-align: center;
position: relative;
}

#imgArea {
display: inline-block;
margin: 0 auto;
max-width:150px;
max-height:150px;
position: relative;
background-color: #eee;
font-family: Arial, Helvetica, sans-serif;
font-size: 13px;
}
#imgArea img {
outline: medium none;
vertical-align: middle;
max-width:150px;
max-height:150px;
}
#imgChange {
background: url("../img/overlay.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
bottom: 0;
color: #FFFFFF;
display: block;
height: 30px;
left: 0;
line-height: 32px;
position: absolute;
text-align: center;
max-width:150px;
}
#imgChange input[type="file"] {
bottom: 0;
cursor: pointer;
left: 0;
margin: 0;
opacity: 0;
padding: 0;
position: absolute;
width: 150px;
z-index: 0;
}


</style>
                        <div class="text-center"><div id="imgContainer">
    <div id="imgArea"><img class id="blah" src="./img/default.jpg">
      <div id="imgChange"><span>Profile Passport</span>
        <input type="file"  name="pic" onchange="readURL(this);" >
      </div>
    </div>
</div></div></div>
                    <div class="form-group">
                  <label>Titles:</label>
                    <input type="text" class="form-control form-control-user" id="title" name="title" placeholder="eg. Mr,Dr,Engr..." required ></div>
                    <div class="form-group">
                        <label>Firstname:</label>
                    <input type="text" class="form-control form-control-user" id="fname" name="fname" placeholder="eg. John" required >
                  </div>
                  <div class="form-group">
                        <label>Lastname/Surname:</label>
                    <input type="text" class="form-control form-control-user" name="sname" id="sname" placeholder="eg. Shaw" required >
                  </div>
                  <div class="form-group">
                      <label>Other Name:</label>
                    <input type="text" class="form-control form-control-user" id="oname" name="oname" placeholder="Fredricks" required
                    >
                  </div>
                  <div class="form-group">
                      <label>Date of Birth:</label>
                    <input type="date" name="dob" id="dob" class="form-control form-control-user" placeholder="May/15/1998">
                  </div>
                  <div class="form-group">
                  <label class="label">Marital Status: </label>
                                <div class="form-check">
                                    <div class="form-check">
                                    <label class="radio">
                                        <input class="form-check-input" type="radio" name="mart" checked value="Married">
                                        Married
                                    </label></div>
                                     <div class="form-check">
                                    <label class="radio">
                                        <input class="form-check-input" type="radio" name="mart" value="Single">
                                        Single
                                    </label></div>
                                    <div class="form-check">
                                    <label class="radio">
                                        <input class="form-check-input" type="radio" name="mart" value="Divorced">
                                        Divorced
                                    </label></div>
                                    <div class="form-check">
                                    <label class="radio">
                                        <input class="form-check-input" type="radio" name="mart" value="Widowed">
                                        Widowed
                                    </label></div></div>
                                    
                                    <div class="form-group">
                                        <label>Village :</label>
                    <input type="text" name="village" id="village" class="form-control form-control-user" placeholder="Village" required>
                  </div>
                                   
                                    <div class="form-group">
                                        <label>Lagos Address :</label>
                    <input type="text" name="lga" id="lga" class="form-control form-control-user" placeholder="Lagos Address" required>
                </div>
              </div>
              </div>
              </div></div>
              
              <!-- /.col-lg-6 -->
              <div class="card mb-4 border-bottom-primary">
                  <div class="card shadow mb-4">
                <div class="card-header">
                  Member Electronic/Health Details
                </div>
                <div class="card-body">
                    <div class="form-group">
                   <label for="email" class="label">Email:</label>
                                    <input type="email" class="form-control form-control-user" placeholder="Email" name="email" id="email">
                  </div>
                  <div class="form-group">
                      <label>Phone Number :</label>
                    <input type="number" name="phone" id="phone" required class="form-control form-control-user" placeholder="eg. 08134567889" maxlength="11">
                  </div>
                  
                  <div class="form-group">
                      <label>Whatsap Number:</label>
                     <input type="number" class="form-control form-control-user" placeholder="Whatsapp Number" name="wn" id="wn" maxlenth="11">
                  </div>
                  <div class="form-group">
                      <label>Health Challenges:</label>
                    <input type="text" class="form-control form-control-user" name="hp" id="h" placeholder="health Challenges" >
                  </div>
                  </div>
                </div>
                </div>
              
              </div>

               <div class="col-lg-6">

              <!-- Default Card Example -->
              <div class="card mb-4 border-bottom-primary">
                  <div class="card shadow mb-4">
                <div class="card-header">
                  Membership Details/Next of Kin Details
                </div>
                <div class="card-body">
                  <div class="form-group">
                      <label>Year of Entry:</label>
                    <input type="text" class="form-control form-control-user" placeholder="2015" name="yoe" id="yoe"  maxlength="4">
                    </div>
                    <div class="form-group">
                        <label>Membership Number:</label>
                                       <input type="name" class="form-control form-control-user" placeholder="Membership Number" name="mn" id="mn" required>
                                    </div>
                    <div class="form-group"><label for="group">Group:</label>
                                    <?php
                                        if (mysqli_num_rows($getgroup)) {
                                            echo "<div class='form-group'>";
                                                echo "<select class='form-control' name='group'>";
                                                    while ($gotgroup = mysqli_fetch_assoc($getgroup)) {
                                                        echo "<option value = ".$gotgroup['id'].">".$gotgroup['name']."</option>";
                                                    }
                                                echo "</select>";
                                            echo "</div>";
                                        } else {
                                            echo "Please Create a group before registering a new member";
                                        }
                                        
                                    ?></div>
                                    <div class="form-group">
                                        <label>Old Debts:</label>
                                       <input type="text" class="form-control form-control-user" placeholder="Old Debts" name="olddebt" id="olddebt">
                                    <small style="color:red">*Leave blank if there are no old debts</small></div>
                                    <div class="form-group">
                                        <label for="credit">Credit:</label>
                                        <input type="number" name="credit" id="credit" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="exempted">Exempted?:</label>
                                        <select name="exempted" id="exempted" class="form-control">
                                          <option value="0"> Not Exempted</option>
                                          <option value="1">Exempted</option>
                                        </select>
                                    </div>
                                     <hr>
                                      <p><b>Next of Kin Details</b></p>
                                      <div class="form-group">
                                          <label>Next of Kin Full Name:</label>
                                      <input type="text" class="form-control form-control-user" placeholder="John Shaw" name="fn" id="fn"></div>
                                      <div class="form-group">
                                          <label>Next of Kin Address:</label>
                                      <input type="text" class="form-control form-control-user" placeholder="6,gasner ,london..." name="noka" id="noka" required ></div>
                                      <div class="form-group">
                                          <label>Next of Kin Phone No:</label>
                    <input type="number" class="form-control form-control-user" placeholder="eg. 0803456778" name="nokp" id="nokp" required maxlength="11">
                  </div>
                 <div class="form-group">
                     <label>Relationship:</label>
                    <input type="text" class="form-control form-control-user" placeholder="eg. Father" name="nokr" id="nokr" required>
                  </div>
                </div>
              </div>
              </div>
              
              <!-- /.col-lg-6 -->
              </div>
              <!-- /.class row -->

</div>
<br>
                        <?php
                            echo $msg;
                        ?>
                        <div class="control text-center">
                            <input type="submit" value="Register" name="submit" class="btn btn-primary">
                        </div>

</form>

        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
</div>
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
  <?php
        require 'includes/scripts.php';
    ?>

</body>

</html>