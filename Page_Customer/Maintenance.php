<?php 
require ("../Base/Header3_Master/Session_Master.php");

$PageTitle = "Company Maintenance - Veeco Tech Invoice System";
$ActivePage = 3.0;
?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <script src="../Lib/jquery/jquery_v3.js"></script>
    <?php require ("../Base/Header3_Master/Header_Master.php"); ?> 
    <style type="text/css">
        .pan_cont{
            background-color: rgba(76, 246, 255, 0.5);
            padding: 30px 20px 30px 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        
        .pan_cont .pan_text{
            font-family: sans-serif;
        }
        
        .pan_space{
            margin-top: 30px;
        }
    </style>
  </head>

  <body class="hold-transition sidebar-mini">
  <div class="wrapper">
  <!-- Navbar -->
  <?php require ("../Base/Header3_Master/Menubar_Master.php"); ?> 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Maintenance</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Maintenance</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
   <div class="container-fluid" >
       <div class="row">
           <div class="col-md-2"></div>
           <div class="col-md-8 pan_cont" align="center" >
               <h5 class="pan_text">Here are go to customer information and settings.</h5><br />
               <button type="button" onclick="window.open('CustomerDetails.php','_self');" class="btn btn-outline-primary"><i class="fa fa-gear text-info"></i>&nbsp;&nbsp;Customer Settings</button>
           </div>
           <div class="col-md-2"></div>
       </div>
       <div class="row pan_space">
           <div class="col-md-2"></div>
           <div class="col-md-8 pan_cont" align="center" >
               <h5 class="pan_text">Here are go to company product information and settings.</h5><br />
               <button type="button" onclick="window.open('ProductMaintenance.php','_self');" class="btn btn-outline-primary"><i class="fa fa-gear text-info"></i>&nbsp;&nbsp;Product Settings</button>
           </div>
           <div class="col-md-2"></div>
       </div>
   </div>
  </div>

   <?php require ("../Base/Header3_Master/Footer_Master.php"); ?> 

</div>
   <?php require ("../Base/Header3_Master/Scripts_Master.php"); ?> 
  </body>
</html>
