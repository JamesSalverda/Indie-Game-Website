<?php
    require('connect.php');


    if ($_POST && isset($_POST['characterId'])) {


        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $id      = filter_input(INPUT_POST, 'characterId', FILTER_SANITIZE_NUMBER_INT);
        $img     = filter_input(INPUT_POST, 'imgName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $imgQuery = "SELECT * FROM characters WHERE characterId = :characterId";
        $imgStatement = $db->prepare($imgQuery);
        $imgStatement->bindValue(':characterId', $id);
        $imgStatement->execute();
        $imgRemoval = $imgStatement->fetch();
        $dir = "images/characters/" . $imgRemoval['imgName'];
        echo $dir;
        unlink($dir);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "UPDATE characters SET imgName = 'OhNO' WHERE characterId = :characterId";
        $statement = $db->prepare($query);
        $statement->bindValue(':characterId', $id);
        
        // Execute the INSERT.
        $statement->execute();
        
        // Redirect after update.
        header("Location: characterPage.php");
        exit;
    }
?>