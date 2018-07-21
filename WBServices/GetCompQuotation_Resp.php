<?php
header("Content-Type: application/json; charset=UTF-8");
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

$data = json_decode($_POST["datas"], false);

$pid = $data->Comp_Id;
$final_data = array();
$final_2nd = array();

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();

$Conn = $SqlMgr->GetConnection();

$stmt = $Conn->prepare("CALL sp_GetQuotationList(?);");

$stmt->bind_param("i", $pid);

if($stmt->execute() == true){
    $res = $stmt->get_result();
    
    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
            $tmp = array();
            
            foreach($row as $cols){
                array_push($tmp, $cols);
            }
            
            array_push($final_data, $tmp);
            unset($tmp);
        }
        
        for($i=0; $i<count($final_data); $i++){
            $final_data[$i][0] = substr($final_data[$i][0], 7);
            $final_data[$i][2] = substr($final_data[$i][2], 7);
        }
        
        for($rows = 0; $rows < count($final_data); $rows++){
            $tmp = array();
            
            for($cols = 0; $cols < count($final_data[$rows]) - 1; $cols++){
                if($cols == 0){
                    array_push($tmp, "");
                }
                
                if($cols <= 2){
                    if($cols == 2){
                        $joins = $final_data[$rows][$cols]. " - ". $final_data[$rows][$cols+1];
                        array_push($tmp, $joins);
                    }
                    else{
                        array_push($tmp, $final_data[$rows][$cols]);
                    }
                }
                else{
                    array_push($tmp, $final_data[$rows][$cols+1]);
                }
            }
            
            array_push($final_2nd, $tmp);
            unset($tmp);
        }
    }
}

$SqlMgr->Disconnect();

echo json_encode($final_2nd);
