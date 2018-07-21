<link rel="stylesheet" href="bootstrap3_part.css" />
<script src="../../Js/InvoiceSubmit_Reqs.js"></script>
<script src="../../Js/DynamicColumn_InvoiceModal.js"></script>
<script src="../../Js/GetCompCustList_Reqs.js"></script>
<script type="text/javascript">
    
$(document).ready(function(e){
    $('#conv_sign').html($('#Currency option:selected').val());
    
   $('#Currency').change(function(c){
       $('#conv_sign').html($('#Currency option:selected').val());
   });
});

$(document).ready(function(e){
   $('#btn_Create_Close').click(function(f){
       document.getElementById('modal_form').reset();
   }); 
   
});


</script>

  <?php require ("./Currencies.php"); ?> 

<div id="Create_Invoice_Modal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static" style="z-index:9999;">
    <form method="post" autocomplete="off" class="" id="modal_form">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: rgba(255,255,255,0.7);">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Invoice</h5>
                </div>
                <div class="modal-body" style="padding-bottom: 3px;padding-top: 3px;">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="InvoiceNo" class="control-label col-md-5">Invoice No</label>
                                <label for="InvoiceDate" class="control-label col-md-6">Invoice Date</label>
                                <div class="input-group">
                                    <input type="text" id="InvoiceNo_Minified" class="form-control col-md-5" placeholder="Invoice No" onfocus="ReleaseWhite(this);" disabled="disabled"/>
                                    <input type="date" id="InvoiceDate" placeholder="Invoice Date" class="form-control col-md-7" onfocus="ReleaseWhite(this);"/>
                                    <input type="hidden" id="InvoiceNo" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="CustomerID" class="control-label">Customer ID</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="CustomerID" readonly="readonly" placeholder="Customer No" onfocus="ReleaseWhite(this);" disabled="disabled" />
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-outline-primary" onclick="CustomerSelectShow('<?php echo $Sess_UserID; ?>');">
                                            <i class="glyphicon glyphicon-search" ></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="CustomerName" class="control-label col-md-8">Customer Name</label>
                                <label for="SSMRegNo" class="control-label col-md-3">SSM Registration No</label>
                                <div class="input-group">
                                    <input type="text" id="CustomerName" class="form-control col-md-8" placeholder="Customer Name" readonly="readonly" />
                                    <input type="text" id="SSMRegNo" placeholder="SSM Registration" class="form-control col-md-4" readonly="readonly" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Terms" class="control-label col-md-4">Terms</label>
                                <label for="Currency" class="control-label col-md-4">Currency</label>
                                <label for="taxCode" class="control-label col-md-3">Tax Code</label>
                                <div class="input-group">
                                    <select id="Terms" class="form-control col-md-4" onfocus="ReleaseWhite(this);">
                                        <option value="none" selected="selected" >Please select</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Cash">Cash</option>
                                        <option value="IBG">IBG</option>
                                        <option value="IBFT">IBFT</option>
                                        <option value="RENTAS">RENTAS</option>
                                    </select>
                                    <select id="Currency" class="form-control col-md-4" onchange="TotalUpAmt()" onfocus="ReleaseWhite(this);">
                                        <option value="none" >Please select</option>
                                        <?php
                                        foreach($datas as $r)
                                        {
                                            $sel = '';
                                            
                                            if($r["Sign"]=='MYR'){
                                                $sel = 'selected="selected"';
                                            }
                                            
                                            echo '<option value="'.$r["Sign"].'" '.$sel.' >'.$r["DisplayName"].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <input type="text" readonly="readonly" class="form-control col-md-4" id="taxCode" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="AttnName" class="control-label">Receiver Name</label>
                                <div class="input-group">
                                    <input type="text" id="AttnName" placeholder="Attn Name" maxlength="50" class="form-control" onfocus="ReleaseWhite(this);"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary" id="panel_desc">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-md-10">Invoice Description (Max: <strong id="count">0</strong> / 10)</div>
                                            <div class="col-md-2 text-right">
                                                <button type="button" onclick="AddColumn(<?php echo $Sess_UserID; ?>);ReleasePanel();" class="btn btn-outline-success btn-sm" style="border: 0;" >
                                                    <i class="glyphicon glyphicon-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <link rel="stylesheet" href="../../Styles/ScrollableTable.css" />
                                        <table id="Desc_Container" class="table table-striped ScrollTable" data-whatever="@getbootstrap">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Item Code</th>
                                                    <th>Quantity</th>
                                                    <th>Unit (RM)</th>
                                                    <th>Amt (RM)</th>
                                                    <th>Tax Code</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-md-4">Currency in <strong id="conv_sign"></strong>: <strong id="convert_grand_amt">0.00</strong></div>
                                            <div class="col-md-3">Total Tax: <strong id="tax_charged">0.00</strong></div>
                                            <div class="col-md-5">Grand Total (w. Tax in MYR): <strong id="grand_total">0.00</strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" id="btn_Create_Submit" onclick="SubmitInvoice_Statement(<?php echo $Sess_UserID; ?>);" >Create New Invoice</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="btn_Create_Close">Close Form</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="SelectPopUp.js"></script>

<script type="text/javascript">
    GetDateTime();
    
    function GetDateTime(){
        let today = new Date().toISOString().substr(0, 10);
        
        document.getElementById("InvoiceDate").value = today;
    }
</script>
