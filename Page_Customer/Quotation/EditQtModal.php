
<script src="../../Js/DynamicColumn_Qt_EditModal.js"></script>
<script src="../../Js/QuotationEditSubmit_Reqs.js"></script>

<?php require ("./Currencies.php"); ?> 

<script type="text/javascript">
    
$(document).ready(function(e){
    $('#qt_edit_conv_sign').html($('#Qt_Edit_Currency option:selected').val());
    
   $('#Qt_Edit_Currency').change(function(c){
       $('#qt_edit_conv_sign').html($('#Qt_Edit_Currency option:selected').val());
   });
});

$(document).ready(function(e){
   $('#btn_Edit_Close').click(function(f){
       document.getElementById('modal_form-edit_qt').reset();
       
       counter = 0;
       
       $('#qt_edit_Desc_Container tbody').children().remove();
   }); 
   
});

function Qt_Edit_Click(){
    var tb = document.getElementById("quotation_item");
    var cell;
    var row_pos = 0;

    if(tb.rows.length > 0){
        for(var i=1; i<tb.rows.length; i++){
            cell = tb.rows[i].cells[0];

            for(var j=0; j<cell.childNodes.length; j++){
                if(cell.childNodes[j].type === "radio"){
                    if(cell.childNodes[j].checked === true){
                        row_pos = i;
                        break;
                    }
                }
            }
        }
        
        var qt_value = document.getElementById("quotation_item").rows[row_pos].cells[1].innerHTML;
        
        var xmlhttp = new XMLHttpRequest();
    
        xmlhttp.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                var data = JSON.parse(this.responseText);
                
                var det = data.Data_Inf;
                var desc = data.Data_Desc;

                $('#Qt_Edit_No').val(det[0].substr(7));
                $('#Qt_Edit_Date').val(det[1]);
                $('#Qt_Edit_CustomerID').val(det[2].substr(7));
                $('#Qt_Edit_CustomerName').val(det[3]);
                $('#Qt_Edit_SSMRegNo').val(det[4]);
                $('#Qt_Edit_Terms').val(det[5]);
                $('#Qt_Edit_Currency').val(det[6]);
                $('#Qt_Edit_taxCode').val(det[7]);
                $('#Qt_Edit_AttnName').val(det[8]);
                
                qt_edit_counter = desc.length;
                
                for(var i=0; i<desc.length; i++){
                    var html_string = "<tr>";
                    html_string += '<td><div class="input-group"><input type="text" class="form-control" readonly value="'+desc[i][0]+'" /><div class="input-group-btn">'+
                        '<button type="button" class="btn btn-outline-primary" onclick="qt_edit_ProductId_PopUpSelect(<?php echo $Sess_UserID; ?>,this);"><i class="glyphicon glyphicon-search" ></i></button></div></div></td>';
                    html_string += '<td><input type="number" value="'+desc[i][1]+'" class="form-control" min="1" max="200" oninput="qt_edit_Qty_OnInputCount(this,this.value);qt_edit_TotalUpAmt();"  /></td>';
                    html_string += '<td><input type="text" class="form-control" value="'+desc[i][2]+'" readonly/></td>';
                    html_string += '<td><input type="text" class="form-control" value="'+desc[i][3]+'" readonly /></td>';
                    html_string += '<td><input type="text" class="form-control" value="'+desc[i][4]+'" readonly /></td>';
                    html_string += '<td><button type="button" onclick="qt_edit_deleteRow(this)" class="btn btn-outline-danger btn-sm" style="border: 0;"><i class="glyphicon glyphicon-remove"></i></button></td>';
                    html_string += "</tr>";

                    $('#qt_edit_Desc_Container tbody').append(html_string);
                }
                
                $('#qt_edit_count').html(qt_edit_counter);
                $('#qt_edit_conv_sign').html($('#Qt_Edit_Currency option:selected').val());
                qt_edit_TotalUpAmt();
                $('#qt_no_head').html(det[0].substr(7));
            }
        };


        xmlhttp.open("POST", "/WBServices/GetEditDetailsQt_Resp.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("datas="+JSON.stringify({"qt_val":qt_value,"comp_id":"<?php echo $Sess_UserID; ?>"})); 
    }
}

