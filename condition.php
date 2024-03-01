<?php

session_start();
if(!isset($_SESSION['admin_username'])){
    header("location: index.php");
    exit;
}
//DECONNEXION
// Vérifier si l'utilisateur a cliqué sur le lien de déconnexion
if (isset($_GET['logout'])) {
    // Détruire la session
    session_destroy();
    
    // Rediriger l'utilisateur vers une page de connexion ou autre
    header("Location: index.php"); // Remplacez "index.php" par la page de votre choix
    exit;
}
//fin DECONNEXION

require './connection.php';

if (isset($_POST['enregistrer'])) {
    $email = $_POST['email'];
    $validite = $_POST['validite'];
    $debut = $_POST['debut'];
    $fin = $_POST['fin'];
    $type = $_POST['type'];
    $statut = $_POST['statut'];
    $evidence = $_POST['evidence'];

    if (!empty($email) && !empty($validite) && !empty($debut) && !empty($fin) && !empty($type) && !empty($statut) && !empty($evidence)) {
        $insert = $con->prepare("INSERT INTO travail(id, valTemp, dateDebut, dateFin, type, statut, evidence) VALUES(:email, :validite, :debut, :fin, :type, :statut, :evidence)");
        $insert->bindParam(':email', $email);
        $insert->bindParam(':validite', $validite);
        $insert->bindParam(':debut', $debut);
        $insert->bindParam(':fin', $fin);
        $insert->bindParam(':type', $type);
        $insert->bindParam(':statut', $statut);
        $insert->bindParam(':evidence', $evidence);
        $insert->execute();
               
        if ($insert) {

                header("location:condition.php");
               
                // Popup Success

           
        } else {
            echo "<script>alert('Non enregistré');</script>";
        }
    } else {
        echo "<script>alert('Entrez toutes les données');</script>";
        header("location:condition.php");
    }
}

// Suppression automatique de l'employé operationelle lorsque la date d'expiration est atteinte.

// $today = date("Y-m-d"); 



$today = date("Y-m-d"); 

// Supprimez directement les enregistrements expirés
$query = $con->prepare("DELETE FROM travail WHERE DATE(dateFin) < :today");
$query->bindParam(':today', $today);
$query->execute();

