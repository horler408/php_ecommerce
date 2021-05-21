<?php 
    if($_POST) {
        include_once "./../../config/database.php";
        include_once "./../../objects/user.php";

        // Database connection
        $database = new Database();
        $db = $database->getConnection();

        // Product object
        $user = new User($db);

        // To set product id to be deleted
        $user->id = $_POST['object_id'];

        // To delete the product
        if($user->delete()) {
            echo "<div>User was deleted successfully!</div>";
        }else {
            echo "<div>Unable to delete user</div>";
        }
    }
?>