<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$datas = json_decode($_POST["datas"], false);

$CompId = $datas->CompanyId;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$Query = "SELECT count(*) as 'CT_Tax' from taxinvoices WHERE CompanyId=".$CompId.";"
        . "SELECT count(*) as 'CT_Quo' from quotation WHERE CompanyId=".$CompId.";"
        . "SELECT count(*) as 'CT_Rec' from receipt WHERE CompanyId=".$CompId.";";

$Counter = array();

if($Conn->multi_query($Query)){
    
    do{
        if($Res = $Conn->store_result()){
            
            $row = $Res->fetch_assoc();
            
            foreach($row as $cols){
                array_push($Counter, $cols);
            }
            
            $Res->free();
        }
        
        
    }
    while($Conn->more_results() && $Conn->next_result());
}
    
$SqlMgr->Disconnect();

echo json_encode($Counter);