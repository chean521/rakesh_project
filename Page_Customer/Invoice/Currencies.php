<?php

$SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
$SqlMgr->Connect();
$Conn = $SqlMgr->GetConnection();

$datas = array();
$res = $Conn->query("Select * From currencies");

while($rows = $res->fetch_assoc())
{
    array_push($datas, $rows);
}

$SqlMgr->Disconnect();