<?php
require_once 'config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$admin_id = $_SESSION['user_id'];

// Fetch all projects created by this admin
$query = "SELECT * FROM projects WHERE created_by = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$projects = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <h1>Admin Dashboard</h1>
        <a href="logout.php" class="btn">Logout</a>
    </div>

    <div class="container">
        <h2>Your Projects</h2>
        <a href="create_project.php" class="btn btn-success">Create New Project</a>

        <?php if (empty($projects)): ?>
            <p>No projects created yet.</p>
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
                                <a href="assign_staff.php?project_id=<?php echo $project['id']; ?>" class="btn btn-primary">Assign Staff</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>