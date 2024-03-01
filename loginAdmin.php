<?php

session_start(); // Démarrez la session
//-----SESSION ADMIN-----//
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernom = $_POST['usern'];
    $passwo = $_POST['pass'];

    try {
        // Connectez-vous à la base de données en utilisant PDO
        include "connection.php";

        // Préparez la requête SQL pour récupérer l'administrateur en fonction du nom d'utilisateur
        $stmt = $con->prepare("SELECT * FROM admin_users WHERE AdminNom = :test and adminPass = :ps");
        $stmt->bindParam(':test', $usernom);
        $stmt->bindParam(':ps', $passwo);
        $stmt->execute();
        $row = $stmt->fetch();

        if ($row) {
            $_SESSION["admin_username"] = $usernom; // Stocker le nom d'utilisateur dans la session
    
            header("location: admin1.php");  // Redirigez vers la page admin1.php
        } else {
            // L'authentification a échoué, redirigez vers la page de connexion avec un message d'erreur
            echo "ts mandeha";
        }

    } catch (PDOException $e) {
        echo "Erreur de base de données : " . $e->getMessage();
    }
}
//-----FIN SESSION ADMIN-----//

//-----SESSION employer-----//


//-----FIN SESSION employer-----//
?>






