<?php

require './connection.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['employeId'])) {
    $compteId = $_POST['employeId'];

    // Récupérer de l'id employe de l'employé
    $query = $con->prepare("SELECT id FROM usercompte WHERE idCompte = :userId");
    $query->bindParam(':userId', $compteId, PDO::PARAM_INT);
    $query->execute();
    $id = $query->fetchColumn();

    // Récupérer l'adresse e-mail de l'employé
    $emailQuery = $con->prepare("SELECT email FROM employe WHERE id = :employeId");
    $emailQuery->bindParam(':employeId', $id, PDO::PARAM_INT);
    $emailQuery->execute();
    $employeEmail = $emailQuery->fetchColumn();

    // Récupérer le nom d'utilisateur et le mot de passe de la table usercompte
   $compteQuery = $con->prepare("SELECT nomUtilisateur, motdepasse FROM usercompte WHERE idCompte = :userId");
    $compteQuery->bindParam(':userId', $compteId, PDO::PARAM_INT);
    $compteQuery->execute();
    $compteInfo = $compteQuery->fetch(PDO::FETCH_ASSOC);

    // Envoi de l'e-mail
    $mail = new PHPMailer(true);

    try {
        // Configuration de PHPMailer
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Configurez le serveur SMTP de votre fournisseur de messagerie
        $mail->SMTPAuth = true;
        $mail->Username = 'faniriasahine@gmail.com'; // Votre adresse e-mail
        $mail->Password = 'joro gqux lvva agkz'; // Votre mot de passe
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Destinataire
        $mail->setFrom('faniriasahine@gmail.com', 'Administrateur');
        $mail->addAddress($employeEmail);

        // Contenu de l'e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Informations du compte';
        $mail->Body = 'Votre nom d\'utilisateur est : ' . $compteInfo['nomUtilisateur'] . '<br>Votre mot de passe est : ' . $compteInfo['motdepasse'];
        $mail->send();
        echo 'E-mail envoyé avec succès';
    } catch (Exception $e) {
        echo 'Erreur lors de l\'envoi de l\'e-mail : ' . $mail->ErrorInfo;
    }
}

?>




