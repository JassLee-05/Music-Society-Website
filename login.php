<?php
session_start();
$login_parameter = 0;
$message = ''; // Initialize $message

if (!isset($_SESSION['login']) && isset($_POST['name']) && isset($_POST['password'])) {      
    $name = $_POST['name'];
    $password = $_POST['password'];
    $login_parameter = 1;
} else if (isset($_SESSION['login'])){
    list($name, $password) = explode("|", $_SESSION['login']);
    $login_parameter = 1;
}

//..do validation e.g. cannot be empty etc.

if (empty($error) && $login_parameter == 1) {
    // Use prepared statements to prevent SQL injection
    require_once('mysql_connect.php');
    $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die ("Could not connect to database: " . mysqli_connect_error());

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows == 1) {           
        $row = $result->fetch_assoc();
        if ($row['account_status'] == "Blocked") {
            $message = "<div class='message access-denied'>Your account has been blocked. Please contact the administrator for assistance.</div>";
        } else {
            if ($row['status'] == "A"){
                $_SESSION['username'] = $name;
                setcookie("username", $name, time() + (86400 * 30), "/"); // 86400 = 1 day
                header('Refresh:5; url=admin.php?status=A');                
            } else if ($row['status'] == "M"){
                $_SESSION['username'] = $name;
                setcookie("username", $name, time() + (86400 * 30), "/"); // 86400 = 1 day
                header('Refresh:5; url=member.php?status=M');                
            } else {
                $message = "<div class='message access-denied'>Invalid user status</div>";
            }
            $message .= "<div class='message redirect-message'>We will redirect to the homepage soon...</div>";
        }
    } else {
        $message = "<div class='message access-denied'>Access Denied</div><br>";
    }
    $stmt->close();
    $mysqli->close();
} else {
    //!empty($error)
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            background: white;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .form-box {
            width: 450px;
            padding: 20px;
            position: relative;
            background: rgba(255, 255, 255, 0.9);
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #333;
        }

        label {
            color: #333;
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            text-align: left;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="text"]:focus, 
        input[type="password"]:focus {
            background-color: #ddd;
            outline: none;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            opacity: 0.9;
            transition: opacity 1s;
        }

        input[type="submit"]:hover {
            opacity: 1;
        }

        a {
            color: dodgerblue;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .signin {
            text-align: center;
        }
        
        .redirect-message {
            color: blue;
            font-weight:800;
        }

        .access-denied {
            color: red;
            font-weight:800;
        }
    </style>
</head>
<body>
   
    <div class="form-box">
        <?php echo $message; ?>
        <form action="login.php" method="post">
            <h1>Login</h1>
            <label for="name"><b>Username:</b></label>
            <input type="text" id="name" name="name" placeholder=" Enter Username" required>

            <label for="password"><b>Password:</b></label>
            <input type="password" id="password" name="password" placeholder="Enter Password" required>
            <input type="checkbox" onclick="togglePassword()">Show Password
            <script src="js/register.js"></script>

            <input type="submit" value="Login">
        </form>
    </div>

</body>
</html>