<?php include("parts/head.inc.php") ?>

<body id="menu">
    
<?php include("parts/header.inc.php") ?>

    <div id="app" class="section_menu container">

        <img class="section_gauche" :src="image" alt="Image de nourriture">
    
        <div class="section_droite">
            <h1>Menu</h1>

            <?php foreach($categories as $categorie) : ?>

                <?php $plats_de_categorie = $plats->toutParCategorie($categorie["id"]); ?>
                <?php if(count($plats_de_categorie) != 0) : ?>

                    <h2 class="categorie_repas"><?= $categorie["nom"] ?></h2>

                    <?php foreach($plats_de_categorie as $plat) : ?>
                        <div class="repas" @click="changerImage('<?= $plat["image"] ?>', <?= $plat["id"] ?>)" :class="{selectionnee: <?= $plat["id"] ?> == est_selectionnee}">
                            <h3 class="titre_repas"><?= $plat["nom"] ?></h3>
                            <span class="prix"><strong><?= number_format($plat["prix"], 2) ?> $</strong></span>
                            <p class="description"><?= $plat["description"] ?></p>
                        </div>
                    <?php endforeach; ?>

                <?php endif; ?>
                
            <?php endforeach; ?>
            
        </div>
    </div>

    <script src="public/js/menu.js" type="module"></script>

<?php include("parts/footer.inc.php") ?>