<?php
// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : 1;
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : "";
 
// make quantity a minimum of 1
$quantity=$quantity<=0 ? 1 : $quantity;
 
// read cookie
$cookie = $_COOKIE['cart_items_cookie'];
$cookie = stripslashes($cookie);
$saved_cart_items = json_decode($cookie, true);
 
// remove the item from the array
unset($saved_cart_items[$id]);
 
// delete cookie value
setcookie("cart_items_cookie", "", time()-3600);
 
// add the item with updated quantity
$saved_cart_items[$id]=array(
    'quantity'=>$quantity
);
 
// enter new value
$json = json_encode($saved_cart_items, true);
setcookie("cart_items_cookie", $json, time() + (86400 * 30), '/'); // 86400 = 1 day
$_COOKIE['cart_items_cookie']=$json;
 
// redirect to product list and tell the user it was added to cart
header('Location: cart.php?action=quantity_updated&id=' . $id);
die();
?>