<?php
// read cookie contents
$cookie = isset($_COOKIE['cart_items_cookie']) ? $_COOKIE['cart_items_cookie'] : "";
$cookie = stripslashes($cookie);
$saved_cart_items = json_decode($cookie, true);
 
// connect to database
include './../config/database.php';
include './../config/core.php';
 
// include objects
include_once "./../objects/product.php";
include_once "./../objects/product_image.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
 
// set page title
$page_title="Cart";
 
// include page header html
include './../products/layouts/header.php';
 
// contents will be here 
$action = isset($_GET['action']) ? $_GET['action'] : "";
 
echo "<div class='col-md-12'>";
    if($action=='removed'){
        echo "<div class='alert alert-info'>";
            echo "Product was removed from your cart!";
        echo "</div>";
    }
 
    else if($action=='quantity_updated'){
        echo "<div class='alert alert-info'>";
            echo "Product quantity was updated!";
        echo "</div>";
    }
 
    else if($action=='empty_cart'){
        echo "<div class='alert alert-danger'>";
            echo "Cart was emptied!";
        echo "</div>";
    }
 
    else if($action=='exists'){
        echo "<div class='alert alert-info'>";
            echo "Product already exists in your cart!";
        echo "</div>";
    }
echo "</div>";

if(count($saved_cart_items)>0){ 
    echo "<div class='col-md-12'>";
        // remove all cart contents
        echo "<div class='right-button-margin' style='overflow:hidden;'>";
            echo "<button class='btn btn-default pull-right' id='empty-cart'>Empty Cart</button>";
        echo "</div>";
    echo "</div>";
 
    // get the product ids
    $ids = array();
    foreach($saved_cart_items as $id=>$name){
        array_push($ids, $id);
    }
 
    $stmt=$product->readByIds($ids);
 
    $total=0;
    $item_count=0;
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $quantity = $saved_cart_items[$id]['quantity'];
        $sub_total = $price * $quantity;
 
        // =================
        echo "<div class='cart-row'>";
            echo "<div class='col-md-8'>";
 
                echo "<div class='product-name m-b-10px'>";
                    echo "<h4>{$name}</h4>";
                echo "</div>";
 
                // update quantity
                echo "<form class='update-quantity-form w-200-px'>";
                    echo "<div class='product-id' style='display:none;'>{$id}</div>";
                    echo "<input type='number' value='{$quantity}' name='quantity' class='form-control cart-quantity m-b-10px cart-quantity-dropdown' min='1' />";
                    echo "<button class='btn btn-default update-quantity' type='submit'>Update</button>";
                echo "</form>";
 
                // delete from cart
                echo "<a href='./remove_from_cart.php?id={$id}' class='btn btn-default'>";
                    echo "Delete";
                echo "</a>";
            echo "</div>";
 
            echo "<div class='col-md-4'>";
                echo "<h4>$" . number_format($price, 2, '.', ',') . "</h4>";
            echo "</div>";
        echo "</div>";
        // =================
 
        $item_count += $quantity;
        $total += $sub_total;
    }
 
    echo "<div class='col-md-8'></div>";
    echo "<div class='col-md-4'>";
        echo "<div class='cart-row'>";
            echo "<h4 class='m-b-10px'>Total ({$item_count} items)</h4>";
            echo "<h4>$" . number_format($total, 2, '.', ',') . "</h4>";
            echo "<a href='./checkout.php' class='btn btn-success m-b-10px'>";
                echo "<span class='glyphicon glyphicon-shopping-cart'></span> Proceed to Checkout";
            echo "</a>";
        echo "</div>";
    echo "</div>";
 
} 
else{
    echo "<div class='col-md-12'>";
        echo "<div class='alert alert-danger'>";
            echo "No products found in your cart!";
        echo "</div>";
    echo "</div>";
}
 
// layout footer 
include './../products/layouts/footer.php';
?>
