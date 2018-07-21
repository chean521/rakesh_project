
<script type="text/javascript">
    $(document).ready(function(e){
       var check_Over_XMLHttp = new XMLHttpRequest();
        check_Over_XMLHttp.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                var data = JSON.parse(this.responseText);

                return data;
            }
        };

        check_Over_XMLHttp.open("POST", "/WBServices/Overdue_Count.php", false);
        check_Over_XMLHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        check_Over_XMLHttp.send("Inputs="+JSON.stringify({"Comp_Id":"<?php echo $Sess_UserID; ?>"}));
        var Overdue = check_Over_XMLHttp.onreadystatechange().OverdueCount; 
        
        $('#count_overdue').html(Overdue);
         $('#count_overdue2').html(Overdue);
        
        if(Overdue > 0){
            $('#badge_show_1').css("color","red");
            $('#badge_show_2').css("color","red");
        }
    });
    
</script>

<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
          <a href="../../" class="nav-link">Home</a>
      </li>
     
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item">
          <div style="margin-top: 7px; color:yellowgreen;"><i class="fa fa-clock-o mr-2"></i> <strong id="clock"></strong></div>
      </li>
      
      <li class="nav-item">
          <div style="margin-top: 7px;margin-left: 20px;color:skyblue;"><i class="fa fa-calendar-check-o mr-2"></i> <strong><?php echo $Sess_Last; ?></strong></div>
      </li>
      
      
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa fa-warning" id="badge_show_1"></i>
          <span class="badge badge-danger navbar-badge"><strong id="count_overdue"></strong></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header" id="badge_show_2" style="font-weight:bold;">Invoice Overdue Warning</span>
          <div class="dropdown-divider"></div>
          <a href="../../Page_Customer/Invoice/invoice.php" class="dropdown-item">
              <i class="fa fa-bank mr-2"></i> <strong id="count_overdue2"></strong> invoice(s) unpaid.
            <span class="float-right text-muted text-sm">Go To Invoice</span>
          </a>
          
        </div>
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
    <a href="../../Page_Customer/" class="brand-link"> 
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $PhotoURL; ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $UserName; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link <?php echo ($ActivePage==1)?"active":""; ?>">
              <i class="nav-icon fa fa-dashboard"></i>
              <p>
                Dashboard
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                  <a href="../../Page_Customer/" class="nav-link <?php echo ($ActivePage==1)?"active":""; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Main Dashboard</p>
                </a>
              </li>
              
            </ul>
          </li>
          
          
          <li class="nav-item has-treeview">
              <a href="#" ondblclick="window.open('../../Page_Customer/Maintenance.php','_self');" class="nav-link <?php echo ($ActivePage>=2.0 && $ActivePage< 3)?"active":""; ?>">
              <i class="nav-icon fa fa-edit"></i>
              <p>
                Invoicing
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="../../Page_Customer/Quotation/quotation.php" class="nav-link <?php echo ($ActivePage==2.1)?"active":""; ?>">
                        <i class="nav-icon fa fa-circle-o text-info"></i>
                        <p>Quotation</p>
                      </a>
                    </li>


                    <li class="nav-item">
                        <a href="../../Page_Customer/Invoice/invoice.php" class="nav-link <?php echo ($ActivePage==2.2)?"active":""; ?>">
                        <i class="nav-icon fa fa-circle-o text-info"></i>
                        <p>Invoice</p>
                      </a>
                    </li>

                    <li class="nav-item">
                        <a href="../../Page_Customer/Receipt/receipt.php" class="nav-link <?php echo ($ActivePage==2.3)?"active":""; ?>">
                        <i class="nav-icon fa fa-circle-o text-info"></i>
                        <p>Receipt</p>
                      </a>
                    </li>
                </ul>
          </li>
          
          <li class="nav-item has-treeview">
              <a href="#" ondblclick="window.open('../../Page_Customer/Maintenance.php','_self');" class="nav-link <?php echo ($ActivePage>=3 && $ActivePage< 4)?"active":""; ?>">
              <i class="nav-icon fa fa-edit"></i>
              <p>
                Maintenance
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="../../Page_Customer/CustomerDetails.php" class="nav-link <?php echo ($ActivePage==3.1)?"active":""; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Customer</p>
                </a>
              </li>
              <li class="nav-item">
                  <a href="../../Page_Customer/ProductMaintenance.php" class="nav-link <?php echo ($ActivePage==3.2)?"active":""; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Product</p>
                </a>
              </li>
              
            </ul>
          </li>
          
         <li class="nav-item has-treeview">
             <a href="#" class="nav-link <?php echo ($ActivePage>= 4.0)?"active":""; ?>" ondblclick="window.open('../../Page_Customer/User_Settings.php','_self');">
              <i class="nav-icon fa fa-gear text-info"></i>
              <p>
                Setting
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="../../Page_Customer/Maintenance/Picture_Update.php" class="nav-link <?php echo ($ActivePage==4.1)?"active":""; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Change Picture</p>
                </a>
              </li>
              <li class="nav-item">
                  <a href="../../Page_Customer/Maintenance/Profile_Update.php" class="nav-link <?php echo ($ActivePage==4.2)?"active":""; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Change Profile</p>
                </a>
              </li>
              <li class="nav-item">
                  <a href="../../Page_Customer/Maintenance/Password_Update.php" class="nav-link <?php echo ($ActivePage==4.3)?"active":""; ?>">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
            </ul>
         </li>
         
           
             
         
            <!--Logut Nav-->
          <li class="nav-item">
              <a href="../../UserManage/LogOut.php" class="nav-link">
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