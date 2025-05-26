<?php
require_once '../includes/db.php';

// Fetch all users
$users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);

// Fetch all judges for the dropdown
$judges = $pdo->query("SELECT * FROM judges")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $judge_id = $_POST['judge_id'];
    $score = (int)$_POST['score'];

    // Validate score
    if ($score < 1 || $score > 100) {
        $error = "Score must be between 1 and 100.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO scores (user_id, judge_id, score) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, $judge_id, $score]);
            $success = "Score submitted successfully!";
        } catch (PDOException $e) {
            $error = "Error submitting score: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Judge Portal - Assign Scores</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav style="background-color: #f8f9fa; padding: 10px; text-align: center;">
    <a href="../public/">Public Scoreboard</a> |
    <a href="../admin/">Admin Panel</a> |
    <a href="../judge/">Judge Portal</a> |
    <a href="../">Home</a>
</nav>
    <h1>Judge Portal - Assign Scores</h1>

    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>

    <h2>Users</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?php echo htmlspecialchars($user['display_name']) . " (" . htmlspecialchars($user['username']) . ")"; ?>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <label>
                        Judge:
                        <select name="judge_id" required>
                            <option value="">Select Judge</option>
                            <?php foreach ($judges as $judge): ?>
                                <option value="<?php echo $judge['id']; ?>">
                                    <?php echo htmlspecialchars($judge['display_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label>
                        Score (1-100):
                        <input type="number" name="score" min="1" max="100" required>
                    </label>
                    <button type="submit">Submit Score</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
