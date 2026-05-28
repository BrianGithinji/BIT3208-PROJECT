<?php

$conn = mysqli_connect("localhost", "root", "", "authdb");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM users");

while($row = mysqli_fetch_assoc($result)){
    echo "ID: " . $row['id'] . "<br>";
    echo "Username: " . $row['username'] . "<br>";
    echo "Email: " . $row['email'] . "<br>";
    echo "Role: " . $row['role'] . "<br>";
    echo "<hr>";
}

mysqli_close($conn);

?>
