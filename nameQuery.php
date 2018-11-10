<?php

    define("serverName", "localhost");
    define("username", "root");
    define("pass", "");
    define("databaseName", "chatDB");
    define("usernameTableName", "activeUsers");

    $conn = new mysqli(serverName, username, pass, databaseName);
    if ($conn->connect_error) {
        die("<p>Connection failed: " . $conn->connect_error . "</p>");
    }
    $sql_query = "SELECT username FROM " . usernameTableName . " WHERE 1";
    $result = mysqli_query($conn, $sql_query);
	if(!$result){
        echo "Failed sql query: " . $sql_query;
	}
    $resultCount = mysqli_num_rows($result);

    $names = [];
    for($i = 0; $i < $resultCount; $i++){
        $name = mysqli_fetch_row($result);
        array_push($names, $name[0]);
    }
    echo json_encode($names);
?>