<?php include("parts/admin-head.inc.php") ?>

<body id="admin_ajout_categorie">
    
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

        <h1>Ajouter une catégorie</h1>

        <?php // Gestion des erreurs possibles ?>
        <?php if(isset($_GET["champs_vide"])) : ?>
            <p class="erreur">Erreur! Veuillez remplir tous les champs.</p>
        <?php elseif(isset($_GET["erreur"])) : ?>
            <p class="erreur">Une erreur s'est produite! Veuillez recommencer.</p>
        <?php elseif (isset($_GET["erreur_max_nom"])) : ?>
            <p class="erreur">Erreur! Le nom de la catégorie ne doit pas contenir plus de 100 caractères.</p>
        <?php endif ?>

        <form action="ajout-categorie-submit" method="POST">
            <input type="text" name="nom" placeholder="Nom de la catégorie">
            <label for="ordre_categorie">Ordre :</label>

            <select name="ordre" id="ordre_categorie">
                <option value="1">Au début</option>

                <?php foreach($categories as $categorie) : ?>
                    <option value="<?= $categorie["ordre"] + 1 ?>">Après <?= strtolower($categorie["nom"]) ?></option>
                <?php endforeach; ?>
                
            </select>

            <input class="btn" type="submit" value="Ajouter">
        </form>

    </div>
</body>
</html>