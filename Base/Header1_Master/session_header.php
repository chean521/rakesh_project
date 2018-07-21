<?php

require ("Engines/SessionManager.php");

$Session = new SessionManager();
$Session->StartSession();
$Session->CreateSession();

$Sess_Status = $Session->GetSession("Login_Status");
$Sess_UserID = $Session->GetSession("Login_ID");
$Sess_Admin = $Session->GetSession("Login_IsAdmin");


function LogInDisplay(){
    return '<li><a href="#" data-toggle="modal" data-target="#usr_reg"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                         <li><a href="#" data-toggle="modal" data-target="#usr_log"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>'
    ;
}

function LogOutDisplay($isAdmin){
    $Portal_To = "";
    
    switch ($isAdmin){
        case "yes":
            $Portal_To = "../Page_Admin/";
            break;
        case "no":
            $Portal_To = "../Page_Customer/";
            break;
    }
    
    return '<li><a href="'.$Portal_To.'"><span class="glyphicon glyphicon-home"></span> Portal Dashboard</a></li>
                         <li><a href="../UserManage/LogOut.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>'
    ;
}