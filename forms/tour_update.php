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

$tourguide_id = $_GET['id'] ?? NULL;

if ($tourguide_id == NULL) {
    header("Location: tour_index.php");
    exit();
}

$database = new Database(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
$conn = $database->connect();

if (isset($_POST['tour_update'])) {
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
    } else {
        
        $existing_image_query = "SELECT image FROM tourguide WHERE guideID = ?";
        $stmt = $conn->prepare($existing_image_query);
        $stmt->bind_param("i", $tourguide_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $image = $row['image'];
        }
    }

    $stmt = $conn->prepare("UPDATE tourguide SET name=?, email=?, phone=?, specialization=?, image=? WHERE guideID=?");
    $stmt->bind_param("sssssi", $name, $email, $phone, $specialization, $image, $tourguide_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('The tour guide has been updated successfully!');</script>";
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

<?php
class TourGuide {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getTourGuideById($tourguide_id) {
        $query = "SELECT * FROM tourguide WHERE guideID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $tourguide_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            return false; 
        }

        $tourguide = $result->fetch_assoc();
        $stmt->close();

        return $tourguide;
    }
}


$database = new Database(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
$conn = $database->connect();

$tourGuideHandler = new TourGuide($conn);

$tourguide_id = $_GET['id'] ?? NULL;

if ($tourguide_id == NULL) {
    header("Location: tour_index.php");
    exit();
}

$tourguide = $tourGuideHandler->getTourGuideById($tourguide_id);

if (!$tourguide) {
    echo "Tour guide not found";
    exit();
}

$name = $tourguide['name'];
$email = $tourguide['email'];
$phone = $tourguide['phone'];
$specialization = $tourguide['specialization'];
?>


        <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Update Tour Guide</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active"><a href="tour_index.php" style="text-decoration: none;">Tour Guide</a> / Update</li>
                </ol>
                <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label" style="font-weight: bold;">Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: bold;">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: bold;">Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: bold;">Specialization</label>
                    <input type="text" name="specialization" class="form-control" value="<?= htmlspecialchars($specialization) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-weight: bold;">Image</label>
                    <input type="file" name="image" class="form-control" accept="img/*" id="imageUpload">
                    <button type="button" id="previewButton" class="btn btn-secondary"><i class="fas fa-eye"></i> Preview</button>
                    <img id="imagePreview" style="display:none; max-width: 100%; max-height: 400px; margin: auto;" />
                </div>
                <button type="submit" name="tour_update" class="btn btn-success w-100 mb-1">Update</button>
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
                const imageUrlFromDatabase = "<?php echo $tourguide['image']; ?>";
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


