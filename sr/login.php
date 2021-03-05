<?php
    include 'header.php';
    include 'android/db/db_connect.php';
    include 'android/functions.php';

    session_start();

    $email = $password = "";
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
        }
        else{
            $error = "* Enter email";
        }

        if (isset($_POST['password'])) {
            $password = $_POST['password'];
        }
        else{
            $error = "* Enter password";
        }

        if($error == ""){
            //Check if the email already exist
            $query = "SELECT user_id, password_hash, salt, user_status FROM user WHERE email = ?";
         
            if($stmt = $con->prepare($query)){
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($user_id, $passwordHashDB, $salt, $user_status);
                if($stmt->fetch()){
                    /* Validate the password */
                    if(password_verify(concatPasswordWithSalt($password, $salt), $passwordHashDB)){
                        $_SESSION['user_id'] = $user_id;
                        if($user_status == 3){	# For admins user status is 3, for normal people its 0
                            $_SESSION['status'] = "admin";
                            # $_SESSION['access'] = "all";
                        }
                        else{
                            $_SESSION['access'] = "none";
                        }
                        header("Location: home.php");
                    }
                    else{
                        $error = "* Invalid username or password";
                    }
                }
                else{
                    $error = "* Invalid username or password";
                }
                $stmt->close();
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <!-- For laptop -->
    <div class="row search-laptop">
        <div class="col-1 space">&nbsp</div>

        <div class="col-2 sidebar" style="background-image: linear-gradient(to bottom right, lightblue, white);">
            <center>
                <div class="title"> Speech Analyst </div>
            </center>

            <?php if(isset($_SESSION['access']) && $_SESSION['access'] == "all"){ ?>
            <div class="about-project">
                <i class="fa fa-angle-right"></i> <a href="pending_speech.php" class="about-link">Pending Speeches</a>
            </div>
            <?php } ?>
            
            <div class="about-project">
                <i class="fa fa-angle-right"></i> About this project
            </div>
            <div class="about-option"><a href="about.php#what_is_it" class="about-link">- What is it?</a></div>
            <div class="about-option"><a href="about.php#how_does_it_work" class="about-link">- How does it work?</a></div>
            <div class="about-option"><a href="about.php#how_to_search" class="about-link">- How to search?</a></div>
            <div class="about-option"><a href="about.php#contact" class="about-link">- Contact</a></div>
        </div>
        <div class="col-8 search-div" style="background-image: linear-gradient(to bottom right, #eafaff, #ffffff);"><br>
            <center>
            <h1 style="margin: 10px 0 15px 0">Admin Login</h1>
            <h4 style="margin: 10px 0 15px 0">Only Admin can check for suspicious contents. 
                <br>If you are not an admin then contact <a href="https://speechanalyst.com/contact/">here</a> to get the premium access.
                <br><br>
            </h4>

            <div style="width: 65%; display: inline-block;">
                <form action="login.php" method="post">
                    <span style="color: red"><?php echo $error; ?></span>

                    <div class="category"><i class="fa fa-envelope"></i> &nbspE-mail:</div>
                    <input type="email" class="text" placeholder="Enter your email" name="email" required value="<?php echo $email; ?>">

                    <div class="category"><i class="fa fa-lock"></i> &nbspPassword:</div>
                    <input type="password" class="text" placeholder="Enter password" name="password" required value="<?php echo $password; ?>">

                    <!--<br>Do not have an account? <a href="register.php">Sign up</a>.<br>-->

                    <input type="submit" class="button" id="login_btn" value="Login" name="submit">
                </form>
            </div>
            </center>
        </div>

        <div class="col-1 space">&nbsp</div>
    </div>

    <!-- For mini-laptop -->
    <div class="row search-mini-laptop">
        <div class="col-3 sidebar" style="background-image: linear-gradient(to bottom right, lightblue, white);">
            <center>
                <div class="title"> Speech Analyst </div>
            </center>

            <?php if($_SESSION['access'] == "all"){ ?>
            <div class="about-project">
                <i class="fa fa-angle-right"></i> <a href="pending_speech.php" class="about-link">Pending Speeches</a>
            </div>
            <?php } ?>
            
            <div class="about-project">
                <i class="fa fa-angle-right"></i> About this project
            </div>
            <div class="about-option"><a href="about.php#what_is_it" class="about-link">- What is it?</a></div>
            <div class="about-option"><a href="about.php#how_does_it_work" class="about-link">- How does it work?</a></div>
            <div class="about-option"><a href="about.php#how_to_search" class="about-link">- How to search?</a></div>
            <div class="about-option"><a href="about.php#contact" class="about-link">- Contact</a></div>
        </div>
        <div class="col-9 search-div" style="background-image: linear-gradient(to bottom right, #eafaff, #ffffff);"><br>
            <center>
            <h1 style="margin: 10px 0 15px 0">Admin Login</h1>

            <h4 style="margin: 10px 0 15px 0">Only Admin can check for suspicious contents. 
                <br>If you are not an admin then contact <a href="https://speechanalyst.com/contact/">here</a> to get the premium access.
                <br><br>
            </h4>

            <div style="width: 80%; display: inline-block;">
                <form action="login.php" method="post">
                    <span style="color: red"><?php echo $error; ?></span>

                    <div class="category"><i class="fa fa-envelope"></i> &nbspE-mail:</div>
                    <input type="email" class="text" placeholder="Enter your email" name="email" required value="<?php echo $email; ?>">

                    <div class="category"><i class="fa fa-lock"></i> &nbspPassword:</div>
                    <input type="password" class="text" placeholder="Enter password" name="password" required value="<?php echo $password; ?>">

                    <!--<br>Do not have an account? <a href="register.php">Sign up</a>.<br>-->

                    <input type="submit" class="button" id="login_btn" value="Login" name="submit">
                </form>
            </div>
            </center>
        </div>
    </div>

    <!-- For ipad -->
    <div class="row search-ipad">
        <div class="col-12 search-div"><br>
            <center>
            <h1 style="margin: 10px 0 15px 0">Admin Login</h1>

            <h4 style="margin: 10px 0 15px 0">Only Admin can check for suspicious contents. 
                <br>If you are not an admin then contact <a href="https://speechanalyst.com/contact/">here</a> to get the premium access.
                <br><br>
            </h4>

            <div style="width: 90%; display: inline-block;">
                <form action="login.php" method="post">
                    <span style="color: red"><?php echo $error; ?></span>

                    <div class="category"><i class="fa fa-envelope"></i> &nbspE-mail:</div>
                    <input type="email" class="text" placeholder="Enter your email" name="email" required value="<?php echo $email; ?>">

                    <div class="category"><i class="fa fa-lock"></i> &nbspPassword:</div>
                    <input type="password" class="text" placeholder="Enter password" name="password" required value="<?php echo $password; ?>">

                    <!--<br>Do not have an account? <a href="register.php">Sign up</a>.<br>-->

                    <input type="submit" class="button" id="login_btn" value="Login" name="submit">
                </form>
            </div>
            </center>
        </div>
    </div>


    <!-- For mobile -->
    <div class="row search-mobile">
        <div class="col-12 search-div"><br>
            <center>
            <h1 style="margin: 10px 0 15px 0">Admin Login</h1>
            
            <h4 style="margin: 10px 0 15px 0">Only Admin can check for suspicious contents. 
                <br>If you are not an admin then contact <a href="https://speechanalyst.com/contact/">here</a> to get the premium access.
                <br><br>
            </h4>

            <div style="width: 90%; display: inline-block;">
                <form action="login.php" method="post">
                    <span style="color: red"><?php echo $error; ?></span>

                    <div class="category"><i class="fa fa-envelope"></i> &nbspE-mail:</div>
                    <input type="email" class="text" placeholder="Enter your email" name="email" required value="<?php echo $email; ?>">

                    <div class="category"><i class="fa fa-lock"></i> &nbspPassword:</div>
                    <input type="password" class="text" placeholder="Enter password" name="password" required value="<?php echo $password; ?>">

                    <!--<br>Do not have an account? <a href="register.php">Sign up</a>.<br>-->

                    <input type="submit" class="button" id="login_btn" value="Login" name="submit">
                </form>
            </div>
            </center>
        </div>
    </div>


</body>
</html>