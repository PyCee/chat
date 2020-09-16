<?php
    require 'sqlInterface.php';
    global $conn;

    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $query = "BEGIN;
    INSERT INTO `users`(`name`, `color`, `is_active`) 
        VALUES ('".$username."', 'black', 1) 
        ON DUPLICATE KEY UPDATE `users`.`is_active` = 1;
    INSERT INTO `events`(`type`, `user_id`) 
        VALUES ('user_joined', (SELECT `users`.`id` FROM `users` 
        WHERE `users`.`name` = '".$username."'));
    SELECT `users`.`last_timestamp` FROM `users` 
        WHERE `users`.`name` = '" . $username . "' LIMIT 1;
    COMMIT;";
    mysqli_multi_query($conn, $query) or die(mysqli_error($conn));

    $timestamp = "";
    do {
        if ($result = mysqli_store_result($conn)) {
            while ($row = mysqli_fetch_row($result)) {
                // Assign timestamp when reached
                $timestamp = $row[0];
            }
            mysqli_free_result($result);
        }
    } while (mysqli_next_result($conn));

    echo $timestamp;
?>