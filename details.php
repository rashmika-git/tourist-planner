<?php
include 'db.php';

if(!isset($_GET['id'])){
header("Location: index.php");
exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("
SELECT attractions.*, categories.name AS category_name
FROM attractions
LEFT JOIN categories
ON attractions.category_id = categories.id
WHERE attractions.id = ?
");

$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if(!$data){
echo "Attraction not found";
exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<title><?php echo htmlspecialchars($data['name']); ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">

<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<style>
#map{
height:400px;
border-radius:15px;
}
</style>

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">

<h2 class="mb-3">
<?php echo htmlspecialchars($data['name']); ?>
</h2>

<img
src="uploads/<?php echo htmlspecialchars($data['IMAGE']); ?>"
class="img-fluid mb-3"
style="max-height:400px;object-fit:cover;border-radius:15px;">

<p>
<strong>Category:</strong>
<?php echo htmlspecialchars($data['category_name']); ?>
</p>

<p>
<strong>Description:</strong><br>
<?php echo htmlspecialchars($data['description']); ?>
</p>

<p>
<strong>Distance:</strong>
<?php echo $data['distance_km']; ?> km
</p>

<p>
<strong>Opening Hours:</strong>
<?php echo $data['opening_hours'] ?: "Not available"; ?>
</p>

<p>
<strong>Entry Fee:</strong>
<?php echo $data['entry_fee'] ?: "Not available"; ?>
</p>

<p>
<strong>Contact:</strong>
<?php echo $data['contact'] ?: "Not available"; ?>
</p>


<h5 class="mt-4">Location Map</h5>

<div id="map"></div>


<button
onclick="addToPlannerWithToast(
'<?php echo htmlspecialchars($data['name']); ?>',
'<?php echo htmlspecialchars($data['category_name']); ?>',
'<?php echo $data['distance_km']; ?>',
'<?php echo htmlspecialchars($data['opening_hours']); ?>'
)"
class="btn btn-success mt-3">

Add to Planner

</button>

</div>


<!-- TOAST MESSAGE -->

<div id="toastMsg"
style="
position:fixed;
bottom:30px;
right:30px;
background:#2ecc71;
color:white;
padding:15px 25px;
border-radius:12px;
box-shadow:0 10px 25px rgba(0,0,0,.3);
display:none;
z-index:9999;
font-weight:500;
">
✅ Added to planner successfully!
</div>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<script>

// MAP INITIALIZATION

var map = L.map('map').setView(
[<?php echo $data['latitude']; ?>,
<?php echo $data['longitude']; ?>],14
);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
).addTo(map);

L.marker([
<?php echo $data['latitude']; ?>,
<?php echo $data['longitude']; ?>
]).addTo(map);


// ADD TO PLANNER WITH TOAST

function addToPlannerWithToast(name,category,distance,hours){

let planner = JSON.parse(localStorage.getItem("planner")) || [];

if(planner.some(item => item.name === name)){
alert("Already added to planner!");
return;
}

planner.push({
name:name,
category:category,
distance:distance,
hours:hours
});

localStorage.setItem("planner",JSON.stringify(planner));

showToast();

}


// TOAST FUNCTION

function showToast(){

let toast=document.getElementById("toastMsg");

toast.style.display="block";

setTimeout(()=>{
toast.style.display="none";
},2500);

}

</script>

</body>
</html>