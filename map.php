<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>

<head>

<title>Interactive Map</title>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<link rel="stylesheet"
href="assets/css/style.css">

<style>
#map{
height:600px;
border-radius:15px;
}
</style>

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">

<h3>Explore Attractions Map</h3>

<div id="map"></div>

</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

// Horana center
var map = L.map('map').setView([6.7157,80.0607],12);

// Base map
L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
attribution:'© OpenStreetMap'
}).addTo(map);


// Marker icon colors
function getMarkerIcon(category){

let iconUrl="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png";

if(category==1)
iconUrl="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png";

else if(category==2)
iconUrl="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png";

else if(category==3)
iconUrl="https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-orange.png";


return new L.Icon({
iconUrl: iconUrl,
shadowUrl:
"https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png",
iconSize:[25,41],
iconAnchor:[12,41],
popupAnchor:[1,-34]
});
}

<?php

$result = $conn->query("
SELECT attractions.*, categories.name AS category_name
FROM attractions
LEFT JOIN categories
ON attractions.category_id = categories.id
");

while($row=$result->fetch_assoc()){

echo "

L.marker(
[".$row['latitude'].",".$row['longitude']."],
{icon:getMarkerIcon(".$row['category_id'].")}
)

.addTo(map)

.bindPopup(
'<b>".$row['name']."</b><br>'
+'Category: ".$row['category_name']."<br>'
+'<a href=details.php?id=".$row['id'].">View details</a>'
);

";

}

?>

</script>

</body>
</html>