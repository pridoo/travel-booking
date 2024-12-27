<?php
session_start();

class SessionManager {
    public static function checkAdminSession() {
        if (!isset($_SESSION['userAdmin'])) {
            header("Location: ../login.php");
            exit();
        }
    }
}

require '../db/connection.php'; 

$post_id = $_GET['id'] ?? NULL;

if ($post_id == NULL) {
    header("Location: blog_index.php");
    exit();
}

$database = new Database(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
$conn = $database->connect();

if (isset($_POST['post_update'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $date = $_POST['date'];
    $content = $_POST['content'];
    $status = $_POST['status'];
    $image = isset($_FILES['image']['name']) && $_FILES['image']['error'] == UPLOAD_ERR_OK ? $_FILES['image']['name'] : null;

    if ($image) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_path = "img/" . $image;

        if (move_uploaded_file($image_tmp_name, $image_path)) {
        } else {

        }
    } else {
        $existing_image_query = "SELECT image FROM posts WHERE post_id = ?";
        $stmt = $conn->prepare($existing_image_query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $image = $row['image'];
        }
    }

    $stmt = $conn->prepare("UPDATE posts SET title=?, category=?, author=?, date=?, content=?, status=?, image=? WHERE post_id=?");
    $stmt->bind_param("sssssssi", $title, $category, $author, $date, $content, $status, $image, $post_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('The post has been updated successfully!');</script>";
        echo "<script>window.location.href = 'blog_index.php';</script>";
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

<?php
class Post {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getPostById($post_id) {
        $query = "SELECT * FROM posts WHERE post_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            return false; 
        }

        $post = $result->fetch_assoc();
        $stmt->close();

        return $post;
    }
}


$database = new Database(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
$conn = $database->connect();

$postHandler = new Post($conn);

$post_id = $_GET['id'] ?? NULL;

if ($post_id == NULL) {
    header("Location: blog_index.php");
    exit();
}

$post = $postHandler->getPostById($post_id);

if (!$post) {
    echo "Post not found";
    exit();
}

$title = $post['title'];
$category = $post['category'];
$author = $post['author'];
$date = $post['date'];
$content = $post['content'];
$status = $post['status'];
?>

        <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Update Post</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active"><a href="index.php" style="text-decoration: none;">Dashboard</a> / Update</li>
                </ol>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold;">Title</label>
                        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($title) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold;">Category</label>
                        <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($category) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold;">Author</label>
                        <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($author) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold;">Date</label>
                        <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($date) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight: bold;">Content</label>
                        <textarea name="content" id="content" class="form-control" required><?= htmlspecialchars($content) ?></textarea>
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
                            <option value="active" <?= $status === 'Active' ? 'selected' : '' ?>>
                                <?php echo $status === 'active' ? 'Active' : 'Active'; ?>
                            </option>
                            <option value="draft" <?= $status === 'Draft' ? 'selected' : '' ?>>
                                <?php echo $status === 'draft' ? 'Draft' : 'Draft'; ?>
                            </option>
                        </select>
                    </div>
                    <button type="submit" name="post_update" class="btn btn-success w-100 mb-1">Update</button>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
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

                const imageUrlFromDatabase = "<?php echo $post['image']; ?>";
                if (imageUrlFromDatabase) {
                    const fullImageUrl = "../img/" + imageUrlFromDatabase;
                    this.imagePreview.src = fullImageUrl;
                    this.imagePreview.style.display = "block";
                } else {
                    alert("Image not available in database.");
                }
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


