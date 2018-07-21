<?php 
require ("../../Base/Header4_Master/Session2_Master.php");

$PageTitle = "Update Profile - Veeco Tech Invoice System";
$ActivePage = 4.2;
?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require ("../../Base/Header4_Master/Header_Master.php"); ?> 
    <style type="text/css">
        .cont-over{
            max-height: 660px; 
            display: block; 
            overflow-y: scroll; 
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            background-color: rgba(124, 124, 124, 0.4);
            padding: 15px 15px 15px 15px;
        }
        
        .btn_set{
            float: right;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(e){
            
            var xmlhttp = new XMLHttpRequest();
            
            xmlhttp.onreadystatechange = function(e){
                if(this.readyState === 4 && this.status === 200){
                    var data = JSON.parse(this.responseText);
                    
                    var forms = document.getElementById("form_comp_update");
                    
                    forms.Company_Name.value = data[1];
                    forms.SSM_Reg.value = data[2];
                    forms.Address.value = data[3];
                    forms.zip.value = data[6];
                    forms.city.value = data[4];
                    forms.State.value = data[5];
                    forms.phNB.value = data[10].substr(3);
                    forms.phone_EXT.value = data[15];
                    forms.Fax.value = data[14].substr(3);
                    forms.mobNB.value = data[9];
                    forms.web.value = data[17];
                    forms.email.value = data[8];
                }
            };
            
            xmlhttp.open("POST", "/WBServices/GetCompDetails_Single_Resp.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("datas="+JSON.stringify({"Pid" : <?php echo $Sess_UserID; ?>}));
        });
        
        function UpdateValidation(){
            var isError = false;
            
            var forms = document.getElementById("form_comp_update");
            
            if(forms.Address.value.length < 5) { isError = true; forms.Address.style.backgroundColor = "red"; }
            if(forms.zip.value.length !== 5) { isError = true; forms.zip.style.backgroundColor = "red"; }
            if(forms.city.value.length < 3) { isError = true; forms.city.style.backgroundColor = "red"; }
            if(forms.State.value === "none") { isError = true; forms.State.style.backgroundColor = "red"; }
            if(forms.phNB.value.length < 7) { isError = true; forms.phNB.style.backgroundColor = "red"; }
            if(forms.email.value.length < 10) { isError = true; forms.email.style.backgroundColor = "red"; }
                        
            if(isError === true){
                alert("Invalid input, please input again!");
                return false;
            }
            else{
                if(confirm("Are you sure want to proceed changes?") === false){
                    return false;
                }
            }
        }
        
        function SetWhite(input){
            input.style.backgroundColor = "white";
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
            <h1 class="m-0 text-dark">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Settings</li>
              <li class="breadcrumb-item active">Profile Update</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
   <div class="container-fluid" >
       <form method="post" action="CompanyEdit_SubmitPOST.php" autocomplete="off" id="form_comp_update" onsubmit="return UpdateValidation();">
       <div class="row">
           <div class="col-md-1"></div>
           <div class="col-md-10">
               <h3 align="center">Company Profile Update</h3><br />
               <div class="container cont-over">
                 
                     <div class="form-group">
                        <label class="control-label" for="companyName">Company Name / Business Registration No:</label>
                        <div class="input-group">
                            <input type="text" class="form-control col-md-8" id="Company_Name" readonly/>
                            <input type="text" class="form-control col-md-4" id="SSM_Reg" readonly/>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="control-label" for="Add">Addres:</label>
                        <textarea class="form-control" id="Address" placeholder="Enter Address" name="Address" style="min-height: 40px;" maxlength="60" ></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="city">Postal Code / City:</label>
                        <div class="input-group">
                            <input type="text" class="form-control col-md-3" id="zip" placeholder="Postal/Zip" name="zip" maxlength="5" onfocus="SetWhite(this);"/>
                            <input type="text" class="form-control col-md-9" id="city" placeholder="City" name="city" maxlength="30" onfocus="SetWhite(this);" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="state" class="control-label">Province/State:</label>
                        <select class="form-control" id="State" name="State" onfocus="SetWhite(this);">
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
                   
                   <div class="form-group" onfocus="SetWhite(this);">
                        <label for="email" class="control-label">Email:</label>
                        <input type="email" id="email" class="form-control" name="emails" maxlength="30"/>
                    </div>

                    <div class="form-group">
                        <label for="country" class="control-label">Country:</label>
                        <select class="form-control" id="Country" disabled="disabled">
                            <option selected="selected" value="Malaysia">Malaysia</option>
                        </select>
                    </div>

                    <div class="form-group" onfocus="SetWhite(this);">
                        <label class="control-label" for="phNB">Phone:</label>
                        <div class="input-group">
                            <input type="text" disabled="disabled" id="AreaCode" class="form-control col-md-1" name="AreaCode" value="+60" />
                            <input type="phone" class="form-control col-md-9" id="phNB" placeholder="Enter Phone Number" name="phNB"/>
                            <input type="text" maxlength="3" id="phone_EXT" class="form-control col-md-2" placeholder="Ext No" name="phone_EXT" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="Fax">Fax:</label>
                        <div class="input-group">
                            <input type="text" disabled="disabled" id="AreaCode" class="form-control col-md-1" name="AreaCode" value="+60" maxlength="12" />
                            <input type="fax" class="form-control col-md-11" id="Fax" placeholder="Enter FAX" name="Fax"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="mobNB">Mobile:</label>
                        <input type="mobile" class="form-control" id="mobNB" placeholder="Enter Mobile Number" name="mobNB" maxlength="12"/>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="web">Website:</label>
                        <input type="website" class="form-control" id="web" placeholder="Enter Website" name="web" maxlength="300"/>
                    </div>
                     
               </div>
           </div>
           <div class="col-md-1"></div>
       </div>
       <div class="row">
           <div class="col-md-1"></div>
           <div class="col-md-10">
               <button type="submit" class="btn btn-outline-primary btn_set" id="btn_Submit" style="margin-top: 15px;margin-right: 120px;">Update Profile Information</button>
           </div>
           <div class="col-md-1"></div>
       </div>
   </form>
   </div>
  </div>

   <?php require ("../../Base/Header4_Master/Footer_Master.php"); ?> 

</div>
   <?php require ("../../Base/Header4_Master/Scripts_Master.php"); ?> 
  </body>
</html>
