<?php
require '../db/connection.php';

class PostManager {
    private $connection;

    public function __construct($database) {
        $this->connection = $database->connect();
    }

    public function deletePost($post_id) {
        $stmt = $this->connection->prepare("DELETE FROM posts WHERE post_id = ?");
        $stmt->bind_param("i", $post_id);

        if ($stmt->execute()) {
            return true; 
        } else {
            return false; 
        }
    }
}

$postManager = new PostManager($database);

$post_id = $_GET['id'] ?? NULL;

if($post_id == NULL){
    header('Location: blog_index.php');
    exit();
}

if ($postManager->deletePost($post_id)) {
    echo "<script>alert('The post has been successfully deleted.'); window.location.href = 'blog_index.php';</script>";
    exit();
} else {
}
?>

