<?php
session_start();
require_once('includes/config.php');
require_once('Constants.php');
require_once('User.php');
require_once('Comments.php');
require_once('Blog.php');


//$poster = $_SESSION['id'];

//$queryPoster = 'SELECT name FROM users WHERE id = :poster';
//$statement1 = $db->prepare($queryPoster);
//$statement1->bindValue(':poster', $poster);
//$statement1->execute();
//$name = $statement1->fetchColumn();
//$statement1->closeCursor();


$stmt2 = $db->prepare('SELECT postID,authID,name, postTitle,postDesc, postCont, postDate ,tags, commentsEnabled FROM blog_posts WHERE postID = :postID');
$stmt2->execute(array(':postID' => $_GET['id']));
$row1 = $stmt2->fetch();

$stmt = $db->prepare('SELECT postID,authID,name, postTitle,postDesc, postCont, postDate ,tags, commentsEnabled FROM blog_posts WHERE postID = :postID');
$stmt->execute(array(':postID' => $_GET['id']));
$row = $stmt->fetchAll(PDO::FETCH_CLASS |PDO::FETCH_PROPS_LATE, "Blog",array('postID','authId','name','postTitle','postDesc','postCount','postDate','tags','commentsEnabled'));

//print_r($row);

foreach ($row as $ro) :
$idperson = $ro->getAuthid();
endforeach;

//$queryName = 'SELECT name FROM users WHERE id = :idperson';
//$statement2 = $db->prepare($queryName);
//$statement2->bindValue(':idperson', $idperson);
//$statement2->execute();
//$name = $statement2->fetchColumn();
//$statement2->closeCursor();
//
//echo $name;

$stmt3 = $db->prepare('Select * FROM comments WHERE postID = :postID');
$stmt3->execute(array(':postID' => $_GET['id']));
$comments = $stmt3->fetchAll(PDO::FETCH_CLASS |PDO::FETCH_PROPS_LATE, "Comments",array('postID','posterID','commentID','comment','date','likes'));

$stmt2 = $db->prepare('Select * FROM comments WHERE postID = :postID');
$stmt2->execute(array(':postID' => $_GET['id']));
$row2 = $stmt2->fetch();

//print_r($comments);
foreach ($row as $ro) :
$blogtext = $ro->getPostCont();
endforeach;

$url = '!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i';
$blogtext = preg_replace($url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $blogtext);



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
        <script src="js/ajax_categories.js" type="text/javascript"></script>
        <script src="jquery/jquery-1.11.2.js" type="text/javascript"></script>
        <script src="jquery/new.js" type="text/javascript"></script>
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
                            <li><p class="navbar-text"><img src="uploads/thumbs/<?php echo $_SESSION['id']; ?>.png" height ="100" width ="150" alt=""></p></li>
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
            <p class="navbar-text"><img src="uploads/thumbs/<?php echo $row1['authID']; ?>.png" alt=""></p>
<?php

//echo '<div>';
//
//
//echo '<h1>' . $row['postTitle'] . '</h1>';
//echo '<p>Posted on ' . $row['postDate'] . '</p>';
//echo '<p>By ' . $name . '</p>';
//echo '<p>' . $blogtext . '</p>';
//echo '<p>Tags are ' . $row['tags'] . '</p>';
$tags = $row1['tags'];
$parts = explode(" ", $tags);
$commas=  implode(',', (array) $parts);
                            
//?>
                  
 <h1> <?php foreach ($row as $ro) : echo $ro->getPostTitle()?><?php endforeach; ?></h1>
 <p> <?php foreach ($row as $ro) : echo $ro->getPostDate()?><?php endforeach; ?><p>
 <p>By <?php foreach ($row as $ro) : echo $ro->getName()?><?php endforeach; ?><p>
 <?php echo '<p>' . $blogtext . '</p>';?>
 <p>Tags are <?php foreach ($row as $ro) : echo $commas ?><?php endforeach; ?><p>
   
</h1>
            <!-- Comment -->





<?php foreach ($comments as $comment) : ?>
                <a class="pull-left" href="#">
    <!--                            <img class="media-object" src="http://placehold.it/64x64" alt="">-->
                </a>
                <div class="media-body">
                    <h4 class="media-heading">
                        <img src="uploads/thumbs/<?php echo $comment->getPosterID(); ?>.png" height="26" width = "30"alt="">
                        <small><?php echo $comment->getComment(); ?></small>
                        
<!--                        <small><?php echo $name; ?></small>-->
                        <small><?php echo $comment->getDate(); ?></small>
                     <small>   <input type="hidden" name="count" value="<?php echo ($comment->getPosterID()); ?>" /></small>
                        
              <form action="likeUpdate.php" method="post">
    <input type="hidden" name="postID" value="<?php echo ($comment->getPostID()); ?>" />
    <input type="hidden" name="comid" value="<?php echo ($comment->getCommentID()); ?>" />
    <input type="hidden" name="count" value="<?php echo ($comment->getLikes()); ?>" /><small>
        
        <button id="target" type="submit"><img src ="images/like.png"alt="thumbs" width="15" height = 15></button>
    
                            </form>
                      
                        <div id="output"><?php
    echo $comment->getLikes();
    $tot = $comment;
    ?></div>
                    </h4>
                    
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

<!-- Comments Form -->
<?php
if ($row1["commentsEnabled"] == COMMENTS_ENABLED) {
    ?> 
    <div class="well">

        <h4>Leave a Comment:</h4>

        <!--        <div class="form-group">
                    <label for="name">Confirm Password</label>
                    <input type="password" name="cpassword" placeholder="Confirm Password" required class="form-control" />
                    <span class="text-danger"><?php if (isset($cpassword_error)) echo htmlspecialchars($cpassword_error, ENT_QUOTES); ?></span>
                </div>-->
        <form role="form" action="insert_comment.php" method="POST">
            <div class="form-group">
                <textarea class="form-control" name="postcomments" rows="3"></textarea>
                <span class="text-danger"><?php if (isset($error_message)) echo htmlspecialchars($error_message, ENT_QUOTES); ?></span>
                <input type="hidden" name="postid" value="<?php echo ($row1["postID"]); ?>" />
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    </div>    

    <?php
    ;
}
?>

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