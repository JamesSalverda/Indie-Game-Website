<!-- James Salverda
     November 12, 2019
     Final Project
     Search postings on the Home Page by Title -->

<?php
    require('connect.php');

    

    if(isset($_POST['search'])){

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 15 ? (int)$_GET['per-page'] : 5;

        $start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

        $searchQ = $_POST['search'];
        $searchQ = preg_replace("#[^0-9a-z]#i", "", $searchQ);

        $query = "SELECT * FROM homepage WHERE title LIKE '%$searchQ%' OR content LIKE '%$searchQ%' LIMIT {$start}, {$perPage}";
        $statement = $db->prepare($query);

        $statement->execute(); 

        $search = $statement->fetchAll(PDO::FETCH_ASSOC);

        
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CacheGrab</title>
</head>
<body>

    <h1>Super Powered Battle Friends</h1>

    <nav>
        <a href="homePage.php">Home</a>
        <a href="characterPage.php">Characters</a>
        <a href="stagePage.php">Stages</a>
        <a href="aboutUsPage.php">About Us</a>
    </nav>

    <form action="paginationTest.php" method="post">
        <input type="text" name="search" placeholder="Search for Updates...">
        <input type="submit" value="Go">
    </form>

    <?php foreach ($search as $sea) : ?>
        <h3><a href="show.php?postID=<?=$sea['postID']?>"><?= $sea['title'] ?></a></h3><p><?= date("F d, Y, g:i a", strtotime($sea['time']))?></p>
                
        <a href="editHomePage.php?postID=<?=$sea['postID']?>">Edit</a>
    <?php endforeach ?>
    
</body>
</html>