<?php

class Security{
    
    public static function CaptchaHash($val){
        $hash = 5381;
        $value = strtoupper($val);
        for($i=0; $i< strlen($value); $i++){
            $hash = (($hash << 5) + $hash) + ord(substr($value, $i));
        }
        
        return $hash;
    }
    
    
    
}

