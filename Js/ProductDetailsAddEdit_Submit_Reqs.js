
function Product_Submit(comp_id,opt){

    var prod_code = $('#add_ProductCode');
    var manufacture = $('#add_ProductManufacture');
    var model = $('#add_ProductModel');
    var price = $('#add_ProductPrice');
    var tax = $('#add_TaxCode option:selected').val();
    
    var isError = false;
    
    if(prod_code.val().length === 0) { isError = true; }
    if(manufacture.val().length === 0) { isError = true; }
    if(model.val().length === 0) { isError = true; }
    if(price.val().length=== 0 || isNaN(price.val())) { isError = true; }
    if(tax === "none") { isError = true; }
    
    if(isError === true){
        alert("Input field missing, please fill in the blank.");
        return;
    }
    
    if(confirm("Are you sure want to submit?") === false){
        return;
    }
    
    var Compiled_Data = [];
    
    Compiled_Data.push(comp_id);
    Compiled_Data.push(opt);
    Compiled_Data.push(prod_code.val());
    Compiled_Data.push(manufacture.val());
    Compiled_Data.push(model.val());
    Compiled_Data.push(price.val());
    Compiled_Data.push(tax);

    var xmlhttp = new XMLHttpRequest();
            
    xmlhttp.onreadystatechange = function(e){
        if(this.readyState === 4 && this.status === 200){
            var Resp_Data = JSON.parse(this.responseText);
            
            if(Resp_Data.Result === "true"){
                alert("Action performed!");
                window.location.reload();
            }
            else{
                alert("Action not performed, please seek administrator!");
                window.location.reload();
            }
        }
    };

    xmlhttp.open("POST", "/WBServices/ProductDetailsAddEdit_Submit_Resp.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("datas="+JSON.stringify({"Compiled_Data":Compiled_Data}));

}

