
function GetProductList(pid){
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function(){
        
        if(this.readyState === 4 && this.status === 200){
            var Res = JSON.parse(this.responseText);
            
            var html_string = "";
            
            if(this.responseText === "[]"){
                html_string += '<tr>';
                html_string += '<td colspan="8" class="text-center"><span class="text-danger">No Product Added.</span></td>';
                html_string += '</tr>';
            }
            else{
                
                for(var i=0; i<Res.length; i++){
                    html_string += '<tr>';
                    
                    for(var j=0; j<Res[i].length; j++){
                        if(j === Res[i].length - 1 || j === Res[i].length - 2){
                            if(j === Res[i].length - 1){
                                html_string += '<td> '+Res[i][j-1]+' - '+Res[i][j]+'</td>';
                            }
                        }
                        else{
                            html_string += '<td>'+Res[i][j]+'</td>';
                        }
                    }
                    
                    html_string += '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Update" data-whatever="@getbootstrap">EDIT</button></td>'+
                                    '<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Delete" >DELETE</button></td>';
                    html_string += '<input type="hidden" id="ProductCode_'+i+'" value="'+Res[i][0]+'" /></td>';
                    html_string += '</tr>';
                    
                }
            }
            
            document.getElementById("ProductList").innerHTML = html_string;
        }
    };
    
    xmlhttp.open("POST", "/WBServices/GetProductList_Resp.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("data="+JSON.stringify({"Pid" : pid}));
}