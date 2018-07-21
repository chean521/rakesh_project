<?php 
require("../Base/Header3_Master/Session_Master.php"); 
$PageTitle = "Customer Details - Veeco Tech Invoice System";
$ActivePage = 3.1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../Lib/jquery/jquery_v3.js"></script>
    <script src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">
  <?php require("../Base/Header3_Master/Header_Master.php"); ?>
      <script type="text/javascript">
    $(document).ready(function(e){
    
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function(){

            if(this.readyState === 4 && this.status === 200){
                var Res = JSON.parse(this.responseText);

                $('#Customer_Details').DataTable({
                    "pagingType": "full_numbers",
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "scrollY"  : "500px",
                    "data" : Res,
                    "columnDefs": [
                        { 
                            "targets": -2, 
                            "data": null, 
                            "defaultContent": '<button type="button" class="btn btn-outline-success" onclick="GetCustomerName_Stat(this);" data-toggle="modal" data-target="#Set_Status_Customer" data-whatever="@getbootstrap">Set Status</button>'
                        },
                        { 
                            "targets": -1, 
                            "data": null, 
                            "defaultContent": '<button type="button" class="btn btn-outline-warning" onclick="GetTaxInf();GetEditDetails_Customer(<?php echo $Sess_UserID; ?>,this);" data-toggle="modal" data-target="#Edit_Customer_Modal" data-whatever="@getbootstrap">EDIT</button>'
                        },
                        {
                            "targets": 4,
                            "className": "dt-body-center"
                        }
                    ]
                 });
                 
                 var i = 1;
                 
                 for(var i=1; i<=Res.length; i++){
                     var tb_cell = $('#Customer_Details').find('tr:eq('+i+')').find('td:eq(4)').html();
                     
                     switch(tb_cell){
                        case "Active":
                             $('#Customer_Details').find('tr:eq('+i+')').find('td:eq(4)').addClass("text-success");
                             break;
                             
                        case "Hold":
                            $('#Customer_Details').find('tr:eq('+i+')').find('td:eq(4)').addClass("text-warning");
                            break;

                        case "Suspended":
                        case "Terminated":
                            $('#Customer_Details').find('tr:eq('+i+')').find('td:eq(4)').addClass("text-danger");
                             break;
                     }
                     
                 }
            }
        };

        xmlhttp.open("POST", "/WBServices/GetCompCustList_Resp.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("data="+JSON.stringify({"Pid" : <?php echo $Sess_UserID; ?>}));

    });
  </script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php require("../Base/Header3_Master/Menubar_Master.php"); ?>

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
              <li class="breadcrumb-item">Maintenance</li>
              <li class="breadcrumb-item active">Customer List</li>
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
            <h2>Customer Details</h2>

            <!-- ADD CUSTOMER POPUP INPUT BOX-->
            <div align="right" style="padding-bottom: 20px;">
                <button type="button" onclick="GetCustomerId();" class="btn btn-outline-primary" style="text-align: right;" data-toggle="modal" data-target="#Add_Customer_Modal" data-whatever="@getbootstrap">Add Customer</button>
            </div>
           <!-- Button trigger modal -->

               <table id="Customer_Details" class="display" >
                  <thead>
                      <tr>
                          <th>Customer ID</th> 
                          <th>Company Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Status</th>
                          <th></th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>

                  </tbody>
              </table>
            </div>
           <div class="col-md-1"></div>
    <!-- /.content -->
       </div>
  </div>
  <!-- /.content-wrapper -->

  <?php require("../Base/Header3_Master/Footer_Master.php"); ?>
</div>
    <?php require ("MainPage_Modal/CustomerDetails_Modal.php") ?>

    <?php require("../Base/Header3_Master/Scripts_Master.php"); ?>
</body>
</html>
