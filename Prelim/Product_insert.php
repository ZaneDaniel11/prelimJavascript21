<?php
include('Connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Name = $_POST['name'];
    $Category = $_POST['category'];
    $Quantity = $_POST['quantity'];
    $Image = $_FILES['image']['name']; // Get the image name from files array
    $ImageTmp = $_FILES['image']['tmp_name']; // Get the temporary file name

    // Specify the directory where images will be stored
    $target_dir = "./uploads/";
    // Generate a unique file name to avoid overwriting existing files
    $target_file = $target_dir . uniqid() . basename($Image);

    // Move the uploaded file to the specified directory
    if (move_uploaded_file($ImageTmp, $target_file)) {
        // Prepare and execute the SQL query to insert product data
        $query = "INSERT INTO product (name,category,quantity,image_url) 
                  VALUES (?, ?, ?, ?)";
        $statement = $connection->prepare($query);
        $statement->bind_param("ssss", $Name, $Category, $Quantity, $target_file);
        $res = $statement->execute();

        if ($res) {
            echo json_encode(["res" => "success"]);
        } else {
            echo json_encode(["res" => "error", "message" => "Failed to insert data"]);
        }
    } else {
        echo json_encode(["res" => "error", "message" => "Failed to upload image"]);
    }
} else {
    echo json_encode(["res" => "error", "message" => "Invalid request method"]);
}
?>
