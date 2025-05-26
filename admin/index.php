<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $display_name = trim($_POST['display_name']);

    // form validation
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
    <nav style="background-color: #f8f9fa; padding: 10px; text-align: center;">
        <a href="../public/">Public Scoreboard</a> |
        <a href="../admin/">Admin Panel</a> |
        <a href="../judge/">Judge Portal</a> |
        <a href="../">Home</a>
    </nav>

    <div class="form-table">
        <h1>Admin Panel - Manage Judges</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Display Name:</label>
                <input type="text" name="display_name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Judge</button>
        </form>

        <div class="existing-list">
            <h2>Existing Judges</h2>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Display Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($judges as $judge): ?>
                    <tr>
                        <td><?= htmlspecialchars($judge['username']) ?></td>
                        <td><?= htmlspecialchars($judge['display_name']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>