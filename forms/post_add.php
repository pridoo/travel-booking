<?php

class SessionManager {
    public static function checkAdminSession() {
        session_start();
        if (!isset($_SESSION['userAdmin'])) {
            header("Location: ../login.php");
            exit();
        }
    }
}

SessionManager::checkAdminSession();

require '../db/connection.php';

class PostManager {
    private $connection;

    public function __construct($database) {
        $this->connection = $database->connect();
    }

    public function addPost($data) {
        $stmt = $this->connection->prepare("INSERT INTO posts (title, category, author, date, content, image, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $data['title'], $data['category'], $data['author'], $data['date'], $data['content'], $data['image'], $data['status']);

        if ($stmt->execute()) {
            return true; 
        } else {
            return false; 
        }
    }
}

$postManager = new PostManager($database);

if(isset($_POST['post_add'])){
    $data=[];
    foreach ($_POST as $name => $val){
        if($name!="post_add")
            $data[$name] = $val;
    }

    if (isset($_FILES['image'])) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_path = "../img/" . $image_name;

        if (move_uploaded_file($image_tmp_name, $image_path)) {
            $data['image'] = $image_name;
        } else {
            
        }
    }

    if ($postManager->addPost($data)) {
        echo "<script>alert('The post has been successfully added.'); window.location.href = 'blog_index.php';</script>";
        exit();
    } else {
        
    }
}      

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin Dashboard</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>
<body class="sb-nav-fixed">
    
<?php include 'navbar.php'; ?>

        <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Add Post</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active"><a href="index.php" style="text-decoration: none;">Blogs</a> / Add</li>
                </ol>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold;">Title</label>
                        <input type="text" name="title" class="form-control"  required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold;">Category</label>
                        <input type="text" name="category" class="form-control"  required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold;">Author</label>
                        <input type="text" name="author" class="form-control"  required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold;">Date</label>
                        <input type="date" name="date" class="form-control"  required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold;">Content</label>
                        <textarea name="content" id="content" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                            <label class="form-label" style="font-weight: bold;">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" id="imageUpload">
                            <button type="button" id="previewButton" class="btn btn-secondary"><i class="fas fa-eye"></i> Preview</button>
                            <img id="imagePreview" style="display:none; max-width: 100%; max-height: 400px; margin: auto;" />
                    </div>
                    

                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold;">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="draft" >Draft</option>
                            <option value="active" >Active</option>
                        </select>
                    </div>
                    <button type="submit" name="post_add" class="btn btn-success w-100 mb-1">Add</button>
                    <a href="blog_index.php" class="btn btn-danger w-100 mb-2">Cancel</a>
                </form>
            </div>
        </main>
        <?php include 'footer.php'; ?>
    </div>
</div>

    <script src="js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@u5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/r1qqk5o6ua6mw30hd4vnhl4lct13258xcfdkqrvkwv8mi3kq/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
    </script>

    <script>
        class ImagePreviewManager {
            constructor(imageUploadId, imagePreviewId, previewButtonId) {
                this.imageUpload = document.getElementById(imageUploadId);
                this.imagePreview = document.getElementById(imagePreviewId);
                this.previewButton = document.getElementById(previewButtonId);
                this.isPreviewVisible = false;

                this.init();
            }

            init() {
                this.imageUpload.addEventListener("change", () => {
                    this.updatePreview();
                });
                this.previewButton.addEventListener("click", () => {
                    this.togglePreview();
                });
            }

            updatePreview() {
                if (this.imageUpload.files && this.imageUpload.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imagePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(this.imageUpload.files[0]);
                    this.imagePreview.style.display = "block";
                }
            }

            togglePreview() {
                if (!this.isPreviewVisible) {
                    if (this.imageUpload.files && this.imageUpload.files[0]) {
                        this.updatePreview();
                    } else {
                        alert("No file chosen.");
                    }
                    this.isPreviewVisible = true;
                } else {
                    this.imagePreview.style.display = "none";
                    this.isPreviewVisible = false;
                }
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            const imagePreviewManager = new ImagePreviewManager("imageUpload", "imagePreview", "previewButton");
        });
    </script>


</body>
</html>


