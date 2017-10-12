<?php
session_start();
require_once 'includes/database.php';
require_once 'Blog.php';
//echo $_SESSION['name'];
//print_r($_SESSION);








//$fields = array($tags, $keywords,$name );
////    print_r($fields);
//    
//    $inputParameters = array();
//
//    foreach ($fields as $field) {
//        // don't forget to validate the fields values from $_POST
//        if (!empty($_POST[$field])) {
//            $inputParameters[$field] = '%' . $_POST[$field] . '%';
//        }
//    }
//
//    $where = implode(' OR ', array_map(function($item) {
//                return "'$item' LIKE :$item";
//            }, array_keys($inputParameters)));
//
//    $search = $db->prepare("SELECT * FROM blog_posts WHERE $where");
//    $search->execute($inputParameters);
//
//    foreach ($search->fetchAll(PDO::FETCH_ASSOC) as $row) {
//        var_dump($row);
//    }
//select * from blog_posts where name= 'Gerry Smith' UNION select * from blog_posts where tags like '%gig%' UNION select * from blog_posts where postDesc like '%Lorem%' UNION SELECT * FROM blog_posts WHERE postDate >= '2017-04-29' AND postDate <= '2017-04-29' 
// $sql = " SELECT * FROM users WHERE fname like '%" . $name . "%' AND user_email LIKE '%" . $email . "%'";
//    $query = "SELECT tags,postCont FROM blog_posts WHERE tags like '%" . $tags . "%' and postCont like '%" . $keywords . "%' and name like '%" . $name . "%'";
//    $statement1 = $db->prepare($query);
//    $statement1->bindValue(':tags', $tags);
//    $statement1->bindValue(':keywords', $keywords);
//    $statement1->bindValue(':name', $name);
//    $statement1->execute();
//    $name = $statement1->fetchAll();
//    $statement1->closeCursor();


    $stmt = $db->prepare('SELECT * from blog_posts');
    $stmt->execute(array());
    $row = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Blog", array('postID', 'authId', 'name', 'postTitle', 'postDesc', 'postCount', 'postDate', 'tags', 'commentsEnabled'));

//print_r($row);
//foreach ($row as $ro) : echo $ro->getName($name)
//
    ?><?php
//endforeach;
    
//    $nResults = filter_by_value($row, 'name', $name); 
//    
//    function filter_by_value ($array, $index, $name){ 
//        if(is_array($array) && count($array)>0)  
//        { 
//            foreach(array_keys($array) as $key){ 
//                $temp[$key] = $array[$key][$index]; 
//                 
//                if ($temp[$key] == $name){ 
//                    $newarray[$key] = $array[$key]; 
//                } 
//            } 
//          } 
//      return $newarray; 
//    } 
//    
//    print_r($nResults);
    
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
    <?php
    try {
        
        $stmt = $db->query('SELECT postID,name, postTitle, postDesc, postDate, tags FROM blog_posts ORDER BY postID DESC');
        while ($row = $stmt->fetch()) {

            echo '<div>';

            echo '<h1><a href="viewpost.php?id=' . $row['postID'];
            echo '<h1><a href="viewpost.php?id=' . $row['postID'] . '">' . $row['postTitle'] . '</a></h1>';
            echo '<p>Posted on ' . date('jS M Y H:i:s', strtotime($row['postDate'])) . '</p>';
            echo '<p>By ' . $row['name'] . '</p>';
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