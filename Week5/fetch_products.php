<?php

$conn = mysqli_connect("localhost", "root", "", "productdb");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM products");

while($row = mysqli_fetch_assoc($result)){
    echo "ID: " . $row['id'] . "<br>";
    echo "Product: " . $row['product_name'] . "<br>";
    echo "Description: " . $row['description'] . "<br>";
    echo "Price: $" . $row['price'] . "<br>";
    echo "Stock: " . $row['stock_quantity'] . "<br>";
    echo "Category: " . $row['category'] . "<br>";
    echo "<hr>";
}

mysqli_close($conn);

?>
