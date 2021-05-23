<?php
// core configuration and database
include_once "./../config/core.php";
include_once './../config/database.php';
 
// To include classes
include_once './../objects/user.php';
 
// To get database connection
$database = new Database();
$db = $database->getConnection();
 
// To initialize objects
$user = new User($db);
 
// To set access code
$user->access_code=isset($_GET['access_code']) ? $_GET['access_code'] : "";
 
// To verify if access code exists
if(!$user->accessCodeExists()){
    die("ERROR: Access code not found.");
}
 
// redirect to login
else{  
    // update status
    $user->status=1;
    $user->updateStatusByAccessCode();
     
    // and the redirect
    header("Location: {$home_url}users/login.php?action=email_verified");
}
?>