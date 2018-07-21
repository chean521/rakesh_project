<?php

class SQLManager{
    
    /** @var string */
    private $Host;
    /** @var string */
    private $UserID;
    /** @var string */
    private $Password;
    /** @var string */
    private $Schema;
    
    /** @var mysqli */
    private $Connection = NULL;
    
    /**
     * Construct SQL Manager to set the connection
     * 
     * @param string $Host
     * @param string $UserID
     * @param string $Passowrd
     * @param string $Schema
     */
    public function __construct($Host=null, $UserID=null, $Passowrd=null, $Schema=null) {
        $this->Host = $Host;
        $this->UserID = $UserID;
        $this->Password = $Passowrd;
        $this->Schema = $Schema;
    }
    
    /**
     * Connect to database with attributes set
     * @throws Exception
     */
    public function Connect(){
        if(empty($this->Host)||empty($this->UserID)||empty($this->Schema)){
            throw new Exception("Invalid connection info.");
        }
        else{
            $this->Connection = new mysqli($this->Host,$this->UserID,$this->Password,$this->Schema);
            
            if($this->Connection->error){
                throw new Exception("Connection failed, at Connect.");
            }
        }
    }
    
    /**
     * Disconnect the SQL Connection establish
     * @throws Exception
     */
    public function Disconnect(){
        if ($this->Connection == NULL) {
            throw new Exception("Connection not establish, at Disconnect.");
        }
        else{
            $this->Connection->close();
            
            $this->Connection = NULL;
        }
    }
    
    /**
     * Get Connected Connection Object
     * 
     * @return mysqli 
     * @throws Exception
     */
    public function GetConnection(){
        if($this->Connection == NULL){
            throw new Exception("Connection not establish, at Disconnect.");
        }
        else{
            return $this->Connection;
        }
    }
    
    public function __destruct() {
    }
    
    /**
     * Perform query result to get result data
     * 
     * Use @var1,@var2,... as the query attributes
     * 
     * @param string $query
     * @param array $attributes
     * @throws Exception
     * @return array Data output for query result
     */
    public function Query_Result($query, $attributes){
        if($this->Connection == NULL){
            throw new Exception("Connection not establish, at Query_Result.");
        }
        else{
            $Attr_Count = 0; $Pos = 0;
            
            for($i=0; $i< strlen($query); $i++){
                if(!strpos($query, "@var".($Attr_Count+1), $Pos) == false){
                    $Attr_Count++;
                    $Pos = $i;
                }
            }
            
            if($Attr_Count == count($attributes)){
                for($i=0; $i<count($attributes); $i++){
                    str_replace("@var".($i+1), "'".$attributes[$i]."'", $query);
                }
                
                $result = $this->Connection->query($query);
                
                if($result->num_rows > 0){
                    $Result_Data = array();
                    
                    while($row = $result->fetch_assoc()){
                        array_push($Result_Data, $row);
                    }
                    
                    return $Result_Data;
                }
                else{
                    return NULL;
                }
            }
            else{
                throw new Exception("Invalid query parameter, at Query_Result");
            }
        }
    }
    
}