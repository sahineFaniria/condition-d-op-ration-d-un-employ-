<?php

require 'connection.php'; // Inclure le fichier de connexion à la base de données

if (isset($_POST['nom']) && isset($_POST['password'])) {
    $nom = $_POST['nom'];
    $password = $_POST['password'];

    

    // Effectuer une requête pour vérifier les informations de connexion dans la table usercompte
    $query = $con->prepare("SELECT * FROM usercompte WHERE nomUtilisateur = :nom AND motdepasse = :pass");
    $query->bindParam(':nom', $nom);
    $query->bindParam(':pass', $password);
    $query->execute();
    $id = $query->fetch(PDO::FETCH_ASSOC);
    if ($query->rowCount() == 1) {
          
        // L'utilisateur est connecté avec succès
        $_SESSION['nom'] = $id["id"];
        header("Location: home.php"); // Rediriger vers la page home.php
    } else {
        // L'authentification a échoué, rediriger vers la page d'erreur ou afficher un message d'erreur
        header("Location: login.php");
    }
} else {
    // Les champs nom et mot de passe ne sont pas définis, gérer cette situation en conséquence
    header("Location: login.php");

}




























// // Inclure votre fichier de connexion à la base de données
// include "connection.php"; // Assurez-vous d'avoir une connexion PDO valide

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $email = $_POST["email"];
//     $password = $_POST["password"];

//     // Requête SQL pour vérifier les informations d'identification de l'utilisateur
//     $query = $con->prepare("SELECT * FROM utilisateur WHERE gmail = :email");
//     $query->bindParam(":email", $email);
//     $query->execute();
//     $user = $query->fetch(PDO::FETCH_ASSOC);

//     if ($user && password_verify($password, $user["pass"])) {
//         // Les informations d'identification sont correctes
//         session_start();
//         $query = $con->prepare("SELECT id FROM employe WHERE email = :email");
//         $query->bindParam(":email", $email);
//         $query->execute();
//         $userr = $query->fetch(PDO::FETCH_ASSOC);
//         if($userr){
//             $_SESSION["user_id"] = $userr["id"];
//             header("location: menu.php"); // Stocker l'ID de l'utilisateur dans la session
//         }
//         $req = $con->prepare("SELECT id FROM employe WHERE email = :email");
//         $req->bindParam(":email", $email);
//         $req->execute();
//         $userr = $req->fetch(PDO::FETCH_ASSOC);
//         if($userr){
//           $_SESSION["user_id"] = $userr["id"];
//            header("location: sendEmail.php"); // Stocker l'ID de l'utilisateur dans la session
//         }
        
//         // Rediriger l'utilisateur vers la page d'accueil ou une autre page protégée
//         header("location: home.php"); // Remplacez "home.php" par la page vers laquelle vous souhaitez rediriger
//         exit; // Assurez-vous de sortir du script pour éviter l'exécution ultérieure
//     } else {
//         // Identifiants incorrects, afficher un message d'erreur
//         echo "Email ou mot de passe incorrect.";
//     }
// }
?>
