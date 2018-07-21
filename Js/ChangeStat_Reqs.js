
function ChangeStat(compId){
    
    var Stat = $('#ddl_Status option:selected').val();
    
    if(Stat === "none"){
        alert("Incorrect option select, please select again!");
        $('#ddl_Status').css("background-color", "red");
        return;
    }
    
    if(confirm("Are you sure want to proceed?") === false){
        return;
    }
    
    var custId = document.getElementById("edit_tg_cust").innerHTML.substr(0,4);
    
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function(){

        if(this.readyState === 4 && this.status === 200){
            var Resp = JSON.parse(this.responseText);

            if(Resp.Result === "true"){
                alert("Status changed.");
                window.location.reload();
            }
            else{
                alert("Status unchanged. Please seek administrator");
            }
        }
    };

    xmlhttp.open("POST", "/WBServices/ChangeStat_Resp.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("inputs="+JSON.stringify({"CustomerId" : custId, "CompanyId": compId, "Status": Stat}));
    
}

function CleanRed(select){
    select.style.backgroundColor = "white";
}

