<?php
	date_default_timezone_set("America/Chicago");

	define("serverName", "localhost");
	define("username", "root");
	define("pass", "");
	define("databaseName", "chatDB");
	define("chatTableName", "chatLog");
	define("usernameTableName", "activeUsers");
	
	// Create connection
	$conn = new mysqli(serverName, username, pass);
	// Check connection
	if ($conn->connect_error) {
		die("<p>Connection failed: " . $conn->connect_error . "</p>");
	} 		
	
	// Create database
	$sql = "CREATE DATABASE IF NOT EXISTS " . databaseName;
	if ($conn->query($sql) === TRUE) {
		echo "<p>Database has been created</p>";
	} else {
		echo "<p>Error creating database: " . $conn->error . "</p>";
	}
	
	// Create connection
	$conn = new mysqli(serverName, username, pass, databaseName);
	// Check connection
	if ($conn->connect_error) {
		die("<p>Connection failed: " . $conn->connect_error . "</p>");
	}
	
	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS " . chatTableName . " (
		id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		username VARCHAR(256) NOT NULL,
		timestamp VARCHAR(64),
		message VARCHAR(1024) NOT NULL
	)";
	
	if ($conn->query($sql) === TRUE) {
		echo "<p>Table " . chatTableName . " has been created</p>";
	} else {
		echo "<p>Error creating table: " . $conn->error . "</p>";
	}

	// sql to create table
	$sql = "CREATE TABLE IF NOT EXISTS " . usernameTableName . " (
		id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		username VARCHAR(256) NOT NULL
	)";
	
	if ($conn->query($sql) === TRUE) {
		echo "<p>Table " . usernameTableName . " has been created</p>";
	} else {
		echo "<p>Error creating table: " . $conn->error . "</p>";
	}
	
	$conn->close();
	
?>