<?php
// Fig 5: Dynamic User Input Handling

$name = $age = $message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $age  = (int) $_POST["age"];

    if (empty($name) || $age <= 0) {
        $message = "Please provide a valid name and age.";
    } elseif ($age < 18) {
        $message = "Hello, $name! You are a minor ($age years old).";
    } else {
        $message = "Hello, $name! You are an adult ($age years old).";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fig 5: User Input Handling</title>
</head>
<body>
    <h2>User Input Form</h2>
    <form method="POST" action="">
        <label>Name: <input type="text" name="name" value="<?= htmlspecialchars($name) ?>"></label><br><br>
        <label>Age:  <input type="number" name="age" value="<?= htmlspecialchars($age) ?>"></label><br><br>
        <button type="submit">Submit</button>
    </form>

    <?php if ($message): ?>
        <p><strong><?= $message ?></strong></p>
    <?php endif; ?>
</body>
</html>
