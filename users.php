<!-- James Salverda
     November 19, 2019
     Final Project
     list users who signed up -->

     <?php
    require('connect.php');
    require('authenticate.php');

    $query = "SELECT * FROM users ORDER BY userId";

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
        <nav>
            <a href="homePage.php">Home</a>
            <a href="characterPage.php">Characters</a>
            <a href="stagePage.php">Stages</a>
            <a href="aboutUsPage.php">About Us</a>
            <a href="blog.php">Blog</a>
        </nav>
    </header>
   
    <?php while ($row = $statement->fetch()): ?>
        <div id="updates">
            <h3><?= $row['username'] ?></h3><p><?= $row['userEmail']?></p>         
            <a href="editUsers.php?userId=<?=$row['userId']?>">Edit</a>
        </div>
    <?php endwhile ?>
    
</body>
</html>