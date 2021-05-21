<?php
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// To include database and core
include_once './../../config/database.php';
include_once './../../config/core.php';

// To include the objects
include_once './../../objects/user.php';
include_once './../../objects/gender.php';
  
// Database connection
$database = new Database();
$db = $database->getConnection();
  
// Objects
$user = new User($db);
$gender = new Gender($db);
  
// To set ID property of user to be read
$user->id = $id;
  
$user->readOne();

// set page headers
$page_title = "Read One User";
include_once "./../layouts/header.php";
  
// Home page button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Home Page";
    echo "</a>";
echo "</div>";

// HTML table for displaying a user details
echo "<table class='table table-hover table-responsive table-bordered'>";
  
    echo "<tr>";
        echo "<td>First Name</td>";
        echo "<td>{$user->first_name}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Last Name</td>";
        echo "<td>{$user->last_name}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Phone Number</td>";
        echo "<td>{$user->contact_number}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Email</td>";
        echo "<td>{$user->email}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Address</td>";
        echo "<td>{$user->address}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Gender</td>";
        echo "<td>";
            // To display gender name
            $gender->id=$user->gender_id;
            $gender->readName();
            echo $gender->name;
        echo "</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Image</td>";
        echo "<td>";
            echo $user->image ? "<img src='uploads/{$user->image}' style='width:300px;' />" : "No image found.";
        echo "</td>";
    echo "</tr>";
  
echo "</table>";
  
// To set the footer
include_once "./../layouts/footer.php";
?>