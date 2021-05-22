<?php
// core.php holds pagination variables
include_once './../config/core.php';
  
// To include database and object files
include_once './../config/database.php';
include_once './../objects/product.php';
include_once './../objects/category.php';
  
// Database object
$database = new Database();
$db = $database->getConnection();
  
$product = new Product($db);
$category = new Category($db);
  
$page_title = "Read Products";
include_once "./layouts/header.php";

echo "<div class='col-md-12'>";
  
    // Query products
    $stmt = $product->readAll($from_record_num, $per_page);
    
    // Pagination Buttons here
    $page_url = "read_products.php?";
    
    $total_rows=$product->countAll();
    
    // To include read_template file that controls how product list will be rendered
    include_once "read_products_template.php";

echo "</div>";

// To set page footer
include_once "./../layouts/footer.php";
?>