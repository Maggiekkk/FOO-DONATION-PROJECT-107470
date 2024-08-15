<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'Admin') {
    header("Location: login.html");
    exit();
}

$userId = $_GET['id'];
$sql = "SELECT * FROM Users WHERE id='$userId'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $userType = $_POST['user_type'];

    $updateSql = "UPDATE Users SET name='$name', email='$email', user_type='$userType' WHERE id='$userId'";
    if ($conn->query($updateSql) === TRUE) {
        header("Location: admin.php");
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Edit User</h1>
    <form action="edit_user.php?id=<?php echo $userId; ?>" method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="user_type">User Type:</label>
            <select id="user_type" name="user_type">
                <option value="Donor" <?php if ($user['user_type'] == 'Donor') echo 'selected'; ?>>Donor</option>
                <option value="Volunteer" <?php if ($user['user_type'] == 'Volunteer') echo 'selected'; ?>>Volunteer</option>
                <option value="FoodBank" <?php if ($user['user_type'] == 'FoodBank') echo 'selected'; ?>>Food Bank</option>
                <option value="Admin" <?php if ($user['user_type'] == 'Admin') echo 'selected'; ?>>Admin</option>
            </select>
        </div>
        <button type="submit">Update User</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
