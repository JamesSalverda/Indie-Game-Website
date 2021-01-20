<!-- James Salverda
     November 5, 2019
     Final Project
     show.php shows the full blog post regardless of length -->

<?php
    require 'connect.php';

    $id = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_NUMBER_INT);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
    $query = "SELECT * FROM homepage WHERE postID = :postID";
    
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
    <div id="full">
        <h3><?= $blog['title'] ?></h3><p><?= date("F d, Y, g:i a", strtotime($blog['time']))?></p>
        <p><?=$blog['content']?></p>
        <a href="editHomePage.php?postID=<?=$blog['postID']?>">Edit</a>
    </div>
</body>
</html>