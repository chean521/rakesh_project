function GenerateInvoice(CompanyId){
    
    var xmlhttp = new XMLHttpRequest();
            
    xmlhttp.onreadystatechange = function(e){
        if(this.readyState === 4 && this.status === 200){
            var Resp_Data = JSON.parse(this.responseText);
            
            document.getElementById("InvoiceNo").value = Resp_Data.NewQt;
            document.getElementById("InvoiceNo_Minified").value = Resp_Data.NewQt.substr(7);
        }
    };

    xmlhttp.open("POST", "/WBServices/QuotationNo_Generator.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Inputs="+JSON.stringify({"Comp_Id":CompanyId}));
    
}