<?php
/*
This file contains database login confirmation assuming ruuning mysql using user root and password ""
*/
define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','login');
//connecting to database
$conn=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
if($conn==false){
    dir("Connection failed");
}



?>