<script src="../../Js/CustomerNo_Generator.js"></script>
<script src="../../Js/AddNewCustomer_Reqs.js"></script>
<script src="../../Js/GetEditCustomerDetails_Reqs.js"></script>
<script src="../../Js/ChangeStat_Reqs.js"></script>
<script src="../../Js/EditCustomer_Reqs.js"></script>

<script type="text/javascript">
    function GetCustomerId(){
        var NewCustNo = JSON.parse(GenerateCustomer(<?php echo $Sess_UserID; ?>));
        
        document.getElementById("add_CustomerID").value = NewCustNo.NewCustomer.substr(7);
    }
    
    $(document).ready(function(e){
       GetTaxInf(); 
    });
    
    function GetTaxInf(){
        
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function(){

            if(this.readyState === 4 && this.status === 200){
                var Resp = JSON.parse(this.responseText);
                
                $('#add_TaxCode').find('option').not(':first').remove().end();
                $('#Edit_TaxCode').find('option').not(':first').remove().end();

                for(var i=0; i<Resp.length; i++){
                    var opt = document.createElement("option");
                    var opt2 = document.createElement("option")
                    
                    opt.value = Resp[i].TaxCode;
                    opt.textContent = Resp[i].TaxDesc;
                    opt2.value = Resp[i].TaxCode;
                    opt2.textContent = Resp[i].TaxDesc;
                    
                    document.getElementById("add_TaxCode").appendChild(opt);
                    document.getElementById("Edit_TaxCode").appendChild(opt2);
                }
            }
        };

        xmlhttp.open("POST", "/WBServices/GetTaxRate_Resp.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send();

    }
    
    function ResetForm(){
        document.getElementById("add_customer_form").reset();        
    }
    
    function ResetForm_stat(){
        document.getElementById("set_stat_form").reset();
    }
    
    function SetWhite(form_control){
        form_control.style.backgroundColor = "white";
    }
    
    function GetCustomerName_Stat(row){
        var ind = row.parentNode.parentNode.rowIndex;
        
        var CustId = document.getElementById("Customer_Details").rows[ind].cells[0].innerHTML;
        var CustName = document.getElementById("Customer_Details").rows[ind].cells[1].innerHTML;
        
        document.getElementById("edit_tg_cust").innerHTML = CustId + " - " + CustName;
    }
    
</script>

<div id="Add_Customer_Modal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static" style="z-index: 9999;">
    <form id="add_customer_form" autocomplete="off">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: rgba(255,255,255,0.7);">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Customer</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="add_CustomerID" class="control-label col-md-8">Customer ID</label>
                                <input type="text" id="add_CustomerID" readonly class="form-control" placeholder="Customer ID" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="add_CustomerName" class="control-label col-md-8">Customer Name</label>
                                <label for="add_SSMRegNo" class="control-label col-md-3">SSM Registration No</label>
                                <div class="input-group">
                                    <input type="text" id="add_CustomerName" maxlength="50" class="form-control col-md-8" placeholder="Customer Name" onfocus="SetWhite(this);" />
                                    <input type="text" id="add_SSMRegNo" maxlength="10" placeholder="SSM Registration" class="form-control col-md-4" onfocus="SetWhite(this);" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="add_address" class="control-label col-md-8">Address</label>
                                <input type="text" id="add_address" maxlength="200" class="form-control" placeholder="Business Address" onfocus="SetWhite(this);" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="add_City" class="control-label col-md-4">City</label>
                                <label for="add_Postal" class="control-label col-md-4">Postal Code</label>
                                <label for="add_State" class="control-label col-md-3">State</label>
                                <div class="input-group">
                                    <input type="text" id="add_City" maxlength="50" class="form-control col-md-4" placeholder="City" onfocus="SetWhite(this);" />
                                    <input type="text" id="add_Postal" placeholder="Postal Code" class="form-control col-md-4" maxlength="5" onfocus="SetWhite(this);" />
                                    <select id="add_State" class="form-control col-md-4" onfocus="SetWhite(this);">
                                        <option value="none" selected="selected">Please select</option>
                                        <option value="Johor Darul Ta'zim">Johor Darul Ta'zim</option>
                                        <option value="Kedah Darul Aman">Kedah Darul Aman</option>
                                        <option value="Kelantan Darul Naim">Kelantan Darul Naim</option>
                                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                                        <option value="Labuan">Labuan</option>
                                        <option value="Malacca">Malacca</option>
                                        <option value="Negeri Sembilan Darul Khusus">Negeri Sembilan Darul Khusus</option>
                                        <option value="Pahang Darul Makmur">Pahang Darul Makmur</option>
                                        <option value="Pulau Pinang">Pulau Pinang</option>
                                        <option value="Perak Darul Ridzuan">Perak Darul Ridzuan</option>
                                        <option value="Perlis Indera Kayangan">Perlis Indera Kayangan</option>
                                        <option value="Putrajaya">Putrajaya</option>
                                        <option value="Sabah">Sabah</option>
                                        <option value="Sarawak">Sarawak</option>
                                        <option value="Selangor Darul Ehsan">Selangor Darul Ehsan</option>
                                        <option value="Terengganu Darul Iman">Terengganu Darul Iman</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="add_Country" class="control-label">Country</label>
                                <input type="text" readonly class="form-control" id="add_Country" value="Malaysia" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="add_TaxCode" class="control-label">Tax Code</label>
                                <select id="add_TaxCode" class="form-control" onfocus="SetWhite(this);">
                                    <option value="none" selected>Please select</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="add_Contact" class="control-label">Contact No / Extension</label>
                                <div class="input-group">
                                    <input type="tel"  maxlength="12" placeholder="Contact No" class="form-control col-md-8" id="add_Contact" onfocus="SetWhite(this);"/>
                                    <input type="text" placeholder="Ext" maxlength="3" id="add_Extension" class="form-control col-md-4" />
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="add_Email" class="control-label">E-Mail</label>
                                <input type="email" class="form-control" placeholder="E-Mail" id="add_Email" onfocus="SetWhite(this);"/>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" id="btn_Add_Submit" onclick="AddNewCustomer(<?php echo $Sess_UserID; ?>);" >Add Customer</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal" onclick="ResetForm();" id="btn_Add_Close">Close Form</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="Set_Status_Customer" class="modal fade" role="dialog" style="z-index: 9999;" data-keyboard="false" data-backdrop="static">
    <form id="set_stat_form" autocomplete="off">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: rgba(255,255,255,0.7);">
                <div class="modal-header">
                    <h4 class="modal-title">Set Business Status</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ddl_Status" class="control-label">Status: (Target Customer: <strong id="edit_tg_cust">xxx</strong>)</label>
                        <select id="ddl_Status" class="form-control" onfocus="CleanRed(this);">
                            <option value="none" selected>Please select</option>
                            <option value="Active" class="text-success">Active</option>
                            <option value="Hold" class="text-warning">Hold</option>
                            <option value="Suspended" class="text-danger">Suspend</option>
                            <option value="Terminated" class="text-danger">Terminate</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" id="btn_stat_Submit" onclick="ChangeStat(<?php echo $Sess_UserID; ?>);" >Change Status</button>
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal" onclick="ResetForm_stat();" id="btn_stat_Close">Close Form</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="Edit_Customer_Modal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static" style="z-index: 9999;">
    <form id="Edit_customer_form" autocomplete="off">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background-color: rgba(255,255,255,0.7);">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Customer Details</h4>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Edit_CustomerID" class="control-label col-md-8">Customer ID</label>
                                <input type="text" id="Edit_CustomerID" readonly class="form-control" placeholder="Customer ID" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Edit_CustomerName" class="control-label col-md-8">Customer Name</label>
                                <label for="Edit_SSMRegNo" class="control-label col-md-3">SSM Registration No</label>
                                <div class="input-group">
                                    <input type="text" id="Edit_CustomerName" maxlength="50" class="form-control col-md-8" placeholder="Customer Name" onfocus="SetWhite(this);" />
                                    <input type="text" id="Edit_SSMRegNo" maxlength="10" placeholder="SSM Registration" class="form-control col-md-4" onfocus="SetWhite(this);" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Edit_address" class="control-label col-md-8">Address</label>
                                <input type="text" id="Edit_address" maxlength="200" class="form-control" placeholder="Business Address" onfocus="SetWhite(this);" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="Edit_City" class="control-label col-md-4">City</label>
                                <label for="Edit_Postal" class="control-label col-md-4">Postal Code</label>
                                <label for="Edit_State" class="control-label col-md-3">State</label>
                                <div class="input-group">
                                    <input type="text" id="Edit_City" class="form-control col-md-4" maxlength="50" placeholder="City" onfocus="SetWhite(this);" />
                                    <input type="text" id="Edit_Postal" placeholder="Postal Code" class="form-control col-md-4" maxlength="5" onfocus="SetWhite(this);" />
                                    <select id="Edit_State" class="form-control col-md-4" onfocus="SetWhite(this);">
                                        <option value="none" selected="selected">Please select</option>
                                        <option value="Johor Darul Ta'zim">Johor Darul Ta'zim</option>
                                        <option value="Kedah Darul Aman">Kedah Darul Aman</option>
                                        <option value="Kelantan Darul Naim">Kelantan Darul Naim</option>
                                        <option value="Kuala Lumpur">Kuala Lumpur</option>
                                        <option value="Labuan">Labuan</option>
                                        <option value="Malacca">Malacca</option>
                                        <option value="Negeri Sembilan Darul Khusus">Negeri Sembilan Darul Khusus</option>
                                        <option value="Pahang Darul Makmur">Pahang Darul Makmur</option>
                                        <option value="Pulau Pinang">Pulau Pinang</option>
                                        <option value="Perak Darul Ridzuan">Perak Darul Ridzuan</option>
                                        <option value="Perlis Indera Kayangan">Perlis Indera Kayangan</option>
                                        <option value="Putrajaya">Putrajaya</option>
                                        <option value="Sabah">Sabah</option>
                                        <option value="Sarawak">Sarawak</option>
                                        <option value="Selangor Darul Ehsan">Selangor Darul Ehsan</option>
                                        <option value="Terengganu Darul Iman">Terengganu Darul Iman</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="Edit_Country" class="control-label">Country</label>
                                <input type="text" readonly class="form-control" id="Edit_Country" value="Malaysia" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Edit_TaxCode" class="control-label">Tax Code</label>
                                <select id="Edit_TaxCode" class="form-control" onfocus="SetWhite(this);">
                                    <option value="none" selected>Please select</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="Edit_Contact" class="control-label">Contact No / Extension</label>
                                <div class="input-group">
                                    <input type="tel" maxlength="12" placeholder="Contact No" class="form-control col-md-8" id="Edit_Contact" onfocus="SetWhite(this);"/>
                                    <input type="text" placeholder="Ext" maxlength="3" id="Edit_Extension" class="form-control col-md-4" />
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="Edit_Email" class="control-label">E-Mail</label>
                                <input type="email" class="form-control" placeholder="E-Mail" id="Edit_Email" onfocus="SetWhite(this);"  maxlength="200"/>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" id="btn_Edit_Submit" onclick="SubmitEditCustomer(<?php echo $Sess_UserID; ?>);" >Edit</button>
                    <button type="reset" class="btn btn-outline-danger" data-dismiss="modal" id="btn_Edit_Close" onclick="ResetForm();">Close Form</button>
                </div>
            </div>
        </div>
    </form>
</div>






