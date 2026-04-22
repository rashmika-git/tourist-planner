function addToPlanner(name, category, distance, hours){

let planner = JSON.parse(localStorage.getItem("planner")) || [];

// prevent duplicates
if(planner.some(item => item.name === name)){
alert("Already added to planner!");
return;
}

planner.push({
name: name,
category: category,
distance: distance,
hours: hours
});

localStorage.setItem("planner", JSON.stringify(planner));

alert("Added to planner!");
}