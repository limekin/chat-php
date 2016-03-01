<?php

    require("init.php");

    // Handles the login of the user.
    function handle_login() {
        global $db_connection;
        // Get the username and the password from the params.
        $username = $_POST['username'];

        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($db_connection, $query);

        if(mysqli_errno($db_connection) != 0) {
            echo mysqli_error($db_connection);
            exit();
        }

        if(mysqli_num_rows($result) == 0) {
            echo "<script>alert('Username wrong dude !')</script>";
        } else {
            $result = mysqli_fetch_array($result);
            $_SESSION['user_id'] = $result['id'];
            header("Location: /chatcraft/home.php");
            exit();
        }
    }

    if(isset($_POST['username'])) handle_login();

?>


<?php require('header.php'); ?>
    <h1>Login</h1>
    <form method="POST">
        <label>Username: </label>
        <input type="text" name="username"/>

        <button type="submit">Login</button>
    </form>
<?php require('footer.php'); ?>