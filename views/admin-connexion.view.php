<?php include("parts/admin-head.inc.php") ?>

<body id="admin_connexion">
    
    <div class="container">

        <header>
            <img class="logo" src="public/img/logo-pub-g4.svg" alt="Logo du Pub G4">
            <div class="section_bouton">
                <a href="index" class="bouton-plein">Retour au site Web</a>
            </div>
        </header>

        <h1>Connexion</h1>

        <?php // Gestion des erreurs possibles ?>
        <?php if (isset($_GET["champs_vide"])) : ?>
            <p class="erreur">Erreur! Veuillez entrer votre courriel et votre mot de passe.</p>
        <?php elseif (isset($_GET["erreur"])) : ?>
            <p class="erreur">Erreur! Nom d'utilisateur ou mot de passe incorrect.</p>
        <?php elseif (isset($_GET["deconnexion"])) : ?>
            <p class="succes">Vous avez bien été déconnecté!</p>
        <?php endif; ?>

        <form action="compte-connexion-submit" method="POST">
            <input type="email" name="courriel" placeholder="Courriel">
            <input type="password" name="mot_de_passe" placeholder="Mot de passe">
            <input class="btn" type="submit" value="Connexion">
        </form>

    </div>

</body>
</html>