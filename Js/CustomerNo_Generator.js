
function GenerateCustomer(CompanyId){
    
    var xmlhttp = new XMLHttpRequest();
            
    xmlhttp.onreadystatechange = function(e){
        if(this.readyState === 4 && this.status === 200){
            return this.responseText;
        }
    };

    xmlhttp.open("POST", "/WBServices/CustomerNo_Generator.php", false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("Inputs="+JSON.stringify({"Comp_Id":CompanyId}));
    
    return xmlhttp.onreadystatechange();
}