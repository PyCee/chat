<?php
    require 'sqlInterface.php';
    global $conn;

    $timestamp = $_POST['timestamp'];

    $query = "SELECT `events`.`type`, `events`.`timestamp`, `users`.`name` AS 'username', 
        `users`.`color` AS 'user_color', `messages`.`message` 
        FROM `events` 
        INNER JOIN `users` ON (`events`.`user_id` = `users`.`id`) 
        LEFT JOIN `messages` ON (`messages`.`event_id` = `events`.`id`) 
        WHERE `events`.`timestamp` > '" . $timestamp . "'
        ORDER BY `events`.`id` ASC;";

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $messages = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
    echo json_encode($messages);
?>