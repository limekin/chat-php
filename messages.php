<?php
    require('init.php');

    // Gets all the users from the databse.
    function all_users() {
        global $db_connection;

        $q = "SELECT * FROM users";
        $result = mysqli_query($db_connection, $q);
        if(mysqli_errno($db_connection) != 0) {
            echo mysqli_error($db_connection);
            exit();
        }

        return $result;
    }

    $users = all_users();
?>

<?php require('header.php'); ?>
    <h3>Messages</h3>

    <div class="messages-container">
        <div id="conversation">

        </div>
        <div id="online-users">
            <ul>
                <?php foreach($users as $user): ?>
                    <li class="username">
                        <?php echo $user['username']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php require('footer.php'); ?>