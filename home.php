<?php
    session_start();
    $_SESSION['authenticate'] = "approved";
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Home 1</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    
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
    
    <div class="container">
        <div class="president">
            <div class="president-image">
                <img src="president.png" alt="president">
            </div>
            <div class="president-info">
                <h1>Elon Musk</h1>
                <p><b>Musico</b> is a vibrant community of music enthusiasts, dedicated to fostering a 
                love for music and providing a platform for musicians of all levels to express themselves, 
                collaborate, and grow. Whether you're a seasoned performer or just starting your musical journey, 
                there's a place for you here. At <b>Musico</b>, we believe in the power of music to inspire, 
                unite, and transform lives. Through a diverse range of activities, events, and initiatives, we aim 
                to create an inclusive and supportive environment where individuals can explore their passion for 
                music and develop their skills. <b>Musico</b> offers a variety of opportunities for members to 
                engage with music in meaningful ways. From jam sessions and workshops to concerts and competitions, 
                there's always something exciting happening. We also provide resources and support for those interested 
                in music production, composition, and other aspects of the music industry. But <b>Musico</b> is 
                more than just a place to play music—it's a community where friendships are formed, creativity is 
                celebrated, and memories are made. Whether you're looking to perform on stage, learn a new instrument, 
                or simply connect with fellow music lovers, you'll find a welcoming home here. Join us on this musical journey 
                and discover the joy of making music together. Together, let's create harmony in our lives and in the world 
                around us. Feel free to customize this introduction to better fit the specific goals, activities, and culture 
                of your music society!
                </p>
            </div>
        </div>

        <!-- music_area  -->
        <div class="music_area">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-10">
                        <div class="row align-items-center">
                            <div class="col-xl-9 col-md-9">
                                <div class="music_field">
                                    <div class="thumb">
                                        <img src="ava.jpg" alt="singer">
                                    </div>
                                    <div class="audio_name">
                                        <div class="name">
                                            <h4>Ava Max</h4>
                                            <p>17 August, 2018</p>
                                        </div>
                                        <audio preload="auto" controls>
                                            <source src="sweet but a psycho.mp3">
                                        </audio>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="video_section">
            <video width="1000px" height="auto" controls>
                <source src="video.mp4" type="video/mp4">
                    Your browser does not support the video tag.
            </video>
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
