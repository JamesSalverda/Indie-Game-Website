<!-- James Salverda
     November 19, 2019
     Final Project
     shows the full blog post -->

<?php
    require 'connect.php';
    session_start();

    $id = filter_input(INPUT_GET, 'characterId', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
    $query = "SELECT * FROM characters WHERE characterId = :characterId";
    
    $statement = $db->prepare($query);
    $statement->bindValue(':characterId', $id, PDO::PARAM_INT);
    $statement->execute(); 

    $blog = $statement->fetch();

    if($statement != null){
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $titles = $row['name'];
            $contents = $row['description'];
            $ids = $row['characterId'];
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
        <nav>
            <a href="homePage.php">Home</a>
            <a href="characterPage.php">Characters</a>
            <a href="stagePage.php">Stages</a>
            <a href="aboutUsPage.php">About Us</a>
            <a href="blog.php">Blog</a>
        </nav>
        
    </header>

    <div id="fullCharacter">
        <?php if(substr($blog['imgName'], 0, 4) != 'OhNO') : ?>     
            <img src="images/characters/<?= $blog['imgName']?>" alt="No Image Uploaded">
        <?php endif ?>
        <h3><?= $blog['name'] ?></h3>
        <p><?=$blog['description']?></p>
    </div>
</body>
</html>