$querySituation = $con->prepare("DELETE FROM situation WHERE id IN (
    SELECT s.id FROM situation s
    LEFT JOIN travail t ON s.id = t.id
    WHERE t.id IS NULL
)");
$querySituation->execute();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin1.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>Administrateur</title>
</head>
<body>
    <!-- popup ajou -->
    <div class="popup" id="myModal">
        <div class="up">
            <div class="popup-close"><i class="ri-close-fill"></i></div>
            <h3>Condition d'opération</h3>
            <div class="popup-input">
                <form action="#" class="form" method ="post">

                    <div class="form-divi">
                        <div class="form-div">
                            <select class name="email">

                            <?php
                                // $sql = "SELECT nom FROM employe";
                                $sql = "SELECT id, nom FROM employe";

                                try {
                                    $stmt = $con->query($sql);
                                    
                                    while ($row = $stmt->fetch()) {
                                    //     echo "
                                    //     <option>" . $row['nom'] . "</option>
                                    //  ";
                                    echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
                                    }
                                } catch (PDOException $e) {
                                    die("Erreur de requête : " . $e->getMessage());
                                }
                            ?>  

                                
                            
                            </select>
                            <label for="email" class="form-lab">Nom</label>
                        </div>
                        <div class="form-div">
                            <input type="text" class="form-input" placeholder="" name="validite">
                            <label for="" class="form-label">Validite Temporel</label>
                        </div>
                    </div>
                    

                    <div class="form-divi">
                        <div class="form-div">
                            <label for="" class="form-label lab">Date debut</label>
                            <input type="date" class="form-input" placeholder="" name="debut">
                        </div>
                        <div class="form-div">
                            <label for="" class="form-label lab">Date fin</label>
                            <input type="date" class="form-input" placeholder="" name="fin">
                        </div>
                    </div>

                    <div class="form-divi">
                        <div class="form-div">
                            <select class name="type">
                            <option value="Développeur">Développeur</option>
                            <option value="Chauffeur">Chauffeur</option>
                            <option value="Formateur">Formateur</option>
                            <option value="Secrétaire">Secrétaire</option>
                            <option value="Gérant">Gérant</option>
                            <option value="réseau">Admin réseau</option>
                            <option value="Designer">Designer</option>

                            </select>
                            <label for="" class="form-lab">Type</label>
                        </div>
                        <div class="form-div">
                            <input type="text" class="form-input" placeholder="" name="statut">
                            <label for="" class="form-label">Status</label>
                        </div>

                    </div>
                    
                    <div class="form-div">
                        <input type="text" class="form-input" placeholder="" name="evidence">
                        <label for="" class="form-label">Evidence</label>
                    </div>
                    
                    <button class="form-btn" name="enregistrer">Enregistrer</button>
                </form>
            </div>
        </div>

    </div>
    <!-- popup ajou -->


    <!-- popup modifier -->
    <div class="popup1" id="myModal">
        <div class="up">
            <div class="popup-close"><i class="ri-close-fill"></i></div>
            <h3>Condition d'opération</h3>
            <div class="popup-input">
            <form action="update_employee.php" class="form" method="post" id="editForm">
                <input type="hidden" name="idc" value="<?php echo $conditionId; ?>">
                <div class="form-divi">
                    <div class="form-div">
                    <label for="email" class="form-lab lab">Nom</label>
                        <select class name="email">
                        <?php
                            $sql = "SELECT id, nom FROM employe";

                            try {
                                $stmt = $con->query($sql);
                                
                                while ($row = $stmt->fetch()) {
                                    // echo "
                                    // <option>" . $row['nom'] . "</option>
                                    // ";
                                    echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
                                }
                            } catch (PDOException $e) {
                                die("Erreur de requête : " . $e->getMessage());
                            }
                        ?>  
                        </select>
                        
                    </div>
                    <div class="form-div">
                        <label for="" class="form-label lab">Validite Temporel</label>
                        <input type="text" class="form-input" placeholder="" name="validite">
                        
                    </div>
                </div>
                    

                <div class="form-divi">
                    <div class="form-div">
                        <label for="" class="form-label lab">Date debut</label>
                        <input type="date" class="form-input" placeholder="" name="debut">
                    </div>
                    <div class="form-div">
                        <label for="" class="form-label lab">Date fin</label>
                        <input type="date" class="form-input" placeholder="" name="fin">
                    </div>
                </div>

                <div class="form-divi">
                    <div class="form-div">
                        <select class name="type">
                        <option value="Développeur">Développeur</option>
                        <option value="Chauffeur">Chauffeur</option>
                        <option value="Formateur">Formateur</option>
                        <option value="Secrétaire">Secrétaire</option>
                        <option value="Gérant">Gérant</option>
                        <option value="réseau">Admin réseau</option>
                        <option value="Designer">Designer</option>

                        </select>
                        <label for="" class="form-lab">Type</label>
                        
                    </div>
                    <div class="form-div">
                        <label for="" class="form-label lab">Status</label>
                        <input type="text" class="form-input" placeholder="" name="statut">
                        
                    </div>
                </div>
                    
                    <div class="form-div">
                        <label for="" class="form-label lab">Evidence</label>
                        <input type="text" class="form-input" placeholder="" name="evidence">
                        
                    </div>
                    
                    <button class="form-btn" name="modifie">Modifier</button>
                </form>
            </div>
        </div>

    </div>
    <!-- fin popup modfier -->

    <!-- popup details -->
    <div class="popup2">
        <div class="up">
            <div class="popup-close"><i class="ri-close-fill"></i></div>
            <h3>Condition d'operation</h3>
            <div class="popup-input">
                
                   
            </div>
            <div class="butn">
                <button class="copie"><i class="ri-file-copy-2-line"></i>Copie</button>
            </div>
        </div>
    </div>
    <!-- fin popup details -->

    <!-- popup aucun selection modification -->
    <div class="popMod" id="modalMod">
        <div class="upMod">
            <img src="image/logo-horizontal.png" alt="" class="logoSmall">
            <h5 class="alertUp">Veuillez sélectionner un employé à modifier.</h5>
            <button class="ok">OK</button>
        </div>
    </div>
    <!-- fin popup aucun selection modification -->

    <!-- popup aucun selection suppression -->
    <div class="popMod" id="modalSup">
        <div class="upMod">
            <img src="image/logo-horizontal.png" alt="" class="logoSmall">
            <h5 class="alertUp">Veuillez sélectionner une condition à supprimer.</h5>
            <button class="ok">OK</button>
        </div>
    </div>
    <!-- fin popup aucun selection suppression -->

    <!-- popup confirmation -->
    <div class="popConf" id="modalConf">
        <div class="upConf">
            <img src="image/logo-horizontal.png" alt="" class="logoSmall">
            <h5 class="alertUp">Voulez-vous vraiment supprimer cette condition ?</h5>
            <div class="btnConf">
                <button class="okk">OK</button>
                <button class="annuler">Annuler</button>
            </div>
            
        </div>
    </div>
    <!-- fin popup confirmation -->

    <!-- popup deconnection -->
    <div class="popConf" id="modalDeco">
        <div class="upConf">
            <img src="image/logo-horizontal.png" alt="" class="logoSmall">
            <h5 class="alertUp">Voulez-vous vraiment vous déconnecter ?</h5>
            <div class="btnConf">
                <button class="okk" id="btnConfOK">OK</button>
                <button class="annuler" id="btnConfAnnuler">Annuler</button>
            </div>
        </div>
    </div>
    <!-- fin popup deconnection -->
    

   <!-- Navigation -->
   <div class="navigation">
        <a href="#" class="logo">
            <img src="image/logo.png" alt="">
            <div class="nom-logo"><span>TAKA</span>LOU</div>
        </a>
        <ul class="menu">
            <li><a href="admin1.php"><i class="ri-home-3-fill"></i>Accueil</a></li>
            <li class="active"><a href="#"><i class="ri-creative-commons-nd-fill"></i>Opération</a></li>
            <li><a href="Employe.php"><i class="ri-shield-user-fill"></i>Employé</a></li>
            <li><a href="Plan.php"><i class="ri-global-fill"></i>Planning</a></li>
            <li><a href="evidence1.php"><i class="ri-folder-chart-2-fill"></i>Evidence</a></li>
        </ul>

        <ul class="dec">
            <div class="divCompte">
                <a href="admin.php" class="voir"><i class="ri-admin-line"></i>Admin</a></l>
                <a href="compte.php" class="voir"><i class="ri-user-line"></i></i>Utilisateur</a></l>
            </div>

            <li class="compte"><a href="#"><i class="ri-arrow-up-s-fill ico"></i>Gérer compte</a></li>
            <li>
                <a href="#" class="deconnect" id="deco">
                    <i class="ri-logout-circle-line"></i>
                    Déconnecter
                </a>
            </li>
        </ul>
   </div>

   <!-- Content -->
   <div class="content">
        <!-- navbar -->
        <nav>
            <i id="top" class="ri-menu-3-line bx"></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="search...">
                    <button class="search-btn" type="submit"><i class="ri-search-line"></i></button>
                </div>
            </form>
            <input type="checkbox" id="theme-toggle" hidden>
            <label for="theme-toggle" class="theme-toggle"></label>
            <a href="#" class="notif">
                <i class="ri-loader-2-line"></i>
                <span class="count"></span>
            </a>
            <a href="#" class="profile">
                <?php
                include("connection.php");
                if ($_SESSION['admin_username']) {
                    $user = $_SESSION['admin_username'];
                    $query = $con->prepare("SELECT e.nom FROM employe e JOIN admincompte a ON (e.id = a.id) WHERE a.admin = :ide");
                    $query->bindParam(":ide", $user);
                    $query->execute();
                    $nom = $query->fetch(PDO::FETCH_ASSOC);
                    $nam = $nom["nom"];
                    echo "<i class='ri-account-circle-line tooltip1' data-title='Admin: $nam'></i>";
                }
                ?>
            </a>
        </nav>
        <!-- fin navbar -->

        <!-- Main -->
        <div class="main">
            <div class="head">
                <div class="left">
                    <h2>Gestion d'opération</h2>
                    <ul class="list">
                        <li>
                            <a href="#">
                                Gestion
                            </a>
                        </li>
                        /
                        <li>
                            <a href="#" class="active">
                                Analytique
                            </a>
                        </li>
                    </ul>
                </div>

                <a class="report">
                    <i class="ri-shake-hands-fill"></i>
                    <span class="ajou">Ajout condition +</span>
                </a>
            </div>

            <!-- Nombre -->
            <ul class="list-nombre">
                <li>
                    <i class="ri-user-3-fill"></i>
                    <span class="info">
                    <?php
                        // Inclure la page de connexion à la base de données
                        include "connection.php";

                        try {
                            // Préparer et exécuter la requête SQL pour compter le nombre total d'employés
                            $query = $con->prepare("SELECT COUNT(*) AS totalEmployes FROM employe");
                            $query->execute();
                            
                            // Récupérer le résultat
                            $result = $query->fetch(PDO::FETCH_ASSOC);
                            
                            // Afficher le nombre total d'employés dans la balise <h3>
                            echo "<h3>" . $result['totalEmployes'] . "</h3>";
                        } catch (PDOException $e) {
                            echo "Erreur : " . $e->getMessage();
                        }
                    ?>
                        <p>Nombre Employé</p>
                    </span>
                </li>
                <li>
                    <i class="ri-user-star-fill"></i>
                    <span class="info">
                    <?php
                        // Inclure la page de connexion à la base de données
                        include "connection.php";

                        try {
                            // Préparer et exécuter la requête SQL pour compter le nombre total d'employés
                            $query = $con->prepare("SELECT  COUNT(DISTINCT employe.id) AS totalOperationnelle
                            FROM employe
                            LEFT JOIN travail ON employe.id = travail.id
                            WHERE travail.id ;
                            ");
                            $query->execute();

                            // Récupérer le résultat
                            $result = $query->fetch(PDO::FETCH_ASSOC);
                            
                            // Afficher le nombre total d'employés dans la balise <h3>
                            echo "<h3>" . $result['totalOperationnelle'] . "</h3>";
                        } catch (PDOException $e) {
                            echo "Erreur : " . $e->getMessage();
                        }
                    ?>
                        <p>opérationelle</p>
                    </span>
                </li>
                <li>
                    <i class="ri-user-forbid-fill"></i>
                    <span class="info">
                    <?php
                            // Inclure la page de connexion à la base de données
                            include "connection.php";

                            try {
                                // Préparer et exécuter la requête SQL pour compter le nombre total d'employés

                                $query = $con->prepare("SELECT COUNT(employe.id) AS totalNonOperationnelle FROM employe LEFT JOIN travail ON employe.id = travail.id WHERE travail.id IS NULL;");
                                $query->execute(); 
                                 
                                // Récupérer le résultat
                                $result = $query->fetch(PDO::FETCH_ASSOC);
                                $total = $result['totalNonOperationnelle'];
                                
                                // Afficher le nombre total d'employés dans la balise <h3>
                                echo "<h3>" . $total . "</h3>";
                            } catch (PDOException $e) {
                                echo "Erreur : " . $e->getMessage();
                            }
                    ?>
                    <p>non-opérationelle</p>
                    </span>
                </li>
                <li>
                    <i class="ri-global-fill"></i>
                    <span class="info">
                    <?php
                        // Inclure la page de connexion à la base de données
                        include "connection.php";

                        try {
                            // Préparer et exécuter la requête SQL pour compter le nombre total d'employés
                            $query = $con->prepare("SELECT COUNT(*) AS totalPlanning FROM plan");
                            $query->execute();
                            
                            // Récupérer le résultat
                            $result = $query->fetch(PDO::FETCH_ASSOC);
                            
                            // Afficher le nombre total d'employés dans la balise <h3>
                            echo "<h3>" . $result['totalPlanning'] . "</h3>";
                        } catch (PDOException $e) {
                            echo "Erreur : " . $e->getMessage();
                        }
                    ?>
                        <p>Planning</p>
                    </span>
                </li>
            </ul>

            <!-- Ordre -->
            <!-- <div class="details"> -->
                <div class="recent">
                    <div class="header">
                        <!-- <i class="ri-global-fill"></i> -->
                        <h3>Condition d'opération</h3>
                        <div class="">
                            <button class="btns ajou" id="ajou">Ajouter</button>
                            <button class="btns mod">Modifier</button>
                            <button class="btns sup">Supprimer</button>
                        </div>
                        <!-- <i class="ri-global-fill"></i>
                        <i class="ri-global-fill"></i> -->
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Nom</td>
                                <th>Type</th>
                                <th>Début</th>
                                <th>Fin</th>
                                <th>Validité</th>
                                <th>Evidence</th>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql = "SELECT r.idCondition, p.nom, r.type, r.dateDebut, r.dateFin, r.valTemp, r.evidence, r.statut FROM travail r join employe p on (p.id = r.id)";
                            try {
                                $stmt = $con->query($sql);
                                
                                while ($row = $stmt->fetch()) {
                                    echo "
                                     <tr data-id='" . $row['idCondition'] . "'>
                                    <td>" . $row['nom'] . "</td>
                                    <td>" . $row['type'] . "</td>
                                    <td>" . $row['dateDebut'] . "</td>
                                    <td>" . $row['dateFin'] . "</td>
                                    <td>" . $row['valTemp'] . "</td>
                                    <td>" . $row['evidence'] . "</td>
                                    <td>" . $row['statut'] . "</td>
                                    </tr>
                                 ";
                                }
                            } catch (PDOException $e) {
                                die("Erreur de requête : " . $e->getMessage());
                            }
                        ?>  
                        </tbody>
                    </table>
                </div>
                
        </div>
        <!-- fin main -->

        
        
   </div>
    



    <script src="js/script.js"></script>
    <script src="jquery-3.7.1.min.js"></script>
    

    <script>

//DETAILS

    document.addEventListener('DOMContentLoaded', function () {
        // ...
        // Récupérez toutes les lignes du tableau
        var lignesTableau = document.querySelectorAll('tbody tr');
        lignesTableau.forEach(function (ligne) {
            ligne.addEventListener('dblclick', function () {
                // Récupérez les données de la ligne
                var nom = ligne.querySelector('td:nth-child(1)').innerText;
                var type = ligne.querySelector('td:nth-child(2)').innerText;
                var dateDebut = new Date(ligne.querySelector('td:nth-child(3)').innerText);
                var dateFin = new Date(ligne.querySelector('td:nth-child(4)').innerText);
                var valTemp = ligne.querySelector('td:nth-child(5)').innerText;
                var evidence = ligne.querySelector('td:nth-child(6)').innerText;
                var status = ligne.querySelector('td:nth-child(6)').innerText;

                // Calculer la différence en jours entre les deux dates
                var differenceEnMillis = dateFin.getTime() - dateDebut.getTime();
                var differenceEnJours = Math.floor(differenceEnMillis / (1000 * 60 * 60 * 24));

                // Remplissez le popup modal avec les données
                var popup = document.querySelector('.popup2');
                var popupInput = popup.querySelector('.popup-input');
                popupInput.innerHTML = `
                <p>NOM: ${nom}</p>
                <p>TYPE: ${type}</p>
                <p>DEBUT: ${dateDebut.toDateString()}</p>
                <p>FIN: ${dateFin.toDateString()}</p>
                <p>VALIDITE: ${valTemp}</p>
                <p>EVIDENCE: ${evidence}</p>
                <p>STATUS: ${status}</p>
                <p>RESTE DE JOURS: <span class='red-text'>${differenceEnJours}</span> jours</p>
            `;


                // Affichez le popup modal
                popup.classList.add('open-popup2');
            });
        });

        var popupClose = document.querySelector('.popup-close');
        popupClose.addEventListener('click', function () {
            var popup = document.querySelector('.popup2');
            popup.classList.remove('open-popup2');
        });

        var boutonCopie = document.querySelector('.copie');
        boutonCopie.addEventListener('click', function () {
            var popupInput = document.querySelector('.popup2 .popup-input');
            var boutonCopieIcone = boutonCopie.querySelector('i');

            // Créez une zone de texte temporaire
            var textarea = document.createElement('textarea');
            textarea.value = popupInput.textContent;
            document.body.appendChild(textarea);

            // Sélectionnez et copiez le texte
            textarea.select();
            document.execCommand('copy');

            // Supprimez la zone de texte temporaire
            document.body.removeChild(textarea);

            // Modifiez le texte et la couleur du bouton
            boutonCopie.innerHTML = '<i class="ri-check-line"></i>Copiée';
            boutonCopie.style.backgroundColor = 'red';

            setTimeout(function () {
                var popup = document.querySelector('.popup2');
                popup.classList.remove('open-popup2');
                boutonCopie.innerHTML = '<i class="ri-file-copy-2-line"></i>Copie';
                boutonCopie.style.backgroundColor = ''; // Réinitialisez la couleur de fond
            }, 3000);
        });

        // ...
    });

//DETAILS




    // DECONNEXION

    document.addEventListener('DOMContentLoaded', function () {
        // Récupérez la référence du bouton de déconnexion
        var btnDeconnexion = document.getElementById('deco');

        // Récupérez la référence de la popup
        var modalDeco = document.getElementById('modalDeco');

        // Récupérez la référence des boutons OK et Annuler de la popup
        var btnConfOK = document.getElementById('btnConfOK');
        var btnConfAnnuler = document.getElementById('btnConfAnnuler');

        // Ajoutez un écouteur d'événement sur le bouton de déconnexion pour afficher la popup
        btnDeconnexion.addEventListener('click', function (e) {
            e.preventDefault(); // Empêcher la redirection immédiate

            modalDeco.style.display = 'block';
        });

        // Ajoutez un écouteur d'événement sur le bouton OK pour masquer la popup et effectuer la déconnexion
        btnConfOK.addEventListener('click', function () {
            // Ajoutez ici le code de déconnexion
            window.location.href = '?logout'; // Redirection vers la déconnexion
        });

        // Ajoutez un écouteur d'événement sur le bouton Annuler pour masquer la popup
        btnConfAnnuler.addEventListener('click', function () {
            modalDeco.style.display = 'none';
        });
    });


    // FIN DECONNECTION






        const navi = document.querySelectorAll('.navigation .menu li a:not(.deconnect)');

            navi.forEach(item =>{
                const li = item.parentElement;
                item.addEventListener('click', () =>{
                    navi.forEach(i =>{
                        i.parentElement.classList.remove('active');
                    })
                    li.classList.add('active');
                })
            });

            const menuBar = document.querySelector('.content nav .bx');
            const sideBar = document.querySelector('.navigation');

            menuBar.addEventListener('click', () =>{
                sideBar.classList.toggle('close');
            });

            const searchBtn = document.querySelector('.content nav form .form-input button');
            const searchBtnIcon = document.querySelector('.content nav form .form-input button .bx');
            const searchForm = document.querySelector('.content nav form');

            searchBtn.addEventListener('click', function(e){
                if(window.innerWidth < 576){
                    e.preventDefault;
                    searchForm.classList.toggle('show');
                    if(searchForm.classList.contains('show')){
                        searchBtnIcon.classList.replace('bx-search', 'bx-x');
                    }else{
                        searchBtnIcon.classList.replace('bx-x', '.bx-search');
                    }
                }
            });

            window.addEventListener('resize', ()=>{
                if(window.innerWidth < 768){
                    navi.classList.add('close');
                }else{
                    navi.classList.remove('close');
                }
                if(window.innerWidth > 576){
                    searchBtnIcon.classList.replace('bx-x', 'bx-search');
                    searchForm.classList.remove('show');
                }
            });

            // oooooooooo MODE SOMBRE ooooooooooo //
            const toggler = document.getElementById('theme-toggle');
            const body = document.body;

            // Vérifie s'il existe une valeur dans le stockage local pour le mode sombre
            const isDarkMode = localStorage.getItem('darkMode');

            // Si le mode sombre est activé dans le stockage local, mettez la classe "dark" sur le corps
            if (isDarkMode === 'true') {
                body.classList.add('dark');
                toggler.checked = true;
            }

            // Ajoutez un gestionnaire d'événements au commutateur
            toggler.addEventListener('change', function () {
                if (this.checked) {
                    body.classList.add('dark');
                    localStorage.setItem('darkMode', 'true'); // Stocke l'état du mode sombre
                } else {
                    body.classList.remove('dark');
                    localStorage.setItem('darkMode', 'false'); // Stocke l'état du mode clair
                }
            });
            // oooooooooo MODE SOMBRE ooooooooooo //

            // RECHERCHE
            const search = document.querySelector('.form-input input'),
                  tableRow =document.querySelectorAll('tbody tr');

            search.addEventListener('input', searchTable);

            function searchTable(){
                tableRow.forEach((row, i)=>{
                    let tableData = row.textContent.toLowerCase(),
                        searchData = search.value.toLowerCase();

                        row.classList.toggle('hd', tableData.indexOf(searchData)< 0);
                        row.style.setProperty('--delay', i / 25 + 's')

                });

                document.querySelectorAll('tbody tr:not(.hd)').forEach((visibleRow, i)=>{
                    visibleRow.style.background = (i % 2 == 0) ? 'transparent' : '#0000000b';
                })
            }


            //lien direct : Ajout de condition
            document.addEventListener('DOMContentLoaded', function () {
                const urlParams = new URLSearchParams(window.location.search);
                const openModal = urlParams.get('openModal');
                if (openModal === 'true') {
                    // Ouvrir le modal en ajoutant la classe "open-popup"
                    const modal = document.getElementById('myModal');
                    modal.classList.add('open-popup');
                }
            });



            
    // Jquery
    $(document).ready(function(){

        $(".ajou").click(function(){
            $(".popup").addClass("open-popup");
        });
        $(".popup-close").click(function(){
            $(".popup").removeClass("open-popup");
            $(".popup1").removeClass("open-popup1");
            $(".popup2").removeClass("open-popup2");
        });
        
        
        

        //click tableau

        $('tr').click(function() {
            // Retirez la classe "selected" de toutes les lignes
            $('tr').removeClass('cli');

            // Ajoutez la classe "selected" à la ligne cliquée
            $(this).addClass('cli');
        });


    
        
        var selectedRow;
            
        // Gérer le clic sur le bouton de suppression
        $(".sup").click(function () {
            selectedRow = $("tr.selected");
            var conditionId = selectedRow.data("id");

            if (conditionId) {
                // Afficher la modal
                var modalSup = document.getElementById('modalConf');
                modalSup.style.display = 'block';
            } else {
                var succesPopup = document.getElementById('modalSup');
                succesPopup.style.display = 'block';
            }
        });

        // Gérer le clic sur le bouton "OK" dans la modal
        $(".okk").click(function () {
            // Récupérer l'ID de la condition à supprimer
            var conditionId = selectedRow.data("id");

            // Masquer la modal
            var modalSup = document.getElementById('modalConf');
            modalSup.style.display = 'none';

            // Envoyer la requête AJAX pour supprimer la condition
            $.ajax({
                type: "POST",
                url: 'delete_employee.php',
                data: { idt: conditionId },
                success: function (reponse) {
                    console.log(reponse);
                    selectedRow.remove(); // Supprimer la ligne sélectionnée
                }
            });
        });

        // Gérer le clic sur le bouton "Annuler" dans la modal
        $(".annuler").click(function () {
            // Masquer la modal
            var modalSup = document.getElementById('modalConf');
            modalSup.style.display = 'none';
        });
        

        // Ajoutez une classe "selected" lors du clic sur une ligne du tableau
        $('tr').click(function () {
            // Retirez la classe "selected" de toutes les lignes
            $('tr').removeClass('selected');

            // Ajoutez la classe "selected" à la ligne cliquée
            $(this).addClass('selected');
        });
        // Fin Selection du bouton supprimer

        // Gestionnaire pour le bouton "Modifier"
        $(".mod").click(function () {

            var selectedRow = $("tr.cli");
            var conditionId = selectedRow.data("id");

            if (conditionId) {
                var nom = selectedRow.find("td:eq(0)").text();
                var type = selectedRow.find("td:eq(1)").text();
                var debut = selectedRow.find("td:eq(2)").text();
                var fin = selectedRow.find("td:eq(3)").text();
                var validite = selectedRow.find("td:eq(4)").text();
                var evidence = selectedRow.find("td:eq(5)").text();
                var statut = selectedRow.find("td:eq(6)").text();

                // Remplissez les champs du formulaire de modification
                $(".popup1 input[name='idc']").val(conditionId);
                
                // Sélectionnez l'option dans la liste déroulante par nom
                $(".popup1 select[name='email'] option:contains('" + nom + "')").prop('selected', true);
    
                $(".popup1 select[name='type']").val(type);
                $(".popup1 input[name='debut']").val(debut);
                $(".popup1 input[name='fin']").val(fin);
                $(".popup1 input[name='validite']").val(validite);
                $(".popup1 input[name='evidence']").val(evidence);
                $(".popup1 input[name='statut']").val(statut);
                    
                // Ouvrez la boîte de dialogue de modification
                $(".popup1").addClass("open-popup1");
                } 
                else {
                    var succesPopup = document.getElementById('modalMod');
                    succesPopup.style.display = 'block';

            // alert("Veuillez sélectionner un employé à modifier.");
            }

            });
            $('tr').click(function () {
                // Retirez la classe "selected" de toutes les lignes
                $('tr').removeClass('cli');

                // Ajoutez la classe "selected" à la ligne cliquée
                $(this).addClass('cli');
            });

            //  Fin Gestionnaire pour le bouton "Modifier"   

            // ok
            $(".ok").click(function(){
                    $(".popMod").hide();
            });
            
            //Gerer Compte
            $(".compte").click(function(){
                    $(".voir").toggleClass("voirr");
                    $(".ico").toggleClass("rot");
            });

            

        });
    </script>
</body>
</html>