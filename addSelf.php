<?php
    $name = $_POST["username"];

	$ms = microtime(true);
	$ms = floor(($ms - floor($ms)) * 1000);
	$timestamp = date("Y:m:d:H:i:s:") . $ms;

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
    $sql_query = "INSERT INTO " . usernameTableName . " (`username`) VALUES ('" . $name . "')";
    mysqli_query($conn, $sql_query);

    echo $timestamp;
?>