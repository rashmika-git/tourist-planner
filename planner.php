<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>

<head>

<title>Planner</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">

<style>
.list-group-item{
display:flex;
justify-content:space-between;
align-items:center;
border-radius:10px;
margin-bottom:10px;
}
</style>

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">

<h3>Your One-Day Visit Planner</h3>

<p class="text-muted">
Arrange attractions in visiting order and download your itinerary.
</p>

<ul id="plannerList" class="list-group mb-3"></ul>

<button onclick="printPlan()" class="btn btn-primary">
Print Itinerary
</button>

<button onclick="downloadPDF()" class="btn btn-success">
Download as PDF
</button>

<button onclick="clearPlanner()" class="btn btn-danger">
Clear Planner
</button>

</div>


<script>

// Load planner data
let planner = JSON.parse(localStorage.getItem("planner")) || [];


// Render planner list
function renderPlanner(){

let list = document.getElementById("plannerList");

list.innerHTML = "";

if(planner.length === 0){

list.innerHTML = `
<div class="alert alert-warning">
Planner is empty. Add attractions first.
</div>
`;

return;
}

planner.forEach((item,index)=>{

list.innerHTML += `
<li class="list-group-item">

<div>

<strong>${item.name}</strong><br>

Category: ${item.category}<br>

Distance: ${item.distance} km<br>

Hours: ${item.hours || "Not available"}

</div>

<div>

<button onclick="moveUp(${index})"
class="btn btn-sm btn-warning">↑</button>

<button onclick="moveDown(${index})"
class="btn btn-sm btn-warning">↓</button>

<button onclick="removeItem(${index})"
class="btn btn-sm btn-danger">
Remove
</button>

</div>

</li>
`;

});

}


// Remove item
function removeItem(index){

planner.splice(index,1);

localStorage.setItem("planner",JSON.stringify(planner));

renderPlanner();

}


// Move item up
function moveUp(index){

if(index > 0){

[planner[index-1],planner[index]] =
[planner[index],planner[index-1]];

localStorage.setItem("planner",JSON.stringify(planner));

renderPlanner();

}

}


// Move item down
function moveDown(index){

if(index < planner.length-1){

[planner[index+1],planner[index]] =
[planner[index],planner[index+1]];

localStorage.setItem("planner",JSON.stringify(planner));

renderPlanner();

}

}


// Print itinerary
function printPlan(){

window.print();

}


// Clear planner
function clearPlanner(){

if(confirm("Clear entire planner?")){

planner = [];

localStorage.removeItem("planner");

renderPlanner();

}

}


// Download PDF itinerary
function downloadPDF(){

const { jsPDF } = window.jspdf;

let doc = new jsPDF();

if(planner.length === 0){

alert("Planner is empty!");

return;

}

doc.setFontSize(18);
doc.text("Tourist Planner Itinerary", 20, 20);

let y = 40;

planner.forEach((item,index)=>{

doc.setFontSize(12);

doc.text(
(index+1)+". "+item.name+
" | Distance: "+item.distance+" km"+
" | Hours: "+(item.hours || "N/A"),
20,
y
);

y += 10;

});

doc.save("planner_itinerary.pdf");

}


// Initial render
renderPlanner();

</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

</body>
</html>