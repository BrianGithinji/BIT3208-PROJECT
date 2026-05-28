<?php

// Connection to productdb
$conn = mysqli_connect("localhost", "root", "", "productdb");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

echo "Connected to productdb successfully!";

?>
