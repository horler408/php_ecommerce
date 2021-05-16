<?php
// core configuration
include_once "./../../config/core.php";
 
// set page title
$page_title = "Create User";
 
// include login checker
include_once "./../auth_checker.php";
 
// include classes
include_once './../../config/database.php';
include_once './../../objects/user.php';
include_once "./../../libs/php/utils.php";
 
// include page header HTML
include_once "./../layouts/header.php";
 
echo "<div class='col-md-12'>";
 
    if($_POST) {
        // Database connection
        $database = new Database();
        $db = $database->getConnection();
    
        // To initialize objects
        $user = new User($db);
    
        // To set user email to detect if it already exists
        $user->email=$_POST['email'];
    
        // To check if email already exists
        if($user->emailExists()){
            echo "<div class='alert alert-danger'>";
                echo "The email you specified is already registered. Please try again or <a href='{$home_url}login'>login.</a>";
            echo "</div>";
        }
    
        else{
            $user->firstname=$_POST['firstname'];
            $user->lastname=$_POST['lastname'];
            $user->contact_number=$_POST['contact_number'];
            $user->address=$_POST['address'];
            $user->password=$_POST['password'];
            $user->access_level='Customer';
            $user->status=1;
            
            if($user->create()){
            
                echo "<div class='alert alert-info'>";
                    echo "Successfully registered. <a href='{$home_url}login'>Please login</a>.";
                echo "</div>";
            
                // empty posted values
                $_POST=array();
            
            }else{
                echo "<div class='alert alert-danger' role='alert'>Unable to register. Please try again.</div>";
            }
        }
    }

    ?>
    <form action='register.php' method='post' id='register'>
        <table class='table table-responsive'>
            <tr>
                <td class='width-30-percent'>Firstname</td>
                <td><input type='text' name='first_name' class='form-control' required value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname'], ENT_QUOTES) : "";  ?>" /></td>
            </tr>
    
            <tr>
                <td>Lastname</td>
                <td><input type='text' name='last_name' class='form-control' required value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname'], ENT_QUOTES) : "";  ?>" /></td>
            </tr>
    
            <tr>
                <td>Contact Number</td>
                <td><input type='text' name='contact_number' class='form-control' required value="<?php echo isset($_POST['contact_number']) ? htmlspecialchars($_POST['contact_number'], ENT_QUOTES) : "";  ?>" /></td>
            </tr>
    
            <tr>
                <td>Address</td>
                <td><textarea name='address' class='form-control' required><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address'], ENT_QUOTES) : "";  ?></textarea></td>
            </tr>
    
            <tr>
                <td>Email</td>
                <td><input type='email' name='email' class='form-control' required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : "";  ?>" /></td>
            </tr>
    
            <tr>
                <td>Password</td>
                <td><input type='password' name='password' class='form-control' required id='passwordInput'></td>
            </tr>
    
            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span> Create
                    </button>
                    <a href="./../dashboard.php" class="btn btn-danger">Return to Dashboard</a>
                </td>
            </tr>
    
        </table>
    </form>
    <?php
 
echo "</div>";
 
// include page footer HTML
include_once "./../layouts/footer.php";
?>