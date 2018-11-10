<?php

    $lastTimestamp = $_POST["lastTimestamp"];
    
	define("serverName", "localhost");
	define("username", "root");
	define("pass", "");
	define("databaseName", "chatDB");
    define("chatTableName", "chatLog");
    
	$conn = new mysqli(serverName, username, pass, databaseName);
	if ($conn->connect_error) {
		die("<p>Connection failed: " . $conn->connect_error . "</p>");
    }
    $sql_query = "SELECT username, timestamp, message FROM " . chatTableName . 
		" WHERE timestamp > '" . $lastTimestamp . "'";
    $result = mysqli_query($conn, $sql_query);
	if(!$result){
		echo "Failed sql query: " . $sql_query;
	}
    $resultCount = mysqli_num_rows($result);

    class Message {
        function __construct($username, $timestamp, $message){
            $this->username = $username;
            $this->timestamp = $timestamp;
            $this->message = $message;
        }
    }
    $messages = [];
    for($i = 0; $i < $resultCount; $i++){
        $row = mysqli_fetch_row($result);
        $message = new Message($row[0], $row[1], $row[2]);
        array_push($messages, $message);
    }
    $results = json_encode($messages);

    echo $results;
	
?>