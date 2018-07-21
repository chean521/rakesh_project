<?php
require ("../Engines/SessionManager.php");

$Session = new SessionManager();
$Session->StartSession();
$Session->CreateSession();

$Sess_Status = $Session->GetSession("Login_Status");
$Sess_UserID = $Session->GetSession("Login_ID");
$Sess_Admin = $Session->GetSession("Login_IsAdmin");

if($Sess_Status == NULL || $Sess_Status == 0){
    header("Location: ../index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title>Set Up New Account - Veeco Tech Invoice System</title>
        <script src="../Lib/jquery/jquery_v3.js"></script>
        <link rel="stylesheet" href="../Lib/bootstrap-3.3.7-dist/css/bootstrap.css" />
        <script src="../Lib/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="../Styles/Scrolls.css" />
        
        <style type="text/css">
            .video-background {
                position: fixed;
                right: 0;
                bottom: 0;
                min-width: 100%;
                min-height: 100%;
                width: auto;
                height: auto;
                z-index: -100; 
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;       
             }
             
             .pimg1{
                position: relative;
                opacity: 1;
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;

                background-attachment: fixed;
            }
            
            .pimg1 {
                background-color: transparent;
            }
            
            .word_white{
                color: #FFFFFF;
            }

        </style>
        <script type="text/javascript">
            $(document).ready(function(e){
                var al_msg = "Please read carefully before proceeding:\n";
                    al_msg += "1. You pressed 'OK' means you agreed our terms and condition.\n";
                    al_msg += "2. Your personal & company data are covered under PDPA Act 2012.\n";
                    al_msg += "3. Offence words are not allowed inside our premises.\n";
                    al_msg += "4. Please fill in the details in required fields.\n";
                    al_msg += "5. Please report to administrator if any problem arises.\n";
                    al_msg += "\n";
                    al_msg += "Thanks for your cooperation with us.";
                
                if(confirm(al_msg) === false){
                    window.open("../index.php","_self");
                }
            });
            
            function FormValidation(){
                
                var docs_pkg = document.forms[0];
                
                var isError = false;
                
                for(var i=0; i<docs_pkg.length; i++){
                    if(i !== 10 || i !== 11 || i !== 12){
                        if(docs_pkg.elements[i].value.length === 0){
                            isError = true;
                        }
                    }
                }
                
                if(isError === true){ alert("Invalid input, please input again."); return false; }
                
                if($('#State option:selected').val() === "none") { alert("Invalid input, please input again."); return false; }
                
                if(confirm("Are you sure want to submit, once submitted can be undone.") === false) return false;
                
                var DataPack = [];
                
                for(var i=0; i<docs_pkg.length; i++){
                    DataPack.push(docs_pkg.elements[i].value);
                }
                
                DataPack.push(<?php echo $Sess_UserID;?>);
                
                DataPack[9] = '+60'+DataPack[9];
                DataPack[11] = '+60'+DataPack[11];
                DataPack[12] = '+60'+DataPack[12];
                
                var xmlhttp = new XMLHttpRequest();
                
                xmlhttp.onreadystatechange = function(){
                    if(this.readyState === 4 && this.status === 200){
                        var data = JSON.parse(this.responseText);
                        
                        if(data.Result === "true"){
                            alert("First setup made successfully, you will been logged out!");
                            window.open("../UserManage/LogOut.php", "_self");
                        }
                        else{
                            alert("Data error!");
                        }
                    }
                };

                xmlhttp.open("POST", "/WBServices/AddNewCompany_Resp.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("Pack=" + JSON.stringify({"DataPack":DataPack}));
                
                return false;
            }
            
            function toUp(input){
                input.value = input.value.toUpperCase();
            }
        </script>
    </head>
    <body>
        <div class ="pimg1">
  
            <video autoplay loop class="video-background" muted plays-inline >
                <source src ="../video/4k background footage (ideal for Blockchain Website).mp4" type="video/mp4"
            </video> 
               
        </div>
        <div class="container-fluid" style="z-index:9999; position: absolute; top: 0;">
            <div class="row" style="margin-top: 40px;">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-primary" style="background-color: rgba(255,255,255,0.4)">
                        <div class="panel-heading" style="background-color: rgba(51, 122, 183,0.5)" >
                            <strong class="panel-title">Set Up Account</strong>
                        </div>
                        <div class="panel-body">
                            <strong style="color:red"><i>* Required fields</i></strong>
                            <form method="post" autocomplete="off" class="form-horizontal" onsubmit="return FormValidation();" id="form_add" name="form_add">
                                 <div class="form-group">
                                    <label class="control-label col-md-3 word_white" for="companyName"><strong style="color:red">*</strong> Company Name: </label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="Company_Name" maxlength="25" placeholder="Company Name"/>
                                    </div>
                                 </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 word_white" for="companyName"><strong style="color:red">*</strong> Business Registration No:</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="SSM_Reg" maxlength="15" placeholder="SSM Registration No"/>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="control-label col-md-3 word_white" for="Add"><strong style="color:red">*</strong> Address:</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" id="Address" placeholder="Enter Address" name="Address" style="min-height: 60px;" maxlength="60" ></textarea>
                                    </div>
                                 </div>

                                 <div class="form-group">
                                     <div class="col-md-6">
                                        <label class="control-label col-md-6 word_white" for="city"><strong style="color:red">*</strong> Postal Code / City</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="zip" placeholder="Postal/Zip" name="zip" maxlength="5" onfocus=""/>
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="col-md-12">
                                            <input type="text" class="form-control" id="city" placeholder="City" name="city" maxlength="30" onfocus="" />
                                         </div>
                                     </div>

                                 </div>

                                 <div class="form-group">
                                    <label for="state" class="control-label col-md-3 word_white"><strong style="color:red">*</strong> Province/State:</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="State" name="State" onfocus="">
                                            <option value="none" selected="selected">Please select</option>
                                            <option value="Johor Darul Ta'zim">Johor Darul Ta'zim</option>
                                            <option value="Kedah Darul Aman">Kedah Darul Aman</option>
                                            <option value="Kelantan Darul Naim">Kelantan Darul Naim</option>
                                            <option value="Kuala Lumpur">Kuala Lumpur</option>
                                            <option value="Labuan">Labuan</option>
                                            <option value="Malacca">Malacca</option>
                                            <option value="Negeri Sembilan Darul Khusus">Negeri Sembilan Darul Khusus</option>
                                            <option value="Pahang Darul Makmur">Pahang Darul Makmur</option>
                                            <option value="Pulau Pinang">Pulau Pinang</option>
                                            <option value="Perak Darul Ridzuan">Perak Darul Ridzuan</option>
                                            <option value="Perlis Indera Kayangan">Perlis Indera Kayangan</option>
                                            <option value="Putrajaya">Putrajaya</option>
                                            <option value="Sabah">Sabah</option>
                                            <option value="Sarawak">Sarawak</option>
                                            <option value="Selangor Darul Ehsan">Selangor Darul Ehsan</option>
                                            <option value="Terengganu Darul Iman">Terengganu Darul Iman</option>
                                        </select>
                                    </div>
                                 </div>

                                <div class="form-group" onfocus="">
                                    <label for="email" class="control-label col-md-3 word_white"><strong style="color:red">*</strong> Email:</label>
                                    <div class="col-md-9">
                                        <input type="email" id="email" class="form-control" name="emails" maxlength="30" placeholder="Your company email address"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="country" class="control-label col-md-3 word_white"><strong style="color:red">*</strong> Country:</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="Country" disabled="disabled">
                                            <option selected="selected" value="Malaysia">Malaysia</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group" onfocus="">
                                    <label class="control-label col-md-3 word_white" for="phNB"><strong style="color:red">*</strong> Phone:</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon">+60</span>
                                            <input type="phone" class="form-control col-md-9" id="phNB" placeholder="Enter Phone Number" name="phNB" maxlength="12"/>
                                            <div class="input-group-btn">
                                                <input type="text" maxlength="3" id="phone_EXT" class="form-control" style="width: 100px" placeholder="Ext No" name="phone_EXT" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 word_white" for="Fax">Fax:</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon">+60</span>
                                            <input type="fax" class="form-control col-md-11" id="Fax" placeholder="Enter FAX" name="Fax" maxlength="12" value="xx-xxxxxxx"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 word_white" for="mobNB">Mobile:</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <span class="input-group-addon">+60</span>
                                            <input type="mobile" class="form-control" id="mobNB" placeholder="Enter Mobile Number" name="mobNB" maxlength="12" value="xx-xxxxxxx" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 word_white" for="web">Website:</label>
                                    <div class="col-md-9">
                                        <input type="website" class="form-control" id="web" placeholder="Enter Website" name="web" maxlength="300" value="http://some.examples.tld"/>
                                    </div>
                                </div>
                                <hr />
                                <h5 style="font-weight:bold;color:#e4ff38" align="center"><i class="glyphicon glyphicon-warning-sign"></i> NOTICE: THESE BELOW SETTINGS ARE ABLE TO SET ONCE ONLY. ONCE SET CAN'T UNDONE.</h5>
                                <div class="form-group">
                                    <label for="pref_Inv" class="control-label col-md-3 word_white"><strong style="color:red">*</strong> Invoice Prefix</label>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="4" id="pref_Inv" class="form-control" placeholder="Invoice Prefix (Min 2, Max 4 alphabet allowed)" onblur="toUp(this);" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pref_Qt" class="control-label col-md-3 word_white"><strong style="color:red">*</strong> Quotation Prefix</label>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="4" id="pref_Qt" class="form-control" placeholder="Quotation Prefix (Min 2, Max 4 alphabet allowed)" onblur="toUp(this);" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pref_Rec" class="control-label col-md-3 word_white"><strong style="color:red">*</strong> Receipt Prefix</label>
                                    <div class="col-md-8">
                                        <input type="text" maxlength="4" id="pref_Rec" class="form-control" placeholder="Receipt Prefix (Min 2, Max 4 alphabet allowed)" onblur="toUp(this);" />
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                        <div class="panel-footer" style="background-color: rgba(181, 181, 181,0.5)" >
                            <div class="text-right">
                                <button type="button" class="btn btn-primary" style="background-color:rgba(21, 0, 255, 0.4)" onclick="$('#form_add').submit();">Process Now</button>
                                <button type="button" class="btn btn-danger" style="background-color:rgba(252, 5, 5, 0.4)" onclick="window.open('../index.php','_self');">Close This Form</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        
    </body>
    
</html>