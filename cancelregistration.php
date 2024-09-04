<?php
session_start();
require_once('mysql_connect.php');
$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Could not connect to database: " . mysqli_connect_error());

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Check if the delete account form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_account'])) {
        // Delete the user's account from the database
        $username = $_SESSION['username'];
        $sql_deleteAccount = "DELETE FROM users WHERE name = ?";
        $stmt = $mysqli->prepare($sql_deleteAccount);

        if ($stmt) {
            $stmt->bind_param("s", $username);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    // Account successfully deleted
                    // Update event IDs
                    $sql_updateIDs = "SET @count = 0;
                                      UPDATE users SET user_id = @count:= @count + 1;
                                      ALTER TABLE users AUTO_INCREMENT = 1";
                    if (mysqli_multi_query($mysqli, $sql_updateIDs)) {
                        // Destroy session data and redirect to home.php
                        session_destroy();
                        header("Location: home.php");
                        exit();
                    } else {
                        // Error updating event IDs
                        $error_message = "Error updating event IDs: " . mysqli_error($mysqli);
                    }
                } else {
                    // Failed to delete account
                    $error_message = "Failed to delete account. No rows affected.";
                }
            } else {
                // Error executing statement
                $error_message = "Error executing statement: " . $stmt->error;
            }
            // Close the statement
            $stmt->close();
        } else {
            // Error preparing statement
            $error_message = "Error preparing statement: " . $mysqli->error;
        }
    }
} else {
    // User is not logged in, redirect them to the login page
    header("Location: login.php");
    exit();
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/member.css">
    <title>Cancel Registration</title>
    <style>
        .container {
            margin: 0 auto;
            width: 70%;
            text-align: center; /* Center align the text */
        }

        .delete {
            margin-top: 20px; /* Add some spacing */
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
                <h3>Welcome to Member Page</h3>
            </div>
            <nav class="head">
                <ul>
                    <li><a href="member.php">Home</a></li>
                    <li><a href="home.php">Log Out</a></li>
                    <li><a href="profile.php">Profile</a></li>
                </ul>
            </nav>
        </div>
        
        
        
    </header>
    
    <div class="main-content">
        <div class="side-navigationlist">
            <nav class="side">
                <table>
                    <tr><td><a href="searchNsort_event.php">Search And Sorting Event</a></td></tr>
                    <tr><td><a href="showeventforbooking.php">Booking For Event</a></td></tr>
                    <tr><td><a href="showcancelbooking.php">Cancel Booking</a></td></tr>
                    <tr><td><a href="cancelregistration.php">Cancel Registration</a></td></tr>
                    <tr><td><a href="viewbookingstatus.php">View Booking Status</a></td></tr>
                    <tr><td><a href="ticket.php">Print Ticket</a></td></tr>
                    <tr><td><a href="feedbackform.php">Feedback Form</a></td></tr>
                </table>
            </nav>
        </div>
        
        <div class="container">
            <h2>Delete Account</h2>
            
            <div class="delete">
                <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                <form method="POST">
                    <input type="submit" name="delete_account" value="Yes, delete my account">
                </form>
                <?php
                if (isset($error_message)) {
                    echo "<p style='color: red;'>$error_message</p>";
                }
                ?>
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