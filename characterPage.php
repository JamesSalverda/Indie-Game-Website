<!-- James Salverda
     November 12, 2019
     Final Project
     Shows character postings made by authorized users -->

<?php
    require('connect.php');

    $query = "SELECT * FROM characters ORDER BY characterID ASC";

    $statement = $db->prepare($query);

    $statement->execute(); 
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
            <form action="searchCharacterPage.php" method="post">
                <input type="text" name="search" placeholder="Search for Characters...">
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

    <form action="newCharacter.php">
        <button >Add a Character</button>
    </form>

    <?php while ($row = $statement->fetch()): ?>
        <div id="updates">
            <h3><a href="fullCharacter.php?characterId=<?=$row['characterId']?>"><?= $row['name'] ?></a></h3>
            <div id="imgWrap">
                <img src="images/characters/<?= $row['imgName']?>" alt="No Image Uploaded">
                <p><?= $row['description'] ?></p>
            </div>
            <a href="editCharacter.php?characterId=<?=$row['characterId']?>">Edit</a>         
        </div>
    <?php endwhile ?>
    
</body>
</html>