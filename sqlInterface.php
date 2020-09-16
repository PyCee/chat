<?php
    $conn = null;

    if($conn == null){
        // Initialize connection
        $conn = new mysqli("localhost", "root", "", "chatDB");
        if ($conn->connect_error) {
            die("<p>Connection failed: " . $conn->connect_error . "</p>");
        }
    }
    function connClose(){
        global $conn;
        mysqli_close($conn);
    }
?>