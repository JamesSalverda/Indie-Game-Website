<!-- James Salverda
     November 5, 2019
     Final Project
     Shows postings made by authorized users -->

<?php
    require('connect.php');

    $query = "SELECT * FROM homepage ORDER BY postID DESC";

    $statement = $db->prepare($query);

    $statement->execute(); 

    session_start();

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

    <form id="update" action="newHomePagePost.php">
        <button >Add an Update</button>
    </form>

    
        <?php if(isset($_SESSION['username'])) : ?>
                <div id="sort">
                <a href="sortTitle.php">Title</a>
                <a href="sortDateOld.php">Old to New</a>
                <b><a href="homePage.php">New to Old</a></b>
            </div>
        <?php endif ?>
    

    <?php if ($statement->rowCount() == 0) : ?>
        <p>No Updates Yet</p>        
    <?php endif ?>
   
    <?php while ($row = $statement->fetch()): ?>
        <div id="updates">
            <h3><a href="show.php?postID=<?=$row['postID']?>"><?= $row['title'] ?></a></h3><p><?= date("F d, Y, g:i a", strtotime($row['time']))?></p>         
            <a href="editHomePage.php?postID=<?=$row['postID']?>">Edit</a>
        </div>
    <?php endwhile ?>
    
</body>
</html>