<?php
require_once 'includes/database.php';
require_once 'functions.php';
require_once 'User.php';
require_once 'Constants.php';
session_start();
include_once 'securimage/securimage.php';
$securimage = new Securimage();


if (isset($_SESSION['usr_id'])) {
    header("Location: index.php");
}



//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_POST['signup'])) {


    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $cpassword = filter_input(INPUT_POST, 'cpassword', FILTER_SANITIZE_STRING);
    //$avatar = filter_input(INPUT_POST, 'avatar');

    $query = "SELECT name FROM users WHERE name=:username";
    $statement2 = $db->prepare($query);
    //   $statement2 ->setFetchMode(PDO::FETCH_PROPS_LATE, 'User');
    $statement2->bindValue(":username", $username);
    $statement2->execute();
    $totalUsers = $statement2->fetch();
    $statement2->closeCursor();

    $query = "SELECT email FROM users WHERE email=:email";
    $statement1 = $db->prepare($query);
    $statement1->bindValue(":email", $email);
    $statement1->execute();
    $totalEmail = $statement1->fetch();
    $statement1->closeCursor();

    print_r($totalUsers);
    echo $totalUsers["name"];
    if ($totalUsers["name"] == $username) {
        $error = true;
        $nameError = "Provided Username is already in use.";
    }
    echo $totalEmail["email"];
    if ($totalEmail["email"] == $email) {
        $error = true;
        $emailError1 = "Provided Email is already in use.";
    }




    include_once 'securimage/securimage.php';

    $securimage = new Securimage();

    if ($securimage->check($_POST['captcha_code']) == false) {
        // the code was incorrect
        // you should handle the error so that the form processor doesn't continue
        // or you can use the following code if there is no validation or you do not know how
        echo "The security code entered was incorrect.<br /><br />";
        echo "Please go <a href='javascript:history.go(-1)'>back</a> and try again.";
        exit;
    }
//    print_r("<pre>");
//print_r($totalEmail );  //for trouble shooting showing results are correct
//print_r("<pre>");




    $p1 = '/[A-Z]/'; //Uppercase
    $p2 = '/[a-z]/'; //Lowercase
    $p3 = '/[0-9]/'; //Numbers
    $p4 = '/!#$%^&*{}()<.>]/'; //Special Characters

    if (!preg_match('/[a-zA-Z0-9]/', $username)) {
        $error = true;
        $name_error = "Name must contain numbers and letters";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $email_error = "Please Enter Valid Email ID";
    }
    if (strlen($password) < PASSWORD_LENGTH) {
        $error = true;
        $password_error = "Password must be minimum of 6 characters";
    }
    if ($password != $cpassword) {
        $error = true;
        $cpassword_error = "Passwords Do not Match";
    }
//Check password has uppercase
    if (!preg_match($p1, $password)) {
        $error = true;
        $password_error = "Password must be minimum of 6 characters with Uppercase,lowercase,numbers and symbols";
    }
//Check password has lowercase
    if (!preg_match($p2, $password)) {
        $error = true;
        $password_error = "Password must be minimum of 6 characters with Uppercase,lowercase,numbers and symbols";
    }
//Check password has numbers
    if (!preg_match($p3, $password)) {
        $error = true;
        $password_error = "Password must be minimum of 6 characters with Uppercase,lowercase,numbers and symbols";
    }
