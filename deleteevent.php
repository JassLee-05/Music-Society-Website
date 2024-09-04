<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/viewevent.css">
    <style>
        h2{
            text-align:center;
        }
        
        .sucess{
            text-align:center;
        }
    </style>
    <title>Delete Event</title>
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
            <h2>Delete Event</h2>

            <?php
                require_once('mysql_connect.php');
                $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Could not connect to database: " . mysqli_connect_error());

                // Check if eventID is set in the GET parameters
                if (isset($_GET['event_id'])) {
                    // Sanitize the input to prevent SQL injection
                    $eventID = mysqli_real_escape_string($mysqli, $_GET['event_id']);

                    // Construct the SQL query to fetch the event details
                    $sql_fetchEvent = "SELECT * FROM add_event WHERE event_id = '$eventID'";

                    // Execute the query to fetch event details
                    $result_fetchEvent = mysqli_query($mysqli, $sql_fetchEvent);

                    if ($result_fetchEvent) {
                        if (mysqli_num_rows($result_fetchEvent) > 0) {
                            $row = mysqli_fetch_assoc($result_fetchEvent);
                            $eventImage = $row['event_image'];
                            $eventTitle = $row['event_title'];
                            $eventDescription = $row['event_description'];
                            $eventDateTime = $row['event_date_time'];
                            $eventLocation = $row['event_location'];

                            // Display event details in a table
                            echo "<div class='event-container'>";
                            echo "<div class='event-details'>";
                            echo "<div class='event-image'><img src='$eventImage' alt='Event Image'></div>";
                            echo "<table>";
                            echo "<tr><th>Event Title:</th><td>$eventTitle</td></tr>";
                            echo "<tr><th>Event Description:</th><td>$eventDescription</td></tr>";
                            echo "<tr><th>Event Date and Time:</th><td>$eventDateTime</td></tr>";
                            echo "<tr><th>Event Location:</th><td>$eventLocation</td></tr>";
                            echo "</table>";
                            echo "<form method='post' action='deleteevent.php'>";
                            echo "<input type='hidden' name='event_id' value='$eventID'>";
                            echo "<button type='submit' name='confirm_delete'>Confirm Delete</button>";
                            echo "</form>";
                            echo "</div>";
                            echo "</div>";
                        } else {
                            echo "<p>Event with ID $eventID does not exist.</p>";
                        }
                    } else {
                        echo "<p>Error fetching event details: " . mysqli_error($mysqli) . "</p>";
                    }
                } 
                // Handle the delete confirmation
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_delete'])) {
                    $eventID = mysqli_real_escape_string($mysqli, $_POST['event_id']);
                    $sql_deleteEvent = "DELETE FROM add_event WHERE event_id = '$eventID'";
                    $result_deleteEvent = mysqli_query($mysqli, $sql_deleteEvent);

                    if ($result_deleteEvent) {
                        // Update event IDs
                        $sql_updateIDs = "SET @count = 0;
                                          UPDATE add_event SET event_id = @count:= @count + 1;
                                          ALTER TABLE add_event AUTO_INCREMENT = 1";
                        if (mysqli_multi_query($mysqli, $sql_updateIDs)) {
                            echo "<p class='success'>Event with event ID $eventID has been deleted successfully.</p>";
                            // Redirect back to admin view page after successful deletion
                            echo "<script>window.location.href = 'admin.php';</script>";
                            exit(); // Ensure no further code execution after redirection
                        } else {
                            echo "<p>Error updating event IDs: " . mysqli_error($mysqli) . "</p>";
                        }
                    } else {
                        echo "<p>Error deleting event: " . mysqli_error($mysqli) . "</p>";
                    }
                }
                // Close the database connection
                mysqli_close($mysqli);
            ?>
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