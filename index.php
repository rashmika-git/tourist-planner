<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>

<head>
<title>Tourist Planner</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">

<h3 class="mb-4">Explore Attractions</h3>

<!-- CATEGORY FILTER -->

<form method="GET" class="mb-2">

<select name="category" class="form-control">

<option value="">All Categories</option>

<?php
$cat=$conn->query("SELECT * FROM categories");

while($c=$cat->fetch_assoc()){
?>

<option value="<?php echo $c['id']; ?>"

<?php if(isset($_GET['category']) && $_GET['category']==$c['id']) echo "selected"; ?>>

<?php echo $c['name']; ?>

</option>

<?php } ?>

</select>

</form>

<!-- DISTANCE FILTER -->

<form method="GET" class="mb-2">

<select name="distance" class="form-control">

<option value="">All Distances</option>

<option value="10">0-10 km</option>
<option value="20">10-20 km</option>
<option value="25">20-25 km</option>

</select>

</form>

<!-- SEARCH BOX -->

<form method="GET" class="mb-3">

<input type="text"
name="search"
class="form-control"
placeholder="Search attractions">

</form>

<a href="index.php" class="btn btn-secondary mb-3">Reset Filters</a>

<div class="row">

<?php

$query="SELECT * FROM attractions WHERE 1";

if(!empty($_GET['category']))
$query.=" AND category_id=".$_GET['category'];

if(!empty($_GET['search']))
$query.=" AND name LIKE '%".$_GET['search']."%'";

if(!empty($_GET['distance'])){

$d=$_GET['distance'];

if($d==10) $query.=" AND distance_km<=10";
elseif($d==20) $query.=" AND distance_km BETWEEN 10 AND 20";
else $query.=" AND distance_km BETWEEN 20 AND 25";

}

$result=$conn->query($query);

if($result->num_rows==0){

echo "<div class='alert alert-warning'>No attractions found</div>";

}

while($row=$result->fetch_assoc()){

?>

<div class="col-md-4">

<div class="card shadow mb-4">

<img src="uploads/<?php echo $row['IMAGE']; ?>"
class="card-img-top"
style="height:200px;object-fit:cover;">

<div class="card-body">

<h5><?php echo $row['name']; ?></h5>

<p>Distance: <?php echo $row['distance_km']; ?> km</p>

<a href="details.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary btn-sm">View</a>

<button
onclick="addToPlanner(
'<?php echo $row['name']; ?>',
'<?php echo $row['category_id']; ?>',
'<?php echo $row['distance_km']; ?>',
'<?php echo $row['opening_hours']; ?>'
)"
class="btn btn-success btn-sm">

Planner

</button>

</div>
</div>
</div>

<?php } ?>

</div>
</div>

<script src="assets/js/planner.js"></script>

</body>
</html>