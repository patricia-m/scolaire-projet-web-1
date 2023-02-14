<?php include("parts/admin-head.inc.php") ?>

<body id="admin">
    <div id="app" class="container">

        <header>
            <img class="logo" src="public/img/logo-pub-g4.svg" alt="Logo du Pub G4">
            <div class="section_bouton">
                <a href="index" class="bouton-plein">Retour au site Web</a>
                <a href="compte-deconnexion-submit" class="bouton-plein">Déconnexion</a>
            </div>
        </header>

        <div class="salutations">
            <h1>Administration</h1>
            <h3>Bonjour <?= $_SESSION["utilisateur_prenom"] ?> !</h3>
        </div>

        <?php // Messages d'erreurs ou de succès ?>
        <?php if (isset($_GET["erreur"])) : ?>
            <p class="erreur">Une erreur s'est produite! Veuillez recommencer.</p>
        
        <?php // Utilisateurs - ajout - modification - suppression ---------------------------------- ?>
        <?php elseif (isset($_GET["compte_succes"])) : ?>
            <p class="succes">L'utilisateur a été créé avec succès!</p>
        <?php elseif (isset($_GET["compte_modif_succes"])) : ?>
            <p class="succes">L'utilisateur a été modifié avec succès!</p>
        <?php elseif (isset($_GET["suppression_utilisateur"])) : ?>
            <p class="succes">L'utilisateur a été supprimé avec succès!</p>

        <?php // Plats - ajout - modification - suppression ----------------------------------------- ?>
        <?php elseif (isset($_GET["plat_succes"])) : ?>
            <p class="succes">Le plat a été ajouté avec succès!</p>
        <?php elseif (isset($_GET["plat_modif_succes"])) : ?>
            <p class="succes">Le plat a été modifié avec succès!</p>
        <?php elseif (isset($_GET["suppression_plat"])) : ?>
            <p class="succes">Le plat a été supprimé avec succès!</p>
                    
        <?php // Catégorie - ajout - modification - suppression ------------------------------------- ?>
        <?php elseif (isset($_GET["categorie_succes"])) : ?>
            <p class="succes">La catégorie a été ajoutée avec succès!</p>
        <?php elseif (isset($_GET["categorie_modif_succes"])) : ?>
            <p class="succes">La catégorie a été modifiée avec succès!</p>
        <?php elseif (isset($_GET["suppression_categorie"])) : ?>
            <p class="succes">La catégorie a été supprimée avec succès!</p>
        <?php elseif (isset($_GET["erreur_categorie"])) : ?>
            <p class="erreur">Erreur! Des plats appartiennent à la catégorie que vous tentez de supprimer. Veuillez vous assurer de supprimer tous les plats avant de supprimer la catégorie.</p>

        <?php endif; ?>


        <div class="boutons_ajout">
            <a href="ajout-categorie" class="ajout_categorie"><h3>Ajouter une catégorie</h3></a>
            <?php if (isset($_SESSION["utilisateur_type"]) && $_SESSION["utilisateur_type"] == 1) : ?>
                <a href="ajout-utilisateur" class="ajout_utilisateur"><h3>Ajouter un utilisateur</h3></a>
            <?php endif; ?>
            <a href="ajout-plat" class="ajout_repas"><h3>Ajouter un plat</h3></a>
        </div>


        <div class="gestion_categorie">
            <h2>Gestion des catégories</h2>

            <?php foreach($categories as $i => $categorie) : ?>
                <div class="categorie">
                    <p><strong><?= $i + 1 . "." ?></strong> <?= $categorie["nom"] ?> </p>
                    <div class="boutons_ajout_suppression">
                        <span><a href="modification-categorie?id= <?= $categorie["id"] ?>" class="bouton-plein">Modifier</a></span>
                        <span><a class="bouton-plein" @click.prevent="ouvrirModalSuppressionCategorie(<?= $categorie["id"] ?>, '<?= addslashes($categorie["nom"]) ?>')">Supprimer</a></span>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>
            
            <div class="modal" ref="modal_categorie">
                <div class="modal-contenu">
                    <p class="texte-modal"> Voulez vous vraiment supprimer la catégorie suivante : <span> {{categorie_nom}}</span> </p>
                    <a :href="'supression-categorie-submit?id=' + categorie_id" class="bouton-plein">Confirmer</a>
                    <a class="bouton-plein fermer" @click.prevent="fermerModal">Annuler</a>
                </div>
            </div>

        </div>

        
        <?php // Section administrateur seulement (modification et suppression des utilisateurs) ?>
        <?php if (isset($_SESSION["utilisateur_type"]) && $_SESSION["utilisateur_type"] == 1) : ?>
            <div class="gestion_utilisateur">
                <h2>Gestion des utilisateurs</h2>

                <?php foreach($utilisateurs as $utilisateur) : ?>
                    <div class="utilisateur">
                        <p><?= $utilisateur["prenom"] ?> <?= $utilisateur["nom"] ?></p>
                        <p><?= $utilisateur["courriel"] ?></p>

                        <div class="boutons_ajout_suppression" v-if="<?= $utilisateur["id"] ?> != 1">
                            <span><a href="modification-utilisateur?id=<?= $utilisateur["id"] ?>" class="bouton-plein">Modifier</a></span>
                            <span><a class="bouton-plein" @click.prevent="ouvrirModalSuppressionUtilisateur(<?= $utilisateur["id"] ?>, '<?= addslashes($utilisateur["courriel"]) ?>')">Supprimer</a></span>
                        </div>

                        <div class="utilisateur_sans_btn" v-if="<?= $utilisateur["id"] ?> == 1">
                            <p class="erreur">COMPTE ADMINISTRATEUR</p>
                        </div>

                    </div>
                    <hr>
                <?php endforeach; ?>

                <div class="modal" ref="modal_utilisateur">
                    <div class="modal-contenu">
                        <p class="texte-modal"> Voulez vous vraiment supprimer l'utilisateur suivant : <span> {{utilisateur_nom}}</span> </p>
                        <a :href="'supression-utilisateur-submit?id=' + utilisateur_id" class="bouton-plein">Confirmer</a>
                        <a class="bouton-plein fermer" @click.prevent="fermerModal">Annuler</a>
                    </div>
                </div>

            </div>
        <?php endif; ?>


        <div class="gestion_menu">
            <h2>Gestion du menu</h2>

            <?php foreach($categories as $categorie) : ?>

                <?php $plats_de_categorie = $plats->toutParCategorie($categorie["id"]); ?>
                <?php if(count($plats_de_categorie) != 0) : ?>

                <h3><?= $categorie["nom"] ?></h3>

                    <?php foreach($plats->toutParCategorie($categorie["id"]) as $plat) : ?>
                        <div class="plat">
                            <img class="img_plat" src="<?= $plat["image"] ?? "public/img/chin-chin.jpg" ?>" alt="">

                            <div class="informations">
                                <h4><?= $plat["nom"] ?></h4>
                                <p class="categorie"><?= $categorie["nom"] ?></p>
                                <p class="prix"><?= number_format($plat["prix"], 2) ?> $</p>
                                <p class="description"><?= $plat["description"] ?></p>
                            </div>

                            <div class="boutons_ajout_suppression">
                                <a href="modification-plat?id= <?= $plat["id"] ?>" class="bouton-plein">Modifier</a>
                                <a class="bouton-plein" @click.prevent="ouvrirModalSuppressionPlat(<?= $plat["id"] ?>, '<?= addslashes($plat["nom"]) ?>')">Supprimer</a>
                            </div>
                        </div>
                
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>

            <div class="modal" ref="modal_plat">
                <div class="modal-contenu">
                    <p class="texte-modal"> Voulez vous vraiment supprimer le plat suivant : <span> {{plat_nom}}</span> </p>
                    <a :href="'supression-plat-submit?id=' + plat_id" class="bouton-plein">Confirmer</a>
                    <a class="bouton-plein fermer" @click.prevent="fermerModal">Annuler</a>
                </div>
            </div>

        </div>
    </div>

    <?php // Bannière mode administrateur seulement ?>
    <?php if (isset($_SESSION["utilisateur_type"]) && $_SESSION["utilisateur_type"] == 1) : ?>
        <h3 class="administrateur">Mode administrateur</h3>
    <?php endif; ?>

    <script src="public/js/admin-accueil-suppression.js" type="module"></script>
</body>
</html>