<?php include("parts/admin-head.inc.php") ?>

<body id="admin_ajout_plat">
    
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

        <h1>Ajouter un plat</h1>

        <?php // Gestion des erreurs possibles ?>
        <?php if(isset($_GET["champs_vide"])) : ?>
            <p class="erreur">Erreur! Veuillez remplir tous les champs.</p>
        <?php elseif(isset($_GET["erreur"])) : ?>
            <p class="erreur">Une erreur s'est produite! Veuillez recommencer.</p>
        <?php elseif(isset($_GET["erreur_prix"])) : ?>
            <p class="erreur">Erreur! Veuillez faire attention au format du prix et entrer des chiffres seulement.</p>
        <?php elseif (isset($_GET["erreur_max_nom"])) : ?>
            <p class="erreur">Erreur! Le nom du plat ne doit pas contenir plus de 100 caractères.</p>
        <?php endif ?>

        <form action="ajout-plat-submit" method="POST" enctype="multipart/form-data">
            <input type="text" name="nom" placeholder="Nom du plat">
            <input type="text" name="prix" placeholder="Prix">
            <textarea rows="4" name="description" placeholder="Description"></textarea>
            <select name="categorie" id="categorie">
                <?php foreach($categories as $categorie) : ?>
                    <option value="<?= $categorie["id"] ?>"><?= $categorie["nom"] ?></option>
                <?php endforeach; ?>
            </select>

            <input type="file" name="image">
            <input class="btn" type="submit" value="Ajouter">
        </form>

    </div>

</body>
</html>