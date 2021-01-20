<!-- James Salverda
     November 19, 2019
     Final Project
     deletes a post when a signed in user chooses delete in the edit page -->

<?php
    require('connect.php');
    session_start();

    if ($_POST && isset($_POST['postID'])) {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $id      = filter_input(INPUT_POST, 'postID', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "DELETE FROM blog WHERE postID = :postID";
        $statement = $db->prepare($query);
        $statement->bindValue(':postID', $id);
        
        // Execute the INSERT.
        $statement->execute();
        
        // Redirect after update.
        header("Location: blog.php");
        exit;
    }
?>