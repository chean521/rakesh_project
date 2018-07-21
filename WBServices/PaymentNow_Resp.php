<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$data = json_decode($_POST["Data"], false);

$PymtData = $data->Comp_Data;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$Query = "Select CustomerId From taxinvoices Where InvoiceNo=?;";

$stmt_1 = $Conn->prepare($Query);
$stmt_1->bind_param("s", $PymtData[2]);
$stmt_1->execute();

$Cust_id = "";

if($res = $stmt_1->get_result()){
    if($res->num_rows > 0){
        $rows = $res->fetch_assoc();
        
        $Cust_id = $rows["CustomerId"];
    }
    
    $res->free_result();
}

$stmt_1->close();
$SqlMgr->Disconnect();
$SqlMgr->Connect();

$Conn_2 = $SqlMgr->GetConnection();

$Query = "INSERT INTO receipt (ReceiptNo, ReceiptDate, CompanyId, CustomerId, PaymentInvoice, GrandTotal, PaymentMethod, PaymentDate, PaymentAmt, PaymentRef)"
        . "VALUES (?,now(),?,?,?,?,?,?,?,?);";

$stmt_2 = $Conn_2->prepare($Query);

$stmt_2->bind_param("sississis", $PymtData[0], $PymtData[1], $Cust_id, $PymtData[2], $PymtData[3], $PymtData[5], $PymtData[4], $PymtData[6], $PymtData[7]);

if($stmt_2->execute() == true){
    
    $SqlMgr->Disconnect();
    $SqlMgr->Connect();
    $Conn_3 = $SqlMgr->GetConnection();
    
    $stmt_3 = $Conn_3->prepare("UPDATE taxinvoices SET PayStatus='PAID', PayDate=now() WHERE InvoiceNo=?");
    $stmt_3->bind_param("s", $PymtData[2]);
    $stmt_3->execute();
    $SqlMgr->Disconnect();
    
    echo json_encode(array("Result"=>"true"));
}
else{
    echo json_encode(array("Result"=>"false"));
}

