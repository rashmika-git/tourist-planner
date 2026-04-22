<?php
include '../db.php';

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: dashboard.php");
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM attractions WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $distance_km = $_POST['distance_km'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $opening_hours = $_POST['opening_hours'];
    $entry_fee = $_POST['entry_fee'];
    $contact = $_POST['contact'];

    /* =====================
       VALIDATION SECTION
    ===================== */

    if($distance_km <= 0){
        die("Distance must be positive");
    }

    if($latitude < -90 || $latitude > 90){
        die("Invalid latitude value");
    }

    if($longitude < -180 || $longitude > 180){
        die("Invalid longitude value");
    }

    /* =====================
       IMAGE UPDATE SECTION
    ===================== */

    if(!empty($_FILES['image']['name'])){

        $image = time() . "_" . basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../uploads/" . $image
        );

        $stmt = $conn->prepare("
            UPDATE attractions
            SET name=?, description=?, category_id=?, distance_km=?,
            latitude=?, longitude=?, opening_hours=?, entry_fee=?, contact=?, IMAGE=?
            WHERE id=?
        ");

        $stmt->bind_param(
            "ssiddsdsssi",
            $name,
            $description,
            $category_id,
            $distance_km,
            $latitude,
            $longitude,
            $opening_hours,
            $entry_fee,
            $contact,
            $image,
            $id
        );

    } else {

        $stmt = $conn->prepare("
            UPDATE attractions
            SET name=?, description=?, category_id=?, distance_km=?,
            latitude=?, longitude=?, opening_hours=?, entry_fee=?, contact=?
            WHERE id=?
        ");

        $stmt->bind_param(
            "ssiddsdssi",
            $name,
            $description,
            $category_id,
            $distance_km,
            $latitude,
            $longitude,
            $opening_hours,
            $entry_fee,
            $contact,
            $id
        );
    }

    $stmt->execute();

    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Attraction</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="container mt-4">

<h3>Edit Attraction</h3>

<form method="POST" enctype="multipart/form-data">

<input
name="name"
class="form-control mb-2"
value="<?php echo htmlspecialchars($data['name']); ?>"
required>

<textarea
name="description"
class="form-control mb-2"
required><?php echo htmlspecialchars($data['description']); ?></textarea>

<select
name="category_id"
class="form-control mb-2"
required>

<?php
$cat = $conn->query("SELECT * FROM categories");

while($c = $cat->fetch_assoc()){
?>

<option value="<?php echo $c['id']; ?>"
<?php if($data['category_id']==$c['id']) echo "selected"; ?>>

<?php echo $c['name']; ?>

</option>

<?php } ?>

</select>

<input
type="number"
step="0.1"
name="distance_km"
class="form-control mb-2"
value="<?php echo $data['distance_km']; ?>"
required>

<input
type="text"
name="latitude"
class="form-control mb-2"
value="<?php echo $data['latitude']; ?>"
required>

<input
type="text"
name="longitude"
class="form-control mb-2"
value="<?php echo $data['longitude']; ?>"
required>

<input
type="text"
name="opening_hours"
class="form-control mb-2"
value="<?php echo htmlspecialchars($data['opening_hours']); ?>">

<input
type="text"
name="entry_fee"
class="form-control mb-2"
value="<?php echo htmlspecialchars($data['entry_fee']); ?>">

<input
type="text"
name="contact"
class="form-control mb-2"
value="<?php echo htmlspecialchars($data['contact']); ?>">

<label class="mb-1">Replace Image</label>

<input
type="file"
name="image"
class="form-control mb-3">

<button
name="update"
class="btn btn-success">
Update Attraction
</button>

<a
href="dashboard.php"
class="btn btn-secondary">
Cancel
</a>

</form>

</div>

</body>
</html>