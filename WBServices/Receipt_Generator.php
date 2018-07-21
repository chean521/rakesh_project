<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$Record = json_decode($_POST["Inputs"], false);

$Company_Id = $Record->Comp_Id;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$Query = "Select RecPrefix from company where UserId=".$Company_Id.";";
$Query .= "SELECT ReceiptNo FROM receipt WHERE CompanyId=".$Company_Id." order by (ReceiptNo) DESC;";

$NewInvoiceNo = $Company_Id."_";

$Inv_No = array();
$InvPref = "";
$query_counter = 0;

if($Conn->multi_query($Query)){
    do{
        if($res = $Conn->store_result()){
            
            if($query_counter == 0){
                while($row = $res->fetch_assoc()){
                    $InvPref = $row["RecPrefix"];
                }
            }
            else{
                while($row = $res->fetch_assoc()){
                    array_push($Inv_No, $row["ReceiptNo"]);
                }
            }
            
            $res->free_result();
            $query_counter++;
        }
    }
    while($Conn->next_result());
}

$SqlMgr->Disconnect();

if(count($Inv_No) == 0){
    $NewInvoiceNo .= $InvPref . "00001";
}
else{ // 100002_TINV00001
    $Code_Cut = substr($Inv_No[0], 11);
    $toCounter = (int) $Code_Cut;
    
    $toCounter += 1;
    
    if      ($toCounter/10000 > 1)  { $NewInvoiceNo .= $InvPref . (string) $toCounter; }
    else if ($toCounter/1000 > 1)   { $NewInvoiceNo .= $InvPref . '0' . (string) $toCounter; }
    else if ($toCounter/100 > 1)    { $NewInvoiceNo .= $InvPref . '00' . (string) $toCounter; }
    else if ($toCounter/10 > 1)     { $NewInvoiceNo .= $InvPref . '000' . (string) $toCounter; }
    else                            { $NewInvoiceNo .= $InvPref . '0000' . (string) $toCounter; }
}

echo json_encode(array("NewRec"=>$NewInvoiceNo));
