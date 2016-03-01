<?php
/**
 * Handles the addition of new chat for the usre.
 */

    // Adds a new im message.
    function add_message() {

    }

    if(isset($_POST['message']))
        add_message();
?>

<?php echo $_POST['user_id']; ?>
Message added.
