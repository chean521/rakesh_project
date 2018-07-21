<?php

header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

/** @var array */
$input_list = json_decode($_POST['CreateData'], false);

$InsertExecution = true;

$details = $input_list->Compiled_Details;
$Desc = $input_list->Compiled_Desc;


$Qt_No = $details->CompanyId . '_' . $details->Qt_No;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);

$QuotationPid = 0;

$SqlMgr->Connect();


$Conn2 = $SqlMgr->GetConnection();
$res = $Conn2->query("Select pid from quotation Where QuotationNo='".$Qt_No."';");
if($res->num_rows > 0){
    while($rows = $res->fetch_assoc()){
        $QuotationPid = (int) $rows["pid"];
    }
}
else{
    $InsertExecution = false;
}

$SqlMgr->Disconnect();

$SqlMgr->Connect();
$Conn = $SqlMgr->GetConnection();
$res = $Conn->query("delete from quotation_details Where QuotationPid=".$QuotationPid.";");

$SqlMgr->Disconnect();


$SqlMgr->Connect();

$Conn3 = $SqlMgr->GetConnection();

$Query_Str_2 = "";

for($j=0; $j<count($Desc); $j++){
    $Query_Str_2 .= "CALL sp_InsertQuotationDesc(".$QuotationPid.",".$details->CompanyId.",'".$Desc[$j]->ProductCode."',".$Desc[$j]->Quantity.");";
}

if(!$Conn3->multi_query($Query_Str_2)){
    $InsertExecution = false;
}

$res_msg = "";
if($InsertExecution == true){
    $res_msg = "true";
}
else{
    $res_msg = "false";
}

echo json_encode(array("Result"=>$res_msg));