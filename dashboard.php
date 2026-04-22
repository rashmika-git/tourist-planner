<?php
include '../db.php';

if(!isset($_SESSION['admin'])){
header("Location: login.php");
exit();
}

// statistics
$total = $conn->query("SELECT COUNT(*) AS total FROM attractions")
->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="container mt-4">

<h3 class="mb-4">Admin Dashboard</h3>


<!-- STATISTICS CARD -->

<div class="card shadow mb-4">

<div class="card-body">

<h5>Total Attractions</h5>

<h2><?php echo $total; ?></h2>

</div>

</div>


<!-- ADD BUTTON -->

<a href="add.php" class="btn btn-success mb-3">
+ Add Attraction
</a>


<!-- TABLE -->

<table class="table table-bordered table-striped">

<tr>
<th>Name</th>
<th>Distance</th>
<th>Category</th>
<th>Actions</th>
</tr>

<?php

$query = $conn->query("
SELECT attractions.*, categories.name AS category_name
FROM attractions
LEFT JOIN categories
ON attractions.category_id = categories.id
");

while($row=$query->fetch_assoc()){
?>

<tr>

<td><?php echo htmlspecialchars($row['name']); ?></td>

<td><?php echo $row['distance_km']; ?> km</td>

<td><?php echo $row['category_name']; ?></td>

<td>

<a href="edit.php?id=<?php echo $row['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>


<button
onclick="confirmDelete(<?php echo $row['id']; ?>)"
class="btn btn-danger btn-sm">

Delete

</button>

</td>

</tr>

<?php } ?>

</table>


<a href="logout.php" class="btn btn-secondary">

Logout

</a>

</div>


<script>

function confirmDelete(id){

if(confirm("Are you sure you want to delete this attraction?")){

window.location="delete.php?id="+id;

}

}

</script>

</body>
</html>