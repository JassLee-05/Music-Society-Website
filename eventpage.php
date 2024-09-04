<?php
    session_start();
    $_SESSION['authenticate'] = "approved";
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Event Page</title>
    <link rel="stylesheet" type="text/css" href="css/viewevent.css">
    <style>
        /* General reset for padding and margins */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
        }

        /* Style for the header */
        header {
            background-color: black;
            color: black;
            padding: 10px 0;
            border-bottom: 2px solid #333; /* Optional: Add border to the bottom of the header */
        }

        .navlist {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        /* Logo style */
        .logo img {
            display: block;
        }

        /* Navigation styles */
        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin: 0 15px;
            position: relative; /* Required for the dropdown positioning */
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            transition: color 0.3s;
            font-weight: bold;
        }

        nav ul li a:hover {
            color: grey;
        }

        /* Dropdown styles */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: black;
            top: 100%;
            right: 0;
            min-width: 400px;
            z-index: 1000;
            padding: 10px;
            border: 1px solid #333; /* Add border color to dropdown */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Optional: Add shadow to the dropdown */
        }

        .dropdown-content h2 {
            font-size: 25px;
            color: white;
            margin-bottom: 10px;
            text-align: center;
        }

        .dropdown-content h4 {
            font-size: 20px;
            color: white;
            margin-bottom: 10px;
            text-align: center;
        }

        .dropdown-content p {
            margin: 10px 0;
            text-align: center;
        }

        .dropdown-content p a {
            color: white;
            text-decoration: none;
            font-size: 15px;
            transition: color 0.3s, text-decoration 0.3s;
        }

        .dropdown-content p a:hover {
            color: blue;
            text-decoration: underline;
        }

        /* Dropdown hover effect */
        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Breaker styles */
        .breaker {
            margin: 10px 0;
            color: black;
            text-align: center;
        }

        .breaker div {
            display: flex;
            align-items: center;
        }

        .divider {
            flex: 1; /* Take up remaining space */
            margin: 0 10px; /* Adjust spacing */
            border: none; /* Remove default border */
            border-bottom: 1px solid black; /* Add custom bottom border */
        }

        .president {
            display: flex; /* Use flexbox layout */
            align-items: center; /* Center items vertically */
            justify-content: space-between; /* Add space between items */
            margin-top: 50px; /* Adjust the top margin as needed */
            margin-left: 200px; /* Adjust the left margin as needed */
            margin-right: 200px; /* Adjust the right margin as needed */
        }

        .president-info {
            flex-grow: 1; /* Allow the info div to grow */
            margin-right: 20px; /* Add space between the info and the image */
        }

        .president-image img {
            width: 350px; /* Set the width of the president's picture */
            margin-right:50px;
            height: auto; /* Maintain aspect ratio */
        }



        /* Social links styles */
        .social-links {
            text-align: center;
            margin-top: 20px;
        }

        .social-icons {
            display: flex; /* Display icons in a row */
            justify-content: center; /* Center icons horizontally */
            align-items: center; /* Center icons vertically */
        }

        .social-icons a {
            display: inline-block; /* Display icons as blocks */
            margin: 0 10px; /* Add margin between icons */
        }

        .social-icons img {
            width: 40px; /* Set the width of the icons */
            height: auto; /* Maintain aspect ratio */
            border-radius: 50%; /* Make the icons circular */
            transition: transform 0.3s ease; /* Add a smooth transition effect */
        }

        .social-icons img:hover {
            transform: scale(1.1); /* Increase the size of the icon on hover */
        }

        .music_area {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50vh; /* Center vertically in the viewport */
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column; /* Ensure vertical alignment within the container */
        }

        .music_field {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border: 1px solid #ddd; /* Optional: Add some border for better visualization */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Optional: Add some shadow for better visualization */
            background-color: #fff; /* Optional: Add a background color */
        }

        .thumb img {
            width: 100px;
            height: auto;
            border-radius: 50%;
            margin-right: 20px; /* Adjust margin to move the image to the right */
        }

        .audio_name {
            flex-grow: 1;
            text-align: left;
        }

        .audio_name h4 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .audio_name p {
            margin: 5px 0;
            font-size: 14px;
            color: #999;
        }

        .music_btn {
            text-align: center;
            margin-left: 20px; /* Adjust margin to move the button to the right */
            margin-top: auto;
        }

        .boxed-btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .boxed-btn:hover {
            background-color: #0056b3;
        }

        .video_section {
            margin-top: 20px;
            text-align: center;
        }

        video {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-bottom: 50px; /* Adjust this value to add desired space */
        }


        /* Footer styles */
        footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Style for the contactUs section */
        .contactUs {
            margin-top: 20px; /* Add space between footer content and contact information */
        }

        .contactUs h3 {
            margin-bottom: 10px; /* Add space below the heading */
        }

        .contactUs img {
            margin-right: 10px; /* Add space between social media icons */
        }

    </style>
</head>

<body>
    <header>
        <div class="navlist">
            <div class="logo">
                <img src="logo.png" alt="logo" width="200px"/>
            </div>

            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li class="dropdown">
                        <a href="eventpage.php">Events</a>
                    </li>
                    <li class="dropdown">
                        <a href="#">Log In/Register</a>
                        <div class="dropdown-content">
                            <h2>Welcome back!!</h2>
                            <p><a href="login.php">Log In</a></p>
                            <div class="breaker">
                                <div><hr class="divider"></div>
                            </div>
                            <h4>Register for member to get more information!</h4>
                            <p><a href="register.php">Register</a></p>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
      
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
                        echo '</div>'; // Closing event-details
                echo '</div>'; // Closing event-container
            }
        } else {
            echo 'Failed to display event';
        }
        mysqli_close($mysqli);
    ?>
    
    <footer>
        <div class="contactUs">
            <h3>Contact us</h3>
            <a href="https://www.facebook.com/profile.php?id=61559349223136&mibextid=ZbWKwL"><img src="facebook.png" alt="fb" width="60px" height="auto"/></a>
            <a href="https://www.instagram.com/musico_club?igsh=dnVlMWdmMmliYnVx"><img src="ig.jpeg" alt="ig" width="60px" height="auto"/></a>
        </div>
    </footer>

</body>
</html>