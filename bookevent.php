<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Event</title>
    <link rel="stylesheet" type="text/css" href="css/member.css">
    <link rel="stylesheet" type="text/css" href="css/viewevent.css">
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
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"],
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #45a049;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .contactUs {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .contactUs h3 {
            margin-right: 10px;
        }

        .contactUs a {
            margin-right: 10px;
        }

        .contactUs a:last-child {
            margin-right: 0;
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
                    <li><a href="memberprofile.php">Profile</a></li>
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
            <h1>Booking Event</h1>
            
            <?php
                require_once('mysql_connect.php');
                $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Could not connect to database: " . mysqli_connect_error());

                if (isset($_GET['event_id'])) {
                    $eventID = mysqli_real_escape_string($mysqli, $_GET['event_id']);
                    $sql_fetchEvent = "SELECT * FROM add_event WHERE event_id = '$eventID'";
                    $result_fetchEvent = mysqli_query($mysqli, $sql_fetchEvent);

                    if ($result_fetchEvent && mysqli_num_rows($result_fetchEvent) > 0) {
                        $row = mysqli_fetch_assoc($result_fetchEvent);
                        $eventImage = $row['event_image'];
                        $eventTitle = $row['event_title'];
                        $eventDescription = $row['event_description'];
                        $eventDateTime = $row['event_date_time'];
                        $eventLocation = $row['event_location'];

                        echo "<div class='event-container'>";
                        echo "<div class='event-details'>";
                        echo "<div class='event-image'><img src='$eventImage' alt='Event Image'></div>";
                        echo "<table>";
                        echo "<tr><th>Event Title:</th><td>$eventTitle</td></tr>";
                        echo "<tr><th>Event Description:</th><td>$eventDescription</td></tr>";
                        echo "<tr><th>Event Date and Time:</th><td>$eventDateTime</td></tr>";
                        echo "<tr><th>Event Location:</th><td>$eventLocation</td></tr>";
                        echo "</table>";
                        echo "</div>";
                        echo "</div>";
                    } else {
                        echo "<p>Event with ID $eventID does not exist.</p>";
                    }
                }
            ?>

            <form action="bookingsubmit.php" method="POST">
                 <input type="hidden" name="event_id" value="<?php echo $eventID; ?>">
                <input type="hidden" name="event_title" value="<?php echo $eventTitle; ?>">
                
                <input type="hidden" name="booking_status" value="pending">

                <label for="student_name">1. Full Name (As per IC)</label>
                <input type="text" id="student_name" name="studentName" required placeholder="Enter your name">

                <label for="student_id">2. Student ID (e.g: 24ABC12345)</label>
                <input type="text" id="student_id" name="studentId" required placeholder="Enter your student ID">

                <label for="program_of_study">3. Program of Study</label>
                <select id="program_of_study" name="programOfStudy" required>
                    <option value="" disabled selected>Choose your program of study</option>
                    <option value="DIT">Diploma in Information Technology</option>
                    <option value="DEM">Diploma in E-marketing</option>
                    <option value="BBA">Bachelor in Business Administration(Honours)</option>
                    <option value="BCS">Bachelor in Communication Studies(Honours)</option>
                    <option value="BHC">Bachelor in Hospitality and Catering Management(Honours)</option>
                </select>

                <label>4. Pick a Row:</label>
                <select id="row_selected" name="rowSelected" required>
                    <option value="" disabled selected>Choose the rows</option>
                    <option value="A">Row A</option>
                    <option value="B">Row B</option>
                    <option value="C">Row C</option>
                    <option value="D">Row D</option>
                    <option value="E">Row E</option>
                </select>
                
                <label>5. Pick a Seat:</label>
                <select id="seat_selected" name="seatSelected" required>
                    <option value="" disabled selected>Choose the seat</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
                
                <button type="submit" name="book">Book</button>
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
