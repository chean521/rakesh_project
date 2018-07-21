<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$Record = json_decode($_POST["Inputs"], false);

$Company_Id = $Record->Comp_Id;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$Query = "SELECT CustomerId FROM companycustomer WHERE CompanyNo=".$Company_Id." order by (CustomerId) DESC;";

$NewCustNo = $Company_Id."_";

$Cust_No = array();

if($res = $Conn->query($Query)){
    
    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
            array_push($Cust_No, $row["CustomerId"]);
        }
    }
}

$SqlMgr->Disconnect();

if(count($Cust_No) == 0){
    $NewCustNo .=  "C001";
}
else{ // 100002_TINV00001
    $Code_Cut = substr($Cust_No[0], 8);
    $toCounter = (int) $Code_Cut;
    
    $toCounter += 1;
    
    if      ($toCounter/100 > 1)    { $NewCustNo .= 'C' .(string) $toCounter; }
    else if ($toCounter/10 > 1)     { $NewCustNo .= 'C0' . (string) $toCounter; }
    else                            { $NewCustNo .= 'C00' . (string) $toCounter; }
}

echo json_encode(array("NewCustomer"=>$NewCustNo));
