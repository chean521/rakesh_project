<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$data = json_decode($_POST["datas"], false);

$pid = $data->qt_val;
$comp = $data->comp_id;

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$stmt = $Conn->prepare("CALL sp_GetQuotationList_Parts_Single(?,?);");

$qt_id = (string)$comp . '_' . $pid;

$stmt->bind_param("is", $comp, $qt_id);

$stmt->execute();

$dataset = 0;
$Data_Inf = array();
$Data_Desc = array();

while($res = $stmt->get_result()){
    if($res->num_rows > 0){
        switch ($dataset){
            case 0:
                while($row = $res->fetch_assoc()){
                    foreach($row as $cols){
                        array_push($Data_Inf, $cols);
                    }
                }
                break;

            case 1:
                while($row = $res->fetch_assoc()){
                    $tmp = array();
                    
                    foreach($row as $cols){
                        array_push($tmp, $cols);
                    }
                    
                    array_push($Data_Desc, $tmp);
                    unset($tmp);
                }
                break;
        }
    }
    
    $res->free_result();
    $stmt->next_result();
    $dataset++;
}

$stmt->close();
$SqlMgr->Disconnect();

echo json_encode(array("Data_Inf"=>$Data_Inf, "Data_Desc"=>$Data_Desc));