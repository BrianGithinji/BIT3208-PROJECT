<?php

// Connection to authdb
$conn = mysqli_connect("localhost", "root", "", "authdb");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

echo "Connected to authdb successfully!";

?>
