<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$data = json_decode($_POST["datas"], false);

$pid = $data->Comp_Id;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$stmt = $Conn->prepare("CALL sp_GetReceiptList(?)");
$stmt->bind_param('i', $pid);
$res = $stmt->execute();
$Res_Set = $stmt->get_result();

$Result_Data = array();

if($Res_Set->num_rows > 0){
    while($rows = $Res_Set->fetch_assoc()){
        $cols = array();
        
        array_push($cols, substr($rows["ReceiptNo"],7));
        array_push($cols, $rows["ReceiptDate"]);
        array_push($cols, substr($rows["PaymentInvoice"], 7));
        array_push($cols, $rows["CustomerName"]);
        array_push($cols, $rows["GrandTotal"]);
        array_push($cols, $rows["PaymentDate"]);
        array_push($cols, $rows["PaymentMethod"]);
        
        array_push($Result_Data, $cols);
    }
}

echo json_encode($Result_Data);