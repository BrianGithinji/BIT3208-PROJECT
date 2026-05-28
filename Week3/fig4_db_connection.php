<?php
// Fig 4: Database Connection Script

$host = "localhost";
$dbname = "sample_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connection successful!";

    // Example query
    $stmt = $pdo->query("SELECT * FROM users");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<br>ID: {$row['id']} | Name: {$row['name']} | Email: {$row['email']}";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
