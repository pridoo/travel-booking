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

if (isset($_POST['tour_add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialization = $_POST['specialization'];
    $image = isset($_FILES['image']['name']) && $_FILES['image']['error'] == UPLOAD_ERR_OK ? $_FILES['image']['name'] : null;

    if ($image) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_path = "../img/" . $image;

        if (move_uploaded_file($image_tmp_name, $image_path)) {

        } else {

        }
    } 

    $stmt = $conn->prepare("INSERT INTO tourguide (name, email, phone, specialization, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $specialization, $image);
    
    if ($stmt->execute()) {
        echo "<script>alert('The tour guide has been added successfully!');</script>";
        echo "<script>window.location.href = 'tour_index.php';</script>";
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
                <h1 class="mt-4">Add Tour Guide</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active"><a href="tour_index.php" style="text-decoration: none;">Tour Guide</a> / Update</li>
                </ol>
                <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label" style="font-weight: bold;">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: bold;">Email</label>
                    <input type="email" name="email" class="form-control"  required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: bold;">Phone</label>
                    <input type="text" name="phone" class="form-control"  required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: bold;">Specialization</label>
                    <input type="text" name="specialization" class="form-control"  required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: bold;">Image</label>
                    <input type="file" name="image" class="form-control" accept="img/*" id="imageUpload">
                    <button type="button" id="previewButton" class="btn btn-secondary"><i class="fas fa-eye"></i> Preview</button>
                    <img id="imagePreview" style="display:none; max-width: 100%; max-height: 400px; margin: auto;" />
                </div>
                    <button type="submit" name="tour_add" class="btn btn-success w-100 mb-1">Add</button>
                    <a href="tour_index.php" class="btn btn-danger w-100 mb-2">Cancel</a>
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
        this.imagePreview.style.display = "none";
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


