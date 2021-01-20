<!-- James Salverda
     November 5, 2019
     Final Project
     deletes a post when an athuorized user chooses delete in the edit page -->

<?php
    require('connect.php');
    require('authenticate.php');

    if ($_POST && isset($_POST['postID'])) {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $id      = filter_input(INPUT_POST, 'postID', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "DELETE FROM homepage WHERE postID = :postID";
        $statement = $db->prepare($query);
        $statement->bindValue(':postID', $id);
        
        // Execute the INSERT.
        $statement->execute();
        
        // Redirect after update.
        header("Location: homePage.php");
        exit;
    }
?>