<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Our Blog</title>
        <link rel ="stylesheet" type ="text/css" href="css/common.css"/>
    </head>
    <body>
        <main>
        <header><h1>Our Blog</h1></header>
        <h1>Database error</h1>
        <p>there was an error connecting to the database, check that the database is installed and named correctly</p>
        <p> Error message: <?php echo $error_message; ?></p>
        </main>
    
    </body>
    <footer><?php require_once("includes/footer.php"); ?></footer>
    
</html>