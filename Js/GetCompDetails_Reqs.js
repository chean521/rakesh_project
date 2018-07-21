
function GetCompanyDetails(){
        
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function(){
        if(this.readyState === 4 && this.status === 200){
            var data = JSON.parse(this.responseText);
            var result = [];
            
            for(var i=0; i<data.length; i++){
                var tmp = [];
                tmp.push((i+1));
                tmp.push(data[i]["CompanyName"]+" ("+data[i]["CompanyReg"] + ")");
                tmp.push(data[i]["Address"]+", "+data[i]["City"]+","+data[i]["Postal"]+"&nbsp;"+data[i]["State"]+", "+data[i]["Country"]);
                tmp.push(data[i]["CompanyEmail"]);
                tmp.push(data[i]["ContactPhone"] + "&nbsp;(Ext. " + data[i]["Extension"] + ")");
                
                result.push(tmp);
            }
                
            return result;
        }
    };
    
    xmlhttp.open("POST", "/WBServices/GetCompDetails_Resp.php", false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send();
    
    return xmlhttp.onreadystatechange();
}