<?php
include '../db.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['add'])){

    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $distance_km = $_POST['distance_km'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $opening_hours = $_POST['opening_hours'];
    $entry_fee = $_POST['entry_fee'];
    $contact = $_POST['contact'];

    /* =========================
       VALIDATION SECTION
    ========================== */

    if($distance_km <= 0){
        die("Distance must be positive");
    }

    if($latitude < -90 || $latitude > 90){
        die("Invalid latitude value");
    }

    if($longitude < -180 || $longitude > 180){
        die("Invalid longitude value");
    }

    /* =========================
       IMAGE UPLOAD
    ========================== */

    $image = "";

    if(!empty($_FILES['image']['name'])){

        $image = time() . "_" . basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../uploads/" . $image
        );
    }

    /* =========================
       SECURE INSERT QUERY
    ========================== */

    $stmt = $conn->prepare("
        INSERT INTO attractions
        (name, description, category_id, distance_km,
        latitude, longitude, opening_hours,
        entry_fee, contact, IMAGE)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssiddsdsss",
        $name,
        $description,
        $category_id,
        $distance_km,
        $latitude,
        $longitude,
        $opening_hours,
        $entry_fee,
        $contact,
        $image
    );

    $stmt->execute();

    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Add Attraction</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="container mt-4">

<h3>Add New Attraction</h3>

<form method="POST" enctype="multipart/form-data">

<input name="name"
class="form-control mb-2"
placeholder="Attraction Name"
required>

<textarea name="description"
class="form-control mb-2"
placeholder="Description"
required></textarea>

<select name="category_id"
class="form-control mb-2"
required>

<option value="">Select Category</option>

<?php
$cat = $conn->query("SELECT * FROM categories");

while($c = $cat->fetch_assoc()){
?>

<option value="<?php echo $c['id']; ?>">
<?php echo $c['name']; ?>
</option>

<?php } ?>

</select>

<input type="number"
step="0.1"
name="distance_km"
class="form-control mb-2"
placeholder="Distance (km)"
required>

<input type="text"
name="latitude"
class="form-control mb-2"
placeholder="Latitude"
required>

<input type="text"
name="longitude"
class="form-control mb-2"
placeholder="Longitude"
required>

<input type="text"
name="opening_hours"
class="form-control mb-2"
placeholder="Opening Hours">

<input type="text"
name="entry_fee"
class="form-control mb-2"
placeholder="Entry Fee">

<input type="text"
name="contact"
class="form-control mb-2"
placeholder="Contact Info">

<label class="mb-1">Upload Image</label>

<input type="file"
name="image"
class="form-control mb-3">

<button name="add"
class="btn btn-success">
Save Attraction
</button>

<a href="dashboard.php"
class="btn btn-secondary">
Cancel
</a>

</form>

</div>

</body>
</html>