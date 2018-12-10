<?php
    $name = $_POST["username"];

    define("serverName", "localhost");
    define("username", "root");
    define("pass", "");
    define("databaseName", "chatDB");
    define("usernameTableName", "activeUsers");
    define("chatTableName", "chatLog");

    $conn = new mysqli(serverName, username, pass, databaseName);
    if ($conn->connect_error) {
        die("<p>Connection failed: " . $conn->connect_error . "</p>");
    }
    $name = mysqli_real_escape_string($conn, $name);
    $sql_query = "DELETE FROM " . usernameTableName . " WHERE username = '" . $name . "'";
    mysqli_query($conn, $sql_query);
	
	
	// If userlist is empty, clear table
    $sql_query = "SELECT id FROM " . usernameTableName;
    $result = mysqli_query($conn, $sql_query);
    $resultCount = mysqli_num_rows($result);
	
	if($resultCount == 0){
		$sql_query = "DELETE FROM " . chatTableName;
		mysqli_query($conn, $sql_query);
	}
?>