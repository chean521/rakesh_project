<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$datas = json_decode($_POST['datas'], false);

$Usr_Data = $datas->DataPack;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$Query = "INSERT INTO users(UserId,UserName,UserPass,PersonalName,Roles,isFirstLogin,DateCreated)"
        . " VALUES (?,?,?,?,1001,1,now());";

$types = "isss";

$stmt = $Conn->prepare($Query);

$input_Arr[] = &$types;
$dt = count($Usr_Data);

for($i=0; $i<$dt; $i++){
    $input_Arr[] = &$Usr_Data[$i];
}

call_user_func_array(array($stmt, 'bind_param'), $input_Arr);

if($stmt->execute() == true){
    echo json_encode(array("Result" => "true"));
}
else{
    echo json_encode(array("Result" => "false"));
}

