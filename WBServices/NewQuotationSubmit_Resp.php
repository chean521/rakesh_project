<?php

header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

/** @var array */
$input_list = json_decode($_POST['CreateData'], false);

$InsertExecution = true;

$details = $input_list->Compiled_Details;
$Desc = $input_list->Compiled_Desc;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();
$Conn = $SqlMgr->GetConnection();

$query_string = 
        'INSERT INTO quotation'
        . '(QuotationNo,QuotationDate,CustomerId,Terms,curr,Attn,CompanyId,GrandTotal,RecordCreatedOn)'
        . 'VALUES'
        . '(?,?,?,?,?,?,?,?,now());';

$tps = "ssssssid";
$vl = $details;

$stmt = $Conn->prepare($query_string);

$input_Arr[] = &$tps;
$dt = count($vl);
for($i=0; $i<$dt; $i++){
    $input_Arr[] = &$vl[$i];
}

call_user_func_array(array($stmt, 'bind_param'), $input_Arr);

$result = $stmt->execute();

if($result == false){
    $InsertExecution = false;
}

$SqlMgr->Disconnect();

$QuotationPid = 0;

$SqlMgr->Connect();

$Conn2 = $SqlMgr->GetConnection();
$res = $Conn2->query("Select pid from quotation Where QuotationNo='".$details[0]."';");
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

$Conn3 = $SqlMgr->GetConnection();

$Query_Str_2 = "";

for($j=0; $j<count($Desc); $j++){
    $Query_Str_2 .= "CALL sp_InsertQuotationDesc(".$QuotationPid.",".$details[6].",'".$Desc[$j]->ProductCode."',".$Desc[$j]->Quantity.");";
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