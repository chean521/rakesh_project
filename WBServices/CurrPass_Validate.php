<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$data = json_decode($_POST['data_sec'], false);

$UserId = $data->UserId;
$CurrInput = $data->StockVal;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$stmt = $Conn->prepare("Select count(*) as 'isTrue' From users Where UserPass= ? AND UserId = ? ; ");

$stmt->bind_param("si", $CurrInput, $UserId);

$ttl_rows = 0;

if($stmt->execute() == true){
    $res = $stmt->get_result();
    
    $row = $res->fetch_assoc();
    $ttl_rows = (int) $row["isTrue"];
    
    $res->free_result();
}

$SqlMgr->Disconnect();

if($ttl_rows > 0){
    echo json_encode(array("Result"=>true));
}
else{
    echo json_encode(array("Result"=>false));
}
