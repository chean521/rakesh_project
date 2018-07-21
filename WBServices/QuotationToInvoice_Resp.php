<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$datas = json_decode($_POST["CreateData"], false);

$NewTaxInv = $datas->New_Inv;
$Qt_Id = $datas->Qt_Id;
$Comp_Id = $datas->Comp_Id;

$combine = $Comp_Id . '_' . $Qt_Id;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$stmt = $Conn->prepare("CALL sp_QuotationToInvoice (?,?,?);");
$stmt->bind_param('sis', $combine, $Comp_Id, $NewTaxInv);

if($stmt->execute()){
    echo json_encode(array("Result"=>"true"));
}
else{
    echo json_encode(array("Result"=>"false"));
}
