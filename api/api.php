<?php

// Database connection information
require 'db_credentials.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set headers to allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Get data from the URL parameters
$operation = $_GET['operation'] ?? '';

// Perform CRUD operations based on the operation parameter
switch ($operation) {
    case 'create':
        $name = $_GET['name'] ?? '';
        $state = $_GET['state'] ?? '';
        // Create new record
        $sql = "INSERT INTO ARD (name, state) VALUES ('$name', '$state')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Record created successfully"));
        } else {
            echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
        }
        break;
    case 'update':
        $id = $_GET['id'] ?? '';
        $name = $_GET['name'] ?? '';
        $state = $_GET['state'] ?? '';
        // Update existing record
        $sql = "UPDATE ARD SET name='$name', state='$state' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Record updated successfully"));
        } else {
            echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
        }
        break;
    case 'delete':
        $id = $_GET['id'] ?? '';
        // Delete record
        $sql = "DELETE FROM ARD WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(array("message" => "Record deleted successfully"));
        } else {
            echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
        }
        break;
    case 'get':
        $id = $_GET['id'] ?? '';
        if (!empty($id)) {
            // Retrieve specific record if ID is provided
            $sql = "SELECT * FROM ARD WHERE id='$id'";
        }
        $result = $conn->query($sql);
        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        echo json_encode($rows);
        break;
    default:
        // Retrieve all records if no ID is provided
        $sql = "SELECT * FROM ARD";
        $result = $conn->query($sql);
        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        echo json_encode($rows);
        break;


}

// Close connection
$conn->close();

?>