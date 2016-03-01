<?php

    require("../init.php");

    // Gets the details of the given user.
    function get_user() {
        global $db_connection;

        $id = $_GET['id'];
        $q = "SELECT * FROM users WHERE id = $id";
        $result = mysqli_query($db_connection, $q);
        if(mysqli_errno($db_connection) != 0) {
            echo mysqli_error($db_connection);
            exit();
        }

        return mysqli_fetch_array($result);
    }

    // Gets the users online status.
    function get_online_status() {
        global $db_connection;
        $id = $_GET['id'];

        $query = "SELECT recent_ping FROM users WHERE id=$id";
        $result = mysqli_query($db_connection, $query);
        if(mysqli_errno($db_connection) != 0) {
            echo mysqli_error($db_connection);
            exit();
        }

        // Now check if the difference between current time and the time
        // the user sent the recent ping is greater than 15 second.
        $result = mysqli_fetch_array($result);
        $recent_ping = $result['recent_ping'];
        $current_time = time();

        if($current_time - $recent_ping >= 15) return false;
        return true;
    }

    // Gets the id of the profile's user.
    function get_id() {
        return $_GET['id'];
    }

    $user = get_user();
    $is_online = get_online_status();
    $profile_user_id = get_id();
?>

<?php require("../header.php"); ?>

    <script>
        window.profile_user_id = <?php echo $profile_user_id; ?>
    </script>
    <h3>
        Showing proflie of user ...
        <?php echo $user['username']; ?>
        <?php if($is_online): ?>
            <p>The user is online.</p>
        <?php else: ?>
            <p>The user is not online.</p>
        <?php endif; ?>
    </h3>

    <button id='start_chat' type="button">Send message</button>

<?php require("../footer.php"); ?>
