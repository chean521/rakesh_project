<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
          <a href="../" class="nav-link">Home</a>
      </li>
     
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
      <li class="nav-item">
          <div style="margin-top: 7px;color:yellowgreen;"><i class="fa fa-clock-o mr-2"></i> <strong id="clock"></strong></div>
      </li>
      
      <li class="nav-item">
          <div style="margin-top: 7px;margin-left: 20px;color: skyblue;"><i class="fa fa-calendar-check-o mr-2"></i> <strong><?php echo $Sess_Last; ?></strong></div>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fa fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index1.php" class="brand-link">
        
    </a>
        
     

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../Images/download.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $Admin_Name; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link <?php echo ($PageNo == 1.0)?"active":""; ?>">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                Dashboard
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="../Page_Admin/" class="nav-link <?php echo ($PageNo == 1.0)?"active":""; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Admin Dashboard </p>
                </a>
              </li>
            </ul>
             <!-- End Dashboard for Admin -->
    
         
              <!-- Company managment Nav -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php echo ($PageNo == 2.0)?"active":""; ?>">
              <i class="nav-icon fa fa-table"></i>
              <p>
                Client Management
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="../Page_Admin/Company_Details.php" class="nav-link <?php echo ($PageNo == 2.0)?"active":""; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Client Details</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php echo ($PageNo == 3.0)?"active":""; ?>">
              <i class="nav-icon fa fa-gear"></i>
              <p>
                Settings
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="ChangePassword.php" class="nav-link <?php echo ($PageNo == 3.0)?"active":""; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
            </ul>
          </li>

            <!--Logut Nav-->
          <li class="nav-item">
            <a href="../UserManage/LogOut.php" class="nav-link">
              <i class="nav-icon fa fa-circle-o text-info"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>