<?php

header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$data = json_decode($_POST["datas"], false);

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$res = $Conn->query("Select * From company WHERE UserId=".$data->Pid.";");

$Comp_Det = array();

if($res->num_rows > 0){
    while($row = $res->fetch_assoc()){
        foreach($row as $cols){
            array_push($Comp_Det, $cols);
        }
    }
}

$SqlMgr->Disconnect();

echo json_encode($Comp_Det);