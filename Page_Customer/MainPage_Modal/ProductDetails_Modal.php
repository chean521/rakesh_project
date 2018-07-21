<script src="../Js/ProductDetailsAddEdit_Submit_Reqs.js"></script>
<script type="text/javascript">
    function GetTaxInf(){
        
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function(){

            if(this.readyState === 4 && this.status === 200){
                var Resp = JSON.parse(this.responseText);

                for(var i=0; i<Resp.length; i++){
                    var opt = document.createElement("option");
                    
                    opt.value = Resp[i].TaxCode;
                    opt.textContent = Resp[i].TaxDesc;
                    
                    document.getElementById("add_TaxCode").appendChild(opt);
                }
            }
        };

        xmlhttp.open("POST", "/WBServices/GetTaxRate_Resp.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send();
        
    }
    
    var word_lim = 0;
    
    function WordCountLimit(input_box){
        $('#prog_show').css("display", "block");
        
        switch(input_box){
            case 0:
                word_lim = 12;
                CountPercent(document.getElementById('add_ProductCode'));
                break;
                
            case 1:
                word_lim = 30;
                CountPercent(document.getElementById('add_ProductManufacture'));
                break;
                
            case 2:
                word_lim = 24;
                CountPercent(document.getElementById('add_ProductModel'));
                break;
        }
        
    }
    
    function LoseFocus(){
        $('#prog_show').css("display", "none");
    }
    
    function CountPercent(box){
        var lg = parseInt(box.value.length);
        
        var ttl = (lg/word_lim)*100;
        
        $('#length_counter').val(ttl);
    }
</script>
<link rel="stylesheet" href="../../Page_Customer/MainPage_Modal/bootstrap_merge.css" />
<style type="text/css">
    .prog{
        position: absolute;
        right: 20px;
        font-size: 10pt;
    }
    
    progress{
        border-radius: 25px;
    }
</style>

<script type="text/javascript">
    function ModalMode(ModeOpt, rows){
        switch(ModeOpt){
            case 1:
                ButtonClickOption = 1;
                $('#add_ttl').html("Add Product Option");
                $('#add_ProductCode').removeAttr("disabled");
                $('#btn_Add_Proc').html("Add Product");
                break;
                
            case 2:
                ButtonClickOption = 2;
                $('#add_ttl').html("Edit Product Option");
                $('#add_ProductCode').attr("disabled","disabled");
                $('#btn_Add_Proc').html("Edit Product");
                
                var ind = rows.parentNode.parentNode.rowIndex;
                
                var elems = document.getElementById("Product_Details");
                $('#add_ProductCode').val(elems.rows[ind].cells[0].innerHTML);
                $('#add_ProductManufacture').val(elems.rows[ind].cells[1].innerHTML);
                $('#add_ProductModel').val(elems.rows[ind].cells[2].innerHTML);
                $('#add_ProductPrice').val(elems.rows[ind].cells[3].innerHTML);
                $('#add_TaxCode').find('option[value="'+elems.rows[ind].cells[4].innerHTML+'"]').attr("selected",true);
                break;
                
        }
    }
    
    function CheckExistance(inputs){
        if(ButtonClickOption === 1){
            var len = inputs.value.length;
            
            if(len >= 7){
                var xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function(){

                    if(this.readyState === 4 && this.status === 200){
                        var Resp = JSON.parse(this.responseText);

                        if(Resp.Duplicate === "yes"){
                            document.getElementById('add_ProductCode').parentNode.classList.add("has-error");
                            document.getElementById('add_ProductCode').parentNode.classList.remove("has-success");
                            inputs.focus();
                        }
                        else{
                            document.getElementById('add_ProductCode').parentNode.classList.add("has-success");
                            document.getElementById('add_ProductCode').parentNode.classList.remove("has-error");
                        }
                    }
                };

                xmlhttp.open("POST", "/WBServices/CheckProductDuplicate_Resp.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("datas="+JSON.stringify({"ProductNo":inputs.value, "CompanyId":"<?php echo $Sess_UserID; ?>"}));
            }
            else{
                inputs.focus();
            }
        }
        
    }
    
    function RemoveBoxes(){
        if(ButtonClickOption === 1){
            document.getElementById('add_ProductCode').parentNode.classList.remove("has-success");
            document.getElementById('add_ProductCode').parentNode.classList.remove("has-error");
        }
        
        document.getElementById("add_product_form").reset();
        $('#add_TaxCode').children('option:not(:first)').remove();
    }
</script>

<div id="add_product" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static" style="z-index: 9999;">
    <form id="add_product_form" autocomplete="off" >
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: rgba(255,255,255, 0.7)">
                <div class="modal-header">
                    <h4 class="modal-title" id="add_ttl">Add Product Option</h4>
                </div>
                <div class="modal-body">
                    <div class="prog" id="prog_show" style="display:none;">Max Length: <progress id="length_counter" max="100" min="0"></progress></div>
                    <div class="form-group has-feedback">
                        <label for="add_ProductCode" class="control-label">Product Code</label>
                        <input type="text" id="add_ProductCode" class="form-control" maxlength="12" onfocus="WordCountLimit(0);" oninput="CountPercent(this);" onblur="LoseFocus();CheckExistance(this);" />
                    </div>
                    <div class="form-group">
                        <label for="add_ProductManufacture" class="control-label">Manufacture Company</label>
                        <input type="text" id="add_ProductManufacture" class="form-control" maxlength="30" onfocus="WordCountLimit(1);" oninput="CountPercent(this);" onblur="LoseFocus();"/>
                    </div>
                    <div class="form-group">
                        <label for="add_ProductModel" class="control-label">Product Model</label>
                        <input type="text" id="add_ProductModel" class="form-control" maxlength="24" onfocus="WordCountLimit(2);" oninput="CountPercent(this);" onblur="LoseFocus();"/>
                    </div>
                    <div class="form-group">
                        <label for="add_ProductPrice" class="control-label">Product Price</label>
                        <input type="number" min="0.00" max="99999999.99" step="0.01" id="add_ProductPrice" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="add_TaxCode" class="control-label">Tax Code</label>
                        <select id="add_TaxCode" class="form-control">
                            <option value="none" selected>Please select</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" id="btn_Add_Proc" onclick="Product_Submit(<?php echo $Sess_UserID; ?>, ButtonClickOption);" >Add Product</button>
                    <button type="reset" class="btn btn-outline-danger" data-dismiss="modal" onclick="RemoveBoxes();" id="btn_Close_Proc">Close Form</button>
                </div>
            </div>
        </div>
    </form>
</div>


