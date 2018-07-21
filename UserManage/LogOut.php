<?php

require ('../Engines/SessionManager.php');

$Sess = new SessionManager();

$Sess->StartSession();
$Sess->DeleteSession();

header("Location: ../index.php");
