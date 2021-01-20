<!-- James Salverda
     November 12, 2019
     Final Project
     deletes a character when an authuorized user chooses delete in the edit page -->

     <?php
    require('connect.php');
    require('authenticate.php');

    if ($_POST && isset($_POST['characterId'])) {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $id      = filter_input(INPUT_POST, 'characterId', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "DELETE FROM characters WHERE characterId = :characterId";
        $statement = $db->prepare($query);
        $statement->bindValue(':characterId', $id);
        
        // Execute the DELETE.
        $statement->execute();
        
        // Redirect after update.
        header("Location: characterPage.php");
        exit;
    }
?>