//Check password has symbols
//    if (!preg_match($p4, $password)) {
//        $error = true;
//        $password_error = "Password must be minimum of 6 characters with Uppercase,lowercase,numbers and symbols";
//    }
    if (!$error) {


//Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $usertype = 1;
//Create the SQL insert statement
        $query = "INSERT INTO users (name, email, password, usertype) VALUES (:name, :email, :password,:usertype)";

//Use PDO to sanatise the input
        $statement = $db->prepare($query);

//Bind the variable to the placeholders in the query
        $statement->bindValue(':name', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $hashed_password);
        $statement->bindValue(':usertype', $usertype);
//Add the user to the database
        $statement->execute();

        $successmsg = "Thank you for registering";
        header("Location: avatar.php");
//   $statement->closeCurser();
    } else {
        $errormsg = "Error in registering...Email or Username allready in use or not a valid email entered  !";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Registration Script</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" >
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/common.css" rel="stylesheet" type="text/css"/>
        <link href="css/mainpage.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>

    <body>



        <nav>
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php">Our Blog inc</a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar1">
                        <ul class="nav navbar-nav navbar-right">
                            <?php if (isset($_SESSION['id'])) { ?>
                                <li><p class="navbar-text">Signed in as <?php echo $_SESSION['email']; ?></p></li>
                                <li><a href="logout.php">Log Out</a></li>
                                <li><a href="memberPage.php">Members</a></li>
                            <?php } else { ?>
                                <li><a href="login.php">Login</a></li>
                                <li><a href="register.php">Sign Up</a></li>
                                <li><a href="index.php">Home</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </nav>


        <main>


        </nav>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 well">
                    <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
                        <fieldset>
                            <legend>Sign Up</legend>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" placeholder="Enter Full Name" required value="<?php if ($error) echo $username; ?>" class="form-control" />
                                <span class="text-danger"><?php if (isset($name_error)) echo htmlspecialchars($name_error, ENT_QUOTES); ?></span>
                            </div>

                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="text" name="email" placeholder="Email" required value="<?php if ($error) echo $email; ?>" class="form-control" />
                                <span class="text-danger"><?php if (isset($email_error)) echo htmlspecialchars($email_error, ENT_QUOTES); ?></span><span class="text-danger">
                                    <span class="text-danger"><?php if (isset($email_error1)) echo htmlspecialchars($email_error1, ENT_QUOTES); ?></span><span class="text-danger">
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Password</label>
                                            <input type="password" name="password" placeholder="Password" required class="form-control" />
                                            <span class="text-danger"><?php if (isset($password_error)) echo htmlspecialchars($password_error, ENT_QUOTES); ?></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Confirm Password</label>
                                            <input type="password" name="cpassword" placeholder="Confirm Password" required class="form-control" />
                                            <span class="text-danger"><?php if (isset($cpassword_error)) echo htmlspecialchars($cpassword_error, ENT_QUOTES); ?></span>
                                        </div>

                                        <div class="form-group">
                                            
                                            <div class="form-group">
                                                
                                                <br>
                                                <br>
                                                <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
                                            </div>
                                        </div>

                                        <br>
                                        <div class="form-group">
                                            <a href="register.php"></a>
                                            <input type="text" name="captcha_code" size="10" maxlength="6" />
                                            <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="signup" value="Sign Up" class="btn btn-primary" />
                                        </div>
                                        </fieldset>
                                        </form>
                                        <span class="text-success"><?php
                                            if (isset($successmsg)) {
                                                echo $successmsg;
                                            }
                                            ?></span>
                                        <span class="text-danger"><?php
                                            if (isset($errormsg)) {
                                                echo $errormsg;
                                            }
                                            ?></span>
                                        </div>
                                        </div>
                                        <div class="messages"><?php echo $message; ?></div>
                                        
                                        <?php if ($thumb_src != '') { ?>
                                            <div class="gallery">
                                                <ul>
                                                    <li><img src="<?php echo $thumb_src; ?>" alt=""></li>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                        <div class="row">
                                            <div class="col-md-4 col-md-offset-4 text-center">	
                                                Already Registered? <a href="login.php">Login Here</a>
                                            </div>
                                        </div>
                                        </div>
                                        <script src="js/jquery-1.10.2.js"></script>
                                        <script src="js/bootstrap.min.js"></script>
                                        </body>
                                        </html>






                                        </body>
                                        <footer><?php require_once("includes/footer.php"); ?></footer>
                                        </html>
