<?php
    require 'sqlInterface.php';
    global $conn;

    $query = "SELECT `users`.`name` AS 'username', 
    `users`.`color` AS 'user_color' 
    FROM `users` 
    WHERE `users`.`is_active` = 1
    ORDER BY `users`.`last_timestamp` ASC;";

    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    echo json_encode($users);
?>