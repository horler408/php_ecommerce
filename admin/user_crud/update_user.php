<?php
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// To include the database
include_once './../../config/database.php';
include_once './../../config/core.php';
  
// To initialise the objects
include_once './../../objects/user.php';
include_once './../../objects/gender.php';
  
// Database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$user = new User($db);
$gender = new Gender($db);
  
// set ID property of product to be edited
$user->id = $id;
  
// read the details of product to be edited
$user->readOne();
  
// set page header
$page_title = "Update Profile";
include_once "./../layouts/header.php";
  
echo "<div class='right-button-margin'>
          <a href='index.php' class='btn btn-default pull-right'>Home Page</a>
    </div>";

    if($_POST){
  
        // set product property values
        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->email = $_POST['email'];
        $user->address = $_POST['address'];
        $user->contact_number = $_POST['contact_number'];
        $user->gender_id = $_POST['gender_id'];
    
        $image = !empty($_FILES["image"]["name"])
        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]) : "";
        $user->image = $image;
      
        // update the product
        if($user->update()){
            echo "<div class='alert alert-success alert-dismissable'>";
                echo "Product was updated.";
            echo "</div>";
            echo $user->uploadPhoto();

        }
        else{
            echo "<div class='alert alert-danger alert-dismissable'>";
                echo "Unable to update product.";
            echo "</div>";
        }
    }

    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" enctype="multipart/form-data">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td class='width-30-percent'>Firstname</td>
                <td><input type='text' name='first_name' class='form-control' required value="<?php echo $user->first_name; ?>" /></td>
            </tr>
    
            <tr>
                <td>Lastname</td>
                <td><input type='text' name='last_name' class='form-control' required value="<?php echo $user->last_name; ?>" /></td>
            </tr>
    
            <tr>
                <td>Contact Number</td>
                <td><input type='text' name='contact_number' class='form-control' required value="<?php echo $user->contact_number; ?>" /></td>
            </tr>
    
            <tr>
                <td>Address</td>
                <td><textarea name='address' class='form-control' required><?php echo $user->address; ?></textarea></td>
            </tr>
    
            <tr>
                <td>Email</td>
                <td><input type='email' name='email' class='form-control' required value="<?php echo $user->email; ?>" /></td>
            </tr>

            <tr>
                <td>Gender</td>
                <td>
                    <?php
                    $stmt = $gender->read();
                    
                    // put them in a select drop-down
                    echo "<select class='form-control' name='gender_id'>";
                    
                        echo "<option>Please select...</option>";
                        while ($row_gender = $stmt->fetch(PDO::FETCH_ASSOC)){
                            $gender_id=$row_gender['id'];
                            $gender_name = $row_gender['name'];
                    
                            // current category of the product must be selected
                            if($user->gender_id == $gender_id){
                                echo "<option value='$gender_id' selected>";
                            }else{
                                echo "<option value='$gender_id'>";
                            }
                    
                            echo "$gender_name</option>";
                        }
                    echo "</select>";
                    ?>
                </td>
            </tr>

            <tr>
                <td>Photo</td>
                <td><input type="file" name="image" ></td>
            </tr>
    
            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span> Update
                    </button>
                    <a href="./../dashboard.php" class="btn btn-danger">Return to Dashboard</a>
                </td>
            </tr>
    
        </table>
    </form>
    <?php

// set page footer
include_once "./../layouts/footer.php";
?>

