<?php 
require ("../Base/Header2_Master/Session_Master.php"); 
   
$PageTitle = "Dashboard Admin - Veeco Tech Invoice System";
$PageNo = 1.0
?>

<!DOCTYPE html>
<html>
<head>
    <?php require ('../Base/Header2_Master/Header_Master.php'); ?>
    
    <script type="text/javascript">
        $(document).ready(function(e){
            var title_chart = "";
            var date = new Date();
            var Now_Mon = date.getMonth();
            var month = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
            var disp = [], set_last = 0;

            var count = Now_Mon;
            var jump_year = false;

            for(var i=6; i>0; i--){
                if(count === 0){
                    disp.push(month[count]);
                    count = 11;
                    jump_year = true;
                }
                else{
                    disp.push(month[count]);
                    set_last = count;
                    count--;
                }
            }

            if(jump_year === true){
                title_chart = "Client Registered " + month[set_last] + "&nbsp;" + (date.getFullYear()-1) + " - " + month[Now_Mon] + "&nbsp;" + date.getFullYear();
            }
            else{
                title_chart = "Client Registered " + month[Now_Mon-6] + "&nbsp;" + date.getFullYear() + " - " + month[Now_Mon] + "&nbsp;" + date.getFullYear();
            }

            var invert_disp = [];

            for(var i=(disp.length-1); i >= 0; i--){
                invert_disp.push(disp[i]);
            }
            
            var xmlhttp = new XMLHttpRequest();
            
            xmlhttp.onreadystatechange = function(e){
                
                if(this.readyState === 4 && this.status === 200){
                    var Resp = JSON.parse(this.responseText);
                    
                    return Resp;
                }
            }
            
            xmlhttp.open("POST", "/WBServices/AdminDashboard_Resp.php", false);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send();
            
            var data = xmlhttp.onreadystatechange();
            
            document.getElementById('active_user').innerHTML = data[1];
            document.getElementById('register_user').innerHTML = data[0];
            
            var invertData = [];
            
            for(var i=0; i<data[2].length; i++){
                invertData.push(data[2][data[2].length - i - 1]);
            }
            
            var ctx = document.getElementById("User_Stat").getContext('2d');
            document.getElementById("Stat_Title").innerHTML = title_chart;
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: invert_disp,
                    datasets: [{
                        label: 'Current 6 Month',
                        data: invertData,
                        backgroundColor: [
                            'rgba(141, 249, 69, 0.2)'
                        ],
                        borderColor: [
                            'rgba(49, 124, 0,1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        });
    </script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php require ('../Base/Header2_Master/Menubar_Master.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Admin Statistic Chart</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                    
                </div>
              </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3 id="active_user"></h3>
                                  <p>User Active</p>
                                </div>
                                <div class="icon">
                                  <i class="ion ion-person-add"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-3">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 id="register_user"></h3>
                                  <p>Total Registration</p>
                                </div>
                                <div class="icon">
                                  <i class="ion ion-person-add"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="row" style="margin-top: 25px;">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <h4 id="Stat_Title" align="center"></h4>
                            <canvas id="User_Stat" height="130px" ></canvas>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
            
            
            
          
              <!-- /.card-body-->
    </div>
    <!-- right col -->
  </div>
  
    <?php require('../Base/Header2_Master/Footer_Master.php'); ?>
</body>
</html>
