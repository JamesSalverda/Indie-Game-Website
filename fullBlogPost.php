<!-- James Salverda
     November 19, 2019
     Final Project
     shows the full blog post -->

<?php
    require 'connect.php';
    session_start();

    $id = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_NUMBER_INT);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
    $query = "SELECT * FROM blog WHERE postID = :postID";
    
    $statement = $db->prepare($query);
    $statement->bindValue(':postID', $id, PDO::PARAM_INT);
    $statement->execute(); 

    $blog = $statement->fetch();

    if($statement != null){
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $titles = $row['title'];
            $contents = $row['content'];
            $ids = $row['postID'];
        }         
    }

    $createdBy = filter_input(INPUT_POST, 'createdBy', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $postId = filter_input(INPUT_POST, 'postID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $commentQuery = "SELECT * FROM comments WHERE postId = :postID";
    $commentStatement = $db->prepare($commentQuery);
    $commentStatement->bindValue(':postID', $blog['postID']);
    $commentStatement->execute();
    
    
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
        <nav>
            <a href="homePage.php">Home</a>
            <a href="characterPage.php">Characters</a>
            <a href="stagePage.php">Stages</a>
            <a href="aboutUsPage.php">About Us</a>
            <a href="blog.php">Blog</a>
        </nav>
    </header>

    <div id="fullBlog">
        <h3><?= $blog['title'] ?></h3><p><?= $blog['createdBy']?></p>
        <p><?=$blog['content']?></p>
        <?php if(isset($_SESSION['username'])) : ?>
            <a href="editBlog.php?postID=<?=$blog['postID']?>">Edit</a>
            <a href="newComment.php?postID=<?=$blog['postID']?>">Comment</a><br>
        <?php endif ?>
    </div>
        <br>
    
        <?php while($comment = $commentStatement->fetch()) :?>
            <div id="fullComment">
                <h5><?= $comment['createdBy'] ?></h5>
                <p><?= $comment['comment'] ?></p>
                <?php if(isset($_SESSION['username'])) : ?>
                    <form method="post" action="deleteComment.php">
                        <input type="hidden" name="commentId" value="<?= $comment['commentId'] ?>">
                        <button type="submit">Delete</button>
                    </form>
                <?php endif ?>
            </div> 
        <?php endwhile ?>
        
</body>
</html>