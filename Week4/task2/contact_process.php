<?php
// ─── Contact Form Processor ───────────────────────────────────────────────
// Demonstrates: handling both POST and GET, $_POST vs $_GET, input processing

$method = $_SERVER['REQUEST_METHOD']; // "POST" or "GET"

// ── Handle GET (FAQ Search) ───────────────────────────────────────────────
if ($method === 'GET' && isset($_GET['search'])) {

    // $_GET reads data from the URL query string
    $search = htmlspecialchars(trim($_GET['search']));

    // Simulated FAQ data
    $faqs = [
        ['q' => 'How do I reset my password?',    'a' => 'Click "Forgot Password" on the login page and follow the email instructions.'],
        ['q' => 'How do I register for a course?','a' => 'Fill in the registration form with your details and select your course.'],
        ['q' => 'What are the tuition fees?',     'a' => 'Please contact the finance office for current fee structures.'],
        ['q' => 'How do I contact support?',      'a' => 'Use the contact form on this page or email support@example.com.'],
    ];

    $results = array_filter($faqs, fn($f) =>
        stripos($f['q'], $search) !== false || stripos($f['a'], $search) !== false
    );
}

// ── Handle POST (Contact Message) ────────────────────────────────────────
$errors  = [];
$success = false;
$name = $email = $subject = $message = '';

if ($method === 'POST') {

    if (!isset($_POST['name'])) {
        header('Location: contact.html');
        exit;
    }

    // $_POST reads data from the request body (not visible in URL)
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate
    if (empty($name))    $errors[] = "Name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email address.";
    if (empty($subject)) $errors[] = "Please select a subject.";
    if (strlen($message) < 10) $errors[] = "Message must be at least 10 characters.";

    if (empty($errors)) {
        $success = true;
        // In a real app: mail($to, $subject, $message) or save to DB
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Result</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f0f2f5; margin: 0; padding: 40px 20px; }
        .card { background: #fff; padding: 35px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 580px; margin: 0 auto; }
        h2 { margin-top: 0; }
        .success-title { color: #27ae60; }
        .get-title { color: #2980b9; }
        .error-box { background: #fdecea; color: #c0392b; padding: 15px; border-radius: 6px; }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .info-table td { padding: 9px 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        .info-table td:first-child { font-weight: bold; color: #555; width: 30%; }
        .faq-item { background: #eaf4fb; padding: 12px 15px; border-radius: 6px; margin-top: 10px; }
        .faq-item strong { color: #2980b9; }
        .no-result { color: #888; font-style: italic; }
        .concept { margin-top: 20px; background: #fef9e7; padding: 15px; border-radius: 6px; font-size: 13px; }
        .concept h4 { margin: 0 0 8px; color: #b7950b; }
        code { background: #f0f0f0; padding: 2px 5px; border-radius: 3px; }
        .url-demo { background: #f4f4f4; padding: 10px; border-radius: 5px; font-size: 12px; word-break: break-all; margin-top: 8px; }
        a { display: inline-block; margin-top: 15px; color: #e67e22; font-size: 14px; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="card">

<?php if ($method === 'GET' && isset($_GET['search'])): ?>
    <!-- ── GET Result ── -->
    <h2 class="get-title">🔍 Search Results (GET)</h2>

    <p style="font-size:13px; color:#555;">
        Your search term was read from <code>$_GET['search']</code>.<br>
        Check your browser's address bar — the search term is visible in the URL.
    </p>

    <div class="url-demo">
        <strong>URL received by server:</strong><br>
        <?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>
    </div>

    <p><strong>Searching for:</strong> "<?= $search ?>"</p>

    <?php if (!empty($results)): ?>
        <?php foreach ($results as $faq): ?>
            <div class="faq-item">
                <strong>Q: <?= $faq['q'] ?></strong><br>
                A: <?= $faq['a'] ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="no-result">No results found for "<?= $search ?>".</p>
    <?php endif; ?>

    <div class="concept">
        <h4>GET Method – Key Points</h4>
        <ul>
            <li>Data appended to URL: <code>?search=password</code></li>
            <li>Read with <code>$_GET['search']</code> in PHP.</li>
            <li>Bookmarkable and shareable — good for searches.</li>
            <li>Never use GET for passwords or sensitive data.</li>
        </ul>
    </div>

<?php elseif ($method === 'POST'): ?>
    <!-- ── POST Result ── -->
    <?php if (!empty($errors)): ?>
        <h2>Message Not Sent</h2>
        <div class="error-box">
            <ul style="margin:0; padding-left:18px;">
                <?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?>
            </ul>
        </div>
        <a href="contact.html">← Try Again</a>

    <?php else: ?>
        <h2 class="success-title">✅ Message Sent!</h2>

        <table class="info-table">
            <tr><td>Name</td><td><?= $name ?></td></tr>
            <tr><td>Email</td><td><?= $email ?></td></tr>
            <tr><td>Subject</td><td><?= $subject ?></td></tr>
            <tr><td>Message</td><td><?= $message ?></td></tr>
            <tr><td>Sent At</td><td><?= date('Y-m-d H:i:s') ?></td></tr>
        </table>

        <div class="concept">
            <h4>POST Method – Key Points</h4>
            <ul>
                <li>Data sent in the <strong>request body</strong> — not visible in the URL.</li>
                <li>Read with <code>$_POST['name']</code>, <code>$_POST['message']</code>, etc.</li>
                <li><code>htmlspecialchars()</code> sanitizes output to prevent XSS.</li>
                <li><code>filter_var(FILTER_VALIDATE_EMAIL)</code> validates email server-side.</li>
                <li>Use POST for any form that submits or changes data.</li>
            </ul>
        </div>

        <a href="contact.html">← Send Another Message</a>
    <?php endif; ?>

<?php else: ?>
    <p>No form data received. <a href="contact.html">← Go back</a></p>
<?php endif; ?>

</div>
</body>
</html>
