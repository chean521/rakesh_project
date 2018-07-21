<?php

class Users {
    
    /**
     * Get Full Name of specific user
     * 
     * @param integer $pid
     * @param mysqli $conn
     */
    public static function GetUserFullName($pid,$conn){
        
        if($conn instanceof mysqli){
            $res = $conn->query("select PersonalName from users where UserId=".$pid.';');
            $Name = "";
            
            if($res->num_rows > 0){
                while($row = $res->fetch_assoc()){
                   $Name = $row["PersonalName"]; 
                }
                
                return $Name;
            }
            else{
                return NULL;
            }
        }
        else{
            return NULL;
        }
    }
}
