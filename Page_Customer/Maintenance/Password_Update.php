<?php 
require ("../../Base/Header4_Master/Session2_Master.php");

$PageTitle = "Password Settings - Veeco Tech Invoice System";
$ActivePage = 4.3;
?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require ("../../Base/Header4_Master/Header_Master.php"); ?> 
    <script src="../../Lib/realperson_captcha/jquery.plugin.js"></script>
    <script src="../../Lib/realperson_captcha/jquery.realperson.js"></script>
    <script src="../../Lib/PasswordStrength/password.js"></script>
    <link rel="stylesheet" href="../../Lib/PasswordStrength/password.css" />
    <link rel="stylesheet" href="../../Lib/realperson_captcha/jquery.realperson.css"/> 
    <link rel="stylesheet" href="../../Styles/Glyphicon.css" />
    <style type="text/css">
        .pan_cont{
            background-color: rgba(76, 246, 255, 0.5);
            padding: 30px 20px 30px 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        
        .pan_cont .pan_text{
            font-family: sans-serif;
        }
        
        .pan_space{
            margin-top: 30px;
        }
        
    </style>
    <script type="text/javascript">
        var cap = null;
        
        $(document).ready(function(e){
            cap = $('#captcha_box').realperson({
                length: 8,
                chars: $.realperson.alphanumeric
            });
        });
        
        $(document).ready(function(e){
            $('#pass_new').password({
                shortPass: 'The password is too short',
                badPass: 'Weak; try combining letters & numbers',
                goodPass: 'Medium; try using special charecters',
                strongPass: 'Strong password',
                containsUsername: 'The password contains the username',
                enterPass: 'Type your password',
                showPercent: true,
                showText: true, // shows the text tips
                animate: true, // whether or not to animate the progress bar on input blur/focus
                animateSpeed: 'slow', // the above animation speed
                username: false, // select the username field (selector or jQuery instance) for better password checks
                usernamePartialMatch: true, // whether to check for username partials
                minimumLength: 5
            });
        });
        
        function CurrPassView(){
            $('#pass_curr').prop("type", "text");
        }
        
        function CurrPassNorm(){
            $('#pass_curr').prop("type", "password");
        }
        
        function NewPassView(){
            $('#pass_new').prop("type", "text");
        }
        
        function NewPassNorm(){
            $('#pass_new').prop("type", "password");
        }
        
        function SubmitNewPass(){
            
            if(ValidateHash() === false) { alert("Invalid captcha!"); $('#realperson-regen').click(); $('#captcha_code').focus(); return;}
            
            if(ValidateCurrentPwd() === false) { alert("Invalid current password!"); $('#pass_curr').focus(); return;}
            
            if(ValidateConfirmPwd() === false) { alert("Invalid confirmation password!"); $('#pass_conf').focus(); return;}
            
            if(confirm("Are you sure want to change password?") === false) return;
            
            var newpwd = $('#pass_new').val();
            
            var xmlhttp = new XMLHttpRequest();
            
            xmlhttp.onreadystatechange = function(e){
                if(this.readyState === 4 && this.status === 200){
                    var res = JSON.parse(this.responseText);
                    
                    if(res.Result === true){
                        alert("Password changed, you will be logged out!");
                        window.open("../../UserManage/LogOut.php","_self");
                    }
                }
            };

            xmlhttp.open("POST", "/WBServices/ChangePwd_Resp.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("items="+JSON.stringify({"NewPwd":newpwd, "loginId": <?php echo $Sess_UserID; ?>}));
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
        
        function ValidateCurrentPwd(){
            
            var StockVal = $('#pass_curr').val();
            
            var xmlhttp = new XMLHttpRequest();
            
            xmlhttp.onreadystatechange = function(e){
                if(this.readyState === 4 && this.status === 200){
                    return this.responseText;
                }
            };

            xmlhttp.open("POST", "/WBServices/CurrPass_Validate.php", false);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("data_sec="+JSON.stringify({"UserId":<?php echo $Sess_UserID; ?>, "StockVal": StockVal}));

            var Result = JSON.parse(xmlhttp.onreadystatechange());
            
            return Result.Result;
        }
        
        function ValidateConfirmPwd(){
            var newpwd = $('#pass_new').val();
            var confpwd = $('#pass_conf').val();
            
            return (newpwd === confpwd);
        }
        
    </script>
  </head>

  <body class="hold-transition sidebar-mini">
  <div class="wrapper">
  <!-- Navbar -->
  <?php require ("../../Base/Header4_Master/Menubar_Master.php"); ?> 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Password Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Settings</li>
              <li class="breadcrumb-item active">Passowrd Update</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
   <div class="container-fluid" >
       <div class="row">
           <div class="col-md-4"></div>
           <div class="col-md-4" align="center" >
               <h4 style="font-family:sans-serif;">Change Password</h4>
           </div>
           <div class="col-md-4"></div>
       </div>
       <div class="row pan_space">
           <div class="col-md-4"></div>
           <div class="col-md-4 pan_cont">
               <form id="form_pwd" autocomplete="off" method="post" >
                    <div class="form-group">
                        <label class="control-label" for="unique_userid">Unique User ID:</label>
                        <input type="text" class="form-control" id="unique_userid" name="unique_userid" value="<?php echo $Sess_UserID; ?>" readonly />
                    </div>
                    <div class="form-group">
                       <label class="control-label" for="pass_curr">Current Password:&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open" onmouseover="CurrPassView()" onmouseout="CurrPassNorm()"></span></label>
                        <input type="password" class="form-control" id="pass_curr" placeholder="Current Password" name="pass_curr" maxlength="30"/>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="control-label" for="pass_new">New Password:&nbsp;&nbsp;<span class="glyphicon glyphicon-eye-open" onmouseover="NewPassView()" onmouseout="NewPassNorm()"></span></label>
                        <input type="password" class="form-control" id="pass_new" placeholder="New Password" name="pass_new" maxlength="30"/>
                    </div>
                   <div class="form-group">
                        <label class="control-label" for="pass_conf">Confirm New Password:</label>
                        <input type="password" class="form-control" id="pass_conf" placeholder="Confirm New Password" name="pass_conf" maxlength="30"/>
                    </div>
                   <div class="form-group">
                        <label class="control-label" for="captcha_code">Please input this:</label>
                        <div class="input-group">
                            <div class="col-md-1" id="captcha_box"></div>
                            <input type="text" class="form-control col-md-11" id="captcha_code" placeholder="Insert captcha here" name="captcha_code" maxlength="8"/>
                        </div>
                    </div>
               </form>
           </div>
           <div class="col-md-4"></div>
       </div>
       <div class="row pan_space">
           <div class="col-md-4"></div>
           <div class="col-md-4" align="center">
               <button type="button" class="btn btn-outline-primary btn_set" id="btn_Submit" onclick="SubmitNewPass();">Change Password</button>
           </div>
           <div class="col-md-4">
           </div>
       </div>
   </div>
  </div>
  
  
   <?php require ("../../Base/Header4_Master/Footer_Master.php"); ?> 

    </div>
   <?php require ("../../Base/Header4_Master/Scripts_Master.php"); ?> 
  </body>
</html>
