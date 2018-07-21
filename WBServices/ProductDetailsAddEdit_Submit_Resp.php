<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$datas = json_decode($_POST['datas'], false);

$Cust_Data = $datas->Compiled_Data;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$Query = "";

switch((int)$Cust_Data[1]){
    case 1:
        $Query = "INSERT INTO companyproduct(ProductCode,ProductManufacture,ProductDesc,ProductPrice,TaxCode,CompanyNo) VALUES (?,?,?,?,?,?);";
        break;
    
    case 2:
        $Query = "UPDATE companyproduct SET ProductManufacture= ?,ProductDesc= ?,ProductPrice= ?,TaxCode= ? WHERE "
            . "CompanyNo= ? AND ProductCode= ?;";
        break;
}

$stmt = $Conn->prepare($Query);

switch((int)$Cust_Data[1]){
    case 1:
        $stmt->bind_param("sssssi", $Cust_Data[2],$Cust_Data[3],$Cust_Data[4],$Cust_Data[5],$Cust_Data[6],$Cust_Data[0]);
        break;
    
    case 2:
        $stmt->bind_param("ssisis", $Cust_Data[3],$Cust_Data[4],$Cust_Data[5],$Cust_Data[6],$Cust_Data[0],$Cust_Data[2]);
        break;
}

if($stmt->execute() == true){
    echo json_encode(array("Result"=>"true"));
}
else{
    echo json_encode(array("Result"=>"false"));
}

