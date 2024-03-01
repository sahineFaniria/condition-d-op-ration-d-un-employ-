<?php
session_start();
if(!isset($_SESSION['admin_username'])){
    header("location: index.php");
    exit;
}

// Vérifier si l'utilisateur a cliqué sur le lien de déconnexion
if (isset($_GET['logout'])) {
    // Détruire la session
    session_destroy();
    
    // Rediriger l'utilisateur vers une page de connexion ou autre
    header("Location: index.php");
    exit;
}

include("connection.php");

if (isset($_POST['enregistrer'])) {
    $nom = $_POST['nom'];
    $utilisateur = $_POST['utilisateur'];
    $motdepasse = $_POST['motdepasse'];

    if (!empty($nom) && !empty($utilisateur) && !empty($motdepasse)) {
        $insert = $con->prepare("INSERT INTO admincompte(id, admin, mdp) VALUES(:nom, :utilisateur, :motdepasse)");
        $insert->bindParam(':nom', $nom);
        $insert->bindParam(':utilisateur', $utilisateur);
        $insert->bindParam(':motdepasse', $motdepasse);
        $insert->execute();
               
        if ($insert) {

                header("location:admin.php");
               
                // Popup Success

               
           
        } else {
            echo "<script>alert('Non enregistré');</script>";
        }
    } else {
        echo "<script>alert('Entrez toutes les données');</script>";
        header("location:compte.php");
    }
}

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
    <!-- Popup ajout -->
    <div class="popup" id="myModal">
        <div class="up">
            <div class="popup-close"><i class="ri-close-fill"></i></div>
            <h3>Compte utilisateur</h3>
            <div class="popup-input">
                <form action="#" class="form" method ="post">

                    <div class="form-divi">
                        <div class="form-div">
                            <select class name="nom">

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
                            <label for="nom" class="form-lab">Nom</label>
                        </div>
                        <div class="form-div">
                            <input type="text" class="form-input" placeholder="" name="utilisateur" >
                            <label for="" class="form-label">Nom utilisateur</label>
                        </div>
                    </div>

                    
                    <div class="form-div">
                        <input type="text" class="form-input" placeholder="" name="motdepasse" >
                        <label for="" class="form-label">Mot de passe</label>
                    </div>
                    
                    <button class="form-btn" name="enregistrer">Enregistrer</button>
                </form>
            </div>
        </div>

    </div>
    <!-- FIn popup ajou -->

    <!-- popup modifier -->
    <div class="popup1" id="myModal">
        <div class="up">
            <div class="popup-close"><i class="ri-close-fill"></i></div>
            <h3>Compte utilisateur</h3>
            <div class="popup-input">
                <form action="update_employee.php" class="form" method ="post">
                    <input type="hidden" name="idadmin" value="<?php echo $adminId; ?>">
                    <div class="form-divi">
                        <div class="form-div">
                            <select class name="nom">

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
                            <label for="nom" class="form-lab">Nom</label>
                        </div>
                        <div class="form-div">
                            <input type="text" class="form-input" placeholder="" name="utilisateur" >
                            <label for="" class="form-label">Nom utilisateur</label>
                        </div>
                    </div>

                    
                    <div class="form-div">
                        <input type="text" class="form-input" placeholder="" name="motdepasse" >
                        <label for="" class="form-label">Mot de passe</label>
                    </div>
                    
                    <button class="form-btn" name="modfi">Enregistrer</button>
                </form>
            </div>
        </div>

    </div>
    <!-- fin popup modfier -->

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
            <li><a href="condition.php"><i class="ri-creative-commons-nd-fill"></i>Opération</a></li>
            <li><a href="Employe.php"><i class="ri-shield-user-fill"></i>Employé</a></li>
            <li><a href="Plan.php"><i class="ri-global-fill"></i>Planning</a></li>
            <li><a href="evidence1.php"><i class="ri-folder-chart-2-fill"></i>Evidence</a></li>
        </ul>

        <ul class="dec">
            <div class="divCompte">
                <a href="admin.php" class="vue acti"><i class="ri-admin-line"></i>Admin</a></l>
                <a href="compte.php" class="vue"><i class="ri-user-line"></i></i>Utilisateur</a></l>
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

                <a class="report" href="condition.php?openModal=true">
                    <i class="ri-shake-hands-fill"></i>
                    <span>Ajout condition +</span>
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
                        <h3>Gérer compte administrateur</h3>
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
                                <!-- <td>Profile</td> -->
                                <td>Nom</td>
                                <th>Nom administrateur</th>
                                <td class="end">Mot de passe</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql = "SELECT r.idadmin, p.nom, r.admin, r.mdp FROM admincompte r join employe p on (p.id = r.id)";
                            try {
                                $stmt = $con->query($sql);
                                
                                while ($row = $stmt->fetch()) {
                                    echo "
                                     <tr data-id='" . $row['idadmin'] . "'>
                                    <td>" . $row['nom'] . "</td>
                                    <td>" . $row['admin'] . "</td>
                                    <td>" . $row['mdp'] . "</td>
                                    </tr>
                                 ";
                                }
                            } catch (PDOException $e) {
                                die("Erreur de requête : " . $e->getMessage());
                            }
                        ?>  
                            
                            <!-- <tr>
                                <td><img src="image/sahine3.JPG" alt="" class="imgPro"></td>
                                <td>Nere</td>
                                <td>Nere199</td>
                                <td>nere2023@@</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                
        </div>
        <!-- fin main -->

        
        
   </div>
    



    <script src="js/script.js"></script>
    <script src="jquery-3.7.1.min.js"></script>
    <script>



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
            // Toggle
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
                    visibleRow.style.background = (i % 2 == 0) ?   '#0000000b' : 'transparent';
                })
            }



            // Jquery
            $(document).ready(function(){

                $(".ajou").click(function(){
                    $(".popup").addClass("open-popup");
                });
                $(".popup-close").click(function(){
                    $(".popup").removeClass("open-popup");
                    $(".popup1").removeClass("open-popup1");
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
                    var adminId = selectedRow.data("id");
        
                    if (adminId) {
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
                    var adminId = selectedRow.data("id");
        
                    // Masquer la modal
                    var modalSup = document.getElementById('modalConf');
                    modalSup.style.display = 'none';
        
                    // Envoyer la requête AJAX pour supprimer la condition
                    $.ajax({
                        type: "POST",
                        url: 'delete_employee.php',
                        data: { ida: adminId },
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
                    var adminId = selectedRow.data("id");

                    if (adminId) {
                        var nom = selectedRow.find("td:eq(0)").text();
                        var utilisateur = selectedRow.find("td:eq(1)").text();
                        var motdepasse = selectedRow.find("td:eq(2)").text();

                        // Remplissez les champs du formulaire de modification
                        $(".popup1 input[name='idadmin']").val(adminId);
                        
                        // Sélectionnez l'option dans la liste déroulante par nom
                        $(".popup1 select[name='nom'] option:contains('" + nom + "')").prop('selected', true);

                      
                        $(".popup1 input[name='utilisateur']").val(utilisateur);
                        $(".popup1 input[name='motdepasse']").val(motdepasse);
                            
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
                // $(".compte").click(function(){
                //     $(".voir").toggleClass("voirr");
                //     $(".ico").toggleClass("rot");
                // });


                    

            }); 


    </script>
</body>
</html>