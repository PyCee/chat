<?php
    require 'sqlInterface.php';
    global $conn;
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    
    $query = "
    BEGIN;
    UPDATE `users` SET `is_active` = 0 WHERE `users`.`name` LIKE '" . $username . "';
    INSERT INTO `events`(`type`, `user_id`)
        VALUES ('user_left', (SELECT `users`.`id` FROM `users` 
        WHERE `users`.`name` = '".$username."'));
    COMMIT;";
    mysqli_multi_query($conn, $query) or die(mysqli_error($conn));
?>