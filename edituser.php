<?php
    require 'includes/conn.php';
    if (!isset($_SESSION['admin'])) {
        header('Location:index.php');
    }
    if(!isset($_GET['id'])){
        header("Location:index.php");
    }
    $getgroup = mysqli_query($con, "SELECT * FROM groups");
    $member = mysqli_real_escape_string($con, $_GET['id']);
    $getod = mysqli_query($con, "SELECT * FROM levy WHERE category = 1 AND member_id = '".$member."'");
    if (mysqli_num_rows($getod)) {
        while ($a = mysqli_fetch_assoc($getod)) {
            $olddebt = $a['amount'];
            $odid = $a['id'];
        }
    } else {
        $olddebt = 0;
    }
    $get = mysqli_query($con, "SELECT * FROM members WHERE id = '".$member."'");
    if(mysqli_num_rows($get)){
        while ($mem = mysqli_fetch_assoc($get)) {
            $pass = $mem['password'];
            $title = $mem['title'];
            $fname = $mem['fname'];
            $sname = $mem['sname'];
            $oname = $mem['oname'];
            $exempted = $mem['exempted'];
            $dob = $mem['dob'];
            $ms = $mem['marital_status'];
            $village = $mem['village'];
            $la = $mem['lagos_address'];
            $email = $mem['email'];
            $phone = $mem['phone'];
            $wn = $mem['wa_number'];
            $id = $mem['id'];
            $pics2 = $mem['pro_pic'];
            if ($mem['challenge'] == "") {
                $challenge = "NONE";
            }else{
              $challenge = $mem['challenge'];
            }
            $username = $mem['username'];
            $yoe = $mem['yoe'];
            $gns = $mem['group_no'];
            $chkgroup = mysqli_query($con, "SELECT * FROM groups WHERE id = '".$gns."'");
            while ($g = mysqli_fetch_assoc($chkgroup)) {
                $gname = $g['name'];
            }
        }
        $getnok = mysqli_query($con, "SELECT * FROM next_of_kin WHERE member_id = '".$member."'");
        while ($nok = mysqli_fetch_assoc($getnok)) {
            $nokn = $nok['name'];
            $noka = $nok['address'];
            $nokp = $nok['phone'];
            $nokr = $nok['relationship'];
        }
    }else{
        header("Location:index.php");
    }
    $date = date("d/m/Y");
    $msg = "";
    if (isset($_POST['submit'])) {
          $title = mysqli_real_escape_string($con, $_POST['title']);
          $fname = mysqli_real_escape_string($con, $_POST['fname']);
          $sname = mysqli_real_escape_string($con, $_POST['sname']);
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
          $nexempted = mysqli_real_escape_string($con, $_POST['exempted']);
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
          $mn = mysqli_real_escape_string($con, $_POST['mn']);
          $fn = mysqli_real_escape_string($con, $_POST['fn']);
          $gn = mysqli_real_escape_string($con, $_POST['group']);
          $noka = mysqli_real_escape_string($con, $_POST['noka']);
          $nokp = mysqli_real_escape_string($con, $_POST['nokp']);
          $nokr = mysqli_real_escape_string($con, $_POST['nokr']);
            
                if (is_numeric($wn)) {
                    if (is_numeric($yoe)) {
                        
                          if($_FILES['pic']['size'] > 0){
                            if($_FILES["pic"]["type"]=="image/jpeg" ||$_FILES["pic"]["type"]=="image/png" ||$_FILES["pic"]["type"]=="image/JPG"){
                              move_uploaded_file($_FILES['pic']['tmp_name'],"img/users/".$_FILES['pic']['name']);
                              $in = mysqli_query($con, "UPDATE members SET title = '".$title."', fname = '".$fname."', sname = '".$sname."', oname = '".$oname."',dob = '".$dob."', marital_status = '".$mart."', village = '".$village."', lagos_address = '".$lga."', email = '".$email."', phone = '".$phone."', wa_number = '".$wn."', challenge = '".$hp."', username = '".$username."', password = '".$pass."', yoe = '".$yoe."', group_no = '".$gn."', pro_pic = '".$_FILES['pic']['name']."', exempted = '".$nexempted."' WHERE id = '".$member."'");
                            $innext = mysqli_query($con, "UPDATE next_of_kin SET name = '".$fn."', address = '".$noka."', phone = '".$nokp."', relationship = '".$nokr."' WHERE member_id = '".$member."'");
                            $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Edited member details', '".$date."')");
                            if ($_POST['olddebt'] > 0) {
                              $checkold = mysqli_query($con, "SELECT * FROM levy WHERE member_id = '".$member."' AND name = 'Old Debts'");
                                if(is_numeric($_POST['olddebt'])){
                                  $olddebt = $_POST['olddebt'];
                                    if (mysqli_num_rows($checkold)) {
                                        $change = mysqli_query($con, "UPDATE levy SET amount = '".$olddebt."' WHERE member_id = '".$member."' AND name = 'Old Debts'");
                                        header("Location:user.php?id=$member");
                                    } else {
                                        $in = mysqli_query($con, "INSERT INTO levy VALUES('', 'Old Debts', '1', '".$olddebt."', '".$member."', FALSE, NULL, NULL)");
                                        header("Location:user.php?id=$member");
                                    }
                                }else{
                                    $msg = "<div class='notification is-danger'>
                                                <button class='delete'></button>
                                                Old debt must be numeric.
                                            </div>";
                                }
                            }else{
                                header("Location:user.php?id=$member");
                            }
                            }else{
                              $msg="<div class='alert alert-danger'>Select a valid Filetype to upload</div>";
                            }
                          }elseif($_FILES['pic']['size'] <= 0){
                            $in = mysqli_query($con, "UPDATE members SET title = '".$title."', pro_pic = '".$pics2."', fname = '".$fname."', sname = '".$sname."', oname = '".$oname."',dob = '".$dob."', marital_status = '".$mart."', village = '".$village."', lagos_address = '".$lga."', email = '".$email."', phone = '".$phone."', wa_number = '".$wn."', challenge = '".$hp."', username = '".$username."', password = '".$pass."', yoe = '".$yoe."', group_no = '".$gn."', exempted = '".$nexempted."'  WHERE id = '".$member."'");
                            $innext = mysqli_query($con, "UPDATE next_of_kin SET name = '".$fn."', address = '".$noka."', phone = '".$nokp."', relationship = '".$nokr."' WHERE member_id = '".$member."'");
                            $inlog = mysqli_query($con, "INSERT INTO bank_log VALUES('', 'Edited member details', '".$date."')");
                            if ($_POST['olddebt'] > 0) {
                              $checkold = mysqli_query($con, "SELECT * FROM levy WHERE member_id = '".$member."' AND name = 'Old Debts'");
                                if(is_numeric($_POST['olddebt'])){
                                  $olddebt = $_POST['olddebt'];
                                    if (mysqli_num_rows($checkold)) {
                                        $change = mysqli_query($con, "UPDATE levy SET amount = '".$olddebt."' WHERE member_id = '".$member."' AND name = 'Old Debts'");
                                        header("Location:user.php?id=$member");
                                    } else {
                                        $in = mysqli_query($con, "INSERT INTO levy VALUES('', 'Old Debts', '1', '".$olddebt."', '".$member."', FALSE, NULL, NULL)");
                                        header("Location:user.php?id=$member");
                                    }
                                }else{
                                    $msg = "<div class='alert alert-danger'>
                                                <button class='delete'></button>
                                                Old debt must be numeric.
                                            </div>";
                                }
                            }else{
                                header("Location:user.php?id=$member");
                            }
                          }
                        
                    }else{
                       $msg = "<div class='alert alert-danger'>
                                <button class='delete'></button>
                                Year of entry should be numeric
                            </div>"; 
                    }
                }else{
                    $msg = "<div class='alert alert-danger'>
                                <button class='delete'></button>
                                Member Whatsapp number should be numeric
                            </div>";
                }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ichida Progress Union | Edit Member</title>
  <meta name="description" content="">
  <meta name="author" content="">
<?php
        require 'includes/header.php';
    ?>


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
          <h1 class="h3 mb-4 text-gray-800">Edit | <?php echo $title." ".$fname." ".$oname." ".$sname;?></h1>
         <form action="edituser.php?id=<?php echo $member?>" method="post" enctype="multipart/form-data" data-parsely-validate>
      <div class="row">

            <div class="col-lg-6">

              <!-- Default Card Example -->
              <div class="card mb-4 border-bottom-primary" >
                  <div class="card shadow mb-4">
                <div class="card-header">
                  Personal Details
                </div>
                <div class="card-body">
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
    <div id="imgArea"><img id="blah" src="img/users/<?php echo $pics2?>" alt="your image" />
    <div id="imgChange"><span>Profile Passport</span>
        <input type="file"  name="pic" onchange="readURL(this);" value="img/users/<?php echo $pics2?>" >
      </div>
    </div>
                        </div></div>
                    <div class="form-group">
                     <label for="title">Title</label>
                    <input type="text" class="form-control form-control-user" id="title" name="title" placeholder="Title"  value="<?php echo $title?>"></div>
                    <div class="form-group">
                        <label for="fname">First Name</label>
                    <input type="text" class="form-control form-control-user" id="fname" name="fname" placeholder="First Name"  value="<?php echo $fname?>">
                  </div>
                  <div class="form-group">
                    <label for="sname">Last Name</label>
                    <input type="text" class="form-control form-control-user" id="sname" name="sname" placeholder="Surame"  value="<?php echo $sname?>">
                  </div>
                  <div class="form-group">
                    <label for="oname">Other Names</label>
                    <input type="text" class="form-control form-control-user" id="oname" name="oname" placeholder="Other Name" 
                    value="<?php echo $oname?>">
                  </div>
                  <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" class="form-control form-control-user" placeholder="Date of Birth" value="<?php echo $dob?>">
                  </div>
                  <div class="form-group">
                  <label class="label">Marital Status:</label>
                                <div class="form-check">
                                    <label class="radio">
                                        <input class="form-check-input" type="radio" name="mart" value="Single" <?php if($ms=="Single"){?> checked="true" <?php } ?>>
                                        Single
                                    </label></div>
                                    <div class="form-check">
                                    <label class="radio">
                                        <input class="form-check-input" type="radio" name="mart" value="Married" <?php if($ms=="Married"){?> checked="true" <?php } ?>>
                                        Married
                                    </label></div>
                                    <div class="form-check">
                                    <label class="radio">
                                        <input class="form-check-input" type="radio" name="mart" value="Divorced" <?php if($ms=="Divorced"){?> checked="true" <?php } ?>>
                                        Divorced
                                    </label></div>
                                    <div class="form-check">
                                    <label class="radio">
                                        <input class="form-check-input" type="radio" name="mart" value="Widowed" <?php if($ms=="Widowed"){?> checked="true" <?php } ?>>
                                        Widowed
                                    </label></div></div>
                                    
                                    <div class="form-group">
                                        <label for="village">Village</label>
                    <input type="text" name="village" id="village" class="form-control form-control-user" placeholder="Village"  value="<?php echo $village?>">
                  </div>
                                   
                                    <div class="form-group">
                                        <label for="lga">Lagos Address</label>
                    <input type="text" name="lga" id="lga" class="form-control form-control-user" placeholder="Lagos Address"  value="<?php echo $la?>">
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
                                    <input type="email" class="form-control form-control-user" placeholder="Email" name="email" id="email" value="<?php echo $email?>">
                  </div>
                  <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone"  class="form-control form-control-user" placeholder="Phone Number" maxlength="11" value="<?php echo $phone?>">
                  </div>
                  
                  <div class="form-group">
                    <label for="wn">Whatsap Number</label>
                     <input type="text" class="form-control form-control-user" placeholder="Whatsapp Number" name="wn" id="wn" maxlenth="11" value="<?php echo $wn?>">
                  </div>
                  <div class="form-group">
                    <label for="hp">Health Challenge </label>
                    <input type="text" class="form-control form-control-user" name="hp" id="h" placeholder="health Challenges" value="<?php echo $challenge?>">
                  </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                    <input type="text" class="form-control form-control-user" placeholder="Username" name="username" id="username"  value="<?php echo $username?>">
                    <small style = "color:red">*The username cannot be admin</small></div>
                    <div class="form-row">
                    <label> Password: </label>
                    <input type="password" name="pass" id="pass" class="form-control form-control-user" placeholder="password"  value="<?php echo $pass?>">
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
                    <label for="yoe">Year of Entry</label>
                    <input type="text" class="form-control form-control-user" placeholder="Year of Entry" name="yoe" id="yoe" maxlength="4" value="<?php echo $yoe?>">
                    </div>
                    <div class="form-group"><label for="group">Group:</label>
                                    <?php
                                        if (mysqli_num_rows($getgroup)) {
                                            echo "<div class='form-group'>";
                                                echo "<select class='form-control' name='group'>";
                                                    while ($gotgroup = mysqli_fetch_assoc($getgroup)) {
                                                      if ($gotgroup['id'] == $gns) {
                                                        $gg = $gotgroup['id'];
                                                        echo "<option selected value = '".$gotgroup['id']."'>".$gotgroup['name']."</option>";
                                                      }else{
                                                        echo "<option value = '".$gotgroup['id']."'>".$gotgroup['name']."</option>";
                                                      }
                                                    }
                                                echo "</select>";
                                            echo "</div>";
                                        } else {
                                            echo "Please Create a group before registering a new member";
                                        }
                                        
                                    ?></div>
                                    <div class="form-group">
                                      <label for="olddebt">Old Debts:</label>
                                       <input type="text" class="form-control form-control-user" placeholder="Old Debts" name="olddebt" id="olddebt" value="<?php echo $olddebt?>">
                                    <small style="color:red">*Leave blank if there are no old debts</small></div>
                                    <div class="form-group">
                                        <label for="exempted">Exempted?: </label>
                                        <select name="exempted" id="exempted" class = "form-control">
                                          <?php 
                                            if ($exempted == true) {
                                              echo "
                                                      <option value = '1' selected>Exempted</option>
                                                      <option value = '0'>Not Exempted</option>
                                                   ";
                                            } else {
                                              echo "
                                                      <option value = '1'>Exempted</option>
                                                      <option value = '0' selected>Not Exempted</option>
                                                   ";
                                            }
                                            
                                          ?>
                                        </select>
                                    </div>
                                     <hr>
                                      <p>Next of Kin Details</p>
                                      <div class="form-group">
                                      <input type="text" class="form-control form-control-user" placeholder="Next of Kin Name" name="fn" id="fn" value="<?php echo $nokn?>"></div>
                                      <div class="form-group">
                                      <input type="text" class="form-control form-control-user" placeholder="Next of Kin Address" name="noka" id="noka"  value="<?php echo $noka?>"></div>
                                      <div class="form-group">
                    <input type="text" class="form-control form-control-user" placeholder="Next of Kin Phone No" name="nokp" id="nokp"  maxlength="11" value="<?php echo $nokp?>">
                  </div>
                 <div class="form-group">
                    <input type="text" class="form-control form-control-user" placeholder="Relationship" name="nokr" id="nokr"  value="<?php echo $nokr?>">
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
                            <input type="submit" value="edit" name="submit" class="btn btn-primary">
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
