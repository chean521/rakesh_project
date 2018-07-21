<script type="text/javascript">
    function PayModal_Click(row){
        var ind = row.parentNode.parentNode.rowIndex;
        
        var Row_Data = document.getElementById("invoice_item").rows[ind];
        var Inv_No = Row_Data.cells[0].innerHTML;
        var GrandTtl = Row_Data.cells[4].innerHTML;
        
        $('#pymt_inv_show').html(Inv_No);
        $('#InvAmt').val(GrandTtl);
    }
    
    $(document).ready(function(e){
        $('#PymtAmt').on('input', function(c){
            var valAmt = parseFloat($(this).val());
            var valInv = parseFloat($('#InvAmt').val());
            
            var bal = valAmt - valInv;
            
            $('#RtnBal').val(bal.toFixed(2));
        });
        
        $('#PymtAmt').focusout(function(c){
            var valAmt = parseFloat($(this).val());
            var valInv = parseFloat($('#InvAmt').val());
            
            if(isNaN(valAmt) ||valInv > valAmt){
                alert("Amount to pay should not less than grand total.");
                $('#PymtAmt').val(valInv);
                $('#RtnBal').val(0.00);
                $('#PymtAmt').focus();
            }
        });
    });
</script>

<div id="make_pymt_modal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static" style="z-index:9999;">
    <form id="form_mk_pymt" autocomplete="off" >
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: rgba(255,255,255,0.7);">
                <div class="modal-header">
                    <h4 class="modal-title">Make Payment (Tax Invoice: <strong id="pymt_inv_show">xxxxxxx</strong>)</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="PymtDate" class="control-label">Payment Date</label>
                        <input type="date" id="PymtDate" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="PymtType" class="control-label">Payment Type</label>
                        <select id="PymtType" class="form-control">
                            <option value="none" selected="selected" >Please select</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Cash">Cash</option>
                            <option value="IBG">IBG</option>
                            <option value="IBFT">IBFT</option>
                            <option value="RENTAS">RENTAS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="PymtAmt" class="control-label">Amount to Pay (MYR)</label>
                        <input type="number" id="PymtAmt" class="form-control"  />
                    </div>
                    <div class="form-group">
                        <label for="InvAmt" class="control-label">Invoice Amount (MYR)</label>
                        <input type="number" id="InvAmt" class="form-control" disabled="disabled" />
                    </div>
                    <div class="form-group">
                        <label for="RtnBal" class="control-label">Balance/Change (MYR)</label>
                        <input type="number" id="RtnBal" class="form-control" disabled="disabled" />
                    </div>
                    <div class="form-group">
                        <label for="RtnBal" class="control-label">Payment Remark</label>
                        <textarea id="PymtRemark" class="form-control" maxlength="400"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success" id="btn_payment_now" onclick="PaymentNow()" >Pay Now</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal" onclick="CleanValue()" id="btn_Pymt_Close">Close Form</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="../../Js/Receipt_Generator.js"></script>
<script type="text/javascript">
    GetDateTime_Pay();
    
    function GetDateTime_Pay(){
        let today = new Date().toISOString().substr(0, 10);
        
        document.getElementById("PymtDate").value = today;
    }
    
    function PaymentNow(){
        
        var WrongInput = false;
        
        var inv_id = $('#pymt_inv_show').html();
        var pymt_date = $('#PymtDate').val();
        var pymt_type = $('#PymtType option:selected').val();
        var pymt_amt = $('#PymtAmt').val();
        var grand_ttl = $('#InvAmt').val();
        var remark = $('#PymtRemark').val();
        
        if(pymt_date === null || pymt_date === "") WrongInput = true;
        if(pymt_type === "none") WrongInput = true;
        if(isNaN(pymt_amt)) WrongInput = true;
        if(remark === null || remark === "") WrongInput = true;
        
        if(WrongInput === true){
            alert("Invalid input, please input again.");
            return;
        }
        
        if(confirm("Are you sure want make payment now?") === false)
            return;
        
        var Comp_data = [];
        
        var NewRec = JSON.parse(GenerateReceipt(<?php echo $Sess_UserID; ?>)).NewRec;
        
        Comp_data.push(NewRec);
        Comp_data.push(<?php echo $Sess_UserID; ?>);
        Comp_data.push(<?php echo $Sess_UserID; ?> + '_' + inv_id);
        Comp_data.push(grand_ttl);
        Comp_data.push(pymt_date);
        Comp_data.push(pymt_type);
        Comp_data.push(pymt_amt);
        Comp_data.push(remark);
        
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                var data = JSON.parse(this.responseText);

                if(data.Result === "true"){
                    alert("Payment made successfully, Receipt No: " + NewRec.substr(7));
                    window.open("../../Page_Customer/Receipt/receipt.php", "_self");
                }
                else{
                    alert("Payment made unsuccessfully, please try again!");
                }
            }
        };

        xmlhttp.open("POST", "/WBServices/PaymentNow_Resp.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("Data="+JSON.stringify({"Comp_Data":Comp_data}));
    }
    
    function CleanValue(){
        document.getElementById("form_mk_pymt").reset();
    }
</script>
