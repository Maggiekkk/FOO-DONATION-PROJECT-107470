<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Admin') {
    header("Location: login.html");
    exit();
}

// Handle delete request
if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];
    $deleteSql = "DELETE FROM Users WHERE id='$userId'";
    if ($conn->query($deleteSql) === TRUE) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

// Handle edit request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
    $userId = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $userType = $_POST['user_type'];

    $editSql = "UPDATE Users SET name='$name', email='$email', user_type='$userType' WHERE id='$userId'";
    if ($conn->query($editSql) === TRUE) {
        echo "User updated successfully.";
    } else {
        echo "Error updating user: " . $conn->error;
    }
}

// Fetch all users
$sql = "SELECT * FROM Users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Manage Users</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Admin Panel - Manage Users</h1>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>User Type</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['user_type']; ?></td>
            <td>
                <a href="admin.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                | <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="logout.php">Logout</a>
</body>
</html>

<?php
$conn->close();
?>
