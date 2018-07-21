<?php 
require ("../../Base/Header4_Master/Session2_Master.php");
$PageTitle = "Quotation - Veeco Tech Invoice System";
$ActivePage = 2.1;
?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require ("../../Base/Header4_Master/Header_Master.php"); ?> 
      
    <script src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css">
    <script src="../../Js/QuotationNo_Generator.js"></script>
    <script src="../../Js/QuotationToInvoice_Reqs.js"></script>
    <script type="text/javascript">
        $(document).ready(function(e){
            
            var Comp_Id = '<?php echo $Sess_UserID; ?>';
            
            var xmlhttp = new XMLHttpRequest();
    
            xmlhttp.onreadystatechange = function(){
                if(this.readyState === 4 && this.status === 200){
                    var data = JSON.parse(this.responseText);
                    
                    var table = $('#quotation_item').DataTable({
                        "pagingType": "full_numbers",
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        "scrollY"  : "470px",
                        "data" : data,
                        "columnDefs": [
                            { 
                                "targets": -3, 
                                "data": null, 
                                "defaultContent": '<button type="button" id="btn_generateInv" class="btn_chg_inv btn btn-outline-success" onclick="SubmitQuotationToInvoice(<?php echo $Sess_UserID; ?>, this);">To Invoice</button>',
                                "className": "dt-body-center"
                            },
                            { 
                                "targets": -2, 
                                "data": null, 
                                "defaultContent": '<button type="button" id="btn_toPDF" class="btn btn-outline-primary" onclick="PrintPDF(this);">Print PDF</button>',
                                "className": "dt-body-center"
                            },
                            { 
                                "targets": -1, 
                                "data": null, 
                                "defaultContent": '<button type="button" id="btn_delInv" class="btn btn-outline-danger" onclick="delete_data(this);">Delete</button>',
                                "className": "dt-body-center"
                            },
                            { 
                                "targets": 0, 
                                "data": null, 
                                "defaultContent": '<input type="radio" name="radio_qt_select" id="radio_qt_select" onchange="Check_Radio();" >',
                                "className": "dt-body-center"
                            },
                            { 
                                "targets": [4,5], 
                                "className": "dt-body-center"
                            },
                            { 
                                "targets": [-3,-2,-1,0,1,2,3,4,5], 
                                "className": "dt-head-center"
                            }
                        ]
                   });
                   
                   var btn_inv = document.getElementsByClassName("btn_chg_inv btn");
                   var radio_inv = document.getElementsByName("radio_qt_select");
                   
                   for(var i=0; i<btn_inv.length; i++){
                       if(data[i][6] !== null){
                           btn_inv[i].classList.remove("btn-outline-success");
                           btn_inv[i].classList.add("btn-outline-disabled");
                           btn_inv[i].setAttribute("disabled", "disabled");
                           radio_inv[i].setAttribute("disabled","disabled");
                       }
                   }
                }
            };

            xmlhttp.open("POST", "/WBServices/GetCompQuotation_Resp.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("datas="+JSON.stringify({"Comp_Id":Comp_Id}));

        });

        function delete_data(rows){
            var this_index = rows.parentNode.parentNode.rowIndex;
            var inv_no = document.getElementById("quotation_item").rows[this_index].cells[1].innerHTML;
            
            if(confirm("Are you sure want to delete quotation? (No: "+inv_no+")") === true){
                
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
                
                xmlhttp.open("POST", "/WBServices/DeleteQt_Resp.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("del_data="+JSON.stringify({"Inv_No":inv_no, "Comp_No":"<?php echo $Sess_UserID; ?>"}));
            }
        }
        
        function PrintPDF(rows){
            var comp_id = <?php echo $Sess_UserID; ?>;
            var row_ind = rows.parentNode.parentNode.rowIndex;
            
            var tax_inv = document.getElementById("quotation_item").rows[row_ind].cells[1].innerHTML;
            
            var inv_join = comp_id.toString() + "_" + tax_inv;
            
            window.open("../../Page_Customer/PDF_Engine/PDF_Render.php?Comp_ID="+comp_id+"&Qt_No="+inv_join+"&type=quotation", "_blank");
        }

        function Check_Radio(){
            var tb = document.getElementById("quotation_item");
            var cell;
            var Cols_Check = false;
            
            if(tb.rows.length > 0){
                for(var i=1; i<tb.rows.length; i++){
                    cell = tb.rows[i].cells[0];
                    
                    for(var j=0; j<cell.childNodes.length; j++){
                        if(cell.childNodes[j].type === "radio"){
                            if(cell.childNodes[j].checked === true){
                                Cols_Check = true;
                            }
                        }
                    }
                }
                
                if(Cols_Check === true){
                    document.getElementById("btn_edit_inv").classList.remove("btn-outline-disabled");
                    document.getElementById("btn_edit_inv").classList.add("btn-outline-warning");
                    document.getElementById("btn_edit_inv").removeAttribute("disabled");
                }
                
            }
            else{
                document.getElementById("btn_edit_inv").classList.remove("btn-outline-warning");
                document.getElementById("btn_edit_inv").classList.add("btn-outline-disabled");
                document.getElementById("btn_edit_inv").setAttribute("disabled","disabled");
            }
            
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
              <li class="breadcrumb-item active">Quotation</li>
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

                 <h3 align="center">Quotation List</h3>

                 <br />
                 <div align="right">
                     <button id="btn_add_inv" class="btn btn-outline-info btn-xs" onclick="GenerateInvoice(<?php echo $Sess_UserID; ?>);" data-toggle="modal" data-target="#Create_Invoice_Modal" data-whatever="@getbootstrap">Create</button>
                     <button id="btn_edit_inv" disabled="disabled" class="btn btn-outline-disabled btn-xs"  onclick="Qt_Edit_Click();" data-toggle="modal" data-target="#Edit_QT_Modal" data-whatever="@getbootstrap">Edit</button>
                 </div>
                 <br />

                 <table id="quotation_item" class="display hover">
                     <thead>
                         <tr>
                             <th></th>
                             <th>Quotation No.</th>
                             <th>Quotation Date</th>
                             <th>Customer Name</th>
                             <th>Currency</th>
                             <th>Grand Total (MYR)</th>
                             <th>Generate Invoice</th>
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
   <br>
  <?php require_once ('QuotationModal.php'); ?>
  <?php require_once ('EditQtModal.php'); ?>

   <?php require ("../../Base/Header4_Master/Footer_Master.php"); ?> 

</div>
   <?php require ("../../Base/Header4_Master/Scripts_Master.php"); ?> 
  </body>
</html>
