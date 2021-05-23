<?php
include_once "./../config/core.php";

// include login checker
$require_login=true;
include_once "./../users/auth_checker.php";

// To set page title
$page_title="Add Cart";

include "./../layouts.header.php";

$id = isset($_GET['id']) ? $_GET['id'] : "";
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : 1;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// make quantity a minimum of 1
$quantity = $quantity<=0 ? 1 : $quantity;
 
// add new item on array
$cart_items[$id] = array(
    'quantity'=>$quantity
);
 
// read
$cookie = isset($_COOKIE['cart_items_cookie']) ? $_COOKIE['cart_items_cookie'] : "";
$cookie = stripslashes($cookie);
$saved_cart_items = json_decode($cookie, true);
 
// if $saved_cart_items is null, prevent null error
if(!$saved_cart_items){
    $saved_cart_items=array();
}
 
// check if the item is in the array, if it is, do not add
if(array_key_exists($id, $saved_cart_items)){
    // redirect to product list and tell the user it was added to cart
    header('Location: ./../products/product.php?id=' . $id . '&action=exists');
}
 
// else, add the item to the array
else{
    // if cart has contents
    if(count($saved_cart_items)>0){
        foreach($saved_cart_items as $key=>$value){
            // add old item to array, it will prevent duplicate keys
            $cart_items[$key]=array(
                'quantity'=>$value['quantity']
            );
        }
    }
 
    // put item to cookie
    $json = json_encode($cart_items, true);
    setcookie("cart_items_cookie", $json, time() + (86400 * 30), '/'); // 86400 = 1 day
    $_COOKIE['cart_items_cookie']=$json;
 
    // redirect to product list and tell the user it was added to cart
    header('Location: ./../products/product.php?id=' . $id . '&action=added');
}
die();

include "./../layouts.footer.php";
?>
