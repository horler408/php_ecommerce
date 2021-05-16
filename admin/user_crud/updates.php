<?php
    $id = isset($_GET["id"]) ? $_GET["id"] : die("User ID not found!");

    // set page title
    $page_title = "Update User";

    // To include the database
    include_once './../../config/database.php';
    include_once './../../config/core.php';

    // To include the header html
    include_once "./../layouts/header.php";

    // Codes that fetched the data to be updated
    try {
        $query = "SELECT id, first_name, last_name, email, address, contact_number FROM users WHERE id = ? LIMIT 0,1";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(1, $id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
        $contact_number = $row['contact_number'];
        $address = $row['address'];

    }catch(PDOException $e) {
        die("ERROR: " .$e->getMessage());
    }

    // Code that saves the updated data
    if($_POST) {
        try {
            $query = "UPDATE users
                    SET 
                        first_name = :first_name,
                        last_name = :last_name,
                        email = :email,
                        contact_number = :contact_number,
                        address = :address,
                        WHERE id=:id";
        
            $stmt = $conn->prepare($query);

            $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
            $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
            $email = htmlspecialchars(strip_tags($_POST['email']));
            $contact_number = htmlspecialchars(strip_tags($_POST['contact_number']));
            $address = htmlspecialchars(strip_tags($_POST['address']));

            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contact_number', $contact_number);
            $stmt->bindParam(':address', $address);

            if($stmt->execute()) {
                echo "<div class='alert alert-success'>Product updated successfully</div>";
            }else {
                echo "<div class='alert alert-danger'>Unable to update product, please try again.</div>";
            }

        }catch(PDOException $e) {
            die("Error: " .$e.getMessage());
        }
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?id={$id}"); ?>" method="post">
        <table class="table table-hover table-responsive table-bordered">
        <tr>
                <td class='width-30-percent'>Firstname</td>
                <td><input type='text' name='first_name' class='form-control' required value="<?php echo htmlspecialchars($first_name, ENT_QUOTES); ?>" /></td>
            </tr>
    
            <tr>
                <td>Lastname</td>
                <td><input type='text' name='last_name' class='form-control' required value="<?php echo htmlspecialchars($last_name, ENT_QUOTES); ?>" /></td>
            </tr>
    
            <tr>
                <td>Contact Number</td>
                <td><input type='text' name='contact_number' class='form-control' required value="<?php echo htmlspecialchars($contact_number, ENT_QUOTES); ?>" /></td>
            </tr>
    
            <tr>
                <td>Address</td>
                <td><textarea name='address' class='form-control' required><?php echo htmlspecialchars($address, ENT_QUOTES); ?></textarea></td>
            </tr>
    
            <tr>
                <td>Email</td>
                <td><input type='email' name='email' class='form-control' required value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>" /></td>
            </tr>
    
            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span> Save
                    </button>
                    <a href="./../dashboard.php" class="btn btn-danger">Return to Dashboard</a>
                </td>
            </tr>
        </table>
    </form>
    
    <?php
    // To include footer html
    include_once "./../layouts/footer.php";
?>
