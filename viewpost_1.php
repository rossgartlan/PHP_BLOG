<?php
session_start();
require_once('includes/config.php');
require_once('Constants.php');
require_once('User.php');
require_once('Comments.php');
require_once('Blog.php');

//function addLikes($tot) {
//    $tot ++;
//    return false;
//}
//
//
//if (isset($_GET['hello'])) {
//    $run = addLikes($tot);
//}
//if (!$run) {
//    $stmt2 = $db->prepare('INSERT INTO comments(likes)VALUES(:tot) WHERE postID = :postID');
//    $stmt2->execute(array(':postID' => $_GET['id']));
//}

$stmt = $db->prepare('SELECT postID, postTitle, postCont, postDate ,tags FROM blog_posts WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetch();
//$stmt = $db->prepare('SELECT postID,authID, postTitle,postDesc, postCont, postDate ,tags, commentsEnabled FROM blog_posts WHERE postID = :postID');
//$stmt->execute(array(':postID' => $_GET['id']));
//$row = $stmt->fetchAll(PDO::FETCH_CLASS |PDO::FETCH_PROPS_LATE, "Blog",array('postID','authId','postTitle','postDesc','postCount','postDate','tags','commentsEnabled'));

$poster = $_SESSION['id'];

$queryPoster = 'SELECT name FROM users WHERE id = :poster';
$statement1 = $db->prepare($queryPoster);
$statement1->bindValue(':poster', $poster);
$statement1->execute();
$name = $statement1->fetchColumn();
$statement1->closeCursor();

//$stmt3 = $db->prepare('Select comment,date,likes FROM comments WHERE postID = :postID');
//$stmt3->execute(array(':postID' => $_GET['id']));
//$comments = $stmt3->fetchAll();
$stmt3 = $db->prepare('Select comment,date,likes FROM comments WHERE postID = :postID');
$stmt3->execute(array(':postID' => $_GET['id']));
$comments = $stmt3->fetchAll(PDO::FETCH_CLASS |PDO::FETCH_PROPS_LATE, "Comments",array('postID','posterID','authID','postTitle','postDesc','postCont','postDate','tags','commentsEnabled'));



//$query = 'Select comment,date,likes FROM comments WHERE postID = :postID';
//$statement2 = $db->prepare($query);
//$statement2->bindValue(':postID', $postID);
//$statement2->execute();
//$comments = $statement2->fetchAll();
//$statement2->closeCursor();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Blog - <?php echo $row['postTitle']; ?></title>
        <link rel="stylesheet" href="style/main.css">
        <link href="css/blog-post.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
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
                            <li><a href="logout.php"></a></li>
                            <li><a href="memberPage.php">Members</a></li>
<?php } ?>
                  </ul>
                </div>
            </div>
        </nav>

        <div id="wrapper">

            <!--            <h1>Blog</h1>-->
            <hr />
<!--            <p><a href="./">Blog Index</a></p>-->
            <p class="navbar-text"><img src="uploads/thumbs/<?php echo $row->getAuthid(); ?>.png" alt=""></p>
            <?php
            echo '<div>';

            echo '<h1>' . $row['postTitle'] . '</h1>';
            echo '<p>Posted on ' . date('jS M Y', strtotime($row['postDate'])) . '</p>';
            echo '<p>' . $row['postCont'] . '</p>';

            echo '</div>';
            ?>
            <!-- Comment -->
            <?php foreach ($comments as $comment) : ?>
                <a class="pull-left" href="#">
    <!--                            <img class="media-object" src="http://placehold.it/64x64" alt="">-->
                </a>
                <div class="media-body">
                    <h4 class="media-heading">
                        <small><?php echo $comment->getComment(); ?></small>
                        
                        <small><?php echo $name; ?></small>
                        <small><?php echo $comment->getDate(); ?></small>
                        <button id="target" type="button"><img src ="images/like.png"alt="thumbs" width="15" height = 15></button>
                        <div id="output"><?php
    echo $comment->getLikes();
    $tot = $comment->getLikes();
    ?></div>

                         




                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>




    </div>



    <!--                                <form action ="delete_post.php" method="POST">
                                       
                                        <input type="hidden" name="postID" value="<?php echo($post["postID"]); ?>"/>
                                        <input type="hidden" name="postTitle" value="<?php echo($post["postTitle"]); ?>"/>
                                        <input type="submit" value="Delete" button class="myButton"/>
                                    </form>-->



    <!-- Blog Comments -->

    <!-- Comments Form -->
    <div class="well">

        <h4>Leave a Comment:</h4>
        <form role="form" action="insert_comment.php" method="POST">
            <div class="form-group">
                <textarea class="form-control" name="postcomments" rows="3"></textarea>

                <input type="hidden" name="postid" value="<?php echo ($row["postID"]); ?>" />
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
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

</body>
</html>