<?php
require_once '../db/connection.php';

class DeleteComment {
       private $conn;
   
       public function __construct($conn) {
           $this->conn = $conn;
       }
   
       public function deleteRecord($comment_id) {
           $sql = "DELETE FROM comments WHERE comment_id = ?";
           $stmt = $this->conn->prepare($sql);
           $stmt->bind_param("i", $comment_id);

                if ($stmt->execute()) {
                    $stmt->close();
                    return true;
                } else {
                    return false;
                }

       }
   }
   
   if (isset($_GET['id']) && !empty($_GET['id'])) {
       $comment_id = intval($_GET['id']);
       $deleteComment = new DeleteComment($conn);
   
       if ($deleteComment->deleteRecord($comment_id)) {
           echo "<script>alert('The comment has been deleted successfully.');</script>";
           echo "<script>window.location.href = 'comment_index.php';</script>";
           exit();
       } else {
           header("Location: comment_index.php?error=deletion_failed");
           exit();
       }
   } else {
       header("Location: comment_index.php?error=invalid_id");
       exit();
   }
?>
