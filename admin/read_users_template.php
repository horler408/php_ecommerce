<?php
// Search form
echo "<form role='search' action='search.php'>";
echo "<div class='input-group col-md-3 pull-left margin-right-1em'>";
    $search_value=isset($search_term) ? "value='{$search_term}'" : "";
    echo "<input type='text' class='form-control' placeholder='Type user's first_name or last_name...' name='s' id='srch-term' required {$search_value} />";
    echo "<div class='input-group-btn'>";
        echo "<button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i></button>";
    echo "</div>";
echo "</div>";
echo "</form>";

// Link to create records
echo "<a href='./user_crud/create_user.php' class='btn btn-primary pull-right m-b-1em'>Create New User</a>";

if($num>0){
 
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Firstname</th>";
            echo "<th>Lastname</th>";
            echo "<th>Email</th>";
            echo "<th>Contact Number</th>";
            echo "<th>Access Level</th>";
            echo "<th>Actions</th>";
        echo "</tr>";
    
        // loop through the user records
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
    
            // display user details
            echo "<tr>";
                echo "<td>{$first_name}</td>";
                echo "<td>{$last_name}</td>";
                echo "<td>{$email}</td>";
                echo "<td>{$contact_number}</td>";
                echo "<td>{$access_level}</td>";
                echo "<td>";
                        // Link to show Single Item
                        echo "<a href='./user_crud/read_user.php?id={$id}' class='btn btn-info m-r-1em m-b-1em'>Read</a>";
                        // Link to edit a product
                        echo "<a href='./user_crud/update_user.php?id={$id}' class='btn btn-primary m-r-1em m-b-1em'>Edit</a>";
                        // Link to delete a product
                        echo "<a href='#' onclick='deleteProduct({$id});' class='btn btn-danger m-b-1em'>Delete</a>";
                    echo "</td>";
            echo "</tr>";
            }
    
    echo "</table>";
    
    $page_url="read_users.php?";
    $total_rows = $user->countAll();
 
    // actual paging buttons
    include_once './../components/paging.php';
}
 
// tell the user there are no selfies
else{
    echo "<div class='alert alert-danger'>
        <strong>No users found.</strong>
    </div>";
}
?>