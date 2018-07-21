<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$stmt = $Conn->prepare("CALL sp_AdminDashboard()");

$ResultSet = 0;
$Data_UserRegister = 0; $Data_Active = 0; $Data_Chart = array();

if($stmt->execute()){
    
    while($Res = $stmt->get_result()){
        if($Res->num_rows > 0){
            
            switch($ResultSet){
                case 0:
                    $row_1 = $Res->fetch_assoc();
                    
                    $Data_UserRegister = (int) $row_1["ttl_register"];
                    
                    break;
                
                case 1:
                    $row_2 = $Res->fetch_assoc();
                    
                    $Data_Active = (int) $row_2["active_today"];
                    
                    break;
                
                case 2:
                    while($row_3 = $Res->fetch_assoc()){
                        $tmp = array();
                        
                        foreach($row_3 as $cols){
                            array_push($tmp, $cols);
                        }
                    
                        array_push($Data_Chart, $tmp);
                        unset($tmp);
                    }
                    
                    break;
            }
            
        }
        
        $Res->free_result();
        $stmt->next_result();
        $ResultSet ++;
    }
}

$stmt->close();
$SqlMgr->Disconnect();


if($Data_Chart == null){
    $ps = array();
    
    for($i=0; $i<6; $i++){
        array_push($ps, 0);
    }
    
    echo json_encode(array($Data_UserRegister, $Data_Active, $ps));
}
else{
    $Now_Month = date('m');
    $Now_Year = date ('Y');
    $Diff = (int) $Now_Year - (int) $Data_Chart[0][0];
    $graph_data = array();

    $count = (int) $Now_Month;

    if($Diff > 0){
        for($i=0; $i<6; $i++){
            if($count == 1){
                array_push($graph_data, $Data_Chart[0][$count]);
                $count = 12;
            }
            else{
                array_push($graph_data, $Data_Chart[1][$count]);
                $count--;
            }
        }
    }
    else{
        for($i=$count; $i>($count-6); $i--){
            array_push($graph_data, $Data_Chart[0][$i]);
        }
    }

    echo json_encode(array($Data_UserRegister, $Data_Active, $graph_data));
}

