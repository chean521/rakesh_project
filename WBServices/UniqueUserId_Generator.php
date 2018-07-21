<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$max_inv = 99999;
$min_inv = 10001;

$Res = $Conn->query("Select UserId From users;");

$pid = array();

$Unique_Pid = 0;

if($Res->num_rows > 0){
    while($row = $Res->fetch_assoc()){
        array_push($pid, $row["UserId"]);
    }
    
    for($i=0; $i<count($pid); $i++){
        $Rand_Id = rand($min_inv, $max_inv);
        $isDuplicate = false;
        
        for($j=0; $j<count($pid); $j++){
            if($Rand_Id == $pid[$j]){
                $isDuplicate = true;
                break;
            }
        }
        
        if($isDuplicate == false){
            $Unique_Pid = $Rand_Id;
            break;
        }
    }
    
}
else{
    $Unique_Pid = rand($min_inv, $max_inv);
}

$SqlMgr->Disconnect();

echo json_encode(array("NewPid" => $Unique_Pid));