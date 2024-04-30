<?php

require 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo "Connection unsuccessful!". $conn->connect_error;
} else {
    echo "Connection successful!";
}

// Close connection
$conn->close();

?>
