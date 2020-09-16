<?php
    require 'sqlInterface.php';
    global $conn;

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    $query = "
    BEGIN;
    INSERT INTO `events`(`type`, `user_id`) 
        VALUES ('message_sent', (SELECT `users`.`id` FROM `users` 
        WHERE `users`.`name` = '".$username."'));
    INSERT INTO `messages`(`event_id`, `message`)
        VALUES (LAST_INSERT_ID(), '".$message."');
    COMMIT;
    ";
    mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
?>