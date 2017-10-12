<?php
//include config
session_start();
require_once('includes/config.php');
//print_r($_SESSION);

$email = $_SESSION['email'];

$query = "SELECT name from users WHERE email = :email";
$statement3 = $db->prepare($query);
$statement3->bindValue(":email", $email);
$statement3->execute();
$name = $statement3->fetchColumn();
$statement3->closeCursor();


if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

function make_clickable($text) {
    $regex = '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#';
    return preg_replace_callback($regex, function ($matches) {
        return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";
    }, $text);
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Add Post</title>

        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/blog-post.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"></a>
                </div>
                <div class="collapse navbar-collapse" id="navbar1">
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (isset($_SESSION['id'])) { ?>
                            <li><p class="navbar-text">Signed in as <?php echo $_SESSION['email']; ?></p></li>
                            <li><p class="navbar-text"><img src="uploads/thumbs/<?php echo $_SESSION['id']; ?>.png" alt=""></p></li>
                            <li><a href="logout.php">Log Out</a></li>
                            <li><a href="memberPage.php">Members</a></li>

                        <?php } else { ?>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>

                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">

            <div class="row">

                <!-- Blog Post Content Column -->
                <div class="col-lg-8">

                    <!--                     Blog Post 
                    
                                         Title 
                                        <h1>Blog Post Title</h1>
                    
                                         Author 
                                        <p class="lead">
                                            by <a href="#">Start Bootstrap</a>
                                        </p>-->

                    <hr>

                    <!-- Date/Time -->
                    <p><span class="glyphicon glyphicon-time"></span></p>

                    <hr>

                    <!--                     Preview Image 
                                        <img class="img-responsive" src="http://placehold.it/900x300" alt="">-->

                    <hr>

                    <div id="wrapper">

                        <h2>Add Post</h2>

                        <?php
                        //if form has been submitted process it
                        if (isset($_POST['submit'])) {

//                                                        $authID = 'authID';
//                            
//                            $query = "SELECT name from users WHERE id = :authID";
//                            $statement3 = $db->prepare($query);
//                            $statement3->bindValue(":authID", $authID);
//                            $statement3->execute();
//                            $name = $statement3->fetchColumn();
//                            $statement3->closeCursor();
//                            $_POST = array_map('stripslashes', $_POST);
//                           
                            //collect form data
                            extract($_POST);
                            
//                            $query = "SELECT name from users WHERE email = :email";
//                            $statement3 = $db->prepare($query);
//                            $statement1->bindValue(':email', $email);
//                            $statement3->execute();
//                            $name = $statement3->fetchColumn();
//                            $statement3->closeCursor();

                            //very basic validation
                            if ($postTitle == '') {
                                $error[] = 'Please enter the title.';
                            }

                            if ($postDesc == '') {
                                $error[] = 'Please enter the description.';
                            }

                            if ($postCont == '') {
                                $error[] = 'Please enter the content.';
                            }
                            if ($tags == '') {
                                $error[] = 'Please enter the tag.';
                            }

                            if (!isset($error)) {

                                try {

                                    //insert into database
                                    $id = $_SESSION['id'];
                                    $stmt = $db->prepare('INSERT INTO blog_posts (postTitle,authID,name,postDesc,postCont,postDate,tags,commentsEnabled) VALUES (:postTitle, :id ,:name,:postDesc, :postCont, :postDate, :tags, :commentsEnabled)');
                                    $stmt->execute(array(
                                        ':postTitle' => $postTitle,
                                        ':id' => $id,
                                        ':name' => $name,
                                        ':postDesc' => $postDesc,
                                        ':postCont' => $postCont,
                                        ':postDate' => date('Y-m-d H:i:s'),
                                        ':tags' => $tags,
                                        ':commentsEnabled' => $commentsEnabled
                                    ));

                                    //redirect to index page
                                    header('Location: index.php?action=added');
                                    exit;
                                } catch (PDOException $e) {
                                    echo $e->getMessage();
                                }
                            }
                        }

                        //check for any errors
                        if (isset($error)) {
                            foreach ($error as $error) {
                                echo '<p class="error">' . $error . '</p>';
                            }
                        }
                        ?>
                        <div class="media">
                            <form action='' method='post'>

                                <p><label>Title</label><br />
                                    <input type='text' name='postTitle' value='<?php
                                    if (isset($error)) {
                                        echo $_POST['postTitle'];
                                    }
                                    ?>'></p>
                                


                                <p><label>Description</label><br />
                                    <textarea name='postDesc' cols='60' rows='10'><?php
                                        if (isset($error)) {
                                            echo $_POST['postDesc'];
                                        }
                                        ?></textarea></p>

                                <p><label>Content</label><br />
                                    <textarea name='postCont' cols='60' rows='10'><?php
                                        if (isset($error)) {
                                            echo $_POST['postCont'];
                                        }
                                        ?></textarea></p>

                                <p><label>Tags</label><br />
                                    <textarea name='tags' cols='10' rows='2'><?php
                                        if (isset($error)) {
                                            echo $_POST['tags'];
                                        }
                                        ?></textarea></p>




                                <!--               
                                                 <p><label>Comments</label><br />
                                                <textarea name='tags' cols='10' rows='2'><?php
                                if (isset($error)) {
                                    echo $_POST['commentsEnabled'];
                                }
                                ?></textarea></p>-->

                                <td><label>Comments enabled</label></td>  
                                <td><input type="radio" name="commentsEnabled" value="1" /> Yes</td>
                                <td><input type="radio" name="commentsEnabled" value="0" /> No</td>  
                                </tr>
                                <td><input type="hidden" name='authID' value="<?php $_SESSION['id']; ?>" /> </td> 
                                <td><input type="hidden" name='email' value="<?php $_SESSION['email']; ?>" /> </td> 
                                <p><input type='submit' name='submit' value='Submit'></p>

                            </form>
                        </div>

                    </div>
                    <!-- Blog Categories Well -->
                    <div class="well">
                        <h4>Blog Categories</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-unstyled">
                                    <li><a href="#">Category Name</a>
                                    </li>
                                    <li><a href="#">Category Name</a>
                                    </li>
                                    <li><a href="#">Category Name</a>
                                    </li>
                                    <li><a href="#">Category Name</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-unstyled">
                                    <li><a href="#">Category Name</a>
                                    </li>
                                    <li><a href="#">Category Name</a>
                                    </li>
                                    <li><a href="#">Category Name</a>
                                    </li>
                                    <li><a href="#">Category Name</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>

                    <!-- Side Widget Well -->
                    <div class="well">
                        <h4>Side Widget Well</h4>
                        <p></p>
                    </div>

                </div>

            </div>
            <!-- /.row -->

            <hr>

            <script src="js/jquery-1.10.2.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/jquery.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="js/bootstrap.min.js"></script>

