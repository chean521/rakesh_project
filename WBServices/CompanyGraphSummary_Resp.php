<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$datas = json_decode($_POST["items"], false);

$login_id = $datas->loginId;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$stmt = $Conn->prepare("CALL sp_MontlyChart(?);");

$stmt->bind_param("i", $login_id);

$Month_Data = array();

if($stmt->execute() == true){
    $res = $stmt->get_result();
    
    if($res->num_rows > 0){
        $tmp = array();
        
        while($row = $res->fetch_assoc()){
            
            foreach($row as $cols){
                array_push($tmp, $cols);
            }
        }
        
        array_push($Month_Data, $tmp);
        unset($tmp);
    }
    
    $res->free_result();
}

$SqlMgr->Disconnect();

if($Month_Data == null){
    $ps = array();
    
    for($i=0; $i<6; $i++){
        array_push($ps, 0);
    }
    
    echo json_encode($ps);
}
else{
    $Now_Month = date('m');
    $Now_Year = date ('Y');
    $Diff = (int) $Now_Year - (int) $Month_Data[0][0];
    $graph_data = array();

    $count = (int) $Now_Month;

    if($Diff > 0){
        for($i=0; $i<6; $i++){
            if($count == 1){
                array_push($graph_data, $Month_Data[0][$count]);
                $count = 12;
            }
            else{
                array_push($graph_data, $Month_Data[1][$count]);
                $count--;
            }
        }
    }
    else{
        for($i=$count; $i>($count-6); $i--){
            array_push($graph_data, $Month_Data[0][$i]);
        }
    }

    echo json_encode($graph_data);
}