<?php

    function getPrograme() {
        return array(
            'DIT' => 'Diploma in Information Technology',
            'DEM' => 'Diploma in E-marketing',
            'BBA' => 'Bachelor in Business Administration',
            'BCS' => 'Bachelor in Communication Studies(Honours)',
            'BHC' => 'Bachelor in Hospitality and Catering Management(Honours)'
        );
    }
      

    function detectInputError($student_name,$student_id,$program_of_study,$overall_rating,$venue_setup,$event_informativeness,$attend_future,$most_liked,$improvements) {
                            
    	$error = [];

    	if (empty(trim($student_name))){
            $error['student_name']="Please enter your name.";
        }
        else if(!preg_match("/^[A-Za-z @,\'\.\-\/]+$/",$student_name)){
            $error['student_name']="Invalid character in your name.";
        }
        else if (strlen($student_name)>30){
            $error['student_name']="Your name is more than 30 charactres.";
        }else {
            $student_name = $_POST['studentName'];
        }
         
        if(empty(trim($student_id))){
            $error['student_id']="Please enter your Student id.";
        }
        else if(!preg_match("/^\d{2}[A-Z]{3}\d{5}$/",$student_id)){
            $error['student_id']="Invalid student ID format. It should be like '23ABC12345'.";
        }else {
            $student_id = $_POST['studentId'];
        }

        if(empty(trim($program_of_study))){
            $error['program_of_study'] = "Please choose your program of study.";
        }else {
            $program_of_study = $_POST['programOfStudy'];
        }
                
        if ($overall_rating < 1 || $overall_rating > 10) {
            $error['overall_rating'] = "Please select a valid rating between 1 and 10.";
        }else {
            $overall_rating = $_POST['overallRating'];
        }

        if (empty(trim($venue_setup))) {
            $errors['venue_setup'] = "Please choose an option for the venue and setup.";
        } else {
            $venue_setup = $_POST['venueSetup'];
        }

        if (empty(trim($event_informativeness))) {
            $errors['event_informativeness'] = "Please choose if the event was informative.";
        } else {
            $event_informativeness = $_POST['eventInformativeness'];
        }

        if (empty(trim($attend_future))) {
            $errors['attend_future'] = "Please choose if you would attend a similar event in the future.";
        } else {
            $attend_future = $_POST['attendFuture'];
        }

        if (empty(trim($most_liked))) {
            $errors['most_liked'] = "Please tell us what you liked most about the event.";
        } else if (strlen($most_liked) > 100) {
            $errors['most_liked'] = "Your response is too long. Please limit to 500 characters.";
        }else {
            $most_liked = $_POST['mostLiked'];
        }

        if (empty(trim($improvements))) {
            $errors['improvements'] = "Please provide suggestions for improvement.";
        } else if (strlen($improvements) > 100) {
            $errors['improvements'] = "Your suggestions are too long. Please limit to 500 characters.";
        }else {
            $improvements = $_POST['improvement'];
        }
                
    	return $error;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Thank You for Feedback</title>
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
            <h1>Thank You For Your Feedback!</h1>
            <p>We appreciate your time and effort in providing valuable information to improve our events. </p>
            <p><a href="member.php">Back To Home</a></p>

            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){

                $student_name = trim($_POST['studentName']);
                $student_id = trim($_POST['studentId']);
                $program_of_study = trim($_POST['programOfStudy']);
                $overall_rating = (int) ($_POST['overallRating']);
                $venue_setup = isset($_POST['venueSetup']) ? trim($_POST['venueSetup']) : '';
                $event_informativeness = isset($_POST['eventInformativeness']) ? trim($_POST['eventInformativeness']) : '';
                $attend_future = isset($_POST['attendFuture']) ? trim($_POST['attendFuture']) : '';
                $most_liked = trim($_POST['mostLiked']);
                $improvements = trim($_POST['improvement']);

                        $error = detectInputError($student_name,$student_id,$program_of_study,$overall_rating,$venue_setup,$event_informativeness,$attend_future,$most_liked,$improvements);

                        if (empty($error)){
                            require_once('mysql_connect.php');
                            $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)or die ("Could not connect to database: " . mysqli_connect_error() );
                            $sql_insertRecord = "INSERT INTO event_feedback (student_name,student_id,program_of_study,overall_rating,venue_setup,event_informativeness,
                                attend_future,most_liked,improvements) 
                                VALUES ('$student_name','$student_id','$program_of_study','$overall_rating','$venue_setup','$event_informativeness',
                                '$attend_future','$most_liked','$improvements')";
                            $result_insertRecord = mysqli_query($mysqli, $sql_insertRecord);

                            $allprogram = getPrograme();
                            if($result_insertRecord){
                                echo '<p>Have a great day!</p>';
                            } else {
                                echo "Error inserting record: " . mysqli_error($mysqli);
                            }

                        }else{
                            foreach ($error as $key => $value) {   
                                echo "<p style='color: red;'>$value</p>";
                            }
                        }
                } else {
                    echo '<script type="text/javascript">window.location.href = "home.html";</script>';
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