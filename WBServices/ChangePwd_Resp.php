<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$datas = json_decode($_POST["items"], false);

$NewPwd = $datas->NewPwd;
$login_id = $datas->loginId;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$res = $Conn->query("UPDATE users SET UserPass='".$NewPwd."' WHERE UserId=".$login_id.";");

if($res == true){
    echo json_encode(array("Result"=>true));
}
else{
    echo json_encode(array("Result"=>false));
}

$SqlMgr->Disconnect();