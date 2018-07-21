
function SubmitQuotation_Statement(CompanyId){
    var InvoiceId = $('#InvoiceNo');
    var InvoiceDate = $('#InvoiceDate');
    var CustomerID = $('#CustomerID');
    var Terms = $('#Terms');
    var Currency = $('#Currency');
    var AttnName = $('#AttnName');
    var GrandTotal = $('#grand_total');
    
    var Compiled_Details = [], Compiled_Desc = [];
    var isFormMissing = false;
    
    var Row_Size = document.getElementById("Desc_Container").rows.length;
    
    for(var i=1; i<Row_Size; i++){
        var ProductCode = document.getElementById("Desc_Container").rows[i].cells[0].querySelector("input").value;
        var Quantity = document.getElementById("Desc_Container").rows[i].cells[1].querySelector("input").value;
        
        Compiled_Desc.push({"ProductCode":ProductCode, "Quantity": Quantity});
    }
    
    if(InvoiceDate.val().length === 0) { InvoiceDate.css("background-color","red"); isFormMissing = true; }
    if(CustomerID.val().length === 0) { CustomerID.css("background-color","red"); isFormMissing = true; }
    if(Currency.val() === 'none') { Currency.css("background-color", "red"); isFormMissing = true; }
    if(Terms.val() === 'none') { Terms.css("background-color", "red"); isFormMissing = true;}
    if(AttnName.val().length === 0) { AttnName.css("background-color", "red"); isFormMissing = true; }
    
    if(Compiled_Desc.length === 0){
        document.getElementById("panel_desc").classList.remove("panel-primary");
        document.getElementById("panel_desc").classList.add("panel-danger");
        isFormMissing = true;
    }
    else{
        for(var i=0; i<Compiled_Desc.length; i++){
            if(Compiled_Desc[i].ProductCode === "") { 
                document.getElementById("Desc_Container").rows[i+1].cells[0].querySelector("input").style.backgroundColor = "red";
                isFormMissing = true;
            }

            if(Compiled_Desc[i].Quantity === ""){
                document.getElementById("Desc_Container").rows[i+1].cells[1].querySelector("input").style.backgroundColor = "red";
                isFormMissing = true;
            }
        }
    }
    if(isFormMissing === true){
        alert("Input missing, please check the required empty fields!");
        return;
    }
    else{
        var conf = confirm("Are you sure want to proceed?");
        
        if(conf === true){
            Compiled_Details.push(InvoiceId.val());
            Compiled_Details.push(InvoiceDate.val());
            Compiled_Details.push(CompanyId + "_" + CustomerID.val());
            Compiled_Details.push(Terms.val());
            Compiled_Details.push(Currency.val());
            Compiled_Details.push(AttnName.val());
            Compiled_Details.push(CompanyId);
            Compiled_Details.push(GrandTotal.html());
        
            var xmlhttp = new XMLHttpRequest();
            
            xmlhttp.onreadystatechange = function(e){
                if(this.readyState === 4 && this.status === 200){
                    var resp = JSON.parse(this.responseText);
                    
                    if(resp.Result === "true"){
                        alert("Quotation created.");
                        window.location.reload();
                    }
                    else{
                        alert("Quotation not created, please contact with administrator.");
                    }
                }
            };
            
            xmlhttp.open("POST", "/WBServices/NewQuotationSubmit_Resp.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("CreateData="+JSON.stringify({"Compiled_Details":Compiled_Details, "Compiled_Desc":Compiled_Desc }));
        }
        else{
            return;
        }
    }
}

function ReleaseWhite(controls){
    controls.style.backgroundColor = "white";
}

function ReleasePanel(){
    document.getElementById("panel_desc").classList.remove("panel-danger");
    document.getElementById("panel_desc").classList.add("panel-primary");
}
