<!-- James Salverda
     November 19, 2019
     Final Project
     deletes a user when a authenticated user chooses delete in the edit page -->

     <?php
    require('connect.php');

    if ($_POST && isset($_POST['userId'])) {
        // Sanitize user input to escape HTML entities and filter out dangerous characters.
        $id      = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_NUMBER_INT);
        
        // Build the parameterized SQL query and bind to the above sanitized values.
        $query     = "DELETE FROM users WHERE userId = :userId";
        $statement = $db->prepare($query);
        $statement->bindValue(':userId', $id);
        
        // Execute the INSERT.
        $statement->execute();
        
        // Redirect after update.
        header("Location: users.php");
        exit;
    }
?>