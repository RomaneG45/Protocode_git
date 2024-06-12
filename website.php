<?php

/*This file takes into account the information from the database and return them as a JSON file 
to display them in the drop-down menus of the html page.
Return : JSON file containing the information of the database
exemple: [["country1","job1","protocole_name1"...], ["country2","job2","protocole_name2"...]]
HTML file : home.html
JS file : "website.js"*/

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "protocode_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Créer un tableau pour stocker les données
$data = array();

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    "Connexion à la base de données réussie."; // Supprimé pour éviter l'affichage dans le JSON
}

// Exécuter la requête pour récupérer les données
$sql = "SELECT country,hospital_name,job FROM info";
$result = $conn->query($sql);


// Vérifier si la requête a été exécutée avec succès
if ($result === false) {
    echo "Erreur lors de l'exécution de la requête SQL : " . $conn->error; // Supprimé pour éviter l'affichage dans le JSON
} else {
    // Vérifier si des résultats ont été retournés
    if ($result->num_rows > 0) {
        // Boucler sur les résultats et stocker les données dans le tableau
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        echo "Aucun résultat trouvé."; // Supprimé pour éviter l'affichage dans le JSON
    }
}

// Fermer la connexion
$conn->close();

// Retourner les données encodées en JSON
echo json_encode($data);
?>