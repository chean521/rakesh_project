
function GenerateInvoice(CompanyId){
    
    var xmlhttp = new XMLHttpRequest();
            
    xmlhttp.onreadystatechange = function(e){
        if(this.readyState === 4 && this.status === 200){
            var Resp_Data = JSON.parse(this.responseText);
            
            document.getElementById("InvoiceNo").value = Resp_Data.NewTaxInv;
            document.getElementById("InvoiceNo_Minified").value = Resp_Data.NewTaxInv.substr(7);
            tax_inv = Resp_Data.NewTaxInv.substr(7);
        }
    };

    xmlhttp.open("POST", "/WBServices/InvoiceNo_Generator_Resp.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Inputs="+JSON.stringify({"Comp_Id":CompanyId}));
    
}