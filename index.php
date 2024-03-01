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
    <title>login & sign up</title>
</head>
<body>
    <!-- Code Modal login -->
    <div class="popup-box" id="box">
        <div class="popup">
            <img class="img-takalou" src="image/logo-horizontal.png" alt="">
            <strong>Se connecter</strong>
            <form action="#" class="formu" method="post">
                <div class="input-con">
                    <input type="text" required="required" name="nom">
                    <span>Utilisateur</span>
                </div>
                <div class="input-con">
                    <input type="password" required="required" name="password">
                    <span>Mot de passe</span>
                </div>
                <button type="submit" class="btn-con">Se connecter</button>
            </form>
            
            <p class="small popup-close">retour</p>
            <div class="horizontale">

            </div>
            <div class="icon-con">
                <a href="https://api.whatsapp.com/send?phone=0342073848&text=Bonjour" target="_blank"><i class="ri-whatsapp-fill"></i></a>
                <a href="https://www.facebook.com/profile.php?id=100069652862088" target="blank"><i class="ri-facebook-circle-fill"></i></a>
                <a href="https://twitter.com/Sahine37" target="blank"><i class="ri-twitter-fill"></i></a>
                
            </div>  
        </div>
    </div>
    <!--fin LOGIN -->

    <!-- popup verification -->
    <div class="popConf" id="modalDeco">
        <div class="upConf">
        <img src="image/logo-horizontal.png" alt="" class="logoSmall">
            <h5 class="alertUp">Nom d'utilisateur ou mot de passe incorrect</h5>
            <div class="btnConf">
                <button class="okk" id="btnConfOK">OK</button>
            </div>
        </div>
    </div>
    <!--fin popup verification -->

<?php
    include("connection.php");
    require 'connection.php'; // Inclure le fichier de connexion à la base de données

    if (isset($_POST['nom']) && isset($_POST['password'])) {
        $nom = $_POST['nom'];
        $password = $_POST['password'];

        
        // Effectuer une requête pour vérifier les informations de connexion dans la table usercompte
        $query = $con->prepare("SELECT id FROM usercompte WHERE nomUtilisateur = :nom AND motdepasse = :pass");
        $query->bindParam(':nom', $nom);
        $query->bindParam(':pass', $password);
        $query->execute();
        $id = $query->fetch(PDO::FETCH_ASSOC);

        if ($query->rowCount() == 1) {
            // L'utilisateur est connecté avec succès
            session_start(); // Démarrer la session
            $_SESSION['user_id'] = $id['id']; // Stocker l'ID de l'utilisateur dans la session
            header("Location: home.php"); // Rediriger vers la page home.php
        }else {
            
                    // L'authentification a échoué, afficher une alerte
                    // L'authentification a échoué, afficher une alerte et ajouter la classe rouge
                echo "<script>
                    var modalVer = document.getElementById('modalDeco');
                    modalVer.style.display = 'block';
                    setTimeout(function(){
                        window.location.href = 'index.php';
                    }, 2000);
                </script>";
            exit;

        }
        
    }
    if (isset($_POST['usern']) && isset($_POST['pass'])) {
        $nom = $_POST['usern'];
        $pass = $_POST['pass'];
    
        // Effectuer une requête pour vérifier les informations de connexion dans la table usercompte
        $query = $con->prepare("SELECT * FROM admincompte WHERE admin = :nom AND mdp = :pass");
        $query->bindParam(':nom', $nom);
        $query->bindParam(':pass', $pass);
        $query->execute();
    
        if ($query->rowCount() == 1) {
            // L'utilisateur est connecté avec succès
            session_start(); // Démarrer la session
            $_SESSION["admin_username"] = $nom; // Stocker l'ID de l'utilisateur dans la session
            header("Location: admin1.php"); // Rediriger vers la page home.php
        } else {
            // L'authentification a échoué
            //echo "Erreur d'authentification. Veuillez réessayer.";
            echo "<script>
                    var modalVer = document.getElementById('modalDeco');
                    modalVer.style.display = 'block';
                    setTimeout(function(){
                        modalVer.style.display = 'none';
                        window.location.href = 'index.php';
                    }, 2000);
                  </script>";
            exit;
        }
    }
    
