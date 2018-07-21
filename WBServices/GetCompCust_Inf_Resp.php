<?php

header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$data = json_decode($_POST["inputs"], false);

$pid = $data->c_id;
$cust_id = $data->u_id;
$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$stmt = $Conn->prepare("CALL sp_GetCompCust_Information(?,?)");
$stmt->bind_param('is', $pid,$cust_id);
$res = $stmt->execute();
$rs = $stmt->get_result();

$Result_Data = array();

if($rs->num_rows > 0){
    while($r = $rs->fetch_assoc()){
        foreach($r as $cols){
            array_push($Result_Data, $cols);
        }
    }
}

$SqlMgr->Disconnect();

echo json_encode($Result_Data);