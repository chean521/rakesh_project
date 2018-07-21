
function GetEditDetails_Customer(pid, custId){
    
    var ind = custId.parentNode.parentNode.rowIndex;
    
    var cus = document.getElementById("Customer_Details").rows[ind].cells[0].innerHTML;
    
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function(){

        if(this.readyState === 4 && this.status === 200){
            var Resp = JSON.parse(this.responseText);

            $('#Edit_CustomerID').val(Resp[0].substr(7));
            $('#Edit_CustomerName').val(Resp[1]);
            $('#Edit_SSMRegNo').val(Resp[2]);
            $('#Edit_address').val(Resp[3]);
            $('#Edit_City').val(Resp[4]);
            $('#Edit_Postal').val(Resp[5]);
            $('#Edit_State').val(Resp[6]);
            $('#Edit_Country').val(Resp[7]);
            $('#Edit_TaxCode').val(Resp[11]);
            $('#Edit_Contact').val(Resp[8]);
            $('#Edit_Extension').val(Resp[9]);
            $('#Edit_Email').val(Resp[10]);
        }
    };

    xmlhttp.open("POST", "/WBServices/GetEditCustomerDetails_Resp.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("inputs="+JSON.stringify({"CompanyId" : pid, "CustomerId": cus}));
    
}

