function AddNewCustomer(comp_id){
    
    var Cust_Id         = $('#add_CustomerID');
    var Cust_Name       = $('#add_CustomerName');
    var SSM_Reg         = $('#add_SSMRegNo');
    var Cust_Addr       = $('#add_address');
    var Cust_City       = $('#add_City');
    var Cust_Post       = $('#add_Postal');
    var Cust_Stat       = $('#add_State');
    var Cust_Country    = $('#add_Country');
    var Cust_TaxCode    = $('#add_TaxCode');
    var Cust_Tel        = $('#add_Contact');
    var Cust_Ext        = $('#add_Extension');
    var Cust_Mail       = $('#add_Email');
    
    var isError = false;
    
    if(Cust_Name.val().length === 0) { isError = true; Cust_Name.css("background-color","red"); }
    if(Cust_Addr.val().length === 0) { isError = true; Cust_Addr.css("background-color","red"); }
    if(SSM_Reg.val().length === 0) { isError = true; SSM_Reg.css("background-color","red"); }
    if(Cust_City.val().length === 0) { isError = true; Cust_City.css("background-color","red"); }
    if(Cust_Post.val().length === 0) { isError = true; Cust_Post.css("background-color","red"); }
    if(Cust_Stat.val() === "none") { isError = true; Cust_Stat.css("background-color","red"); }
    if(Cust_Country.val().length === 0) { isError = true; Cust_Country.css("background-color","red"); }
    if(Cust_TaxCode.val() === "none") { isError = true; Cust_TaxCode.css("background-color","red"); }
    if(Cust_Tel.val().length === 0) { isError = true; Cust_Tel.css("background-color","red"); }
    if(Cust_Mail.val().length === 0) { isError = true; Cust_Mail.css("background-color","red"); }
    
    if(isError === true){
        alert("Input field missing, please check the missing input.");
        return;
    }
    
    if(confirm("Are you sure want to add new customer?") === false){
        return;
    }
    
    var Compiled_Data = [];
    
    Compiled_Data.push(comp_id + "_" + Cust_Id.val());
    Compiled_Data.push(Cust_Name.val());
    Compiled_Data.push(SSM_Reg.val());
    Compiled_Data.push(Cust_Addr.val());
    Compiled_Data.push(Cust_City.val());
    Compiled_Data.push(Cust_Post.val());
    Compiled_Data.push(Cust_Stat.val());
    Compiled_Data.push(Cust_Country.val());
    Compiled_Data.push(Cust_Tel.val());
    Compiled_Data.push(Cust_Ext.val());
    Compiled_Data.push(Cust_Mail.val());
    Compiled_Data.push(Cust_TaxCode.val());
    Compiled_Data.push(comp_id);
    Compiled_Data.push("Active");
    
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200){
            if(JSON.parse(this.responseText).Result === "true"){
                alert("Customer Added!");
                window.location.reload();
            }
            else{
                alert("Customer Not Added, please contact administrator.");
            }
        }
    };
    
    xmlhttp.open("POST", "/WBServices/AddNewCustomer_Resp.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("datas="+JSON.stringify({ "DataPack" : Compiled_Data }));
    
}

