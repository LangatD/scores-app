<?php
require_once '../includes/db.php';

// Fetch users and their total scores
$stmt = $pdo->query("
    SELECT u.id, u.username, u.display_name, SUM(s.score) as total_score
    FROM users u
    LEFT JOIN scores s ON u.id = s.user_id
    GROUP BY u.id
    ORDER BY total_score DESC
");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Public Scoreboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- Auto-refresh every 30 seconds -->
    <meta http-equiv="refresh" content="30">
</head>
<body>
    <nav style="background-color: #f8f9fa; padding: 10px; text-align: center;">
    <a href="../public/">Public Scoreboard</a> |
    <a href="../admin/">Admin Panel</a> |
    <a href="../judge/">Judge Portal</a> |
    <a href="../">Home</a>
</nav>
    <h1>Public Scoreboard</h1>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Username</th>
                <th>Display Name</th>
                <th>Total Score</th>
            </tr>
        </thead>
        <tbody>
            <?php $rank = 1; foreach ($users as $user): ?>
                <tr <?php if ($rank == 1) echo 'style="background-color: #ffd700;"'; // Highlight top scorer ?>>
                    <td><?php echo $rank++; ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['display_name']); ?></td>
                    <td><?php echo (int)$user['total_score'] ?: 0; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
