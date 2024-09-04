<?php
require_once('mysql_connect.php');
$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Could not connect to database: " . mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    // Retrieve the user's name from the form data
    $username = $_POST['name'];
    
    // Delete the user's account from the database
    $sql_deleteAccount = "DELETE FROM users WHERE name = ?";
    $stmt = $mysqli->prepare($sql_deleteAccount);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                // Account successfully deleted
                // Update event IDs
                $sql_updateIDs = "SET @count = 0;
                                  UPDATE add_event SET event_id = @count:= @count + 1;
                                  ALTER TABLE add_event AUTO_INCREMENT = 1";
                if (mysqli_multi_query($mysqli, $sql_updateIDs)) {
                    // Redirect back to deletemember.php or any other appropriate page
                    header("Location: deletemember.php");
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
} else {
    // Invalid request
    header("Location: deletemember.php");
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
    <title>Delete Account</title>
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
                    <li><a href="admin.php">Events</a></li>
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
            <h2>Delete Account</h2>
            
            <div class="delete">
                <p>Account deletion status:</p>
                <?php
                if (isset($error_message)) {
                    echo "<p style='color: red;'>$error_message</p>";
                } else {
                    echo "<p style='color: green;'>Account deleted successfully.</p>";
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
