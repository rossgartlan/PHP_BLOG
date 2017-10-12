<?php
session_start();
require_once 'includes/database.php';
require_once 'Blog.php';
//echo $_SESSION['name'];
//print_r($_SESSION);
$stmt = $db->prepare('SELECT * from blog_posts');
$stmt->execute(array());
$row = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Blog", array('postID', 'authId', 'name', 'postTitle', 'postDesc', 'postCount', 'postDate', 'tags', 'commentsEnabled'));

if (isset($_POST['submit'])) {

    $tags = filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING);
    $keywords = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $date1 = filter_input(INPUT_POST, 'range1');
    $date2 = filter_input(INPUT_POST, 'range2');

    if ($_POST['username']) {
        $query = 'SELECT * from blog_posts';
        $statement1 = $db->prepare($query);
        $statement1->execute();
        $row1 = $statement1->fetchAll();
        $statement1->closeCursor();

        $filterBy = $name; // or Finance etc.

        $new = array_filter($row1, function ($var) use ($filterBy) {
            return ($var['name'] == $filterBy);
        });
    }

    if ($_POST['tags']) {

        $query = "SELECT * FROM blog_posts WHERE tags like '%" . $tags . "%'";
        $statement2 = $db->prepare($query);
        $statement2->bindValue(':tags', $tags);
        $statement2->execute();
        $name = $statement2->fetchAll();
        $statement2->closeCursor();

        $filterBy = $tags;

        $new = array_filter($name, function ($var) use ($filterBy) {
            return ($var['tags'] == $filterBy);
        });
    }

//    print_r($new);
//if (isset($_POST['submit'])) {
//
//    $tags = filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING);
//    $keywords = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_STRING);
//    $fields = array($tags, $keywords);
//    
//    foreach ($row as $ro) : echo $ro->getPostTitle()
//
//   // $sql = " SELECT * FROM users WHERE fname like '%" . $name . "%' AND user_email LIKE '%" . $email . "%'";
//    $query = "SELECT * FROM blog_posts WHERE tags like '%" . $tags . "%' and postCont like '%" . $keywords . "%'";
//    $statement1 = $db->prepare($query);
//    $statement1->bindValue(':tags', $tags);
//    $statement1->bindValue(':keywords', $keywords);
//    $statement1->execute();
//    $name = $statement1->fetchAll();
//    $statement1->closeCursor();
//    print_r($name);
//}
//}
}
//
?>
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
                    <a class="navbar-brand" href="index.php">New Music Blog</a>
                </div>
                <div class="collapse navbar-collapse" id="navbar1">
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (isset($_SESSION['id'])) { ?>
                            <li><p class="navbar-text">Signed in as <?php echo $_SESSION['email']; ?></p></li>
                            <li><p class="navbar-text"><img src="uploads/thumbs/<?php echo $_SESSION['id']; ?>.png" height="70" width="100"alt=""></p></li>
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

                    <hr>

                    <!-- Date/Time -->
                    <p><span class="glyphicon glyphicon-time"></span></p>

                    <hr>

                    <!--                     Preview Image 
                                        <img class="img-responsive" src="http://placehold.it/900x300" alt="">-->

                    <hr>
                   
<!--//                    '<p><a href="viewpost.php?id=' . $row['postID'] . '">Read More</a></p>';-->
                    <h1><?php foreach ($new as $ne) : echo $ne['postTitle']?><?php endforeach; ?></h1>
                    <p> by <?php foreach ($new as $ne) : echo $ne['name'] ?><?php endforeach; ?><p>
                    <p> <?php foreach ($new as $ne) : echo $ne['postDesc'] ?><?php endforeach; ?><p>
                    <p><?php foreach ($new as $ne) : echo $ne['postCont']?><?php endforeach; ?><p>
             

                <hr>

                <!-- Blog Comments -->



                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <small></small>
                        </h4>

                    </div>
                </div>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">
                        </h4>

                        <!-- Nested Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <small></small>
                                </h4>

                            </div>
                        </div>
                        <!-- End Nested Comment -->
                    </div>
                </div>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <div class="input-group">


                        <table>                    
                            <form action="searchResults.php" method="post">
                                <tr>
                                    <td>Username:</td>
                                    <td><input type="text" name="username" /></td>
                                </tr>
                                <tr>
                                    <td>Start Date:</td>
                                    <td><input type="text" name="range1" placeholder="yyyy-mm-dd" /></td>
                                </tr>
                                <tr>
                                    <td>End Date:</td>
                                    <td><input type="text" name="range2" placeholder="yyyy-mm-dd" /></td>
                                </tr>
                                <tr>
                                    <td>Tags:</td>
                                    <td><input type="text" name="tags" /></td>
                                </tr>
                                <tr>
                                    <td>Keywords:</td>
                                    <td><input type="text" name="keywords" /></td>
                                </tr>

                                <td><input type="submit" name="submit" value="Search" /></td>
                                </tr>
                            </form>
                        </table>

                    </div>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Rock</a>
                                </li>
                                <li><a href="#">Dance</a>
                                </li>
                                <li><a href="#">Pop</a>
                                </li>
                                <li><a href="#">R&B</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="#">Blues</a>
                                </li>
                                <li><a href="#">Metal</a>
                                </li>
                                <li><a href="#">Electro</a>
                                </li>
                                <li><a href="#">Classical</a>
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
    </body>










    <footer><?php require_once("includes/footer.php"); ?></footer>

</html>