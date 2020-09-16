<?php
    require 'sqlInterface.php';
    global $conn;

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    
    $query = "SELECT (COUNT(`name`) > 0) FROM `users` 
    WHERE `users`.`name` = '" . $username . "' AND `users`.`is_active` = 1;";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    echo mysqli_fetch_row($result)[0];
?>