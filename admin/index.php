<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $display_name = trim($_POST['display_name']);

    // Basic form validation
    if (empty($username) || empty($display_name)) {
        $error = "All fields are required.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO judges (username, display_name) VALUES (?, ?)");
            $stmt->execute([$username, $display_name]);
            $success = "Judge added successfully!";
        } catch (PDOException $e) {
            $error = "Error adding judge: " . $e->getMessage();
        }
    }
}

$judges = $pdo->query("SELECT * FROM judges")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Add Judges</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Admin Panel - Manage Judges</h1>
    <form method="POST">
        <label>Username: <input type="text" name="username" required></label><br>
        <label>Display Name: <input type="text" name="display_name" required></label><br>
        <button type="submit">Add Judge</button>
    </form>

    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>

    <h2>Existing Judges</h2>
    <ul>
        <?php foreach ($judges as $judge): ?>
            <li><?php echo htmlspecialchars($judge['username']) . " (" . htmlspecialchars($judge['display_name']) . ")"; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
