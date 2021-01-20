<!-- James Salverda
     November 26, 2019
     Final Project
     allows an signed in user to comment on a new post. -->

<?php
    require 'connect.php';
    
    session_start();

    $id = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_NUMBER_INT);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    if (strlen($_POST['comment']) > 0) {
        $query = "INSERT INTO comments (comment, createdBy, postID) VALUES (:comment, :createdBy, :postID)";

        $statement = $db->prepare($query);
        $statement->bindValue(':comment', $comment);
        $statement->bindValue(':createdBy', $_SESSION['username']);
        $statement->bindValue(':postID', $id);
        $statement->execute();
        header("Location: blog.php");
        exit();
    }

   

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CacheGrab</title>
    <link rel="stylesheet" type="text/css" href="finalcss.css" />
</head>
<body>

    <header>
        <div id="SuperTitle">
            <h1>Super Powered Battle Friends</h1>
        </div>
        <div id="searchBar">
            <form action="searchHomePage.php" method="post">
                <input type="text" name="search" placeholder="Search for Updates...">
                <input type="submit" value="Go">
            </form>
        </div>
        <nav>
            <a href="homePage.php">Home</a>
            <a href="characterPage.php">Characters</a>
            <a href="stagePage.php">Stages</a>
            <a href="aboutUsPage.php">About Us</a>
            <a href="blog.php">Blog</a>
        </nav>
    </header>

    <div id="New">
        <form method="post" action="newComment.php?postID=<?=$id?>">
            <label>Post</label><br>
            <textarea rows="25" cols="100" name="comment" id="comment"></textarea><br>
            <button type="submit">Add</button><br>
        </form>
    </div>

</body>
</html>