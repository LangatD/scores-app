<?php
require_once '../includes/db.php';

// Fetch all users and judges
$users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
$judges = $pdo->query("SELECT * FROM judges")->fetchAll(PDO::FETCH_ASSOC);

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields exist first
    if (!isset($_POST['judge_id'], $_POST['score'], $_POST['user_id'])) {
        $error = "All fields are required!";
    } else {
        $user_id = $_POST['user_id'];
        $judge_id = $_POST['judge_id'];
        $score = (int)$_POST['score'];

        // Validate score range
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

    <div class="form-table">
        <h1>Judge Portal - Assign Scores</h1>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Participant</th>
                    <th>Judge Selection</th>
                    <th>Score</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($user['display_name']) ?><br>
                        <small>@<?= htmlspecialchars($user['username']) ?></small>
                    </td>
                    <td>
                        <select class="form-control" name="judge_id" required>
                            <option value="">Select Judge</option>
                            <?php foreach ($judges as $judge): ?>
                            <option value="<?= $judge['id'] ?>">
                                <?= htmlspecialchars($judge['display_name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control" 
                               name="score" min="1" max="100" required>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>