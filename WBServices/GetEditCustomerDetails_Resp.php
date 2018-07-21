<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$datas = json_decode($_POST["inputs"], false);

$CustId = $datas->CustomerId;
$CompId = $datas->CompanyId;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$cust_id_compiled = $CompId . '_' . $CustId;

$stmt = $Conn->prepare("CALL sp_GetCompanyCustomer_Full(?,?);");

$stmt->bind_param("is", $CompId, $cust_id_compiled);

$Res_Data = array();

if($stmt->execute() == true){
    $res = $stmt->get_result();
    
    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
            foreach($row as $cols){
                array_push($Res_Data, $cols);
            }
        }
    }
    
}

$stmt->close();
$SqlMgr->Disconnect();

echo json_encode($Res_Data);