<?php

function detectInputError($event_title, $event_description, $event_date_time, $event_location, $event_image) {
    $error = [];

    if (empty(trim($event_title))) {
        $error['event_title'] = "Please enter the event title.";
    }

    if (empty(trim($event_description))) {
        $error['event_description'] = "Please enter the event description.";
    } 

    if (empty(trim($event_date_time))) {
        $error['event_date_time'] = "Please select the event date and time.";
    }

    if (empty(trim($event_location))) {
        $error['event_location'] = "Please enter the event location.";
    } 

    if (empty($event_image)) {
        $error['event_image'] = "Please select an event image.";
    }

    return $error;
}

$successMessage = "";
$errorMessages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    // Retrieve form data
    $event_title = $_POST["eventTitle"];
    $event_description = $_POST["eventDescription"];
    $event_date_time = $_POST["eventDateTime"];
    $event_location = $_POST["eventLocation"];
    $event_image_name = $_FILES["eventImage"]["name"];

    $error = detectInputError($event_title, $event_description, $event_date_time, $event_location, $event_image_name);

    if (empty($error)) {
        require_once('mysql_connect.php');
        $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)or die ("Could not connect to database: " . mysqli_connect_error() );

        $sql_insertRecord = "INSERT INTO add_event (event_title, event_description, event_date_time, event_location, event_image) 
                            VALUES ('$event_title', '$event_description', '$event_date_time', '$event_location', '$event_image_name')";
        $result_insertRecord = mysqli_query($mysqli, $sql_insertRecord);

        if ($result_insertRecord) {
            $successMessage = '<p style="color: green;">Add event successfully!</p>';
        } else {
            $errorMessages[] = "Error inserting record: " . mysqli_error($mysqli);
        }

        mysqli_close($mysqli);

    } else {
        $errorMessages = $error;
    }
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%; 
            max-width: 800px;
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
            text-align:center;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }
    </style>
    <title>Add Event</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
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
            <h2>Add Event</h2>

            <?php 
                if (!empty($successMessage)) {
                    echo $successMessage;
                }
                if (!empty($errorMessages)) {
                    foreach ($errorMessages as $message) {
                        echo '<p class="error">' . $message . '</p>';
                    }
                }
            ?>

            <form method="post" action="addevent.php" enctype="multipart/form-data">

                <label for="event_title">Event Title:</label><br>
                <input type="text" id="event_title" name="eventTitle" required><br><br>

                <label for="event_description">Event Description:</label><br>
                <input type="text" id="event_description" name="eventDescription" required><br><br>

                <label for="event_date_time">Event Date and Time:</label><br>
                <input type="text" id="event_date_time" name="eventDateTime" required><br><br>

                <label for="event_location">Event Location:</label><br>
                <input type="text" id="event_location" name="eventLocation" required><br><br>

                <label for="event_image">Event image:</label><br>
                <input type="file" id="event_image" name="eventImage" required><br><br>

                <input type="submit" name="add" value="Add">
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
