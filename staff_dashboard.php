<?php
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit;
}

$staff_id = $_SESSION['user_id'];

// Fetch all projects assigned to this staff member
$query = "SELECT p.* FROM projects p 
          INNER JOIN project_assignments pa ON p.id = pa.project_id 
          WHERE pa.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();
$projects = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <h1>Staff Dashboard</h1>
        <a href="logout.php" class="btn">Logout</a>
    </div>

    <div class="container">
        <h2>Your Assigned Projects</h2>

        <?php if (empty($projects)): ?>
            <p>No projects assigned to you yet.</p>
        <?php else: ?>
            <table border="1" cellpadding="10">
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td><?php echo $project['name']; ?></td>
                            <td><?php echo $project['description']; ?></td>
                            <td><?php echo $project['created_at']; ?></td>
                            <td>
                                <a href="add_task.php?project_id=<?php echo $project['id']; ?>" class="btn btn-primary">Add Task</a>
                                <a href="view_project.php?project_id=<?php echo $project['id']; ?>" class="btn btn-secondary">View Tasks</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>