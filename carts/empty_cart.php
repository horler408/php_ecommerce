<?php
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
 
// read
$cookie = $_COOKIE['cart_items_cookie'];
$cookie = stripslashes($cookie);
$saved_cart_items = json_decode($cookie, true);
 
// remove values
unset($saved_cart_items);
 
// delete cookie value
unset($_COOKIE["cart_items_cookie"]);
 
// empty value and expiration one hour before
setcookie("cart_items_cookie", "", time() - 3600);
 
// enter empty value
$json = json_encode($saved_cart_items, true);
setcookie("cart_items_cookie", $json, time() + (86400 * 30), '/'); // 86400 = 1 day
$_COOKIE['cart_items_cookie']=$json;
 
// redirect
$redirect_to=isset($_GET['redirect_to']) ? $_GET['redirect_to'] : "";
 
// redirect to thank you page
if($redirect_to=="thank_you"){
    header('Location: thank_you.php');
}
 
// redirect to cart
else{
    header('Location: cart.php?action=empty_cart');
}
die();
?>
