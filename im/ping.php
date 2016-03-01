<?php
/**
 * Handles the ping sent by a user to the server, informing that
 * he is currently online. So take the id of the use who sent this
 * and update his previous online time.
 */
    require("../init.php");

    // Updates the users online status.
    function update_online_status() {
        if( ! isset($_GET['id'])) {
            throw "Error: User id not found in the request.";
            exit();
        }

        global $db_connection;
        // Get the current time in UNIX Timestamp format,
        // and update the recent_ping of the user with it.
        $current_time = time();
        $id = $_GET['id'];
        $query = "UPDATE users SET recent_ping=$current_time WHERE id=$id";
        mysqli_query($db_connection, $query);
        if(mysqli_errno($db_connection) != 0) {
            echo mysqli_error($db_connection);
            exit();
        }
    }

    update_online_status();
?>

Ping updated.