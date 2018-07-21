<?php

header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$datas = json_decode($_POST["del_data"], false);

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$stmt = $Conn->prepare("CALL sp_RemoveQuotation(?,?);");

$join_inv = $datas->Comp_No . '_' . $datas->Inv_No;

$stmt->bind_param("is", $datas->Comp_No, $join_inv);

if($stmt->execute() == TRUE){
    echo json_encode(array("Result"=>"true"));
}
else{
    echo json_encode(array("Result"=>"false"));
}

$SqlMgr->Disconnect();