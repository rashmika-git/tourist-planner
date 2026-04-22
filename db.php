<?php
$conn = new mysqli("localhost", "root", "", "tourist_planner");
if ($conn->connect_error) die("Connection failed");
session_start();
?>