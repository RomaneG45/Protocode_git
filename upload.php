<?php
/*Recovers the uploaded pdf file and transforms it into text thanks to function from parser library. 
Stores pdf files in the "upload" file.
Register the new information from upload.html (job, department, hospital name and the text protocol) into the database
Returns :   if everything is respected : redirection to "upload.html", with the message "success"
            otherwise, write the dislpay the problem*/
require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

// Database connection
$servername = "localhost";
$username = "root";
$password = '';
$dbname = "protocode_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        if ($fileExtension == 'pdf') {
            $uploadFileDir = './uploads/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $parser = new Parser();
                $pdf = $parser->parseFile($dest_path);
                $text = $pdf->getText();

                // Retrieving text field values
                $hospital_name = $conn->real_escape_string($_POST['hospital_name']);
                $department = $conn->real_escape_string($_POST['department']);
                $job = $conn->real_escape_string($_POST['job']);
                $protocole_name = $conn->real_escape_string($_POST['protocole_name']);
                $protocol = $conn->real_escape_string($text);

                // Database insertion
                $sql = "INSERT INTO info (hospital_name, department, job, protocole_name, protocole) 
                        VALUES ('$hospital_name', '$department', '$job', '$protocole_name', '$protocol')";

                if ($conn->query($sql) === TRUE) {
                    $conn->close();
                    header("Location: upload.html?message=success");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            echo "Only PDF files are allowed.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
}
?>
