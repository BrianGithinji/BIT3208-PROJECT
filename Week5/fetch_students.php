<?php

$conn = mysqli_connect("localhost", "root", "", "studentdb");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM students");

while($row = mysqli_fetch_assoc($result)){
    echo "ID: " . $row['id'] . "<br>";
    echo "Name: " . $row['first_name'] . " " . $row['last_name'] . "<br>";
    echo "Email: " . $row['email'] . "<br>";
    echo "Course: " . $row['course'] . "<br>";
    echo "Enrollment Date: " . $row['enrollment_date'] . "<br>";
    echo "<hr>";
}

mysqli_close($conn);

?>
