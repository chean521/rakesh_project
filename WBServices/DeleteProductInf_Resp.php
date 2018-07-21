<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$datas = json_decode($_POST["data"], false);

$Pid = $datas->Pid;
$Prod_ID = $datas->Prod_ID;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$stmt = $Conn->prepare("DELETE FROM companyproduct WHERE ProductCode=? AND CompanyNo=?;");

$stmt->bind_param("si", $Prod_ID, $Pid);

if($stmt->execute() == TRUE){
    echo json_encode(array("Result"=>"true"));
}
else{
    echo json_encode(array("Result"=>"false"));
}

$SqlMgr->Disconnect();