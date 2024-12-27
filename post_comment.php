<?php

require "db/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $post_id = $_POST["post_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    try {
        
        $sql = "INSERT INTO comments (post_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?)";
        $stmt = $database->connect()->prepare($sql);

        
        $stmt->bind_param("issss", $post_id, $name, $email, $subject, $message);

        
        if ($stmt->execute()) {
            

            echo "<script>alert('The comment has been successfully posted.');</script>";
            echo "<script>window.location.href = 'blog2.php?post_id=$post_id';</script>";
            exit();
        } else {
            echo "Error posting comment.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
