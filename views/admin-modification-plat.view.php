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

        <h1>Modifier un plat</h1>

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

        <form action="modification-plat-submit" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $plat["id"] ?>">
            <input type="text" name="nom" placeholder="Nom du plat" value="<?= $plat["nom"] ?>">
            <input type="text" name="prix" placeholder="Prix" value="<?= $plat["prix"] ?>">
            <textarea rows="4" name="description" placeholder="Description"><?= $plat["description"] ?></textarea>

            <select name="categorie" id="categorie"> 
                
                <?php foreach($categories as $categorie) : ?>
                    <option <?php if ($categorie["id"] == $plat["categorie_id"]) { echo "selected"; } ?> value="<?= $categorie["id"] ?>"><?= $categorie["nom"] ?></option>
                <?php endforeach; ?>
        
            </select>

            <input type="file" name="image">
            <input type="hidden" name="image_actuelle" value="<?= $plat["image"] ?>">

            <input class="btn" type="submit" value="Modifier">
        </form>

    </div>

</body>
</html>