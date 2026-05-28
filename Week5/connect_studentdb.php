<?php

// Connection to studentdb
$conn = mysqli_connect("localhost", "root", "", "studentdb");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

echo "Connected to studentdb successfully!";

?>
