<?php

header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$data = json_decode($_POST["data"], false);

$pid = $data->Pid;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$stmt = $Conn->prepare("CALL sp_GetCompanyCustomerDetails(?)");
$stmt->bind_param('i', $pid);
$res = $stmt->execute();
$Res_Set = $stmt->get_result();

$Result_Data = array();

if($Res_Set->num_rows > 0){
    while($rows = $Res_Set->fetch_assoc()){
        
        if($rows["CustStatus"] == "Active" || $rows["CustStatus"] == "Hold"){
            $cols = array();

            array_push($cols, $rows["CustomerId"]);
            array_push($cols, $rows["CustomerName"]);
            array_push($cols, $rows["Email"]);
            array_push($cols, $rows["ContactPhone"]);
            array_push($cols, $rows["Extension"]);

            array_push($Result_Data, $cols);
        }
    }
}

echo json_encode($Result_Data);