<?php
require './connection.php';

// UPDATE EMPLOYE
if (isset($_POST['modifier'])) {
    $id = $_POST['id']; // L'ID de l'employé
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $role = $_POST['role'];
    $adresse = $_POST['adresse'];
    $numero = $_POST['numero'];
    $email = $_POST['email'];

    if (!empty($nom) && !empty($prenom) && !empty($role) && !empty($adresse) && !empty($numero) && !empty($email)) {
        $update = $con->prepare("UPDATE employe SET nom = :nom, prenom = :prenom, role = :role, adresse = :adresse, numero = :numero, email = :email WHERE id = :id");
        $update->bindParam(':id', $id);
        $update->bindParam(':nom', $nom);
        $update->bindParam(':prenom', $prenom);
        $update->bindParam(':role', $role);
        $update->bindParam(':adresse', $adresse);
        $update->bindParam(':numero', $numero);
        $update->bindParam(':email', $email);
        $update->execute();

        if ($update) {
            echo "<script>alert('Modifié');</script>";
                header("location:Employe.php");
                // Popup Success
        } else {
            echo "<script>alert('Non modifié');</script>";
        }
    } else {
        echo "<script>alert('Entrez toutes les données');</script>";
    }

}

// UPDATE DE CONDITION
if (isset($_POST['modifie'])) {
    $idc = $_POST['idc']; // L'ID de l'employé
    $email = $_POST['email'];
    $validite = $_POST['validite'];
    $debut = $_POST['debut'];
    $fin = $_POST['fin'];
    $type = $_POST['type'];
    $statut = $_POST['statut'];
    $evidence = $_POST['evidence'];

    if (!empty($email) && !empty($validite) && !empty($debut) && !empty($fin) && !empty($type) && !empty($statut) && !empty($evidence)) {
        $update = $con->prepare("UPDATE travail SET id = :nom, valTemp = :validite, dateDebut = :debut, dateFin = :fin, type = :type, statut = :statut, evidence = :evidence WHERE idCondition = :idc");
        $update->bindParam(':idc', $idc);
        $update->bindParam(':nom', $email);
        $update->bindParam(':validite', $validite);
        $update->bindParam(':debut', $debut);
        $update->bindParam(':fin', $fin);
        $update->bindParam(':type', $type);
        $update->bindParam(':statut', $statut);
        $update->bindParam(':evidence', $evidence);
        $update->execute();

        if ($update) {
            // echo "<script>alert('Modifié');</script>";
                header("location:condition.php");
                // Popup Success
        } else {
            echo "<script>alert('Non modifié');</script>";
        }
    } else {
        echo "<script>alert('Entrez toutes les données');</script>";
    }

}

//UPDATE PLAN
if (isset($_POST['modif'])) {
    $id = $_POST['idpl']; // L'ID de la planning
    $date = $_POST['date'];
    $statut = $_POST['statut'];
    $tache = $_POST['tache'];

    if (!empty($date) && !empty($statut) && !empty($tache)) {
        $update = $con->prepare("UPDATE plan SET date = :date, statut = :statut, tache = :tache WHERE idPlan = :id");
        $update->bindParam(':id', $id);
        $update->bindParam(':date', $date);
        $update->bindParam(':statut', $statut);
        $update->bindParam(':tache', $tache);
        $update->execute();

        if ($update) {
            // echo "<script>alert('Modifié');</script>";
                header("location:Plan.php");
                // Popup Success
        } else {
            echo "<script>alert('Non modifié');</script>";
        }
    } else {
        echo "<script>alert('Entrez toutes les données');</script>";
    }

}

// UPDATE DE COMPTE UTILISATEUR
if (isset($_POST['modf'])) {
    $idcompte = $_POST['idcompte']; // L'ID de l'employé
    $nom = $_POST['nom'];
    $utilisateur = $_POST['utilisateur'];
    $motdepasse = $_POST['motdepasse'];

    if (!empty($nom) && !empty($utilisateur) && !empty($motdepasse)) {
        $update = $con->prepare("UPDATE usercompte SET id = :nom, nomUtilisateur = :utilisateur, motdepasse = :motdepasse WHERE idCompte = :idcompte");
        $update->bindParam(':idcompte', $idcompte);
        $update->bindParam(':nom', $nom);
        $update->bindParam(':utilisateur', $utilisateur);
        $update->bindParam(':motdepasse', $motdepasse);
        $update->execute();

        if ($update) {
            // echo "<script>alert('Modifié');</script>";
                header("location:compte.php");
                // Popup Success
        } else {
            echo "<script>alert('Non modifié');</script>";
        }
    } else {
        echo "<script>alert('Entrez toutes les données');</script>";
    }

}

// UPDATE DE COMPTE UTILISATEUR
if (isset($_POST['modfi'])) {
    $idcompte = $_POST['idadmin']; // L'ID de l'employé
    $nom = $_POST['nom'];
    $utilisateur = $_POST['utilisateur'];
    $motdepasse = $_POST['motdepasse'];

    if (!empty($nom) && !empty($utilisateur) && !empty($motdepasse)) {
        $update = $con->prepare("UPDATE admincompte SET id = :nom, admin = :utilisateur, mdp = :motdepasse WHERE idadmin = :idcompte");
        $update->bindParam(':idcompte', $idcompte);
        $update->bindParam(':nom', $nom);
        $update->bindParam(':utilisateur', $utilisateur);
        $update->bindParam(':motdepasse', $motdepasse);
        $update->execute();

        if ($update) {
            // echo "<script>alert('Modifié');</script>";
                header("location:admin.php");
                // Popup Success
        } else {
            echo "<script>alert('Non modifié');</script>";
        }
    } else {
        echo "<script>alert('Entrez toutes les données');</script>";
    }

}

?>



