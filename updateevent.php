<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%; /* Adjust the width as needed */
            max-width: 800px; /* Set a maximum width to maintain readability */
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-bottom: 15px;
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
            <?php
                require_once('mysql_connect.php');
                $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Could not connect to database: " . mysqli_connect_error());

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['update'])) {
                        // Sanitize the input to prevent SQL injection
                        $eventID = mysqli_real_escape_string($mysqli, $_POST['event_id']);
                        $eventTitle = mysqli_real_escape_string($mysqli, $_POST['event_title']);
                        $eventDescription = mysqli_real_escape_string($mysqli, $_POST['event_description']);
                        $eventDateTime = mysqli_real_escape_string($mysqli, $_POST['event_date_time']);
                        $eventLocation = mysqli_real_escape_string($mysqli, $_POST['event_location']);

                        // Default query without image update
                        $sql_updateEvent = "UPDATE add_event SET event_title = '$eventTitle', event_description = '$eventDescription', event_date_time = '$eventDateTime', event_location = '$eventLocation' WHERE event_id = '$eventID'";

                        // Handle file upload
                        if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] == UPLOAD_ERR_OK) {
                            $eventImage = $_FILES['event_image']['name'];
                            $target_dir = "uploads/";

                            // Check if the upload directory exists, create if not
                            if (!is_dir($target_dir)) {
                                mkdir($target_dir, 0777, true);
                            }

                            $target_file = $target_dir . basename($eventImage);

                            // Move the uploaded file to the target directory
                            if (move_uploaded_file($_FILES['event_image']['tmp_name'], $target_file)) {
                                // Update the event details including the image
                                $sql_updateEvent = "UPDATE add_event SET event_title = '$eventTitle', event_description = '$eventDescription', event_date_time = '$eventDateTime', event_location = '$eventLocation', event_image = '$target_file' WHERE event_id = '$eventID'";
                            } else {
                                echo "<p>Error uploading image.</p>";
                            }
                        }

                        // Execute the query to update event details
                        if (mysqli_query($mysqli, $sql_updateEvent)) {
                            header("Location: admin.php"); // Redirect to admin.php after successful update
                            exit(); // Ensure no further code execution after redirection
                        } else {
                            echo "<p>Error updating event: " . mysqli_error($mysqli) . "</p>";
                        }
                    } else {
                        // Fetch event details for the first load
                        if (isset($_POST['event_id'])) {
                            $eventID = mysqli_real_escape_string($mysqli, $_POST['event_id']);
                            $sql_fetchEvent = "SELECT * FROM add_event WHERE event_id = '$eventID'";
                            $result_fetchEvent = mysqli_query($mysqli, $sql_fetchEvent);

                            if ($result_fetchEvent) {
                                if (mysqli_num_rows($result_fetchEvent) > 0) {
                                    $row = mysqli_fetch_assoc($result_fetchEvent);
                                    $eventTitle = $row['event_title'];
                                    $eventDescription = $row['event_description'];
                                    $eventDateTime = $row['event_date_time'];
                                    $eventLocation = $row['event_location'];
                                    $eventImage = $row['event_image'];
                                } else {
                                    echo "<p>Event with ID $eventID does not exist.</p>";
                                }
                            } else {
                                echo "<p>Error fetching event details: " . mysqli_error($mysqli) . "</p>";
                            }
                        } else {
                            echo "<p>EventID is not set.</p>";
                        }
                    }
                }

                // Close the database connection
                mysqli_close($mysqli);
            ?>
            
            <h2>Update Event</h2>
            
            <form method="post" action="updateevent.php" enctype="multipart/form-data">
                <input type="hidden" name="event_id" value="<?php echo isset($eventID) ? htmlspecialchars($eventID) : ''; ?>">

                <label for="event_title">Event Title:</label><br>
                <input type="text" id="event_title" name="event_title" value="<?php echo isset($eventTitle) ? htmlspecialchars($eventTitle) : ''; ?>" required><br><br>

                <label for="event_description">Event Description:</label><br>
                <input type="text" id="event_description" name="event_description" value="<?php echo isset($eventDescription) ? htmlspecialchars($eventDescription) : ''; ?>" required><br><br>

                <label for="event_date_time">Event Date and Time:</label><br>
                <input type="text" id="event_date_time" name="event_date_time" value="<?php echo isset($eventDateTime) ? htmlspecialchars($eventDateTime) : ''; ?>" required><br><br>

                <label for="event_location">Event Location:</label><br>
                <input type="text" id="event_location" name="event_location" value="<?php echo isset($eventLocation) ? htmlspecialchars($eventLocation) : ''; ?>" required><br><br>

                <label for="event_image"> Event Image:</label><br>
                <input type="file" id="event_image" name="event_image"><br><br>

                <input type="submit" name="update" value="Update">
            </form>
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
