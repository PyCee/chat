<?php
	
	$username = $_POST["username"];

	$ms = microtime(true);
	$ms = floor(($ms - floor($ms)) * 1000);
	$timestamp = date("Y:m:d:H:i:s:") . $ms;
	
	$message = $_POST["message"];
	
	define("serverName", "localhost");
	define("username", "root");
	define("pass", "");
	define("databaseName", "chatDB");
	define("chatTableName", "chatLog");
	
	// Create connection
	$conn = new mysqli(serverName, username, pass, databaseName);
	// Check connection
	if ($conn->connect_error) {
		die("<p>Connection failed: " . $conn->connect_error . "</p>");
	}
	
	$username = mysqli_real_escape_string($conn, $username);
	$timestamp = mysqli_real_escape_string($conn, $timestamp);
	$message = mysqli_real_escape_string($conn, $message);
	$sql_query = "INSERT INTO " . chatTableName . 
		" (username, timestamp, message) VALUES ('$username', '$timestamp', '$message')";

	$result = mysqli_query($conn, $sql_query);

	if(!$result){
		echo "Failed sql query: " . $sql_query;
	}
	
	$conn->close();
?>