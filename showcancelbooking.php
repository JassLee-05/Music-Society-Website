<?php
    require_once('mysql_connect.php');
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    $loggedInUserName = $_SESSION['username']; 

    $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Could not connect to database: " . mysqli_connect_error());

    $sql_fetchStudentName = "SELECT name FROM users WHERE name = '$loggedInUserName'";
    $result_fetchStudentName = mysqli_query($mysqli, $sql_fetchStudentName);

    if ($result_fetchStudentName && mysqli_num_rows($result_fetchStudentName) > 0) {
        $studentData = mysqli_fetch_assoc($result_fetchStudentName);
        $loggedInStudentName = $studentData['name'];

        $sql_fetchBookings = "SELECT * FROM event_booking WHERE student_name = '$loggedInStudentName' ORDER BY booking_id ASC";
        $result_fetchBookings = mysqli_query($mysqli, $sql_fetchBookings);

        if (!$result_fetchBookings) {
            die("Error fetching booking information: " . mysqli_error($mysqli));
        }
    } else {
        die("No student name found for the logged-in user.");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bookingId = $_POST['booking_id'];

        $loggedInUserName = $_SESSION['username']; 

        $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die("Could not connect to database: " . mysqli_connect_error());

        $sql_fetchBooking = "SELECT * FROM event_booking WHERE booking_id = '$bookingId' AND student_name = '$loggedInUserName'";
        $result_fetchBooking = mysqli_query($mysqli, $sql_fetchBooking);

        if ($result_fetchBooking && mysqli_num_rows($result_fetchBooking) > 0) {
            $sql_cancelBooking = "DELETE FROM event_booking WHERE booking_id = '$bookingId'";
            if (mysqli_query($mysqli, $sql_cancelBooking)) {
                $sql_updateIDs = "SET @count = 0;
                      UPDATE event_booking SET booking_id = @count:= @count + 1;
                      ALTER TABLE event_booking AUTO_INCREMENT = 1";
                mysqli_query($mysqli, $sql_updateIDs);

                header("Location: viewbookingstatus.php?status=cancelled");
                exit();
            } else {
                die("Error cancelling booking: " . mysqli_error($mysqli));
            }
        } else {
            die("Booking not found or you are not authorized to cancel this booking.");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cancel Booking</title>
    <link rel="stylesheet" type="text/css" href="css/member.css">
    <style>
        h1{
            text-align:center;
        }
        
        .container {
            flex: 3;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .container table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .container table th,
        .container table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .container table th {
            background: #4CAF50;
            color: white;
            font-weight: bold;
        }

        .container table td {
            background: #f9f9f9;
        }

        .container table tr:hover td {
            background: #f1f1f1;
        }

        .cancel-button {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .cancel-button:hover {
            background: #c0392b;
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
            <h1>Cancel Booking</h1>
            <table>
                <tr>
                    <th>Student Name</th>
                    <th>Student ID</th>
                    <th>Event Title</th>
                    <th>Row</th>
                    <th>Seat</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php
                if (mysqli_num_rows($result_fetchBookings) > 0) {
                    while ($booking = mysqli_fetch_assoc($result_fetchBookings)) {
                        echo "<tr>
                                <td>{$booking['student_name']}</td>
                                <td>{$booking['student_id']}</td>
                                <td>{$booking['event_title']}</td>
                                <td>{$booking['row_selected']}</td>
                                <td>{$booking['seat_selected']}</td>
                                <td>{$booking['booking_status']}</td>
                                <td>
                                    <form action='' method='POST'>
                                        <input type='hidden' name='booking_id' value='{$booking['booking_id']}'>
                                        <button type='submit' class='cancel-button'>Cancel Booking</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No bookings found.</td></tr>";
                }
                ?>
            </table>
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
