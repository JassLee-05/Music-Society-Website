<?php
    $message = ""; // Initialize the $message variable

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone_number = $_POST['phoneNumber'];
        $password = $_POST['password'];
        $status = $_POST['status']; // Retrieve status from the form
        $account_status = "active";
    
        require_once('mysql_connect.php');
        $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)or die ("Could not connect to database: " . mysqli_connect_error() );
        
        $name = mysqli_real_escape_string($mysqli, $name);
        $email = mysqli_real_escape_string($mysqli, $email);
        $address = mysqli_real_escape_string($mysqli, $address);
        $phone_number = mysqli_real_escape_string($mysqli, $phone_number);
        $password = mysqli_real_escape_string($mysqli, $password);
        $status = mysqli_real_escape_string($mysqli, $status);
        $account_status = mysqli_real_escape_string($mysqli, $account_status);
        
        $sql_insertRecord = "INSERT INTO users (name, email, address, phone_number, password, status, account_status)
                VALUES ('$name','$email','$address','$phone_number','$password','$status','$account_status')";
        $result_insertRecord = mysqli_query($mysqli, $sql_insertRecord);
        
        if ($result_insertRecord) {
            $message = "<div class='succes-message'>Registration successful!</div>";
        } else {
            echo "Error: " . mysqli_error($mysqli);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Reset CSS to ensure consistency across browsers */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 16px; /* Base font size for consistency */
        }

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
            width: 90%; /* Use relative units */
            max-width: 450px; /* Ensure form doesn't exceed a certain width */
            padding: 20px;
            position: relative;
            background: rgba(255, 255, 255, 0.9);
            text-align: center;
            border-radius: 10px;
            border:20px;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2);
        }

        .button-box {
            width: 100%; /* Full width of the form */
            max-width: 220px; /* Ensure buttons don't exceed a certain width */
            margin: 10px auto 20px;
            position: relative;
            border-radius: 30px;
            background: #ddd;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: space-between;
        }

        .toggle-btn {
            width: 50%;
            padding: 10px 20px;
            cursor: pointer;
            background: transparent;
            border: none;
            outline: none;
            text-align: center;
            font-size: 1rem; /* Use relative units */
            font-weight: bold;
            color: #333;
            transition: color 0.3s;
            border-radius: 30px;
            z-index: 1;
            position: relative;
        }

        .toggle-btn.active {
            background: #e67e22;
            color: white;
        }

        #btn {
            left: 0;
            top: 0;
            position: absolute;
            width: 50%;
            height: 100%;
            background: #e67e22;
            border-radius: 30px;
            transition: left 0.3s;
            z-index: 0;
        }

        input[type=text], input[type=password] {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type=text]:focus, input[type=password]:focus {
            background-color: #ddd;
            outline: none;
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

        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
        }

        .registerbtn {
            background-color: #4CAF50;
            color: white;
            padding: 16px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
            opacity: 0.9;
            transition: opacity 0.3s;
        }

        .registerbtn:hover {
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

        /* Responsive design for smaller screens */
        @media (max-width: 600px) {
            .form-box {
                width: 95%;
                padding: 10px;
            }

            .toggle-btn {
                padding: 8px 10px;
                font-size: 0.9rem;
            }

            input[type=text], input[type=password] {
                padding: 10px;
            }

            .registerbtn {
                padding: 12px;
            }
        }

    </style>
    <title>Register</title>
</head>
<body>

   <div class="form-box">
        <?php echo $message; ?>
       
        <div class="button-box">
            <div id="btn"></div>
            <button type="button" class="toggle-btn" onclick="leftClick()">Admin</button>
            <button type="button" class="toggle-btn" onclick="rightClick()">Member</button>
        </div>
        
        <form id="registerForm" action="register.php" method="POST">
            <div class="container">
                <h1>Register Form</h1>
                <hr>

                <label for="name"><b>Username:</b></label>
                <input type="text" placeholder="Enter Name" name="name" id="name" required>

                <label for="email"><b>Email:</b></label>
                <input type="text" placeholder="Enter Email" name="email" id="email" required>
                
                <label for="address"><b>Home Address:</b></label>
                <input type="text" placeholder="Enter Address" name="address" id="address" required>
                
                <label for="phone_number"><b>Phone Number (with dash):</b></label>
                <input type="text" placeholder="Enter Phone Number" name="phoneNumber" id="phone_number" required>
                
                <label for="password"><b>Password:</b></label>
                <input type="password" placeholder="Enter Password" name="password" id="password" required>
                <input type="checkbox" onclick="togglePassword()">Show Password
                
                <input type="hidden" name="status" id="status" value="">

                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

                <button type="submit" class="registerbtn">Register</button>
                
                <div class="container signin">
                    <p>Already have an account? <a href="login.php">Log In</a>.</p>
                </div>
            </div>
        </form>
    </div>

    <script src="js/register.js"></script>
</body>
</html>

