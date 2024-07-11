<?php

/*This file takes into account the information from the database and return them as a JSON file 
to display them in the drop-down menus of the html page.
Return : JSON file containing the information of the database
exemple: [["department1","job1","protocole_name1"...], ["department2","job2","protocole_name2"...]]
HTML file : home.html
JS file : "website.js"*/

// Database connection
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "protocode_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Create an array to store data
$data = array();

// Check connection to the database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    "Successful database connection."; 
}

// Execute query to retrieve data
$sql = "SELECT hospital_name,job,department FROM info";
$result = $conn->query($sql);


// Check that the request is executed correctly
if ($result === false) {
    echo "Error executing SQL query : " . $conn->error; 
} else {
    // Display results if there is
    if ($result->num_rows > 0) {
        // Display results in an array
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        echo "No results found."; 
    }
}

// Close database connection
$conn->close();

// Return JSON-encoded data
echo json_encode($data);
?>