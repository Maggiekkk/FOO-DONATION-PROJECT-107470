<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donorName = trim($_POST['donorName']);
    $donorEmail = trim($_POST['donorEmail']);
    $donorPhone = trim($_POST['donorPhone']);
    $foodType = trim($_POST['foodType']);
    $foodQuantity = intval(trim($_POST['foodQuantity']));

    // Input validation
    if (empty($donorName) || empty($donorEmail) || empty($donorPhone) || empty($foodType) || empty($foodQuantity)) {
        echo "All fields are required.";
        exit;
    }

    // Sanitize email
    $donorEmail = filter_var($donorEmail, FILTER_SANITIZE_EMAIL);

    // Validate email
    if (!filter_var($donorEmail, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Assuming you have a user logged in with session
    $user_id = $_SESSION['user_id'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO Donations (user_id, donorName, donorEmail, donorPhone, foodType, foodQuantity) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssi", $user_id, $donorName, $donorEmail, $donorPhone, $foodType, $foodQuantity);

    if ($stmt->execute() === TRUE) {
        echo "Donation submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
