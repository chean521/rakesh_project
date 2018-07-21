<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$datas = json_decode($_POST["datas"], false);

$ProductNo = $datas->ProductNo;
$CompId = $datas->CompanyId;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$res = $Conn->query("SELECT count(*) as 'ttl_rows' FROM companyproduct WHERE ProductCode='".$ProductNo."' AND CompanyNo=".$CompId.";");

$ttl_rows = 0;

if($res->num_rows > 0){
    while($row = $res->fetch_assoc()){
        $ttl_rows = (int) $row['ttl_rows'];
    }
}

$SqlMgr->Disconnect();

if($ttl_rows > 0){
    echo json_encode(array("Duplicate"=>"yes"));
}
else{
    echo json_encode(array("Duplicate"=>"no"));
}