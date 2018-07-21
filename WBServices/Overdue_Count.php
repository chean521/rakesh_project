<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$Record = json_decode($_POST["Inputs"], false);

$Company_Id = $Record->Comp_Id;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$Query = "CALL sp_DashboardOverdueList(?);";

$stmt = $Conn->prepare($Query);
$stmt->bind_param("i", $Company_Id);

$data = 0;

if($stmt->execute() == true){
    $res = $stmt->get_result();
    
    if($res->num_rows > 0){
        $data = $res->num_rows;
    }
    
    $res->free_result();
}

$SqlMgr->Disconnect();


echo json_encode(array("OverdueCount"=>$data));