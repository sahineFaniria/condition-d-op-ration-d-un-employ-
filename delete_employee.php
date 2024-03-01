<?php
require 'connection.php';
// supprimer employe
if (isset($_POST['ide'])) {
    $employeeId = $_POST['ide'];
    $sql = "DELETE FROM employe WHERE id = :employeeId";

    $stmt = $con->prepare($sql);
    $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Employee deleted successfully.";
    } else {
        echo "Failed to delete employee.";
    }
} else {
    echo "Invalid request.";
}

// supprimer condition
if (isset($_POST['idt'])) {
    $conditionId = $_POST['idt'];
    $sql = "DELETE FROM travail WHERE idCondition = :conditionId";

    $stmt = $con->prepare($sql);
    $stmt->bindParam(':conditionId', $conditionId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Condition deleted successfully.";
    } else {
        echo "Failed to delete condition.";
    }
} else {
    echo "Invalid request.";
}


// supprimer condition
if (isset($_POST['idp'])) {
    $planId = $_POST['idp'];
    $sql = "DELETE FROM plan WHERE idPlan = :planId";

    $stmt = $con->prepare($sql);
    $stmt->bindParam(':planId', $planId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Plan deleted successfully.";
    } else {
        echo "Failed to delete Plan.";
    }
} else {
    echo "Invalid request.";
}

// supprimer Compte utilisateur
if (isset($_POST['ido'])) {
    $compteId = $_POST['ido'];
    $sql = "DELETE FROM usercompte WHERE idCompte = :compteId";

    $stmt = $con->prepare($sql);
    $stmt->bindParam(':compteId', $compteId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Plan deleted successfully.";
    } else {
        echo "Failed to delete Plan.";
    }
} else {
    echo "Invalid request.";
}

// supprimer Compte utilisateur
if (isset($_POST['ida'])) {
    $adminId = $_POST['ida'];
    $sql = "DELETE FROM admincompte WHERE idadmin = :adminId";

    $stmt = $con->prepare($sql);
    $stmt->bindParam(':adminId', $adminId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Plan deleted successfully.";
    } else {
        echo "Failed to delete Plan.";
    }
} else {
    echo "Invalid request.";
}

// supprimer image evidence
if (isset($_GET['id'])) {
    $idEvidence = $_GET['id'];
    // Inclure la page connexion
    include_once "connection.php";
    $sql = "DELETE FROM evidence WHERE idEvidence = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $idEvidence, PDO::PARAM_INT);
    $stmt->execute();
    // Redirection vers la page liste.php
    header("location:evidence1.php");
}
?>




