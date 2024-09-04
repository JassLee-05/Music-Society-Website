<?php
    session_start();

    // Check if user is logged in via session or cookie
    if(isset($_SESSION['username'])) {
        // User is logged in via session
        $username = $_SESSION['username'];
    } else if(isset($_COOKIE['username'])) {
        // User is logged in via cookie
        $username = $_COOKIE['username'];
        $_SESSION['username'] = $username; // Recreate session from cookie
    } else {
        // User is not logged in, redirect to login page
        header("Location: login.php");
        exit;
    }

    // Retrieve user details from the database based on the username
    require_once('mysql_connect.php');
    $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die ("Could not connect to database: " . mysqli_connect_error());

    // Use prepared statements to prevent SQL injection
    $stmt = $mysqli->prepare("SELECT name, email, address, phone_number FROM users WHERE name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $userData = [];
    if ($result && $result->num_rows == 1) {           
        $userData = $result->fetch_assoc();
    } else {
        // User not found in the database
        $userData = null;
    }

    $stmt->close();
    $mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        /* General reset for padding and margins */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

header {
    background-color: black;
    color: white;
    padding: 10px 0;
    width: 100%;
    border-bottom: 2px solid #333;
}

.navlist {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
}

.logo img {
    display: block;
}

.title h3 {
    margin: 0;
}

.head ul {
    list-style-type: none;
    display: flex;
}

.head ul li {
    margin-right: 20px;
}

.head ul li a:visited, .head ul li a:link {
    color: white;
    text-decoration: none;
}

.head ul li a:hover, .head ul li a:active {
    color: rgb(222, 128, 60);
}

.main-content {
    display: flex;
    flex: 1;
}

.side-navigationlist {
    width: 200px;
    background-color: #f4f4f4;
    padding: 20px;
    border-right: 1px solid black;
    height: auto;
    flex-shrink: 0;
    position: relative;
    top: 0;
}

.side-navigationlist .side ul {
    list-style: none;
    padding: 0;
}

.side-navigationlist .side ul li {
    margin: 15px 0;
}

.side-navigationlist .side ul li a {
    color: #333;
    text-decoration: none;
    font-size: 16px;
    display: block;
    padding: 10px;
    transition: background-color 0.3s, color 0.3s;
}

.side-navigationlist .side ul li a:hover {
    background-color: black;
    color: white;
}

.container {
    padding: 20px;
    flex: 1;
    overflow: auto;
}

footer {
    background-color: black;
    color: white;
    padding: 20px;
    text-align: center;
    width: 100%;
    flex-shrink: 0;
}

.contactUs {
    margin-top: 20px;
}

.contactUs h3 {
    margin-bottom: 10px;
}

.contactUs img {
    margin-right: 10px;
}

/* Add this to your existing CSS */

.side-navigationlist .side table {
    width: 100%;
    border-collapse: collapse; /* Merge borders between cells */
}

.side-navigationlist .side table td {
    padding: 10px;
    border-bottom: 1px solid #ddd; /* Add border between rows */
}

.side-navigationlist .side table td a {
    color: black; /* Set text color to black */
    text-decoration: none; /* Remove underlining */
    display: block; /* Convert to block to allow padding */
}

.side-navigationlist .side table td a:hover {
    background-color: #333333; /* Add hover effect */
    color:white;
}

h1 {
    color: #333;
}

p {
    color: #555;
    text-align: left;
}

.profile-box {
    max-width: 500px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    text-align: center;
}


    </style>
</head>
<body>
    <header>
        <div class="navlist">
            <div class="logo">
                <img src="logo.png" alt="logo" width="200px"/>
            </div>
            <div class="title">
                <h3>Welcome to Admin Page</h3>
            </div>
            <nav class="head">
                <ul>
                    <li><a href="admin.php">Home</a></li>
                    <li><a href="home.php">Log Out</a></li>
                    <li><a href="adminprofile.php">Profile</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="main-content">
        <div class="side-navigationlist">
            <nav class="side">
                <table>
                    <tr><td><a href="viewmember.php">View Register Member Records</a></td></tr>
                    <tr><td><a href="blockmember.php">Block Member</a></td></tr>
                    <tr><td><a href="deletemember.php">Delete Member</a></td></tr>
                    <tr><td><a href="viewbooking.php">View All Booking Records For Each Events</a></td></tr>
                    <tr><td><a href="addevent.php">Add Event</a></td></tr>
                    <tr><td><a href="editevent.php">Update Or Delete Event</a></td></tr>
                    <tr><td><a href="viewfeedback.php">View Feedback Form</a></td></tr>
                </table>
            </nav>
        </div>
        
        <div class="container">
            <div class="profile-box">
                <?php if ($userData): ?>
                    <h1>Welcome, <?php echo htmlspecialchars($userData['name']); ?>!</h1>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($userData['address']); ?></p>
                    <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($userData['phone_number']); ?></p>
                <?php else: ?>
                    <p>User not found</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
   
    <footer>
        <div class="contactUs">
            <h3>Contact us</h3>
            <a href="https://www.facebook.com/profile.php?id=61559349223136&mibextid=ZbWKwL"><img src="facebook.png" alt="fb" width="60px" height="auto"/></a>
            <a href="https://www.instagram.com/musico_club?igsh=dnVlMWdmMmliYnVx"><img src="ig.jpeg" alt="ig" width="60px" height="auto"/></a>
        </div>
    </footer>

</body>
</html>
