<?php

/*This file takes into account the information entered in the form on the home.html page to find the corresponding protocols
in the database. 
It registers the name and the description of the corresponding protocols in the file 'correspond_prot.txt' in a json format.
Return : This files refers to the html page containing the corresponding protocols, "correspond_prot.html" and fill the file 'correspond_prot.txt'.
exemple: [["name1","descr1"],["name2","descr2"]]
HTML file : home.html
JS file : any*/

//Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "protocode_db";

// Variable to retrieve file output
$prot_output = array();


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection to the database
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
  echo "Successful database connection.";

}

//Check if the search form has been submitted
if (isset($_GET['submit'])){

  //Retrieve search values
  $protocol_input = $_GET['protocole'];
  $country_input = $_GET['country'];
  $hospital_name_input = $_GET['hospital_name'];
  $job_input = $_GET['job'];  

  //Remove spaces from the hospital name to compare it to the value without spaces retrieved from home.html
  $sql = "SELECT * FROM info 
         WHERE LOWER(protocole) LIKE LOWER('%$protocol_input%') AND
         country = '$country_input' AND
         REPLACE(hospital_name, ' ', '') = '$hospital_name_input' AND
         job = '$job_input'";
  //Execute query
  $result = $conn->query($sql);

  //Check that the request is executed correctly
  if ($result === false) {
    //Managing SQL query errors
    echo "Erreur de requête SQL: " . $conn->error;
  } 

  else {
    //Display results if there is
    if ($result->num_rows > 0) {
      //Display results in a list
      while($row = $result->fetch_assoc()) {

        //Convert protocol writing to utf8
        foreach ($row as $key => $value) {
          if (is_string($value)) {
              $row[$key] = utf8_encode($value);
          }
        }
        //Add protocole to $prot_output
        $prot_output[] = [$row["protocole_name"],$row["protocole"]];

      }
    }

    //If none of the protocols matches
    else {
      $prot_output[] = "No results found";
    }
  }
}

//Convert search result $prot_output to JSON
$file_content = json_encode($prot_output);


//Create or open an output file
$file_output = fopen("correspond_prot.txt","w");
//Write content to output file
fwrite($file_output, $file_content);
//Close output file
fclose($file_output);


//Close database connection
$conn->close();

//Refers to the page containing the corresponding protocols
header("Location: correspond_prot.html");

?>