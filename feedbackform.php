<?php
    $student_name = "";
    $student_id = "";
    $program_of_study = "";
    $overall_rating = "";
    $venue_setup = "";
    $event_informativeness = "";
    $attend_future = "";
    $most_liked = "";
    $improvements = "";
    
    if (!empty($_POST['submit'])) {
        
        $error = array();
        
        if (empty($error)) {
            
            $student_name = ($_POST['studentName']);
            $student_id = ($_POST['studentId']);
            $program_of_study = ($_POST['programOfStudy']);
            $overall_rating = (int)$_POST['overallRating'];
            $venue_setup = ($_POST['venueSetup']);
            $event_informativeness = ($_POST['eventInformativeness']);
            $attend_future = ($_POST['attendFuture']);
            $most_liked = ($_POST['mostLiked']);
            $improvements = ($_POST['improvement']);
        
            require_once('mysql_connect.php');
            $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)or die ("Could not connect to database: " . mysqli_connect_error() );
            $sql_insertRecord = "INSERT INTO event_feedback (student_name,student_id,program_of_study,overall_rating,venue_setup,event_informativeness,
                attend_future,most_liked,improvements) 
                VALUES ('$student_name','$student_id','$program_of_study','$overall_rating','$venue_setup','$event_informativeness',
                '$attend_future','$most_liked','$improvements')";
            $result_insertRecord = mysqli_query($mysqli, $sql_insertRecord);
        }
    }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Event Feedback</title>
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
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left; 
        }

        .flex-horizontal {
            display: flex;
            align-items: center;
            gap: 10px; 
            flex-wrap: wrap;
        }


        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
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
            <h1>Event Feedback Form</h1>
            <form action="feedbacksubmit.php" method="POST"> <!-- Points to the correct processing script -->

                <label for="student_name">1. Full Name (As per IC)</label>
                <input type="text" id="student_name" name="studentName" required placeholder="Enter your name">

                <br><br>
                <label for="student_id">2. Student ID (e.g: 24ABC12345)</label>
                <input type="text" id="student_id" name="studentId" required placeholder="Enter your student ID">

                <br><br>
                <label for="program_of_study">3. Program of Study</label>
                <select id="program_of_study" name="programOfStudy" required>
                    <option value="" disabled selected>Choose your program of study</option>
                    <option value="DIT">Diploma in Information Technology</option>
                    <option value="DEM">Diploma in E-marketing</option>
                    <option value="BBA">Bachelor in Business Administration(Honours)</option>
                    <option value="BCS">Bachelor in Communication Studies(Honours)</option>
                    <option value="BHC">Bachelor in Hospitality and Catering Management(Honours)</option>
                </select>

                <br><br>
                <label>4. How would you rate the event on a scale of 1-10?</label>
                <div class="flex-horizontal">
                    <input type="radio" name="overallRating" value="1"> 1
                    <input type="radio" name="overallRating" value="2"> 2
                    <input type="radio" name="overallRating" value="3"> 3
                    <input type="radio" name="overallRating" value="4"> 4
                    <input type="radio" name="overallRating" value="5"> 5
                    <input type="radio" name="overallRating" value="6"> 6
                    <input type="radio" name="overallRating" value="7"> 7
                    <input type="radio" name="overallRating" value="8"> 8
                    <input type="radio" name="overallRating" value="9"> 9
                    <input type="radio" name="overallRating" value="10"> 10
                </div>

                <br><br>
                <label>5. How was the venue and setup of the event?</label>
                <div class="flex-horizontal">
                    <input type="radio" name="venueSetup" value="excellent"> Excellent
                    <input type="radio" name="venueSetup" value="good"> Good
                    <input type="radio" name="venueSetup" value="average"> Average
                    <input type="radio" name="venueSetup" value="poor"> Poor
                </div>

                <br><br>
                <label>6. Was the event informative and beneficial to you?</label>
                <div class="flex-horizontal">
                    <input type="radio" name="eventInformativeness" value="yes"> Yes
                    <input type="radio" name="eventInformativeness" value="no"> No
                </div>

                <br><br>
                <label>7. Would you attend a similar event in the future?</label>
                <div class="flex-horizontal">
                    <input type="radio" name="attendFuture" value="yes"> Yes
                    <input type="radio" name="attendFuture" value="no"> No
                </div>

                <br><br>
                <label>8. What did you like most about the event?</label>
                <textarea name="mostLiked" rows="5" cols="50" placeholder="Please tell us..."></textarea>

                <br><br>
                <label>9. What could have been improved about the event?</label>
                <textarea name="improvement" rows="5" cols="50" placeholder="Please tell us..."></textarea>

                <br><br>
                <button type="submit" name="submit">Submit Feedback</button>
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
