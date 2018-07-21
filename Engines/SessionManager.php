<?php

class SessionManager {
    
    /** @var string*/
    private $SessionID = null;
    /** @var boolean */
    private $Started = false;
    /** @var integer */
    private $Timeout; // in milliseconds(ms)
    
    /**
     * Construct new Session object
     */
    public function __construct($SessionDuration = 10000) {
        $this->Timeout = $SessionDuration;
    }
    
    /**
     * Check session timeout. Return true if the session
     * time expires and return false when the session time 
     * not expired.
     * 
     * @return boolean
     */
    public function CheckSessionTImeout(){
        $Time_From = $_SESSION["Session_Timeout"];
        $Time_Now = microtime(true);
        
        $diff = round($Time_Now - $Time_From, 3)*1000;
        
        if($diff >= $this->Timeout){
            return true;
        }
        else{
            return false;
        }
    }
    
    /**
     * Add value inside to session to pass values.
     * Throws Exception when duplicated key
     * 
     * @param string $key Keyword of session
     * @param string $value Value to be passed in this key
     * @throws Exception
     */
    public function AddData($key, $value){
        if(isset($_SESSION[$key])){
            throw new Exception("Key already been used, at AddData.");
        }
        else{
            $_SESSION[$key] = $value;
        }
    }
    
    /**
     * Change value inside to session to pass values.
     * Throws Exception when duplicated key
     * 
     * @param string $key Keyword of session
     * @param string $newVal Value to be passed in this key
     * @throws Exception
     */
    public function ChangeData($key, $newVal){
        $_SESSION[$key] = $newVal;
    }
    
    /**
     * Get Session Data by key
     * 
     * @param string $key Key name of current 
     * @return string
     */
    public function GetSession($key){
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        else{
            return NULL;
        }
    }
    
    /**
     * Delete the key of session.
     * Throw Exception when no key stored inside session
     * 
     * @param string $key Key of current session data
     * @throws Exception
     */
    public function DeleteKey($key){
        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }
        else{
            throw new Exception("Key data are null, at DeleteKey");
        }
    }

    public function DeleteSession(){
        if(isset($_SESSION)){
            unset($_SESSION);
            session_unset();
            session_destroy();
        }
        else{
            throw new Exception("Session not established, at DeleteSession.");
        }
    }
    
    public function StartSession(){
        session_start();
    }
    
    public function CreateSession(){
        if(session_status() == PHP_SESSION_NONE){
            $this->SessionID = session_id();
            $this->Started = true;
        }
        else{
            session_regenerate_id();
            $this->SessionID = session_id();
            $this->Started = true;
            $_SESSION["Session_Timeout"] = microtime(true);
        }
    }
    
    public function __destruct() {

    }
}
