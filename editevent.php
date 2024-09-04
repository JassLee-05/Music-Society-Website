<!DOCTYPE HTML>
<html>
<head>
    <title>Edit Event</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <link rel="stylesheet" type="text/css" href="css/viewevent.css">
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
            <h2>Update Or Delete Events</h2>
            <?php
                require_once('mysql_connect.php');
                $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)or die ("Could not connect to database: " . mysqli_connect_error() );
                $sql_readRecord = "SELECT * FROM add_event";
                $result_readRecord = mysqli_query($mysqli, $sql_readRecord);  

                if ($result_readRecord && mysqli_num_rows($result_readRecord) > 0) {
                    while ($row = mysqli_fetch_assoc($result_readRecord)) {
                        echo '<div class="event-container">';
                        echo '<div class="event-image"><img src="' . $row['event_image'] . '" alt="Event Image"></div>'; // Image above
                        echo '<div class="event-details">';
                        echo '<table>';
                        echo '<tr><th>Event Title</th><td>' . $row['event_title'] . '</td></tr>';
                        echo '<tr><th>Description</th><td>' . $row['event_description'] . '</td></tr>';
                        echo '<tr><th>Date & Time</th><td>' . $row['event_date_time'] . '</td></tr>';
                        echo '<tr><th>Location</th><td>' . $row['event_location'] . '</td></tr>';
                        echo '</table>';
                        
                        // Delete button
                        echo '<form action="deleteevent.php" method="GET">';
                        echo '<input type="hidden" name="event_id" value="' . $row['event_id'] . '">';
                        echo '<button type="submit">Delete Event</button>';
                        echo '</form>';

                        echo '<form action="updateevent.php" method="POST">';
                        echo '<input type="hidden" name="event_id" value="' . $row['event_id'] . '">';
                        echo '<button type="submit">Update Event</button>';
                        echo '</form>';
                        
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>0 results</p>';
                }

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


