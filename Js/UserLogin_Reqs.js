function List_SendRequest(cp2)
{
    var UserId = document.getElementById("user_id");
    var Pwd = document.getElementById("pass");
    
    var error = false;
    
    if(UserId.value === null || UserId.value === ""){
        UserId.style.backgroundColor = "Red";
        error = true;
    }
    
    if(Pwd.value === null || Pwd.value === ""){
        Pwd.style.backgroundColor = "Red";
        error = true;
    }
    
    if(error === true){
        alert("Input error, please input again.");
        return;
    }
    
    if(ValidateCapHash(cp2) === false){
        alert("Captcha error, please input again.");
        return;
    }
    
    var encode = JSON.stringify({"UserID":UserId.value, "UserPw":Pwd.value});
    
    UserId.value = "";
    Pwd.value = "";
    
    var xmlhttp = new XMLHttpRequest();
    
    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var data = JSON.parse(this.responseText);
            
            if(data.Result === "true"){
                
                if(data.FirstLogin === 1){
                    window.open("UserManage/First_Landing.php", "_self");
                }
                else{
                    window.location.reload();
                }
            }
            else{
                alert("Invalid combination of User ID and Password, please try again.");
                UserId.style.backgroundColor = "Red";
                Pwd.style.backgroundColor = "Red";
            }
        }
    };
    
    xmlhttp.open("POST", "/WBServices/UserLogin_Resp.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("inf=" + encode);
}
    

$(document).ready(function(e){
    $('#user_id').keyup(function(c){
        $(this).css("background-color", "white");
    });
    $('#pass').keyup(function(c){
        $(this).css("background-color", "white");
    });
});

function ValidateCapHash(cp){
    var HashedCap = cp.realperson('getHash');
    var StockVal = $('#log_captcha_code').val();

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function(e){
        if(this.readyState === 4 && this.status === 200){
            return this.responseText;
        }
    };

    xmlhttp.open("POST", "/WBServices/Captcha_Validation.php", false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("captcha="+JSON.stringify({"cap_data":HashedCap, "StockVal": StockVal}));

    var Result = JSON.parse(xmlhttp.onreadystatechange());

    return Result.Result;
}