?>


    <header>
        <div class="logo">
            <a href="#"><img class="img-takalou" src="image/logo-horizontal.png" alt=""></a>
        </div>

        <!-- <div >
            <nav class="nav" id="nav-menu">
                <a href="#" class="alert">Acceuil</a>
                <a href="#" class="alert">A propos</a>
                <a href="#" class="alert">Menu</a>
                <a href="#" class="alert-contact">Contact</a>
                
            </nav>
        </div> -->

        <div class="lg">
            <button class="btn-login alrt"><i class="ri-admin-line"> <a href="#">admin</a></i></button>
            <i class="ri-menu-3-line menu" id="header-menu"></i>
        </div>

    </header>

    <!-- Dropdown -->
    <div class="dropdown">
        <i class="ri-close-line cl" ></i>
        <ul>
            <li><a href="#" class="" id="on">Acceuil</a></li>
            <li><a href="apropos.php" class="">A propos</a></li>
            <li><a href="menu.php" class="">Menu</a></li>
            <li><a href="#" class="alert-contact">Contact</a></li>
            
        </ul>
    </div>
    <!--  Fin Dropdown -->


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


    <!-- Formulaire de connexion de l'administrateur -->
    <div class="admin-form">
        <div class="form">
            <div class="admin-close"><i class="ri-close-fill"></i></div>
            <div class="box login">
                <h2>Admin</h2>
                <form action="#" method="POST">
                    <div class="inputBox">
                        <!-- <span class="icon"><i class="ri-mail-line"></i></span> -->
                        <input type="text" name="usern" required><label>Admin</label>
                    </div>
                    <div class="inputBox">
                        <!-- <span class="icon"><i class="ri-eye-off-line" id="loginEye"></i></span> -->
                        <input type="password" name="pass" id="loginPass" required><label>Mot de passe</label>
                    </div>
                    <button type="submit" class="Btn">Connexion</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Fin du formulaire de connexion de l'administrateur -->

    
    <section class="section">
        <div class="titre">
            <h1 data-aos="fade-down" data-aos-delay="100">CONDITION D'OPERATION D'UN EMPLOYE</h1>
            <p data-aos="fade-right" data-aos-delay="150">L'avenir dépend de ce <n>que vous faites aujourd'hui.</n></p>
            <p data-aos="fade-left" data-aos-delay="200">Le succès n'est pas la clé du bonheur. Le bonheur est la clé du succès. Si vous aimez ce que vous faites, vous réussirez.</p>
            <button class="button1 alert">Se connecter</button>
            <!-- <button class="button">S'inscrire</button> -->
        </div>

        <!-- Login & Sign up -->
        <div class="log-sig">

            <div class="wrapper">
                <i class="ri-close-line" id="login-fermer"></i>
                <n class="bg-animate"></n>
                <n class="bg-animate2"></n>
                <div class="form-box login">
                    <h2 class="animation" style="--i:0; --j:21;">Connection</h2>
                    <form action="#" method="post">
                        <div class="input-box animation" style="--i:1; --j:22;">
                            <input type="text" name="nom" required>
                            <label for="">Nom d'utilisateur</label>
                            <i class="ri-user-3-line login_icon"></i>
                        </div>
                        <div class="input-box animation" style="--i:2; --j:23;">
                            <input type="password" name="password" required>
                            <label for="">Mot de passe</label>
                            <i class="ri-lock-2-line" login_icon></i>
                        </div>
                        
                        <button type="submit" class="btn animation"style="--i:3; --j:24;">Se connecter</button>
    
                        <div class="register-box animation" style="--i:4; --j:25;">
                            <p>Vous avez oublié votre mot de passe? <a href="#" class="sign-link">Changer</a></p>
                        </div>
                    </form>
                </div>

                <div class="info-text login">
                    <h3 class="animation" style="--i:0; --j:20;">CONDITION D'OPERATION D'UN EMPLOYE</h3>
                    <p class="animation" style="--i:1; --j:21;">L'avenir dépend de ce <n>que vous faites aujourd'hui.</n>    </p>
                    <p class="animation" style="--i:2; --j:22">Le succès n'est pas la clé du bonheur. Le bonheur est la clé du succès.</p></p>
                </div>

                <div class="form-box sign">
                    <h2 class="animation" style="--i:17; --j:0;">mot de passe</h2>
                    <form action="signin.php" method="post">
                        <div class="input-box animation" style="--i:18; --j:1;">
                            <input type="email" required name="email">
                            <label for="">Nom d'utilisateur</label>
                            <i class="ri-user-3-line login_icon"></i>
                        </div>
                        <div class="input-box animation" style="--i:19; --j:2;">
                            <input type="password" required name="password">
                            <label for="">Mot de passe</label>
                            <i class="ri-lock-2-line" login_icon></i>
                        </div>
                        <div class="input-box animation" style="--i:20; --j:3;">
                            <input type="password" required name="password">
                            <label for="">Confirmer mot de passe</label>
                            <i class="ri-lock-2-line" login_icon></i>
                        </div>
                        
                        <button type="submit" class="btn animation" style="--i:21; --j:4;">S'inscrire</button>
    
                        <div class="register-box animation" style="--i:22; --j:5;">
                            <p>Vous avez déjà un compte? <a href="#" class="login-link">Se connecter</a></p>
                        </div>
                    </form>
                </div>

                <div class="info-text sign">
                    <h3 class="animation" style="--i:23; --j:0;">CONDITION D'OPERATION D'UN EMPLOYE</h3>
                    <p class="animation" style="--i:24; --j:1;">L'avenir dépend de ce <n>que vous faites aujourd'hui.</n>    </p>
                    <p class="animation" style="--i:25; --j:2">Le succès n'est pas la clé du bonheur. Le bonheur est la clé du succès.</p></p>
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
        document.addEventListener('DOMContentLoaded', function() {
            if (<?php echo isset($_SESSION["inscription_reussie"]) ? 'true' : 'false'; ?>) {
                // Redirigez l'utilisateur vers la page index.php#login
                window.location = 'index.php#login';
                
                // Utilisez JavaScript pour faire défiler vers la partie de la page contenant le formulaire de connexion
                window.scrollTo(0, document.querySelector("#login").offsetTop);
            }
        });


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




    // var modalVer = document.getElementById('modalDeco');
    // modalVer.style.display = 'block';                          
    // setTimeout(function(){
    //     window.location.href = 'index.php';
    // }, 2000); 
                          

    


    
   

    </script>
    
</body>
</html>