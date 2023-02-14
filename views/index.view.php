<?php include("parts/head.inc.php") ?>

<body id="accueil">
    
<?php include("parts/header.inc.php") ?>

    <section id="entete">
        <h1 class="titre-accueil">Une expérience <br> culinaire d'exception</h1>
        <a href="menu" class="bouton-vide">Voir le menu</a>
        <a href="#temoignages" class="fleche"><div class="fleche_bas"></div></a>
    </section>

    <section id="temoignages">
        <img class="texte_bg_gros" src="public/img/temoignages.png" alt="">
        <div id="app">
            <div class="container">
                <h2>Ce que nos clients disent de nous</h2>
                <div class="temoignages">

                    <div v-for="temoignage in nouveauTableau" class="temoignage">

                        <span class="etoile" v-for="i in 5">
                            <span v-if="temoignage.note >= i"><img src="public/img/star-full.png" alt=""></span>
                            <span v-else-if="temoignage.note == (i - 0.5)"><img src="public/img/star-half.png" alt=""></span>
                            <span v-else><img src="public/img/star-empty.png" alt=""></span>
                        </span>
                    
                        <p>{{temoignage.texte}}</p>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <section id="images">

        <img src="public/img/menu/burger.jpg" alt="">

        <div class="texte">
            <h2>À propos de nous</h2>
            <span class="texte_bg_moyen">À propos</span>
            <p>Depuis maintenant 20 ans, Pub G4 vous fait découvrir des plats de tout genre avec une touche raffinée que vous n’avez goutée nulle part ailleurs. Venez entre amis, pour une soirée romantique ou...</p>
            <a href="a-propos" class="voir_plus"><p>Voir plus</p><div class="fleche"></div></a>
        </div>

        <hr>

        <div class="texte">
            <h2>Un menu varié</h2>
            <span class="texte_bg_moyen">Menu</span>
            <p>Laissez vous tenter par un bon repas raffiné accompagné d'un de nos fameux drinks dans notre ambiance chaleureuse et accueillante.</p>
            <a href="menu" class="voir_plus"><p>Voir plus</p><div class="fleche"></div></a>
        </div>

        <img src="public/img/menu/tartare-boeuf.jpg" alt="">
        
    </section>

    <script src="public/js/accueil.js" type="module"></script>

<?php include("parts/footer.inc.php") ?>