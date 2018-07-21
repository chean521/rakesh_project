function GetCustomerDetailList(pid, compiled){
    
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function(){

        if(this.readyState === 4 && this.status === 200){
            var Resp = JSON.parse(this.responseText);

            document.getElementById("CustomerName").value = Resp[0];
            document.getElementById("SSMRegNo").value = Resp[1];
            document.getElementById("taxCode").value = Resp[2];
        }
    };

    xmlhttp.open("POST", "/WBServices/GetCompCust_Inf_Resp.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("inputs="+JSON.stringify({"c_id" : pid, "u_id": compiled}));
    
}