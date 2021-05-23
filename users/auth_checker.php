<?php
 
// To check if access_level is Admin
if(isset($_SESSION['access_level']) && $_SESSION['access_level']=="Admin"){
    header("Location: {$home_url}admin/dashboard.php?action=logged_in_as_admin");
}
 
// To check if login is required
else if(isset($require_login) && $require_login==true){
    // if user not yet logged in, redirect to login page
    if(!isset($_SESSION['access_level'])){
        header("Location: {$home_url}users/login.php?action=please_login");
    }
}
 
// If already logged in and try to visit the login page again,
else if(isset($page_title) && ($page_title=="Login" || $page_title=="Sign Up")){
    // if user not yet logged in, redirect to login page
    if(isset($_SESSION['access_level']) && $_SESSION['access_level']=="User"){
        header("Location: {$home_url}users/dashboard.php?action=already_logged_in");
    }
}
 
else{
    // no problem, stay on current page
}
?>