</script>

<div id="Edit_QT_Modal" class="modal fade" role="dialog" style="z-index: 9999;" data-keyboard="false" data-backdrop="static">
    <form method="post" autocomplete="off" class="" id="modal_form-edit_qt">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: rgba(255,255,255,0.7);">
            <div class="modal-header">
                <h5 class="modal-title">Edit Quotation (Quotation No: <b id="qt_no_head">Test123</b>)</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="Qt_Edit_No" class="control-label col-md-5">Quotation No</label>
                            <label for="Qt_Edit_Date" class="control-label col-md-6">Quotation Date</label>
                            <div class="input-group">
                                <input type="text" id="Qt_Edit_No" class="form-control col-md-5" placeholder="Quotation No" disabled="disabled"/>
                                <input type="date" id="Qt_Edit_Date" placeholder="Quotation Date" class="form-control col-md-7" disabled="disabled" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="Qt_Edit_CustomerID" class="control-label">Customer ID</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="Qt_Edit_CustomerID" readonly="readonly" placeholder="Customer No" disabled="disabled" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="Qt_Edit_CustomerName" class="control-label col-md-8">Customer Name</label>
                            <label for="Qt_Edit_SSMRegNo" class="control-label col-md-3">SSM Registration No</label>
                            <div class="input-group">
                                <input type="text" id="Qt_Edit_CustomerName" class="form-control col-md-8" placeholder="Customer Name" readonly="readonly" />
                                <input type="text" id="Qt_Edit_SSMRegNo" placeholder="SSM Registration" class="form-control col-md-4" readonly="readonly" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="Qt_Edit_Terms" class="control-label col-md-4">Terms</label>
                            <label for="Qt_Edit_Currency" class="control-label col-md-4">Currency</label>
                            <label for="Qt_Edit_taxCode" class="control-label col-md-3">Tax Code</label>
                            <div class="input-group">
                                <select id="Qt_Edit_Terms" class="form-control col-md-4" disabled="disabled">
                                    <option value="none" selected="selected" >Please select</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="Cash">Cash</option>
                                    <option value="IBG">IBG</option>
                                    <option value="IBFT">IBFT</option>
                                    <option value="RENTAS">RENTAS</option>
                                </select>
                                <select id="Qt_Edit_Currency" class="form-control col-md-4" onchange="TotalUpAmt()" disabled="disabled">
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
                                <input type="text" readonly="readonly" class="form-control col-md-4" id="Qt_Edit_taxCode"  disabled="disabled" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="Qt_Edit_AttnName" class="control-label">Receiver Name</label>
                            <div class="input-group">
                                <input type="text" id="Qt_Edit_AttnName" placeholder="Attn Name" class="form-control" disabled="disabled"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary" id="qt_edit_panel_desc">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-10">Quotation Description (Max: <strong id="qt_edit_count">0</strong> / 10)</div>
                                        <div class="col-md-2 text-right">
                                            <button type="button" onclick="qt_edit_AddColumn(<?php echo $Sess_UserID; ?>);" class="btn btn-outline-success btn-sm" style="border: 0;" >
                                                <i class="glyphicon glyphicon-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <link rel="stylesheet" href="../../Styles/ScrollableTable.css" />
                                    <table id="qt_edit_Desc_Container" class="table table-striped ScrollTable" data-whatever="@getbootstrap">
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
                                        <div class="col-md-4">Currency in <strong id="qt_edit_conv_sign"></strong>: <strong id="qt_edit_convert_grand_amt">0.00</strong></div>
                                        <div class="col-md-3">Total Tax: <strong id="qt_edit_tax_charged">0.00</strong></div>
                                        <div class="col-md-5">Grand Total (w. Tax in MYR): <strong id="qt_edit_grand_total">0.00</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" id="btn_Edit_Submit" onclick="EditQuotation(<?php echo $Sess_UserID; ?>);" >Edit Quotation</button>
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal" id="btn_Edit_Close" onclick="setTimeout(function(e){window.location.reload();},1000);">Close Form</button>
            </div>
        </div>
    </div>
    </form>
</div>