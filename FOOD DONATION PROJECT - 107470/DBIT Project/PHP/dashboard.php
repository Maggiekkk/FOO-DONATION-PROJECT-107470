<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql_user = "SELECT * FROM Users WHERE id='$user_id'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();

$sql_donations = "SELECT * FROM Donations WHERE user_id='$user_id'";
$result_donations = $conn->query($sql_donations);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard - Feed4All</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../DBIT Project/CSS/styles.css">
</head>
<body>
    <header>
        <div>
            <img src="../Images/CompanyLogo.jpg" alt="Feed4All Logo" id="Logo">
            <h1>Feed4All</h1>
            <p><i>Feeding the nation, with every donation!</i></p>
        </div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="directory.html">Food Banks & Shelters</a></li>
                <li><a href="donation.html">Donations</a></li>
                <li><a href="volunteersignup.html">Volunteer Sign-up</a></li>
                <li><a href="register.html">Register</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h3>Welcome, <?php echo $user['name']; ?></h3>
            <p>User Type: <?php echo $user['user_type']; ?></p>
            
            <h3>Your Donations</h3>
            <table>
                <tr>
                    <th>Donor Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Food Type</th>
                    <th>Quantity</th>
                </tr>
                <?php while ($donation = $result_donations->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $donation['donorName']; ?></td>
                    <td><?php echo $donation['donorEmail']; ?></td>
                    <td><?php echo $donation['donorPhone']; ?></td>
                    <td><?php echo $donation['foodType']; ?></td>
                    <td><?php echo $donation['foodQuantity']; ?></td>
                </tr>
                <?php } ?>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Feed4All. All Rights Reserved</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
