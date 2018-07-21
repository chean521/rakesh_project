<?php 
require ("../../Base/Header4_Master/Session2_Master.php");
$PageTitle = "Receipt - Veeco Tech Invoice System";
$ActivePage = 2.3
?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require ("../../Base/Header4_Master/Header_Master.php"); ?> 
      
    <script src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">
    <script type="text/javascript">
        $(document).ready(function(e){
            
            var Comp_Id = '<?php echo $Sess_UserID; ?>';
            
            var xmlhttp = new XMLHttpRequest();
    
            xmlhttp.onreadystatechange = function(){
                if(this.readyState === 4 && this.status === 200){
                    var data = JSON.parse(this.responseText);
                    
                    var table = $('#receipt_item').DataTable({
                        "pagingType": "full_numbers",
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        "scrollY"  : "550px",
                        "data" : data,
                        "columnDefs": [
                            { 
                                "targets": -1, 
                                "data": null, 
                                "defaultContent": '<button type="button" id="btn_delInv" class="btn btn-outline-primary" onclick="PrintPDF(this);">Print Receipt</button>',
                                "className": "dt-body-center"
                            }
                        ]
                   });
                   
                }
            };

            xmlhttp.open("POST", "/WBServices/GetReceiptList_Resp.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("datas="+JSON.stringify({"Comp_Id":Comp_Id}));

        });
        
        function PrintPDF(rows){
            var comp_id = <?php echo $Sess_UserID; ?>;
            var row_ind = rows.parentNode.parentNode.rowIndex;
            
            var tax_inv = document.getElementById("receipt_item").rows[row_ind].cells[0].innerHTML;
            
            var inv_join = comp_id.toString() + "_" + tax_inv;
            
            window.open("../../Page_Customer/PDF_Engine/PDF_Render.php?Comp_ID="+comp_id+"&Rec_No="+inv_join+"&type=receipt", "_blank");
        }

    </script>
  </head>

  <body class="hold-transition sidebar-mini">
  <div class="wrapper">
  <!-- Navbar -->
  <?php require ("../../Base/Header4_Master/Menubar_Master.php"); ?> 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Invoicing</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Invoicing</li>
              <li class="breadcrumb-item active">Receipt</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
   <div class="container-fluid" >
       <div class="row">
           <div class="col-md-1"></div>
           <div class="col-md-10">
            <style>
                 .box
                 {
                 width: 100%;
                 max-width: 1390px;
                 border-radius: 5px;
                 border:1px solid #ccc;
                 padding: 15px;
                 margin: 0 auto;                
                 margin-top:50px;
                 box-sizing:border-box;
                 }
               </style>
               <link rel="stylesheet" href="../../Styles/datepicker.css">
               <script src="../../Lib/bootstrap-3.3.7-dist/js/bootstrap-datepicker1.js"></script>

                 <h3 align="center">Receipt List</h3>

                 <br />

                 <table id="receipt_item" class="display hover">
                     <thead>
                         <tr>
                             <th>Receipt No.</th>
                             <th>Receipt Date</th>
                             <th>Payment Invoice</th>
                             <th>Customer Name</th>
                             <th>Grand Total (MYR)</th>
                             <th>Payment Date</th>
                             <th>Payment Type</th>
                             <th>Print PDF</th>
                         </tr>
                     </thead>
                     <tbody>

                     </tbody>
                 </table>
            
           </div>
           <div class="col-md-1"></div>
       </div>
            
   </div>
  </div>
   <br>

   <?php require ("../../Base/Header4_Master/Footer_Master.php"); ?> 

</div>
   <?php require ("../../Base/Header4_Master/Scripts_Master.php"); ?> 
  </body>
</html>
