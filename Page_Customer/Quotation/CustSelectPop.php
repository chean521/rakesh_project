<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Customer Selection</title>
        <script src="../../Lib/jquery/jquery_v3.js"></script>
        <script src="../../Lib/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="../../Lib/bootstrap-3.3.7-dist/css/bootstrap.css" />
        <?php require ("../../Lib/DataTables/DataTables_CDN.php"); ?>
        
        <script type="text/javascript">
            var xmlhttp = new XMLHttpRequest();
            var dt;

            xmlhttp.onreadystatechange = function(){

                if(this.readyState === 4 && this.status === 200){
                    var Resp = JSON.parse(this.responseText);

                    var arr = [];
                    
                    for(var i=0; i<Resp.length; i++){
                        var CustId = Resp[i]["0"].toString().substr(7,4);
                        var CustName = Resp[i][1];
                        var Contact = Resp[i][3];
                        arr.push(new Array(CustId, CustName, Contact));
                    }

                    dt = $('#container').DataTable({
                        "data": arr,
                        "pagingType": "full_numbers",
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        "scrollY"  : "400px",
                        "columnDefs": [{ "targets": -1, "data": null, "defaultContent": '<button type="button" id="btn_Select" class="btn btn-primary" onclick="">SELECT</button>'}]
                    });
                }
            };

            xmlhttp.open("POST", "/WBServices/GetCompCust_List_Pop.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("data="+JSON.stringify({"Pid" : <?php echo $_GET["pid"]; ?>}));
            
            $(document).ready(function(e){
                $('#container tbody').on('click', '[id*=btn_Select]',function(c){
                    var data = dt.row($(this).parents('tr')).data();
                    var CustId = data[0];
                    var Pid = '<?php echo $_GET["pid"]; ?>';
                    
                    opener.GetCustomerId(CustId, Pid);
                    window.close();
                });
            });
        
        </script>
            
    </head>
    <body>
        <table id="container" class="display">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Contact No</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </body>
</html>
