<?php 
require ("../../Base/Header4_Master/Session2_Master.php");
$PageTitle = "Invoices - Veeco Tech Invoice System";
$ActivePage = 2.2;
?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require ("../../Base/Header4_Master/Header_Master.php"); ?> 
      
    <script src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">
    <script src="../../Js/InvoiceNo_Generator.js"></script>
    <script src="../../Lib/Date/moment.js"></script>
    <script type="text/javascript">
        $(document).ready(function(e){
            
            var Comp_Id = '<?php echo $Sess_UserID; ?>';
            
            var xmlhttp = new XMLHttpRequest();
    
            xmlhttp.onreadystatechange = function(){
                if(this.readyState === 4 && this.status === 200){
                    var data = JSON.parse(this.responseText);
                    
                    var table = $('#invoice_item').DataTable({
                        "pagingType": "full_numbers",
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        "scrollY"  : "470px",
                        "data" : data,
                        "columnDefs": [
                            { 
                                "targets": -3, 
                                "data": null, 
                                "defaultContent": '<button type="button" id="btn_pay_inv" class="btn-payment btn btn-outline-success" onclick="PayModal_Click(this);" data-toggle="modal" data-target="#make_pymt_modal" data-whatever="@getbootstrap">Make Payment</button>'
                            },
                            { 
                                "targets": -2, 
                                "data": null, 
                                "defaultContent": '<button type="button" id="btn_toPDF" class="btn btn-outline-primary" onclick="PrintPDF(this);">Print PDF</button>'
                            },
                            { 
                                "targets": -1, 
                                "data": null, 
                                "defaultContent": '<button type="button" id="btn_delInv" class="btn btn-outline-danger" onclick="delete_data(this);">Delete</button>'
                            }
                        ]
                   });
                   
                    var btn_inv = document.getElementsByClassName("btn-payment btn");
                   
                    for(var i=0; i<btn_inv.length; i++){
                        if(data[i][5] !== null){
                            btn_inv[btn_inv.length-i-1].classList.remove("btn-outline-success");
                            btn_inv[btn_inv.length-i-1].classList.add("btn-outline-disabled");
                            btn_inv[btn_inv.length-i-1].setAttribute("disabled", "disabled");
                        }
                    }
                    
                    for(var i=1; i<=data.length; i++){
                        var item = $('#invoice_item').find('tr:eq('+i+')').find('td:eq(1)').html();
                        
                        var dateInv = moment(item, "YYYY-M-D");
                        var dateNow = new Date();
                        
                        var dateInW = dateNow.getFullYear() + "-" + (dateNow.getMonth()+1) + "-" + dateNow.getDate();
                        
                        var dateM = moment(dateInW, "YYYY-M-D");
                        
                        var diff = dateM.diff(dateInv, "days");
                                                
                        if(diff > 30 && data[data.length-i][5] !== "PAID"){
                            $('#invoice_item').find('tr:eq('+i+')').find('td:eq(1)').css("color","red");
                            $('#invoice_item').find('tr:eq('+i+')').find('td:eq(1)').css("font-weight","bold");
                        }
                    }   
                }
            };

            xmlhttp.open("POST", "/WBServices/GetCompInvoice_Resp.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("datas="+JSON.stringify({"Comp_Id":Comp_Id}));
            
            
        });

        function delete_data(rows){
            var this_index = rows.parentNode.parentNode.rowIndex;
            var inv_no = document.getElementById("invoice_item").rows[this_index].cells[0].innerHTML;
            
            if(confirm("Are you sure want to delete invoice? (No: "+inv_no+")") === true){
                
                var xmlhttp = new XMLHttpRequest();
    
                xmlhttp.onreadystatechange = function(){
                    if(this.readyState === 4 && this.status === 200){
                        var data = JSON.parse(this.responseText);
                        
                        if(data.Result === "true"){
                            alert("Invoice deleted.");
                        }
                        else{
                            alert("Invoice not deleted.");
                        }
                        
                        window.location.reload();
                    }
                };
                
                xmlhttp.open("POST", "/WBServices/DeleteInv_Resp.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("del_data="+JSON.stringify({"Inv_No":inv_no, "Comp_No":"<?php echo $Sess_UserID; ?>"}));
            }
        }
        
        function PrintPDF(rows){
            var comp_id = <?php echo $Sess_UserID; ?>;
            var row_ind = rows.parentNode.parentNode.rowIndex;
            
            var tax_inv = document.getElementById("invoice_item").rows[row_ind].cells[0].innerHTML;
            
            var inv_join = comp_id.toString() + "_" + tax_inv;
            
            window.open("../../Page_Customer/PDF_Engine/PDF_Render.php?Comp_ID="+comp_id+"&Inv_No="+inv_join+"&type=invoice", "_blank");
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
              <li class="breadcrumb-item active">Invoice</li>
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

                 <h3 align="center">Invoice List</h3>

                 <br />
                 <div align="right">
                     <button id="btn_add_inv" class="btn btn-outline-info btn-xs" onclick="GenerateInvoice(<?php echo $Sess_UserID; ?>);" data-toggle="modal" data-target="#Create_Invoice_Modal" data-whatever="@getbootstrap">Create</button>
                 </div>
                 <br />

                 <table id="invoice_item" class="display" >
                     <thead>
                         <tr>
                             <th>Invoice No.</th>
                             <th>Invoice Date</th>
                             <th>Customer Name</th>
                             <th>Currency</th>
                             <th>Invoice Total (MYR)</th>
                             <th>Make Payment</th>
                             <th>Print PDF</th>
                             <th>Delete</th>
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
  <?php require_once ('InvoicesModal.php'); ?>
  <?php require_once ('MakePayment_Modal.php'); ?>
<script>
$(document).ready(function(){
$('.number_only').keypress(function(e){
return isNumbers(e, this);      
});
function isNumbers(evt, element) 
{
var charCode = (evt.which) ? evt.which : event.keyCode;
if (
(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
(charCode < 48 || charCode > 57))
return false;
return true;
}
});
</script>

   <?php require ("../../Base/Header4_Master/Footer_Master.php"); ?> 

</div>
   <?php require ("../../Base/Header4_Master/Scripts_Master.php"); ?> 
  </body>
</html>
