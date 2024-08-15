<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $user_type = trim($_POST['user_type']);

    // Input validation
    if (empty($name) || empty($email) || empty($password) || empty($user_type)) {
        echo "All fields are required.";
        exit;
    }

    // Sanitize email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO Users (name, email, password, user_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $user_type);

    if ($stmt->execute() === TRUE) {
        echo "Registration successful. <a href='login.html'>Login</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
