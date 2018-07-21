<?php
require ('../Config/FileUpload_Config.php');
require ('../Engines/SessionManager.php');
require ('../Engines/SQLManager.php');
require ('../Config/Conn_Config.php');

if(isset($_FILES[FileConfigure::$FILE_VAR]["type"])){
    $ext_name = null;
    $file_name = null;
    
    $tmp = explode('.', $_FILES[FileConfigure::$FILE_VAR]["name"]);
    
    $file_ext = end($tmp);
    
    if($_FILES[FileConfigure::$FILE_VAR]["size"] >= FileConfigure::$MaxFileSize){
        echo json_encode(array("Result"=>"Err_1"));
    }
    else{
        $type_check = false;
        
        for($i=0; $i<count(FileConfigure::$SupportType); $i++){
            if($_FILES[FileConfigure::$FILE_VAR]["type"] == FileConfigure::$SupportType[$i]){
                $type_check = true;
                $file_ext = FileConfigure::$SupportExtension[$i];
            }
        }

        if($type_check == false){
            echo json_encode(array("Result"=>"Err_2"));
        }
        else{
            $Source = $_FILES[FileConfigure::$FILE_VAR]['tmp_name'];

            $tg_Path = FileConfigure::$TargetFolder_Temp_1. $_FILES[FileConfigure::$FILE_VAR]['name'];

            $file_name = (string) $_FILES[FileConfigure::$FILE_VAR]['name'];

            if (move_uploaded_file($Source, $tg_Path) == true){
                $Session = new SessionManager();
                $Session->StartSession();

                $UserId = $Session->GetSession("Login_ID");
                $nowDate = date('Y_m_d_h_i_s');
                $ran = rand(10000,99999);

                $new_file_name = $UserId.'_'.$nowDate.'_'.$ran.'.'.$file_ext;

                if(rename(FileConfigure::$TargetFolder_Temp_1.$file_name, FileConfigure::$TargetFolder_Temp_1.$new_file_name) == true){
                    if(copy(FileConfigure::$TargetFolder_Temp_1.$new_file_name, FileConfigure::$TargetFolder_Company_1.$new_file_name) == true){
                        if(unlink(FileConfigure::$TargetFolder_Temp_1.$new_file_name) == true){
                            $SqlMgr = new SQLManager(Connection::$Host, Connection::$DB_Id, Connection::$DB_Pw, Connection::$Schema);
                            $SqlMgr->Connect();
                            
                            $exist_file = null;
                            
                            $Conn = $SqlMgr->GetConnection();
                            $Res = $Conn->query("SELECT ImageName FROM users WHERE UserId=".$UserId.";");
                            
                            if($Res->num_rows > 0){
                                while($row = $Res->fetch_assoc()){
                                    $exist_file = $row["ImageName"];
                                }
                            }
                            
                            if($exist_file != null){
                                unlink(FileConfigure::$TargetFolder_Company_1.$exist_file);
                            }
                            
                            $SqlMgr->Disconnect();
                            $SqlMgr->Connect();
                            $Conn_2 = $SqlMgr->GetConnection();
                            $Res_2 = $Conn_2->query("UPDATE users SET ImageName='".$new_file_name."' WHERE UserId=".$UserId.";");
                            
                            if($Res_2 == true){
                                $Session->ChangeData("User_Pic", $new_file_name);
                                
                                echo json_encode(array("Result"=>"true"));
                            }
                            else{
                                echo json_encode(array("Result"=>"Err_8"));
                            }
                            
                            $SqlMgr->Disconnect();
                        }
                        else{
                            echo json_encode(array("Result"=>"Err_7"));
                        }
                    }
                    else{
                        echo json_encode(array("Result"=>"Err_6"));
                    }
                }
                else{
                    echo json_encode(array("Result"=>"Err_5"));
                }
            }
            else{
                echo json_encode(array("Result"=>"Err_4"));
            }
        }
    }
}