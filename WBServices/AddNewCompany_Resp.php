<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');


$datas = json_decode($_POST['Pack'], false);

$Cust_Data = $datas->DataPack;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$tmp = array();

foreach($Cust_Data as $lines){
    array_push($tmp, $lines);
}

$UserId = $tmp[count($tmp) - 1];

$Query = "INSERT INTO company(CompanyName,CompanyReg,Address,Postal,City,State,CompanyEmail,"
        . "Country,ContactPhone,Extension,FaxNo,ContactMobile,WebSite,InvPrefix,QtPrefix,RecPrefix,UserId) "
        . "VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? );";

$types = "sssssssssissssssi";

$stmt = $Conn->prepare($Query);

$input_Arr[] = &$types;
$dt = count($tmp);

for($i=0; $i<$dt; $i++){
    $input_Arr[] = &$tmp[$i];
}

call_user_func_array(array($stmt, 'bind_param'), $input_Arr);

if($stmt->execute() == true){
    
    $SqlMgr->Disconnect();
    $SqlMgr->Connect();
    
    $Conn_2 = $SqlMgr->GetConnection();
    
    $Conn_2->query("UPDATE users SET isFirstLogin = 0 WHERE UserId=".$UserId.";");
    
    echo json_encode(array("Result" => "true"));
}
else{
    echo json_encode(array("Result" => "false"));
}

