<?php

require ("../../Engines/SessionManager.php");
require ("../../Engines/SQLManager.php");
require ("../../Config/Conn_Config.php");
require ("../../Engines/Users.php");
require ("../../Config/FileUpload_Config.php");

$Session = new SessionManager();
$Session->StartSession();

$Sess_Status = $Session->GetSession("Login_Status");
$Sess_UserID = $Session->GetSession("Login_ID");
$Sess_Admin = $Session->GetSession("Login_IsAdmin");
$Sess_isFirst = $Session->GetSession("First_Log");
$Sess_Last = $Session->GetSession("Login_Last");
$Sess_Photo = $Session->GetSession("User_Pic");
$UserName = "";
$PhotoURL = null;

if($Sess_Status == 1 && $Sess_Admin == "no"){
    
    if((int)$Sess_isFirst == 1){
        header("Location: ../../UserManage/First_Landing.php");
        exit();
    }
    
    $SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
    $SqlMgr->Connect();
    
    $UserName = Users::GetUserFullName($Sess_UserID, $SqlMgr->GetConnection());
    
    if($Sess_Photo == null){
        $PhotoURL = FileConfigure::$RootFolder_2 . 'dummy_pic.png';
    }
    else{
        $PhotoURL = FileConfigure::$TargetFolder_Company_2 . $Sess_Photo;
    }
}
else{
    header("Location: ../../index.php");
    exit();
}