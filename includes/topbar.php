<?php
  if (isset($_SESSION['admin'])) {
    $name = "Admin";
    $pics = "default.png";
  }elseif (isset($_SESSION['member'])) {
    $member = $_SESSION['member'];
    $get = mysqli_query($con, "SELECT * FROM members WHERE id = '".$member."'");
    if(mysqli_num_rows($get)){
      while ($mems = mysqli_fetch_assoc($get)) {
        $title = $mems['title'];
        $fname = $mems['fname'];
        $sname = $mems['sname'];
        $pics = $mems['pro_pic'];
      }
      $name = $title." ".$fname." ".$sname;
    }
  }
  
?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

           <div class="float-left">
                <button class="btn btn-secondary" onclick="goBack()"><i class="fa fa-long-arrow-alt-left"> Back</i></button>
                <script>
                    function goBack() {
                      window.history.back();
                    }
                </script>
            </div>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->

            <!-- Nav Item - Alerts -->
           

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $name?></span>
                <img class="img-profile rounded-circle" src="img/users/<?php echo $pics?>">
              </a>
              <!-- Dropdown - User Information -->
               <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
              
            </li>

          </ul>

        </nav>