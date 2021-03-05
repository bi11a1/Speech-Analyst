<?php
    include 'header.php';
    include 'android/db/db_connect.php';
    include 'android/functions.php';

    session_start();
    $_SESSION['access'] = 'none';

    $name = $email = $password = $confirm_password = "";
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        }
        else{
            $error = "* Enter name";
        }

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

        if (isset($_POST['confirm_password'])) {
            $confirm_password = $_POST['confirm_password'];
        }
        else{
            $error = "* Confirm password";
        }

        if($error == "" && !(filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $error = "* Invalid email format";
        }
        if($error == "" && $password != $confirm_password){
            $error = "* Password does not match";
        }

        if($error == ""){
            //Check if the email already exist
            if(!emailExists($email)){
         
                //Get a unique Salt
                $salt = getSalt();
                
                //Generate a unique password Hash
                $passwordHash = password_hash(concatPasswordWithSalt($password, $salt), PASSWORD_DEFAULT);
                
                //Query to register new user
                $insertQuery  = "INSERT INTO user(email, name, password_hash, salt) VALUES (?,?,?,?)";
                if($stmt = $con->prepare($insertQuery)){
                    $stmt->bind_param("ssss", $email, $name, $passwordHash, $salt);
                    $stmt->execute();
                    $stmt->close();
                    header("Location: login.php");
                }
            }
            else{
                $error = "* Email is in use";
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
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
        <div class="col-8 search-div" style="background-image: linear-gradient(to bottom right, #eafaff, #ffffff);"><br>
            <center>
            <h1 style="margin: 10px 0 15px 0">User Registration</h1>

            <div style="width: 65%; display: inline-block;">
                <form action="register.php" method="post">
                    <span style="color: red"><?php echo $error; ?></span>

                    <div class="category"><i class="fa fa-user"></i> &nbspName:</div>
                    <input type="text" class="text" placeholder="Enter your name" name="name" required value="<?php echo $name; ?>">

                    <div class="category"><i class="fa fa-envelope"></i> &nbspE-mail:</div>
                    <input type="email" class="text" placeholder="Enter your email" name="email" required value="<?php echo $email; ?>">

                    <div class="category"><i class="fa fa-lock"></i> &nbspPassword:</div>
                    <input type="password" class="text" placeholder="Enter password" name="password" required value="<?php echo $password; ?>">

                    <div class="category"><i class="fa fa-lock"></i> &nbspConfirm-Password:</div>
                    <input type="password" class="text" placeholder="Confirm password" name="confirm_password" required value="<?php echo $confirm_password; ?>">

                    <br>Already have an account? <a href="login.php">Sign in</a>.<br>

                    <input type="submit" class="button" id="reg_btn" value="Register" name="submit">
                </form>
            </div>
            </center>
        </div>

        <div class="col-1 space">&nbsp</div>
    </div>

    <!-- For laptop -->
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
            <h1 style="margin: 10px 0 15px 0">User Registration</h1>

            <div style="width: 80%; display: inline-block;">
                <form action="register.php" method="post">
                    <span style="color: red"><?php echo $error; ?></span>

                    <div class="category"><i class="fa fa-user"></i> &nbspName:</div>
                    <input type="text" class="text" placeholder="Enter your name" name="name" required value="<?php echo $name; ?>">

                    <div class="category"><i class="fa fa-envelope"></i> &nbspE-mail:</div>
                    <input type="email" class="text" placeholder="Enter your email" name="email" required value="<?php echo $email; ?>">

                    <div class="category"><i class="fa fa-lock"></i> &nbspPassword:</div>
                    <input type="password" class="text" placeholder="Enter password" name="password" required value="<?php echo $password; ?>">

                    <div class="category"><i class="fa fa-lock"></i> &nbspConfirm-Password:</div>
                    <input type="password" class="text" placeholder="Confirm password" name="confirm_password" required value="<?php echo $confirm_password; ?>">

                    <br>Already have an account? <a href="login.php">Sign in</a>.<br>

                    <input type="submit" class="button" id="reg_btn" value="Register" name="submit">
                </form>
            </div>
            </center>
        </div>
    </div>

    <!-- For ipad -->
    <div class="row search-ipad">
        <div class="col-12 search-div"><br>
            <center>
            <h2 style="margin: 10px 0 15px 0">User Registration</h2>

            <div style="width: 90%; display: inline-block;">
                <form action="register.php" method="post">
                    <span style="color: red"><?php echo $error; ?></span>

                    <div class="category"><i class="fa fa-user"></i> &nbspName:</div>
                    <input type="text" class="text" placeholder="Enter your name" name="name" required value="<?php echo $name; ?>">

                    <div class="category"><i class="fa fa-envelope"></i> &nbspE-mail:</div>
                    <input type="email" class="text" placeholder="Enter your email" name="email" required value="<?php echo $email; ?>">

                    <div class="category"><i class="fa fa-lock"></i> &nbspPassword:</div>
                    <input type="password" class="text" placeholder="Enter password" name="password" required value="<?php echo $password; ?>">

                    <div class="category"><i class="fa fa-lock"></i> &nbspConfirm-Password:</div>
                    <input type="password" class="text" placeholder="Confirm password" name="confirm_password" required value="<?php echo $confirm_password; ?>">

                    <br>Already have an account? <a href="login.php">Sign in</a>.<br>

                    <input type="submit" class="button" id="reg_btn" value="Register" name="submit">
                </form>
            </div>
            </center>
        </div>
    </div>

    <!-- For mobile -->
    <div class="row search-mobile">
        <div class="col-12 search-div"><br>
            <center>
            <h3 style="margin: 10px 0 15px 0">User Registration</h3>

            <div style="width: 90%; display: inline-block;">
                <form action="register.php" method="post">
                    <span style="color: red"><?php echo $error; ?></span>

                    <div class="category"><i class="fa fa-user"></i> &nbspName:</div>
                    <input type="text" class="text" placeholder="Enter your name" name="name" required value="<?php echo $name; ?>">

                    <div class="category"><i class="fa fa-envelope"></i> &nbspE-mail:</div>
                    <input type="email" class="text" placeholder="Enter your email" name="email" required value="<?php echo $email; ?>">

                    <div class="category"><i class="fa fa-lock"></i> &nbspPassword:</div>
                    <input type="password" class="text" placeholder="Enter password" name="password" required value="<?php echo $password; ?>">

                    <div class="category"><i class="fa fa-lock"></i> &nbspConfirm-Password:</div>
                    <input type="password" class="text" placeholder="Confirm password" name="confirm_password" required value="<?php echo $confirm_password; ?>">

                    <br>Already have an account? <a href="login.php">Sign in</a>.<br>

                    <input type="submit" class="button" id="reg_btn" value="Register" name="submit">
                </form>
            </div>
            </center>
        </div>
    </div>



</body>
</html>