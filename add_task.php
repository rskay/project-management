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

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $due_date = trim($_POST['due_date'] ?? '');

    if (empty($title)) {
        $error = 'Task title is required.';
    } else {
        $query = "INSERT INTO tasks (project_id, assigned_to, title, description, due_date, status) 
                  VALUES (?, ?, ?, ?, ?, 'pending')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iisss", $project_id, $staff_id, $title, $description, $due_date);

        if ($stmt->execute()) {
            $success = 'Task created successfully!';
        } else {
            $error = 'Error creating task: ' . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <h1>Add Task to Project</h1>
        <a href="staff_dashboard.php" class="btn">Back to Dashboard</a>
    </div>

    <div class="container">
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="title">Task Title:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="5"></textarea>

            <label for="due_date">Due Date:</label>
            <input type="date" id="due_date" name="due_date">

            <button type="submit" class="btn btn-success">Create Task</button>
        </form>
    </div>
</body>
</html>
