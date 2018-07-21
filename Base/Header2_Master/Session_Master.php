<?php

require ("../Engines/SessionManager.php");
require ("../Engines/SQLManager.php");
require ("../Config/Conn_Config.php");
require ("../Engines/Users.php");

$Session = new SessionManager();
$Session->StartSession();

$Sess_Status = $Session->GetSession("Login_Status");
$Sess_UserID = $Session->GetSession("Login_ID");
$Sess_Admin = $Session->GetSession("Login_IsAdmin");
$Sess_Last = $Session->GetSession("Login_Last");
$Admin_Name = "";

if($Sess_Status == 1 && $Sess_Admin == "yes"){
    $SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
    $SqlMgr->Connect();
    
    $Admin_Name = Users::GetUserFullName($Sess_UserID, $SqlMgr->GetConnection());
    
}
else{
    header("Location: ../index.php");
    exit();
}