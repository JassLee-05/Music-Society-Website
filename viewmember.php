<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Member</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <style>
        h1 {
                text-align: center;
            }
            
            .container {
                margin: 0 auto; 
                width: 70%;
            }
            
            table {
                width: 70%;
                border-collapse: collapse;
                
            }

            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #f2f2f2;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
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
            <h1>Member Registration Records</h1>
            
            <?php
                require_once('mysql_connect.php');
                $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)or die ("Could not connect to database: " . mysqli_connect_error() );
                $sql_fetchFeedback = "SELECT * FROM users WHERE status = 'M' ";
                $result_fetchFeedback = mysqli_query($mysqli, $sql_fetchFeedback);

                // Check if there are any feedback records
                if (mysqli_num_rows($result_fetchFeedback) > 0) {
                    // Output table header
                    echo "<h2>Member Register Records</h2>";
                    echo "<table border='1'>";
                    echo "<tr>
                        <th>Student Name</th>
                        <th>Email Address</th>
                        <th>Home Address</th>
                        <th>Phone Number</th>
                        <th>Status</th>
                        <th>Account Status</th>
                      </tr>";

                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result_fetchFeedback)) {
                        echo "<tr>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["address"] . "</td>";
                        echo "<td>" . $row["phone_number"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["account_status"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No feedback records found";
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