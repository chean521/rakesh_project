function SubmitQuotationToInvoice(comp_id, qt_id){
    
    if(confirm("Are you sure want to submit invoice? Once submitted can't revert.") === false)
        return;
    
    var ind = qt_id.parentNode.parentNode.rowIndex;
    
    var rl_qt_id = document.getElementById("quotation_item").rows[ind].cells[1].innerHTML;
    var newInv = JSON.parse(GenerateNewInv(comp_id));
    
    if(newInv !== null){
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function(e){
            if(this.readyState === 4 && this.status === 200){
                var resp = JSON.parse(this.responseText);

                if(resp.Result === "true"){
                    alert("Invoice added.");
                    window.location.reload();
                }
                else{
                    alert("Invoice not added, please contact with administrator.");
                }
            }
        };

        xmlhttp.open("POST", "/WBServices/QuotationToInvoice_Resp.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("CreateData="+JSON.stringify({"Qt_Id":rl_qt_id, "Comp_Id":comp_id, "New_Inv":newInv.NewTaxInv }));
    }
}

function GenerateNewInv(comp_id){
    var xmlhttp = new XMLHttpRequest();
            
    xmlhttp.onreadystatechange = function(e){
        if(this.readyState === 4 && this.status === 200){
            
            return this.responseText;
        }
    };

    xmlhttp.open("POST", "/WBServices/InvoiceNo_Generator_Resp.php", false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Inputs="+JSON.stringify({"Comp_Id":comp_id}));
    
    return xmlhttp.onreadystatechange();
}