<?php
    $name = $_POST["username"];

    define("serverName", "localhost");
    define("username", "root");
    define("pass", "");
    define("databaseName", "chatDB");
    define("usernameTableName", "activeUsers");

    $conn = new mysqli(serverName, username, pass, databaseName);
    if ($conn->connect_error) {
        die("<p>Connection failed: " . $conn->connect_error . "</p>");
    }
    $name = mysqli_real_escape_string($conn, $name);
    $sql_query = "DELETE FROM " . usernameTableName . " WHERE username = '" . $name . "'";
    mysqli_query($conn, $sql_query);
    echo($sql_query);
?>