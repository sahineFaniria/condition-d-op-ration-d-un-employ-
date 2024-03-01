<?php

session_start();
if(!isset($_SESSION['user_id'])){
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

// Vérifier si les données sont envoyées
if (isset($_POST['envoyer'])) {
    // Vérifier si une image et du texte ont été choisis
    if (!empty($_FILES['image']) && isset($_POST['idEmploye'])) {
        // Récupérer le nom de l'image
        $img_nom = $_FILES['image']['name'];

        // Définir un nom temporaire
        $tmp_nom = $_FILES['image']['tmp_name'];

        // Obtenir l'heure actuelle
        $time = time();

        // Renommer l'image en utilisant la formule : heure + nom de l'image (pour avoir des noms d'images uniques)
        $nouveau_nom_img = $time . $img_nom;

        // Déplacer l'image vers un dossier appelé "image"
        $deplacer_img = move_uploaded_file($tmp_nom, "image/" . $nouveau_nom_img);

        if ($deplacer_img) {
            // Si l'image a été déplacée dans le dossier
            // Insérons le texte et le nom de l'image dans la base de données
            $ide = $_POST['idEmploye'];
            $sql = "INSERT INTO evidence (type, id) VALUES (?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(1, $nouveau_nom_img);
            $stmt->bindParam(2, $ide);
            $result = $stmt->execute();

            if ($result) {
                // Si l'insertion a réussi, rediriger vers la page liste.php
                header("location: menu.php");
            } else {
                // Si l'insertion a échoué
                $message = "Échec de l'ajout de l'image !";
            }
        } else {
            // Si le déplacement de l'image a échoué
            $message = "Veuillez choisir une image avec une taille inférieure à 1 Mo !";
        }
    } else {
        // Si les champs sont vides, afficher un message
        $message = "Veuillez remplir tous les champs";
    }
}

if (isset($_POST["sit"])) {
    $idEmploye = $_POST["idEmploye"];
    $situation = $_POST["sit"];

    // Vérifier si l'employé a déjà une situation enregistrée
    $select = $con->prepare("SELECT COUNT(*) as count FROM situation WHERE id = :idEmploye");
    $select->bindParam(':idEmploye', $idEmploye);
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    if ($row['count'] > 0) {
        // L'employé a déjà une situation enregistrée, effectuez une mise à jour
        $update = $con->prepare("UPDATE situation SET situation = :situation WHERE id = :idEmploye");
        $update->bindParam(':idEmploye', $idEmploye);
        $update->bindParam(':situation', $situation);
        $update->execute();
    } else {
        // L'employé n'a pas encore de situation enregistrée, effectuez une insertion
        $insert = $con->prepare("INSERT INTO situation (id, situation) VALUES (:idEmploye, :situation)");
        $insert->bindParam(':idEmploye', $idEmploye);
        $insert->bindParam(':situation', $situation);
        $insert->execute();
    }

    header("location: menu.php");
    // Popup Success
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/aos.css"> -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <title>Menu</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="#"><img class="img-takalou" src="image/logo-horizontal.png" alt=""></a>
        </div>

        

        <div >
            <nav class="nav" id="nav-menu">
                <a href="home.php" class="" >Accueil</a>
                <a href="apropos.php" class="">A propos</a>
                <a href="#" class="" id="on">Menu</a>
                <a href="#" class="alert-contact">Contact</a>
            </nav>
        </div>
        
        <div class="lg">
            <button class="btn-login alrt"><a href="#" id="deco">Déconnecter</a></button>
            <i class="ri-menu-3-line menu" id="header-menu"></i>
        </div>
    </header>

    <!-- Dropdown -->
        <div class="dropdown">
            <i class="ri-close-line cl" ></i>
            <ul>
                <li><a href="#" class="" >Accueil</a></li>
                <li><a href="apropos.php" class="">A propos</a></li>
                <li><a href="menu.php" class="" id="on">Menu</a></li>
                <li><a href="#" class="alert-contact">Contact</a></li>
            </ul>
        </div>
    
    <!-- Fin Dropdown -->

    <!-- Popup situation -->
    <div class="popup-sit">
        <div class="popupBox">
            <div class="popup-close icon-close"><i class="ri-close-line"></i></div>
            <strong>ajouter votre situation</strong>
            <form action="#" class="formulaire" method="post">

            <?php
                if($_SESSION["user_id"]){
                    $id = $_SESSION["user_id"];
                    echo "<input type='hidden' name='idEmploye' value='" . $id . "'>";
                }                
                
            ?>


            
                <div class="form-division">
                    <input type="text" class="form-input" placeholder="" name="sit">
                    <label for="" class="form-label">Situation</label>
                </div>
                <button class="popup-close popup-btn">Enregistrer</button> 
            </form>
           
        </div>
    </div>
    <!-- Fin Popup situation -->

    <!-- Popup evidence -->
    <div class="popup-evi">
        <div class="popEvi">
            <div class="popup-cls icon-close"><i class="ri-close-line"></i></div>
            <strong>Importer votre evidence</strong>
            <form action="#" class="formul" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idEmploye" value="<?php echo $_SESSION['user_id']; ?>">
                <div class="form-division">
                    <input type="file" class="put" placeholder="" name = "image">
                </div>
                <button class="popup-close popup-btn" type="submit" name="envoyer">Envoyer</button>
            </form>
        </div>
    </div>
    <!-- Fin Popup evidence -->

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

    <!-- Contact -->
    <div class="contact">
        <div class="cont">
            <div>
                <h1>Contact:</h1> 
            </div>

            <div>
                <a href="https://api.whatsapp.com/send?phone=0342073848&text=Bonjour" target="_blank"><i class="ri-whatsapp-fill"></i></a>
                <a href="https://www.facebook.com/profile.php?id=100069652862088" target="blank"><i class="ri-facebook-circle-fill"></i></a>
                <a href="https://twitter.com/Sahine37" target="blank"><i class="ri-twitter-fill"></i></a>
            </div>
            
        </div>
       
        <button class="contact-fermer">Fermer</button>
        
    </div>

    
    
    <section class="section">
        <div class="block">
            <div class="limite">

                    <div class="divi debut">
                        <h3>Début</h3>
                        <?php
                            if(isset($_SESSION["user_id"])) {
                                $id = $_SESSION["user_id"];
                                $query = $con->prepare("SELECT r.dateDebut FROM travail r JOIN employe p ON (p.id = r.id) WHERE p.id = :ide");
                                $query->bindParam(":ide", $id);
                                $query->execute();
                                $employer = $query->fetch(PDO::FETCH_ASSOC);

                                if($employer) {
                                    $dateDebut = $employer["dateDebut"];
                                    echo "<p>$dateDebut</p>";
                                }
                            }
                        ?>
                    </div>


                    <div class="divi condition">
                        <h3>condition d'operation</h3>
                        <?php
                            if($_SESSION["user_id"]){
                                $id = $_SESSION["user_id"];
                                $query = $con->prepare("SELECT role FROM employe WHERE id = :ide");
                                $query->bindParam(":ide", $id);
                                $query->execute();
                                $employer = $query->fetch(PDO::FETCH_ASSOC);
                                if($employer){
                                    $user_role = $employer["role"];
                                    echo "<p>$user_role</p>";
                                }
                            }
                        ?>
                        

                        
                    </div>


                    <div class="divi fin">
                        <h3>Fin</h3>
                        <?php
                            if(isset($_SESSION["user_id"])) {
                                $id = $_SESSION["user_id"];
                                $query = $con->prepare("SELECT r.dateFin FROM travail r JOIN employe p ON (p.id = r.id) WHERE p.id = :ide");
                                $query->bindParam(":ide", $id);
                                $query->execute();
                                $date = $query->fetch(PDO::FETCH_ASSOC);

                                if($date) {
                                    $dateFin = $date["dateFin"];
                                    echo "<p>$dateFin</p>";
                                }
                            }
                        ?>
                    </div>

            </div>
            <div class="ident">

                <div class="divis evidence">
                    <h3>Evidence</h3>
                    <p></p>
                    <p>Photo</p>
                    <button class="but alt">Importer</button>
                </div>

                <div class="divis identif">
                    <h3>identification</h3>
                    <i class="ri-account-circle-line"></i>
                    

                    <?php
                        if($_SESSION["user_id"]){
                            $id = $_SESSION["user_id"];
                            $query = $con->prepare("SELECT nom FROM employe WHERE id = :ide");
                            $query->bindParam(":ide", $id);
                            $query->execute();
                            $nom_emp = $query->fetch(PDO::FETCH_ASSOC);
                            if($nom_emp){
                                $nom = $nom_emp["nom"];
                                echo "<h3> $nom </h3>";
                            }
                        }
                        
                    ?>
                        <!-- <h3>Profile</h3> -->

                    
                </div>

                <div class="divis situ" >
                    <h3>Situation</h3>
                    <p>Ex: Motivé(e), Engagé(e)</p>
                    <button class="but alert">Décrire</button>
                </div>

            </div>

            <div class="contrat">
                <div class="divi cont">
                    <h3>Contrat:</h3>


                    <?php
                        if (isset($_SESSION["user_id"])) {
                            $id = $_SESSION["user_id"];
                            $query = $con->prepare("SELECT r.valTemp FROM travail r JOIN employe p ON (p.id = r.id) WHERE p.id = :ide");
                            $query->bindParam(":ide", $id);
                            $query->execute();
                            $validite = $query->fetch(PDO::FETCH_ASSOC);

                            if ($validite) {
                                $val = $validite["valTemp"];
                                $affichage = "";

                                // Utiliser une structure conditionnelle pour déterminer le mot à afficher
                                if (strpos($val, 'jour') !== false) {
                                    $affichage = "JOURNALIERE";
                                } elseif (strpos($val, 'semaine') !== false) {
                                    $affichage = "SEMAINE";
                                } elseif (strpos($val, 'mois') !== false) {
                                    $affichage = "MENSTRUELLE";
                                } elseif (strpos($val, 'an') !== false) {
                                    $affichage = "ANNUEL";
                                }

                                echo "<p>$affichage</p>";
                            }
                        }
                    ?>



                    
                </div>
                <div class="card">
                    <span class="card-descri"></span>
                    <h4 class="card-titre">Durée du contrat</h4>
                    <?php
                            if(isset($_SESSION["user_id"])) {
                                $id = $_SESSION["user_id"];
                                $query = $con->prepare("SELECT r.valTemp FROM travail r JOIN employe p ON (p.id = r.id) WHERE p.id = :ide");
                                $query->bindParam(":ide", $id);
                                $query->execute();
                                $validite = $query->fetch(PDO::FETCH_ASSOC);

                                if($validite) {
                                    $val = $validite["valTemp"];
                                    echo "<p>$val</p>";
                                }
                            }
                        ?>
                </div>
                
            </div>
        </div>

     

        
        
    </section>

    <script src="js/script.js"></script>
    <!-- <script src="js/aos.js"></script> -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="jquery-3.7.1.min.js"></script>
    <script>
        AOS.init();
      </script>
    <script>
        $(document).ready(function(){

            // alert popup situation
    $(".popup-close").click(function(){
        $(".popupBox").removeClass("show");
        setTimeout(function(){
            $(".popup-sit").removeClass("open-popup");
        }, 150)
    });

    $(".alert").click(function(){
        $(".popup-sit").addClass("open-popup");
        setTimeout(function(){
            $(".popupBox").addClass("show");
        }, 50)
    });


        // alert popup evidence
    $(".popup-cls").click(function(){
        $(".popEvi").removeClass("shw");
        setTimeout(function(){
            $(".popup-evi").removeClass("open-evi");
        }, 150)
    });

    $(".alt").click(function(){
        $(".popup-evi").addClass("open-evi");
        setTimeout(function(){
            $(".popEvi").addClass("shw");
        }, 50)
    });



            // show contact
    $(".alert-contact").click(function(){
        $(".contact").addClass("open-contact");
    })

    $(".contact-fermer").click(function(){
        $(".contact").removeClass("open-contact")
    })

        // popup admin
    $(".admin-close").click(function(){
        $(".form").removeClass("show");
        setTimeout(function(){
            $(".admin-form").removeClass("open-admin");
        }, 100)
    });

    $(".alrt").click(function(){
        $(".admin-form").addClass("open-admin");
        setTimeout(function(){
            $(".form").addClass("show");
        }, 50)
    });

});

    // Dropdown
    $(".menu").click(function(){
        $(".dropdown").addClass("drop");
    });

    $(".cl").click(function(){
        $(".dropdown").removeClass("drop");
    });




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

    </script>
</body>
</html>