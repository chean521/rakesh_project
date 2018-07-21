

function EditQuotation(comp_id){
    var Compiled_Details = {"CompanyId": comp_id, "Qt_No": $("#Qt_Edit_No").val()};
    var Compiled_Desc = [];
    var isFormMissing = false;
    
    var Row_Size = document.getElementById("qt_edit_Desc_Container").rows.length;
    
    for(var i=1; i<Row_Size; i++){
        var ProductCode = document.getElementById("qt_edit_Desc_Container").rows[i].cells[0].querySelector("input").value;
        var Quantity = document.getElementById("qt_edit_Desc_Container").rows[i].cells[1].querySelector("input").value;
        
        Compiled_Desc.push({"ProductCode":ProductCode, "Quantity": Quantity});
    }
    
    if(Compiled_Desc.length === 0){
        document.getElementById("qt_edit_panel_desc").classList.remove("panel-primary");
        document.getElementById("qt_edit_panel_desc").classList.add("panel-danger");
        isFormMissing = true;
    }
    else{
        for(var i=0; i<Compiled_Desc.length; i++){
            if(Compiled_Desc[i].ProductCode === "") { 
                document.getElementById("qt_edit_Desc_Container").rows[i+1].cells[0].querySelector("input").style.backgroundColor = "red";
                isFormMissing = true;
            }

            if(Compiled_Desc[i].Quantity === ""){
                document.getElementById("qt_edit_Desc_Container").rows[i+1].cells[1].querySelector("input").style.backgroundColor = "red";
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
        
            var xmlhttp = new XMLHttpRequest();
            
            xmlhttp.onreadystatechange = function(e){
                if(this.readyState === 4 && this.status === 200){
                    var resp = JSON.parse(this.responseText);
                    
                    if(resp.Result === "true"){
                        alert("Quotation edited.");
                        window.location.reload();
                    }
                    else{
                        alert("Quotation not edited, please contact with administrator.");
                    }
                }
            };
            
            xmlhttp.open("POST", "/WBServices/EditQuotationSubmit_Resp.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("CreateData="+JSON.stringify({"Compiled_Details":Compiled_Details, "Compiled_Desc":Compiled_Desc }));
        }
        else{
            return;
        }
    }
}