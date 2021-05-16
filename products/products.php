<?php
// read items in the cart
$cookie = isset($_COOKIE['cart_items_cookie']) ? $_COOKIE['cart_items_cookie'] : "";
$cookie = stripslashes($cookie);
$saved_cart_items = json_decode($cookie, true);
 
// to prevent null value
$saved_cart_items = $saved_cart_items == null ? array() : $saved_cart_items;
 
// connect to database
include './../config/database.php';
 
// include objects
include_once "./../objects/product.php";
include_once "./../objects/product_image.php";

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);

// to prevent undefined index notice
$action = isset($_GET['action']) ? $_GET['action'] : "";
 
// for pagination purposes
$page = isset($_GET['page']) ? $_GET['page'] : 1; 
$per_page = 6;
$from_record_num = ($per_page * $page) - $per_page;


// set page title
$page_title="Products";
 
// page header html
include './../layouts/header.php';
 
// contents will be here 
echo "<div class='col-md-12'>";
    if($action=='added'){
        echo "<div class='alert alert-info'>";
            echo "Product was added to your cart!";
        echo "</div>";
    }
 
    if($action=='exists'){
        echo "<div class='alert alert-info'>";
            echo "Product already exists in your cart!";
        echo "</div>";
    }
echo "</div>";

// read all products in the database
$stmt = $product->read($from_record_num, $per_page);
 
// count number of retrieved products
$num = $stmt->rowCount();
 
// if products retrieved were more than zero
if($num>0){
    // needed for paging
    $page_url="products.php?";
    $total_rows=$product->count();
 
    // show products
    include_once "products_template.php";
}
 
// tell the user if there's no products in the database
else{
    echo "<div class='col-md-12'>";
        echo "<div class='alert alert-danger'>No products found.</div>";
    echo "</div>";
}

// layout footer code
include './../layouts/footer.php';
?>