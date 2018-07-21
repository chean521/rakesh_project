<?php 
require ("../../Base/Header4_Master/Session2_Master.php");

$PageTitle = "Picture Settings - Veeco Tech Invoice System";
$ActivePage = 4.1;
?> 

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require ("../../Base/Header4_Master/Header_Master.php"); ?> 
    <script src="../../Js/FileUpload_System.js"></script>
    <style type="text/css">
        .cont-over{
            max-height: 660px; 
            display: block; 
            overflow-y: hidden; 
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            background-color: rgba(124, 124, 124, 0.4);
            padding: 15px 15px 15px 15px;
        }
        
    </style>
    
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
            <h1 class="m-0 text-dark">Company Picture Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Settings</li>
              <li class="breadcrumb-item active">Picture Update</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
   <div class="container-fluid" >
       <form method="post" action="" enctype="multipart/form-data" name="form_file_upload" >
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <h3 align="center">Profile Picture Update</h3><br />
                    <div class="container cont-over" align="center">
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                <h5 style="font-weight: bold; color:white; text-shadow: 2px 2px 8px black;">Company Logo</h5>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                <img src="<?php echo $PhotoURL; ?>" alt="Profile Picture" class="img-thumbnail" width="140px" height="140px" />
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="box_file" class="control-label">Upload New Picture: </label>
                                    <input type="file" name="<?php echo FileConfigure::$FILE_VAR; ?>" id="<?php echo FileConfigure::$FILE_VAR; ?>" required accept="image/*" />
                                </div>
                                <div style="color: red;font-family: sans-serif;">**Max 2MB photo size.</div>
                                <button type="button" class="btn btn-outline-primary" style="margin-top: 20px;" onclick="UploadFile('form_file_upload');" >UPLOAD</button>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </div>
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
