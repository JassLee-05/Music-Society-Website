<?php
// Include the database connection file
require_once('mysql_connect.php');
$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)or die ("Could not connect to database: " . mysqli_connect_error() );

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the member's name from the form submission
    if(isset($_POST['name'])){
        $name = $_POST['name'];

        // Update the database to set the account_status of the member to "Blocked"
        $sql = "UPDATE users SET account_status = 'Blocked' WHERE name = ?";
        $stmt = $mysqli->prepare($sql);
        
        if($stmt){
            $stmt->bind_param("s", $name);
            $stmt->execute();
            
            // Check if the update was successful
            if ($stmt->affected_rows > 0) {
                // Redirect back to the page where the member was blocked
                header("Location: viewmember.php");
                exit();
            } else {
                echo "Error blocking member";
            }
        } else {
            echo "Error preparing statement: " . $mysqli->error;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo "Name parameter not set";
    }
} else {
    // This block is executed if the form was not submitted via POST method
    echo "No form submission detected";
}
?>