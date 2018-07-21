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

if($details[3] == null) {$details[3] = ''; }

$query_string = 
        'INSERT INTO taxinvoices'
        . '(InvoiceNo,InvoiceDate,CustomerId,Terms,curr,Attn,CompanyId,GrandTotal,RecordCreatedOn)'
        . 'VALUES'
        . "(?,?,?,?,?,?,?,?,now());";

$stmt = $Conn->prepare($query_string);

$tps = "ssssssid";

$input_Arr[] = &$tps;
$dt = count($details);
for($i=0; $i<$dt; $i++){
    $input_Arr[] = &$details[$i];
}

call_user_func_array(array($stmt, 'bind_param'), $input_Arr);


if($stmt->execute() == false){
    $InsertExecution = false;
}

$SqlMgr->Disconnect();

$InvoicePid = 0;

$SqlMgr->Connect();

$Conn2 = $SqlMgr->GetConnection();
$res = $Conn2->query("Select pid from taxinvoices Where InvoiceNo='".$details[0]."';");
if($res->num_rows > 0){
    while($rows = $res->fetch_assoc()){
        $InvoicePid = (int) $rows["pid"];
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
    $Query_Str_2 .= "CALL sp_InsertInvoiceDesc(".$InvoicePid.",".$details[6].",'".$Desc[$j]->ProductCode."',".$Desc[$j]->Quantity.");";
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