<header id="navigation">

    <?php // Section menu de l'utilisateur, si utilisateur connecté ?>
    <?php if(!empty($_SESSION["utilisateur_id"])) : ?>
        <div class="utilisateur_connecte">
            <div class="section_admin container">
                <h2>Bonjour <?= $_SESSION["utilisateur_prenom"] ?></h2>
                <span>
                    <a href="administration" class="bouton-plein">Retour à l'administration</a>
                    <a href="compte-deconnexion-submit" class="bouton-plein">Déconnexion</a>
                </span>
            </div>
        </div>
    <?php endif; ?>


    <nav class="container">

        <a href="index"><img class="logo" src="public/img/logo-pub-g4.svg" alt="Logo du Pub G4"></a>

        <div class="hamburger" @click="voirMenu()" :class="{actif : actif}"></>
            <span class="barre"></span>
            <span class="barre"></span>
            <span class="barre"></span>
        </div>

        <ul :class="{actif : actif}">
            <li><a href="index">Accueil</a></li>
            <li><a href="menu">Menu</a></li>
            <li><a href="a-propos">À propos</a></li>
            <li><a href="nous-joindre">Nous joindre</a></li>

            <div class="reseaux">
                <li><a href="https://twitter.com/" target="_blank" title="Consulter le compte Twitter dans un autre onglet"><div class="twitter"></div></a></li>
                <li><a href="https://facebook.com/" target="_blank" title="Consulter le compte Facebook dans un autre onglet"><div class="facebook"></div></a></li>
                <li><a href="https://instagram.com/" target="_blank" title="Consulter le compte Instagram dans un autre onglet"><div class="instagram"></div></a></li>
            </div>
            
        </ul>

    </nav>
</header>

<script src="public/js/navigation.js" type="module"></script>