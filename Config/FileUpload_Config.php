<?php

class FileConfigure{
    
    public static $MaxFileSize = 2097152; // 2 MB in bytes (x2(1024))
    public static $SupportExtension = array("png", "jpg", "jpeg");
    public static $SupportType = array("image/png", "image/jpg", "image/jpeg");
    public static $TargetFolder_Company_1 = "../LogoPic/Company/";
    public static $TargetFolder_Company_2 = "../../LogoPic/Company/";
    public static $TargetFolder_Temp_1 = "../LogoPic/Temp/";
    public static $TargetFolder_Temp_2 = "../../LogoPic/Temp/";
    public static $RootFolder_1 = "../LogoPic/";
    public static $RootFolder_2 = "../../LogoPic/";
    public static $FILE_VAR = "company_logo";
    
}
