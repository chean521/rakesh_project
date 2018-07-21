<script type="text/javascript">
    function SubmitRegForm(){
        var UserId = $('#Reg_UserId').val();
        var PwdNew = $('#Reg_UserPw').val();
        var PwdCon = $('#Reg_ConfPw').val();
        var DispName = $('#Reg_DispName').val();
        
        if(ValidateHash() === false) { alert("Invalid captcha input!"); return; }
        if(PwdNew !== PwdCon) { alert("Invalid confirmation password!"); return; }
        if(UserId.length <= 6) { alert("Invalid user ID input!"); return; }
        if(DispName.length <= 4) { alert("Invalid display name!"); return; }
        
        if(confirm("Are you sure want to create new client account?") === false){
            return;
        }
        
        var Comp_Data = [];
        Comp_Data.push(NewPid());
        Comp_Data.push(UserId);
        Comp_Data.push(PwdNew);
        Comp_Data.push(DispName);
        
        var xmlhttp = new XMLHttpRequest();
        
        xmlhttp.onreadystatechange = function(e){
            if(this.readyState === 4 && this.status === 200){
                return this.responseText;
            }
        };

        xmlhttp.open("POST", "/WBServices/AddNewUser_Resp.php", false);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("datas=" + JSON.stringify({"DataPack":Comp_Data}));

        var Result = JSON.parse(xmlhttp.onreadystatechange());

        if(Result.Result === "true")
            alert("Account created successfully.");
        else
            alert("Account not created!");
        
        window.location.reload();
    }
    
    function NewPid(){
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function(e){
            if(this.readyState === 4 && this.status === 200){
                return this.responseText;
            }
        };

        xmlhttp.open("POST", "/WBServices/UniqueUserId_Generator.php", false);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send();

        var Result = JSON.parse(xmlhttp.onreadystatechange());

        return Result.NewPid;
    }
    
    function ValidateHash(){
        var HashedCap = cap.realperson('getHash');
        var StockVal = $('#captcha_code').val();

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
</script>    

<div id="usr_reg" class="modal fade" role="dialog" style="z-index:9999;">
    <form class="form-horizontal" id="usr_reg_form">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: rgba(56, 248, 255, 0.6);">
                <div class="modal-header" style="border-bottom:none;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"align="center" style="color:white;">Register as Client</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Reg_UserId" class="control-label col-md-4">User Name</label>
                        <div class="col-md-6">
                            <input type="text" id="Reg_UserId" class="form-control" maxlength="30" placeholder="Preferred User Name" />
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="Reg_UserPw" class="control-label col-md-4">User Passowrd</label>
                        <div class="col-md-6">
                            <input type="password" id="Reg_UserPw" class="form-control" maxlength="30" placeholder="New Password" />
                            <span class="glyphicon glyphicon-eye-open form-control-feedback" onmouseover="NewPassView();" onmouseout="NewPassNorm();"></span>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="Reg_ConfPw" class="control-label col-md-4">Confirm Passowrd</label>
                        <div class="col-md-6">
                            <input type="password" id="Reg_ConfPw" class="form-control" maxlength="30" placeholder="Confirm Typing Password" />
                            <span class="glyphicon glyphicon-eye-open form-control-feedback" onmouseover="ConfPassView();" onmouseout="ConfPassNorm();"></span>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="form-group">
                        <label for="Reg_DispName" class="control-label col-md-4">Display Name</label>
                        <div class="col-md-6">
                            <input type="text" id="Reg_DispName" class="form-control" maxlength="50" placeholder="User Display Name"/>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div align="center" id="captcha_box"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" id="captcha_code" class="form-control" maxlength="8" style="width: 66%; margin: auto; text-align: center;" placeholder="Please enter captcha!"/>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:none;">
                    <button type="button" class="btn btn-primary" onclick="SubmitRegForm();">Register</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger" >Exit</button>
                </div>
            </div>
        </div>
    </form>
</div>