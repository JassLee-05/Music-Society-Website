<!DOCTYPE HTML>
<html>
<head>
    <title>Search N Sorting Event</title>
    <link rel="stylesheet" type="text/css" href="css/member.css">
    <link rel="stylesheet" type="text/css" href="css/viewevent.css">
    <style>
        .topnav {
            overflow: hidden;
            background-color: #e9e9e9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .topnav .search-container, .topnav .sort-container {
            flex-grow: 1;
            text-align: right;
        }

        .topnav input[type=text] {
            padding: 6px;
            margin: 8px 0;
            font-size: 17px;
            border: 1px solid #ccc;
            width: 200px;
            margin-right: 8px;
        }

        .topnav button[type=submit] {
            padding: 6px 10px;
            margin: 8px 0;
            font-size: 17px;
            border: none;
            cursor: pointer;
            background-color: #ddd;
        }

        .topnav button[type=submit]:hover {
            background-color: #ccc;
        }

        @media screen and (max-width: 600px) {
            .topnav {
                flex-direction: column;
            }
            .topnav .search-container, .topnav .sort-container {
                text-align: left;
                width: 100%;
            }
            .topnav input[type=text], .topnav button[type=submit] {
                width: 100%;
                margin: 0;
                padding: 14px;
                border: 1px solid #ccc;
            }
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
            <h2>Search And Sorting Events</h2>
     
            <div class="topnav">
                <div class="search-container">
                    <form action="" method="GET">
                        <input type="text" placeholder="Search.." name="search">
                        <button type="submit">Search</button>
                    </form>
                </div>
                <div class="sort-container">
                    <form action="" method="GET">
                        <input type="hidden" name="sort" value="event_date_time">
                        <button type="submit"><a href="?sort=date">Sort by Date</a></button>
                    </form>
                </div>
            </div>
            
             <?php
                $search_query = "";
                $sort_by_date = false;
                
                require_once('mysql_connect.php');
                $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die ("Could not connect to database: " . mysqli_connect_error());
                $sql_readRecord = "SELECT * FROM add_event";

                if (isset($_GET['search'])) {
                    $search_query = mysqli_real_escape_string($mysqli, $_GET['search']);
                    $sql_readRecord .= " WHERE event_title LIKE '%$search_query%'";
                }

                if (isset($_GET['sort']) && $_GET['sort'] == 'date') {
                    $sort_by_date = true;
                }

                if ($sort_by_date) {
                    $sql_readRecord .= " ORDER BY event_date_time DESC";
                }

                $result_readRecord = mysqli_query($mysqli, $sql_readRecord);

                if ($result_readRecord && mysqli_num_rows($result_readRecord) > 0) {
                    while ($row = mysqli_fetch_assoc($result_readRecord)) {
                        echo '<br>';
                        echo '<div class="event-container">';
                        echo '<div class="event-image"><img src="' . $row['event_image'] . '" alt="Event Image"></div>'; // Image above
                        echo '<div class="event-details">';
                        echo '<table>';
                        echo '<tr><th>Event Title</th><td>' . $row['event_title'] . '</td></tr>';
                        echo '<tr><th>Description</th><td>' . $row['event_description'] . '</td></tr>';
                        echo '<tr><th>Date & Time</th><td>' . $row['event_date_time'] . '</td></tr>';
                        echo '<tr><th>Location</th><td>' . $row['event_location'] . '</td></tr>';
                        echo '</table>';
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
