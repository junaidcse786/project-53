<?php
	
	session_start();
	
    date_default_timezone_get();	
    $DB_HOST = "localhost";
    $DB_USER = "root";
    $DB_PASSWORD = "";
    $DB_NAME = "project-52";
	$db = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
	
	if(!($db))
     	trigger_error("Could not connect to the database", E_USER_ERROR);
		
	$db_suffix='ecom_';
	$config_sql = "SELECT * FROM ".$db_suffix."config";
	
    $config_query = mysqli_query($db,$config_sql);
    while($site_obj = mysqli_fetch_object($config_query))
    {    
        if(trim($site_obj->config_name) == 'SITE_NAME')        
            $site_name = $site_obj->config_value;
        if(trim($site_obj->config_name) == 'SITE_URL')    
            $site_url = $site_obj->config_value;
	if(trim($site_obj->config_name) == 'DB_SUFFIX')    
            $db_suffix = $site_obj->config_value;
       define($site_obj->config_name,$site_obj->config_value);
    }  
	
    unset($config_sql,$config_query); 
    define('ROOT_URL', $site_url);		
	
?>