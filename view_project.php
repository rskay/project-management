<?php
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit;
}

$project_id = $_GET['project_id'] ?? null;
$staff_id = $_SESSION['user_id'];

if (!$project_id) {
    header("Location: staff_dashboard.php");
    exit;
}

// Verify staff is assigned to this project
$query = "SELECT * FROM project_assignments WHERE project_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $project_id, $staff_id);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    header("Location: staff_dashboard.php");
    exit;
}

// Fetch project details
$query = "SELECT * FROM projects WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$project = $stmt->get_result()->fetch_assoc();

// Fetch all tasks for this project
$query = "SELECT * FROM tasks WHERE project_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Project - <?php echo $project['name']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <h1><?php echo $project['name']; ?></h1>
        <a href="staff_dashboard.php" class="btn">Back to Dashboard</a>
    </div>

    <div class="container">
        <h2>Project Description</h2>
        <p><?php echo $project['description']; ?></p>

        <h2>Tasks</h2>
        <a href="add_task.php?project_id=<?php echo $project_id; ?>" class="btn btn-success">Add New Task</a>

        <?php if (empty($tasks)): ?>
            <p>No tasks for this project yet.</p>
        <?php else: ?>
            <table border="1" cellpadding="10">
                <thead>
                    <tr>
                        <th>Task Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?php echo $task['title']; ?></td>
                            <td><?php echo $task['description']; ?></td>
                            <td><?php echo ucfirst(str_replace('_', ' ', $task['status'])); ?></td>
                            <td><?php echo $task['due_date'] ?? 'N/A'; ?></td>
                            <td><?php echo $task['created_at']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>