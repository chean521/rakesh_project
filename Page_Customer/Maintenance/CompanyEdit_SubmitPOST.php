<?php

$SubmitData = $_POST;
unset($_POST);

require ('../../Engines/SQLManager.php');
require ('../../Config/Conn_Config.php');
require ("../../Engines/SessionManager.php");

$Session = new SessionManager();
$Session->StartSession();

$Sess_Status = $Session->GetSession("Login_Status");
$Sess_UserID = $Session->GetSession("Login_ID");
$Sess_Admin = $Session->GetSession("Login_IsAdmin");

if($Sess_Status == 0){
    header("Location: ../../");
    exit();
}
else if($SubmitData == null){
    header("Location: Profile_Update.php");
    exit();
}
else{
    
    $Seq_Data = array();

    $c = 0;
    foreach($SubmitData as $input_data){
        if($c == 5 || $c == 7){
            array_push($Seq_Data, '+60'.$input_data);
        }
        else{
            array_push($Seq_Data, $input_data);
        }
        
        $c++;
    }
    
    array_push($Seq_Data, $Sess_UserID);

    $SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
    $SqlMgr->Connect();

    $Conn = $SqlMgr->GetConnection();
    
    $Query = "UPDATE company SET Address= ?,Postal= ?,City= ?,State= ?,CompanyEmail= ?,ContactPhone= ?,Extension= ?,FaxNo= ?,"
            . "ContactMobile= ?,WebSite= ? WHERE UserId = ?;";
    
    $stmt = $Conn->prepare($Query);
    
    $types = "ssssssisssi";
    
    $input_Arr[] = &$types;
    $dt = count($Seq_Data);
    for($i=0; $i<$dt; $i++){
        $input_Arr[] = &$Seq_Data[$i];
    }
    
    call_user_func_array(array($stmt, 'bind_param'), $input_Arr);
    
    if($stmt->execute() == true){
        // Empty
    }
    
    header("Location: Profile_Update.php");
    exit();
}

