<?php 
require ("../Base/Header2_Master/Session_Master.php"); 
   
$PageTitle = "Company Details - Veeco Tech Invoice System";

$PageNo = 2.0;

?>

<!DOCTYPE html>
<html>
<head>
    <?php require ('../Base/Header2_Master/Header_Master.php'); ?>
    <script src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php require ('../Base/Header2_Master/Menubar_Master.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Company Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    
    
    <!-- Main content -->
    
   <div class="container-fluid">
       <div class="row">
           <div class="col-md-1"></div>
           <div class="col-md-10">
                <h2>Company Details</h2>
           </div>
           <div class="col-md-1"></div>
       </div>
       <div class="row">
           <div class="col-md-1"></div>
           <div class="col-md-10">
                <table class="display" id="comp_details_container">
                    <thead>
                      <tr>
                        <th>ID</th> 
                        <th>Company Name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
           </div>
           <div class="col-md-1"></div>
       </div>
           
  
  <script src="../Js/GetCompDetails_Reqs.js"></script>
  <script>
      $(document).ready(function(e){
            var data = GetCompanyDetails();
          
            var table = $('#comp_details_container').DataTable({
                    "pagingType": "full_numbers",
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "scrollY"  : "550px",
                    "data" : data
               });
           });
  </script>
  
  
   </div> 

 </div>
  
    <?php require('../Base/Header2_Master/Footer_Master.php'); ?>
</body>
</html>
