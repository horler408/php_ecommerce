<?php 
    class User {
        private $conn;
        private $table_name = "users";
    
        // Object properties
        public $id;
        public $first_name;
        public $last_name;
        public $email;
        public $contact_number;
        public $address;
        public $gender_id;
        public $image;
        public $password;
        public $access_level;
        public $access_code;
        public $status;
        public $created;
        public $modified;
    
        // constructor
        public function __construct($db){
            $this->conn = $db;
        }

        function emailExists() {
            $query = "SELECT id, first_name, last_name, access_level, password, status
                    FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";

            $stmt = $this->conn->prepare($query);

            // To sanitise email input
            $this->email = htmlspecialchars(strip_tags($this->email));

            $stmt->bindParam(1, $this->email);
            $stmt->execute();

            // To get number of rows
            $num = $stmt->rowCount();

            if($num > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // To assign value to object properties
                $this->id = $row['id'];
                $this->first_name = $row['first_name'];
                $this->last_name = $row['last_name'];
                $this->access_level = $row['access_level'];
                $this->password = $row['password'];
                $this->status = $row['status'];

                return true;
            }
                return false;
        }

        function create() {
            // To get the time stamp
            $this->created = date('Y-m-d H:i:s');

            $query = "INSERT INTO " . $this->table_name . "
                    SET 
                        first_name = :first_name,
                        last_name = :last_name,
                        email = :email,
                        contact_number = :contact_number,
                        address = :address,
                        password = :password,
                        access_level = :access_level,
                        access_code = :access_code,
                        status = :status,
                        created = :created";

            $stmt = $this->conn->prepare($query);

            // To sanitise inputs
            $this->first_name=htmlspecialchars(strip_tags($this->first_name));
            $this->last_name=htmlspecialchars(strip_tags($this->last_name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->contact_number=htmlspecialchars(strip_tags($this->contact_number));
            $this->address=htmlspecialchars(strip_tags($this->address));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->access_level=htmlspecialchars(strip_tags($this->access_level));
            $this->access_code=htmlspecialchars(strip_tags($this->access_code));
            $this->status=htmlspecialchars(strip_tags($this->status));

            // To hash the password before saving to database
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

            // To bind the values
            $stmt->bindParam(':first_name', $this->first_name);
            $stmt->bindParam(':last_name', $this->last_name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':contact_number', $this->contact_number);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':access_level', $this->access_level);
            $stmt->bindParam(':access_code', $this->access_code);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':created', $this->created);

            if($stmt->execute()) {
                return true;
            }else {
                $this->showError($stmt);
                return false;
            }
        }

        function readAll($from_record_num, $per_page) {
            $query = "SELECT id, first_name, last_name, email, contact_number, access_level, created
                    FROM " . $this->table_name . " ORDER BY id DESC LIMIT ?, ?";

            $stmt = $this->conn->prepare($query);

            // To bind variable values
            $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
            $stmt->bindParam(2, $per_page, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;
        }

        function readOne() {
            $query = "SELECT id, first_name, last_name, email, address, gender_id, image, contact_number 
                    FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(1, $this->id);
    
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $this->first_name = $row['first_name'];
            $this->last_name = $row['last_name'];
            $this->email = $row['email'];
            $this->contact_number = $row['contact_number'];
            $this->address = $row['address'];
            $this->gender_id = $row['gender_id'];
            $this->image = $row['image'];
    
        }

        function update() {
            $query = "UPDATE " . $this->table_name . "
                    SET 
                        first_name = :first_name,
                        last_name = :last_name,
                        email = :email,
                        contact_number = :contact_number,
                        address = :address,
                        gender_id = :gender_id,
                        image = :image,
                        WHERE id=:id";
            $stmt = $this->conn->prepare($query);

            // Posted values
            $this->first_name = htmlspecialchars(strip_tags($this->first_name));
            $this->last_name = htmlspecialchars(strip_tags($this->last_name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->address = htmlspecialchars(strip_tags($this->address));
            $this->contact_number = htmlspecialchars(strip_tags($this->contact_number));
            $this->gender_id = htmlspecialchars(strip_tags($this->gender_id));
            $this->image = htmlspecialchars(strip_tags($this->image));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // To bind the parameters
            $stmt->bindParam(":first_name", $this->first_name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":contact_number", $this->first_number);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":address", $this->address);
            $stmt->bindParam(":gender_id", $this->gender_id);
            $stmt->bindParam(":image", $this->image);
            $stmt->bindParam(":id", $this->id);

            if($stmt->execute()) {
                return true;
            }else {
                return false;
            }
        }

        function delete() {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);

            if($result = $stmt->execute()) {
                return true;
            }else {
                return false;
            }
        }

        public function search($search_term, $from_record_num, $per_page) {
            $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
                    FROM " . $this->table_name . " p 
                    LEFT JOIN 
                        categories c
                    ON 
                        p.category_id = c.id
                    WHERE 
                        p.name LIKE ? OR p.description LIKE ?
                    ORDER BY
                        p.name ASC
                    LIMIT ?, ?";

            $stmt = $this->conn->prepare($query);

            // To bind the variable values
            $search_term = "%{$search_term}%";

            $stmt->bindParam(1, $search_term);
            $stmt->bindParam(2, $search_term);
            $stmt->bindParam(3, $from_record_num, PDO::PARAM_INT);
            $stmt->bindParam(4, $from_record_num, PDO::PARAM_INT);

            $stmt->execute();

            // Return values from database
            return $stmt;
        }

        public function countAll_BySearch($search_term) {
            $query = "SELECT COUNT(*) as total_rows 
                    FROM " . $this->table_name . " p
                    WHERE p.name LIKE ? OR p.description LIKE ?";
            $stmt = $this->conn->prepare($query);

            $search_term = "%{$search_term}%";
            $stmt->bindParam(1, $search_term);
            $stmt->bindParam(2, $search_term);

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row['total_rows'];
    
        }

        public function uploadPhoto() {
            $result_message = "";
  
            if($this->image){
                $target_directory = "uploads/";
                $target_file = $target_directory . $this->image;
                $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
        
                // error message is empty
                $file_upload_error_messages="";

                // To check that the uploaded file is an image
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if($check!==false){
                }else{
                    $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
                }
                
                // To ensure coorect file format
                $allowed_file_types=array("jpg", "jpeg", "png", "gif");
                if(!in_array($file_type, $allowed_file_types)){
                    $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
                }
                
                // To check if the file already exist
                if(file_exists($target_file)){
                    $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
                }
                
                // To restrict the size of the file to maximum of 1MB
                if($_FILES['image']['size'] > (1024000)){
                    $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
                }
                
                // To create the upload folder if not exist
                if(!is_dir($target_directory)){
                    mkdir($target_directory, 0777, true);
                }

                // What happens when $file_upload_error_messages is still empty
                if(empty($file_upload_error_messages)){
                    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                        // it means photo was uploaded
                    }else{
                        $result_message.="<div class='alert alert-danger'>";
                            $result_message.="<div>Unable to upload photo.</div>";
                            $result_message.="<div>Update the record to upload photo.</div>";
                        $result_message.="</div>";
                    }
                }
                
                // What happens if $file_upload_error_messages is NOT empty
                else{
                    $result_message.="<div class='alert alert-danger'>";
                        $result_message.="{$file_upload_error_messages}";
                        $result_message.="<div>Update the record to upload photo.</div>";
                    $result_message.="</div>";
                }
        
            }
        
            return $result_message;
        }

        function countAll() {
            $query = "SELECT id FROM " . $this->table_name . "";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $num = $stmt->rowCount();

            return $num;
        }

        function accessCodeExists(){
            $query = "SELECT id
                    FROM " . $this->table_name . "
                    WHERE access_code = ?
                    LIMIT 0,1";
         
            $stmt = $this->conn->prepare( $query );
         
            // To sanitize the input
            $this->access_code=htmlspecialchars(strip_tags($this->access_code));
         
            $stmt->bindParam(1, $this->access_code);
            $stmt->execute();
         
            // To get number of rows
            $num = $stmt->rowCount();
         
            // To check if access_code exists
            if($num>0){
                return true;
            }
            return false;
         
        }

        function updateStatusByAccessCode(){
            $query = "UPDATE " . $this->table_name . "
                    SET status = :status
                    WHERE access_code = :access_code";
         
            $stmt = $this->conn->prepare($query);
         
            $this->status=htmlspecialchars(strip_tags($this->status));
            $this->access_code=htmlspecialchars(strip_tags($this->access_code));
         
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':access_code', $this->access_code);
         
            // execute the query
            if($stmt->execute()){
                return true;
            }
            return false;
        }

        function updateAccessCode(){
            $query = "UPDATE
                        " . $this->table_name . "
                    SET
                        access_code = :access_code
                    WHERE
                        email = :email";
    
            $stmt = $this->conn->prepare($query);
         
            $this->access_code=htmlspecialchars(strip_tags($this->access_code));
            $this->email=htmlspecialchars(strip_tags($this->email));
         
            $stmt->bindParam(':access_code', $this->access_code);
            $stmt->bindParam(':email', $this->email);
         
            // execute the query
            if($stmt->execute()){
                return true;
            }
         
            return false;
        }

        public function showError($stmt){
            echo "<pre>";
                print_r($stmt->errorInfo());
            echo "</pre>";
        }

        function updatePassword(){
            $query = "UPDATE " . $this->table_name . "
                    SET password = :password
                    WHERE access_code = :access_code";
         
            $stmt = $this->conn->prepare($query);
         
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->access_code=htmlspecialchars(strip_tags($this->access_code));
         
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':access_code', $this->access_code);
         
            // execute the query
            if($stmt->execute()){
                return true;
            }
         
            return false;
        }
    }
?>