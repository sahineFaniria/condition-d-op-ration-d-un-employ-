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
    header("Location: index.php"); // Remplacez "index.php" par la page de votre choix
    exit;
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
    <title>Home</title>
</head>
<body>
    <header>
        <div class="logo">
            <a href="#"><img class="img-takalou" src="image/logo-horizontal.png" alt=""></a>
        </div>

        

        <div >
            <nav class="nav" id="nav-menu">
                <a href="#" class="" id="on">Accueil</a>
                <a href="apropos.php" class="">A propos</a>
                <a href="menu.php" class="">Menu</a>
                <a href="#" class="alert-contact">Contact</a>
            </nav>
        </div>
        <div class="lg">
            <button class="btn-login alrt"><a href="#" id="deco">Déconnecter</a></button>
            <i class="ri-menu-3-line menu" id="header-menu"></i>
        </div>
        
    </header>

    <div class="dropdown">
        <i class="ri-close-line cl" ></i>
        <ul>
            <li><a href="#" class="" id="on">Accueil</a></li>
            <li><a href="apropos.php" class="">A propos</a></li>
            <li><a href="menu.php" class="">Menu</a></li>
            <li><a href="#" class="alert-contact">Contact</a></li>
        </ul>
    </div>


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
        <div class="titre">
            <h1 data-aos="fade-down" data-aos-delay="100">"VOTRE EXPLORATION COMMENCE ICI."</h1>
            <p data-aos="fade-right" data-aos-delay="150"> BIENVENUE SUR NOTRE SITE WEB.</p>
            <p data-aos="fade-left" data-aos-delay="200">Le succès n'est pas la clé du bonheur. Le bonheur est la clé du succès. Si vous aimez ce que vous faites, vous réussirez.</p>
            <button class="button1"><a href="menu.php" id="lien">Menu</a></button>
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

            // alert popup
    $(".popup-close").click(function(){
        $(".popup").removeClass("show");
        setTimeout(function(){
            $(".popup-box").removeClass("open-popup");
        }, 150)
    });

    $(".alert").click(function(){
        $(".popup-box").addClass("open-popup");
        setTimeout(function(){
            $(".popup").addClass("show");
        }, 50)
    });

            // show contact
    $(".alert-contact").click(function(){
        $(".contact").addClass("open-contact");
    });

    $(".contact-fermer").click(function(){
        $(".contact").removeClass("open-contact")
    });

    // Dropdown
    $(".menu").click(function(){
        $(".dropdown").addClass("drop");
    });

    $(".cl").click(function(){
        $(".dropdown").removeClass("drop");
    })

        
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