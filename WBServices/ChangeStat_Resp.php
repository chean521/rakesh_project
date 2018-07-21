<?php

header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$datas = json_decode($_POST["inputs"], false);

$CustId = $datas->CustomerId;
$CompId = $datas->CompanyId;
$Stat = $datas->Status;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$cust_id_compiled = $CompId . '_' . $CustId;

$stmt = $Conn->prepare("UPDATE companycustomer SET CustStatus=? Where CustomerId=?;");
$stmt->bind_param("ss", $Stat, $cust_id_compiled);

if($stmt->execute() == true){
    
    echo json_encode(array("Result" => "true"));
}
else{
    echo json_encode(array("Result" => "false"));
}

$SqlMgr->Disconnect();