<!-- James Salverda
     November 12, 2019
     Final Project
     Search postings on the Home Page by Title -->

<?php
    require('connect.php');

    if(isset($_POST['search'])){
        $searchQ = $_POST['search'];
        $searchQ = preg_replace("#[^0-9a-z]#i", "", $searchQ);

        $query = "SELECT * FROM homepage WHERE title LIKE '%$searchQ%' OR content LIKE '%$searchQ%'";
        $statement = $db->prepare($query);

        $statement->execute(); 
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

    <?php if ($statement->rowCount() == 0) : ?>
        <p>No Updates Found</p>        
    <?php endif ?>
   
    <?php while ($row = $statement->fetch()): ?>
        <div id="updates">
            <h3><a href="show.php?postID=<?=$row['postID']?>"><?= $row['title'] ?></a></h3><p><?= date("F d, Y, g:i a", strtotime($row['time']))?></p>
                    
            <a href="editHomePage.php?postID=<?=$row['postID']?>">Edit</a>
        </div>
    <?php endwhile ?>
    
</body>
</html>