<?php
header("Content-Type: application/json; charset=UTF-8");
require_once ('../Engines/Security.php');

$data = json_decode($_POST["captcha"]);

$hash_cap = $data->cap_data;
$Ori_Val = $data->StockVal;

if(Security::CaptchaHash($Ori_Val) == $hash_cap ){
    echo json_encode(array("Result" => true));
}
else{
    echo json_encode(array("Result" => false));
}


