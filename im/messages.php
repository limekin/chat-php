<?php
/**
 * Handles the retrieval of any new messages from the db.
 */
    require('../init.php');

    // Gets a history of chats or any new chats for the user and other
    // other user combinations.
    function get_messages() {
        $user_id = $_GET['user_id'];
        $other_id = $_GET['other_id'];
        $firstime = $_GET['firstime'];
        $result = null;
        $previous_message_id = $_GET['prev_msg_id'];

        // If it's a first time fetch, then get history.
        // Delegate things to get_history.
        if($firstime == "true")
            $result =  get_history($user_id, $other_id);
        else
            $result = get_new_messages($user_id, $other_id, $prev_msg_id);
        update_unseen($user_id, $other_id);

        // Return the converted data.
        return convert_to_json($result);

    }

    // Gets any new messages for the user from other user.
    function get_new_messages($user_id, $other_id, $prev_msg_id) {
        global $db_connection;
        $query = "SELECT * FROM chat_messages WHERE (sender_id = $user_id AND reciever_id = $other_id ";
        $query .= "OR sender_id=$other_id AND reciever_id=$user_id) ";
        $query .= " AND id > $prev_msg_id";

        $result = mysqli_query($db_connection, $query);
        if(mysqli_errno($db_connection) != 0) {
            echo mysqli_error($db_connection);
            exit();
        }

        return $result;
    }

    // Gets a history of chats for the user and other user.
    function get_history($user_id, $other_id) {
        global $db_connection;
        $query =  "(SELECT * FROM messages ";
        $query .= "WHERE (sender_id=$user_id AND reciever_id=$other_id ";
        $query .= "OR sender_id=$other_id AND reciever_id=$user_id) ";
        $query .= "ORDER BY id DESC LIMIT 15) ORDER BY id";

        $result = mysqli_query($db_connection, $query);
        if(mysqli_errno($db_connection) != 0) {
            echo mysqli_error($db_connection);
            exit();
        }

        return $result;
    }

    // Updates the messages to user from other user as seen.
    function update_unseen($user_id, $other_id) {
        global $db_connection;
        $query =  "UPDATE messages SET seen=1 ";
        $query .= "WHERE sender_id=$other_id AND reciever_id=$user_id";
        mysqli_query($db_connection, $query);
        if(mysqli_errno($db_connection) != 0) {
            echo mysqli_error($db_connection);
            exit();
        }
    }

    // Converts the result set to json data.
    function convert_to_json($result) {
        if($result == null) return '{"messages":[]}';
        $to_return = '{"messages":[';
        $json_rows = array();
        foreach($result as $row) {
            $json_rows[] = json_encode($row);
        }
        $to_return .= implode(',', $json_rows) . "]}";

        return $to_return;
    }

    $response = get_messages();

?>

<?php echo $response; ?>