

function SubmitEditCustomer(comp_id){
    var Cust_Id         = $('#Edit_CustomerID');
    var Cust_Name       = $('#Edit_CustomerName');
    var SSM_Reg         = $('#Edit_SSMRegNo');
    var Cust_Addr       = $('#Edit_address');
    var Cust_City       = $('#Edit_City');
    var Cust_Post       = $('#Edit_Postal');
    var Cust_Stat       = $('#Edit_State');
    var Cust_TaxCode    = $('#Edit_TaxCode');
    var Cust_Tel        = $('#Edit_Contact');
    var Cust_Ext        = $('#Edit_Extension');
    var Cust_Mail       = $('#Edit_Email');
    
    var isError = false;
    
    if(Cust_Name.val().length === 0) { isError = true; Cust_Name.css("background-color","red"); }
    if(Cust_Addr.val().length === 0) { isError = true; Cust_Addr.css("background-color","red"); }
    if(SSM_Reg.val().length === 0) { isError = true; SSM_Reg.css("background-color","red"); }
    if(Cust_City.val().length === 0) { isError = true; Cust_City.css("background-color","red"); }
    if(Cust_Post.val().length === 0) { isError = true; Cust_Post.css("background-color","red"); }
    if(Cust_Stat.val() === "none") { isError = true; Cust_Stat.css("background-color","red"); }
    if(Cust_TaxCode.val() === "none") { isError = true; Cust_TaxCode.css("background-color","red"); }
    if(Cust_Tel.val().length === 0) { isError = true; Cust_Tel.css("background-color","red"); }
    if(Cust_Mail.val().length === 0) { isError = true; Cust_Mail.css("background-color","red"); }
    
    if(isError === true){
        alert("Input field missing, please check the missing input.");
        return;
    }
    
    if(confirm("Are you sure want to edit customer details?") === false){
        return;
    }
    
    var Compiled_Data = [];
    
    Compiled_Data.push(Cust_Name.val());
    Compiled_Data.push(SSM_Reg.val());
    Compiled_Data.push(Cust_Addr.val());
    Compiled_Data.push(Cust_City.val());
    Compiled_Data.push(Cust_Post.val());
    Compiled_Data.push(Cust_Stat.val());
    Compiled_Data.push(Cust_Tel.val());
    Compiled_Data.push(Cust_Ext.val());
    Compiled_Data.push(Cust_Mail.val());
    Compiled_Data.push(Cust_TaxCode.val());
    Compiled_Data.push(comp_id + "_" + Cust_Id.val());
    
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200){
            if(JSON.parse(this.responseText).Result === "true"){
                alert("Customer Edited!");
                window.location.reload();
            }
            else{
                alert("Customer Not Edited, please contact administrator.");
            }
        }
    };
    
    xmlhttp.open("POST", "/WBServices/EditCustomerSubmit_Resp.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("datas="+JSON.stringify({ "DataPack" : Compiled_Data }));
    
}