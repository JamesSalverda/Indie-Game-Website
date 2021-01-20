<!-- James Salverda
     November 26, 2019
     Final Project
     deletes a comment when an authuorized user chooses delete -->

<?php
    require('connect.php');
    require('authenticate.php');

    if ($_POST && isset($_POST['commentId'])) {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $id      = filter_input(INPUT_POST, 'commentId', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "DELETE FROM comments WHERE commentId = :commentId";
        $statement = $db->prepare($query);
        $statement->bindValue(':commentId', $id);
        
        // Execute the DELETE.
        $statement->execute();
        
        // Redirect after update.
        header("Location: blog.php");
        exit;
    }
?>