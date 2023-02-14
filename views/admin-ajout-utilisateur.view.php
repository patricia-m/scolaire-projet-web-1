<?php include("parts/admin-head.inc.php") ?>

<body id="admin_ajout_utilisateur">
    
    <div class="container">
        
        <header>
            <img class="logo" src="public/img/logo-pub-g4.svg" alt="Logo du Pub G4">
            <div class="section_bouton">
                <a href="administration" class="bouton-plein">Retour à l'admin</a>
                <a href="compte-deconnexion-submit" class="bouton-plein">Déconnexion</a>
            </div>
        </header>

        <div class="salutations">
            <h2>Administration</h2>
            <h3>Bonjour <?= $_SESSION["utilisateur_prenom"] ?> !</h3>
        </div>

        <h1>Ajouter un utilisateur</h1>

        <?php // Gestion des erreurs possibles ?>
        <?php if (isset($_GET["champs_vide"])) : ?>
            <p class="erreur">Erreur! Veuillez remplir tous les champs.</p>
        <?php elseif (isset($_GET["erreur"])) : ?>
            <p class="erreur">Une erreur s'est produite! Veuillez recommencer.</p>
        <?php elseif (isset($_GET["erreur_max_prenom"])) : ?>
            <p class="erreur">Erreur! Le prénom de l'utilisateur ne doit pas contenir plus de 100 caractères.</p>
        <?php elseif (isset($_GET["erreur_max_nom"])) : ?>
            <p class="erreur">Erreur! Le nom de l'utilisateur ne doit pas contenir plus de 100 caractères.</p>
        <?php elseif (isset($_GET["erreur_max_courriel"])) : ?>
            <p class="erreur">Erreur! Le courriel de l'utilisateur ne doit pas contenir plus de 255 caractères.</p>
        <?php elseif (isset($_GET["erreur_max_mdp"])) : ?>
            <p class="erreur">Erreur! Le mot de passe de l'utilisateur ne doit pas contenir plus de 100 caractères.</p>
        <?php elseif (isset($_GET["erreur_existant"])) : ?>
            <p class="erreur">Erreur! Un utilisateur utilise déjà cette adresse courriel.</p>
        <?php endif; ?>

        <form action="ajout-utilisateur-submit" method="post">
            <input type="text" name="prenom" placeholder="Prénom">
            <input type="text" name="nom" placeholder="Nom">
            <input type="email" name="courriel" placeholder="Courriel">
            <input type="password" name="mot_de_passe" placeholder="Mot de passe">
            <input class="btn" type="submit" value="Ajouter">
        </form>

    </div>

    <?php // Bannière mode administrateur seulement ?>
    <?php if (isset($_SESSION["utilisateur_type"]) && $_SESSION["utilisateur_type"] == 1) : ?>
        <h3 class="administrateur">Mode administrateur</h3>
    <?php endif; ?>

</body>
</html>