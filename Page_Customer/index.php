<?php
require ("../Base/Header3_Master/Session_Master.php");

$PageTitle = "Customer Dashboard - Veeco Tech Invoice System";
$ActivePage = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../Lib/jquery/jquery_v3.js"></script>
    <?php require ("../Base/Header3_Master/Header_Master.php"); ?>
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
            title_chart = "Invoice Make " + month[set_last] + "&nbsp;" + (date.getFullYear()-1) + " - " + month[Now_Mon] + "&nbsp;" + date.getFullYear();
        }
        else{
            title_chart = "Invoice Make " + month[Now_Mon-6] + "&nbsp;" + date.getFullYear() + " - " + month[Now_Mon] + "&nbsp;" + date.getFullYear();
        }
        
        var invert_disp = [];
        
        for(var i=(disp.length-1); i >= 0; i--){
            invert_disp.push(disp[i]);
        }
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                var data = JSON.parse(this.responseText);

                return data;
            }
        };

        xmlhttp.open("POST", "/WBServices/CompanyGraphSummary_Resp.php", false);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("items="+JSON.stringify({"loginId":"<?php echo $Sess_UserID; ?>"}));
        
        var ori_data = xmlhttp.onreadystatechange();
        var invert_data = [];
        
        for (var i=ori_data.length-1; i>=0; i--){
            invert_data.push(ori_data[i]);
        }
    
        var ctx = document.getElementById("invoiceChart").getContext('2d');
        document.getElementById("chart_title").innerHTML = title_chart;
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: invert_disp,
                datasets: [{
                    label: 'Current 6 Month',
                    data: invert_data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)'
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
        
        var xmlhttp_2 = new XMLHttpRequest();
        xmlhttp_2.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                var data = JSON.parse(this.responseText);

                return data;
            }
        };

        xmlhttp_2.open("POST", "/WBServices/CompanyTotalOutput_Resp.php", false);
        xmlhttp_2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp_2.send("datas="+JSON.stringify({"CompanyId":"<?php echo $Sess_UserID; ?>"}));
        
        var count_data = xmlhttp_2.onreadystatechange();
        
        $('#ttl_rc').html(count_data[2]);
        $('#ttl_qt').html(count_data[1]);
        $('#ttl_in').html(count_data[0]);
        
        var xmlhttp_3 = new XMLHttpRequest();
        xmlhttp_3.onreadystatechange = function(){
            if(this.readyState === 4 && this.status === 200){
                var data = JSON.parse(this.responseText);

                return data;
            }
        };

        xmlhttp_3.open("POST", "/WBServices/OverdueList_Resp.php", false);
        xmlhttp_3.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp_3.send("Inputs="+JSON.stringify({"Comp_Id":"<?php echo $Sess_UserID; ?>"}));
        var Overdue = xmlhttp_3.onreadystatechange().OverdueList;

        for(var i=0; i<Overdue.length; i++){
            var html_txt = '<tr>';
            html_txt += '<td>' + (i+1) + '</td>';
            html_txt += '<td>'+(Overdue[i][0])+'</td>';
            html_txt += '<td>'+(Overdue[i][1])+'</td>';
            html_txt += '<td>'+(Overdue[i][2])+' - '+(Overdue[i][3])+'</td>';
            html_txt += '</tr>';
            
            $('#dashboard_overdue tbody').append(html_txt);
        }
        
    });
    
    
</script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php require ("../Base/Header3_Master/Menubar_Master.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Customer Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Monthly Recap Report</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <p class="text-center">
                        <strong id="chart_title"></strong>
                    </p>

                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <canvas id="invoiceChart" height="80px" ></canvas>
                    </div>
                  </div>
                    <!-- /.chart-responsive -->
                    <div class="col-md-4">

                                     <!-- Info Boxes Style 2 -->
                        <div class="info-box mb-3 bg-warning" style="margin-top: 30px;" >
                           <span class="info-box-icon"><i class="fa fa-tag"></i></span>

                           <div class="info-box-content">
                             <span class="info-box-text">TOTAL QUOTATION:</span>
                             <span class="info-box-number" id="ttl_qt"></span>
                           </div>
                           <!-- /.info-box-content -->
                         </div>
                                     
                         <div class="info-box mb-3 bg-info">
                            <span class="info-box-icon"><i class="fa fa-tag"></i></span>

                           <div class="info-box-content">
                             <span class="info-box-text">TOTAL RECEIPT:</span>
                             <span class="info-box-number" id="ttl_rc"></span>
                           </div>
                           <!-- /.info-box-content -->
                         </div>  
                         <!-- /.info-box -->
                         <div class="info-box mb-3 bg-success">
                            <span class="info-box-icon"><i class="fa fa-tag"></i></span>

                           <div class="info-box-content">
                             <span class="info-box-text">TOTAL INVOICE:</span>
                             <span class="info-box-number" id="ttl_in"></span>
                           </div>
                           <!-- /.info-box-content -->
                         </div>    
                   </div>
                </div>
               
                
      
      <!-- table-->
      <div class="container-fluid" style="margin-top: 50px;">
          <div class="row">
              <div class="col-md-12">
                  <h2 style="color:red"><i class="fa fa-warning"></i>&nbsp;&nbsp;Invoice Overdue</h2>  
              </div>
          </div> 
          <div class="row">
              <div class="col-md-12" style="display:block;max-height:250px;height:250px;overflow-y: scroll;">
                  <table class="table table-striped" id="dashboard_overdue">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Invoice No</th>
                      <th>Invoice Date</th>
                      <th>Customer</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
          </div>
      </div>
      
         
              </div>
            </div>
          </div>
        </div>
      </div>
  
    </section>
    <!-- /.content -->
    
    
    
    
  <?php require ("../Base/Header3_Master/Footer_Master.php"); ?>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  
  
</div>
<!-- ./wrapper -->


<!-- REQUIRED SCRIPTS -->
<?php require ("../Base/Header3_Master/Scripts_Master.php"); ?>
</body>
</html>
