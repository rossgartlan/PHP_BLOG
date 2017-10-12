<?php

session_start();
//echo $_SESSION['id'];
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit(); 
}


require_once 'includes/database.php';





?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home | Our Blog</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" >
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Blog Post - Start Bootstrap Template</title>

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/blog-post.css" rel="stylesheet">
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
                    <a class="navbar-brand" href="index.php">Our Blog inc</a>
                </div>
                <div class="collapse navbar-collapse" id="navbar1">
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (isset($_SESSION['id'])) { ?>
                            <li><a href="add-post.php">Add Post</a></li>
                            <li><p class="navbar-text">Signed in as <?php echo $_SESSION['email']; ?></p></li>
                            <li><p class="navbar-text"><img src="uploads/thumbs/<?php echo $_SESSION['id']; ?>.png" height="100" width ="150" alt=""></p></li>
                            <li><a href="logout.php">Log Out</a></li>
                        <?php } else { ?>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Sign Up</a></li>
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

                   
                    <!-- Date/Time -->
                    <h1> <a><span class="glyphicon glyphicon-time">   Latest Posts</span></a></h1>

                    

                   

                    <hr>
                    <?php
                    try {

                        $stmt = $db->query('SELECT postID,authID, postTitle, postDesc, postDate, tags FROM blog_posts ORDER BY postID DESC');
                        
                        while ($row = $stmt->fetch()) {

                            echo '<div>';
                            echo '<h1><a href="viewpost.php?id=' . $row['postID'] . '">' . $row['postTitle'] . '</a></h1>';
                            echo '<p>Posted on ' . date('jS M Y H:i:s', strtotime($row['postDate'])) . '</p>';
                            echo '<p>' . $row['postDesc'] . '</p>';
                            echo '<p><a href="viewpost.php?id=' . $row['postID'] . '">Read More</a></p>';
                            echo '</div>';
//                    echo '<p>' . $row['tags'] . '</p>';
//                    echo '</div>';
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
                    

            <hr>

            <script src="js/jquery-1.10.2.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/jquery.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="js/bootstrap.min.js"></script>
    </body>
</html>









<footer><?php require_once("includes/footer.php"); ?></footer>

</html>