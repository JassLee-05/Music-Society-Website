<?php
    require_once('mysql_connect.php');

    function getPrograme() {
        return array(
            'DIT' => 'Diploma in Information Technology',
            'DEM' => 'Diploma in E-marketing',
            'BBA' => 'Bachelor in Business Administration',
            'BCS' => 'Bachelor in Communication Studies(Honours)',
            'BHC' => 'Bachelor in Hospitality and Catering Management(Honours)'
        );
    }

    function getRows() {
        return array(
            'A' => 'Row A',
            'B' => 'Row B',
            'C' => 'Row C',
            'D' => 'Row D',
            'E' => 'Row E'
        );
    }

    function detectInputError($student_name, $student_id, $program_of_study, $row_selected, $seat_selected) {
        $error = [];

        if (empty(trim($student_name))){
            $error['student_name'] = "Please enter your name.";
        } elseif (!preg_match("/^[A-Za-z @,\'\.\-\/]+$/", $student_name)){
            $error['student_name'] = "Invalid character in your name.";
        } elseif (strlen($student_name) > 30){
            $error['student_name'] = "Your name is more than 30 characters.";
        }

        if (empty(trim($student_id))){
            $error['student_id'] = "Please enter your Student ID.";
        } elseif (!preg_match("/^\d{2}[A-Z]{3}\d{5}$/", $student_id)){
            $error['student_id'] = "Invalid student ID format. It should be like '23ABC12345'.";
        }

        if (empty(trim($program_of_study))){
            $error['program_of_study'] = "Please choose your program of study.";
        }

        if (empty(trim($row_selected))){
            $error['row_selected'] = "Please choose a row.";
        }

        if (empty(trim($seat_selected))){
            $error['seat_selected'] = "Please choose a seat.";
        }

        return $error;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Thank You for Booking</title>
    <link rel="stylesheet" type="text/css" href="css/member.css">
     <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f5f5f5;
        }

        h1 {
            color: #333;
            margin-top: 50px;
        }

        p {
            color: #666;
            margin-bottom: 20px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            width: 80%; 
            max-width: 800px; 
            margin: 10px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book'])) {
                    
                    $student_name = trim($_POST['studentName']);
                    $student_id = trim($_POST['studentId']);
                    $program_of_study = trim($_POST['programOfStudy']);
                    $row_selected = trim($_POST['rowSelected']);
                    $seat_selected = trim($_POST['seatSelected']);
                    $event_title = trim($_POST['event_title']);
                    $booking_status = 'pending';

                    $error = detectInputError($student_name, $student_id, $program_of_study, $row_selected, $seat_selected);

                    if (empty($error)) {
                        $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Could not connect to database: " . mysqli_connect_error());

                        $student_name = mysqli_real_escape_string($mysqli, $student_name);
                        $student_id = mysqli_real_escape_string($mysqli, $student_id);
                        $program_of_study = mysqli_real_escape_string($mysqli, $program_of_study);
                        $row_selected = mysqli_real_escape_string($mysqli, $row_selected);
                        $seat_selected = mysqli_real_escape_string($mysqli, $seat_selected);
                        $event_title = mysqli_real_escape_string($mysqli, $event_title);

                        $sql_insertRecord = "INSERT INTO event_booking (student_name, student_id, program_of_study, row_selected, seat_selected, event_title, booking_status) 
                                             VALUES ('$student_name', '$student_id', '$program_of_study', '$row_selected', '$seat_selected', '$event_title', '$booking_status')";

                        $result_insertRecord = mysqli_query($mysqli, $sql_insertRecord);

                        if ($result_insertRecord) {
                            echo "<div class='container'>
                                    <h1>Thank You for Booking Event!</h1>
                                    <p>Your booking is pending. We will notify you once it is confirmed.</p>
                                    <p><a href='showeventforbooking.php'>Book Another Event</a></p>
                                    <p><a href='member.php'>Back To Member Homepage</a></p>
                                  </div>";
                        } else {
                            echo "<div class='container'>
                                    <h1>Error!</h1>
                                    <p>There was an issue with your booking. Please try again later.</p>
                                  </div>";
                        }
                    } else {
                        echo "<div class='container'>
                                <h1>Error in Your Submission!</h1>";
                        foreach ($error as $err) {
                            echo "<p>$err</p>";
                        }
                        echo "<p><a href='javascript:history.back()'>Back to Booking Form</a></p></div>";
                    }
                }
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