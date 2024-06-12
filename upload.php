<?php

//Ce fichier à pour fonction d'enregistrer les nouveaux protocoles uploadés dans la base de données

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "protocode_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    "Connexion à la base de données réussie."; // Supprimé pour éviter l'affichage dans le JSON
}



//Idée: récuperer les noms dans le js et le mettre dans un json qui sera lu ligne par ligne (bouclage sur le json) pour récupréer les $variables
//Pour les protocole image, il faudra mettre l'algorithme dans le js, le php sera le meme pour tous
$hospital_name=;
$department=;
$job=;
$protocol=;

$sql = "INSERT INTO `info`(`country`, `hospital_name`, `job`, `protocole`) VALUES ('$hospital_name','$department','$job','$protocol')";
$result = $conn->query($sql);