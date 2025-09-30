<?php
    function getMessagesType2($conn, $user_id) {
        $sql_message_type2 = "SELECT message_text FROM message_data WHERE id = ? AND message_type = 2";
        $stmt_message2 = $conn->prepare($sql_message_type2);
        if (!$stmt_message2) {
            die('Prepare failed for message_data type 2: ' . $conn->error);
        }
        $stmt_message2->bind_param('i', $user_id);
        $stmt_message2->execute();
        $result_message2 = $stmt_message2->get_result();
        $messages_type2 = [];
        while ($row_message2 = $result_message2->fetch_assoc()) {
            $messages_type2[] = $row_message2['message_text'];
        }
        return $messages_type2;
    }
    function getMessagesType1($conn, $user_id) {
        $sql_message = "SELECT message_text FROM message_data WHERE id = ? AND message_type = 1";
        $stmt_message = $conn->prepare($sql_message);
        if (!$stmt_message) {
            die('Prepare failed for message_data: ' . $conn->error);
        }
        $stmt_message->bind_param('i', $user_id);
        $stmt_message->execute();
        $result_message = $stmt_message->get_result();
        $messages = [];
        while ($row_message = $result_message->fetch_assoc()) {
            $messages[] = $row_message['message_text'];
        }
        return $messages;
    }
?>