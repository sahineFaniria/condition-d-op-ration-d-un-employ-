<?php

session_start(); // Démarrez la session
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Vérifiez si l'e-mail existe déjà dans la table "employe"
    $query = $con->prepare("SELECT email FROM employe WHERE email = :email");
    $query->bindParam(":email", $email);
    $query->execute();
    $existingEmployee = $query->fetch(PDO::FETCH_ASSOC);

    if ($existingEmployee) {
        // L'e-mail correspond à un employé existant, insérez l'utilisateur dans la table "utilisateur"
        $insertQuery = $con->prepare("INSERT INTO utilisateur (gmail, pass) VALUES (:email, :password)");
        $insertQuery->bindParam(":email", $email);
        $insertQuery->bindParam(":password", $password);
        
        if ($insertQuery->execute()) {
            session_start();
            $_SESSION["inscription_reussie"] = true;
            echo '<script>window.location = "index.php";</script>';
            echo '<script>alert("Inscription réussie ! Vous pouvez maintenant vous connecter.");</script>';
        } else {
            echo "L'inscription a échoué. Veuillez réessayer.";
        }
    } else {
        echo "Vous ne pouvez pas vous inscrire car vous ne faites pas partie de nos employés.";
    }
}


?>