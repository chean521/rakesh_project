<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$data = json_decode($_POST["data"], false);

$pid = $data->Pid;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$stmt = $Conn->prepare("CALL sp_GetCompanyProduct(?)");
$stmt->bind_param('i', $pid);
$res = $stmt->execute();
$Res_Set = $stmt->get_result();

$Result_Data = array();

if($Res_Set->num_rows > 0){
    while($rows = $Res_Set->fetch_assoc()){
        $cols = array();
        
        array_push($cols, $rows["ProductCode"]);
        array_push($cols, $rows["ProductManufacture"]);
        array_push($cols, $rows["ProductDesc"]);
        array_push($cols, $rows["ProductPrice"]);
        array_push($cols, $rows["TaxCode"]);
        array_push($cols, $rows["TaxDesc"]);
        
        array_push($Result_Data, $cols);
    }
}

echo json_encode($Result_Data);