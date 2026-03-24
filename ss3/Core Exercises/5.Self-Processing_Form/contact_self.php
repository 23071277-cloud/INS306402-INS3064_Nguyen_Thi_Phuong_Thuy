<?php
/**
 * Exercise 5: Self-Processing Contact Form
 * Professional, Minimalist, and English version.
 */

$is_submitted = false;
$errors = [];
$data = ['name' => '', 'email' => '', 'phone' => '', 'message' => ''];

// 1. Request Detection
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Sanitize input data
    $data['name']    = trim($_POST['full_name'] ?? '');
    $data['email']   = trim($_POST['email'] ?? '');
    $data['phone']   = trim($_POST['phone'] ?? '');
    $data['message'] = trim($_POST['message'] ?? '');

    // 2. Logic Validation
    if (empty($data['name']))    $errors[] = "Full Name is required.";
    if (empty($data['email']))   $errors[] = "Email Address is required.";
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format.";
    if (empty($data['message'])) $errors[] = "Message content is required.";

    // Success check
    if (empty($errors)) {
        $is_submitted = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Professional Form</title>
    <style>
        /* Minimalist Style Guide */
        :root {
            --bg-color: #f8f9fa;
            --text-main: #2d3436;
            --accent: #2d3436; /* Clean Black/Navy */
            --border: #dee2e6;
            --error: #d63031;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0;
        }

        .form-card {
            background: #ffffff;
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            border: 1px solid var(--border);
            /* Minimal shadow for depth */
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }

        h2 { margin-top: 0; font-weight: 600; font-size: 1.5rem; letter-spacing: -0.5px; }
        p { color: #636e72; font-size: 0.9rem; margin-bottom: 1.5rem; }

        .error-list {
            background: #fff5f5; color: var(--error);
            padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.85rem;
        }

        .form-group { margin-bottom: 1.2rem; }
        
        label { display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem; color: #b2bec3; }

        input, textarea {
            width: 100%; padding: 0.8rem; border: 1px solid var(--border);
            border-radius: 0; /* Square edges for a modern look */
            box-sizing: border-box; font-size: 0.95rem;
        }

        input:focus, textarea:focus { border-color: var(--accent); outline: none; }

        button {
            width: 100%; padding: 1rem; background: var(--accent); color: white;
            border: none; font-weight: 600; cursor: pointer; transition: 0.2s;
        }

        button:hover { background: #000000; }

        .success-state { text-align: center; }
        .success-state a { color: var(--accent); text-decoration: underline; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="form-card">
    <?php if ($is_submitted): ?>
        <div class="success-state">
            <h2>Thank You</h2>
            <p>Your message has been received, <strong><?= htmlspecialchars($data['name']) ?></strong>.</p>
            <p>We will contact you via <strong><?= htmlspecialchars($data['email']) ?></strong> shortly.</p>
            <br>
            <a href="contact_self.php">Send another message</a>
        </div>
    <?php else: ?>
        <h2>Get in touch</h2>
        <p>Please fill out the form below.</p>
        
        <?php if (!empty($errors)): ?>
            <div class="error-list">
                <?php foreach ($errors as $err): ?>
                    <div>• <?= $err ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?= htmlspecialchars($data['name']) ?>" placeholder="e.g. Jane Doe">
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" placeholder="jane@example.com">
            </div>
            <div class="form-group">
                <label>Phone Number (Optional)</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($data['phone']) ?>" placeholder="+1 234 567 890">
            </div>
            <div class="form-group">
                <label>Your Message</label>
                <textarea name="message" rows="4" placeholder="How can we help?"><?= htmlspecialchars($data['message']) ?></textarea>
            </div>
            <button type="submit">Submit Request</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>