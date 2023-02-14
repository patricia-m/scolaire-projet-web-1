    <footer>

        <section id="infolettre">

            <h2>Infolettre</h2>
            <p>Inscrivez-vous à l'infolettre afin d’être avisés des nouveautés au menu</p>

            <?php // Erreurs possibles lors de l'inscription à l'infolettre ?>
            <?php if (isset($_GET["champs_vide"])) : ?>
                <p class="erreur">Erreur! Veuillez entrer tous les champs.</p>
            <?php elseif (isset($_GET["erreur"])) : ?>
                <p class="erreur">Erreur! Veuillez recommencer.</p>
            <?php elseif (isset($_GET["erreur_max_nom"])) : ?>
                <p class="erreur">Erreur! Le nom ne doit pas contenir plus de 100 caractères.</p>
            <?php elseif (isset($_GET["erreur_max_courriel"])) : ?>
                <p class="erreur">Erreur! Le courriel ne doit pas contenir plus de 255 caractères.</p>
            <?php elseif (isset($_GET["erreur_existant"])) : ?>
                <p class="erreur">Erreur! Cette adresse courriel est déjà inscrite à l'infolettre.</p>
            <?php elseif (isset($_GET["succes"])) : ?>
                <p class="succes">Vous avez été inscrit à l'infolettre avec succès.</p>
            <?php endif; ?>

            <form action="ajout-infolettre-submit" method="POST">
                <input type="text" name="nom" placeholder="Nom complet">
                <input type="email" name="courriel" placeholder="Courriel">
                <input class="btn" type="submit" value="M'abonner">
            </form>

        </section>

        <section id="bas_de_page">

            <div class="container informations">
                <a href="index"><img src="public/img/logo-pub-g4.svg" alt="Logo du Pub G4"></a>

                <div class="adresse">
                    <p>297, rue St-Georges,</p>
                    <p>Saint-Jérôme (Québec) J7Z 5A2</p>
                    <p>Téléphone : 450 436-1531</p>
                </div>

                <div class="heures_ouverture">
                    <p>Heures d'ouverture :</p>
                    <p>Lundi au vendredi : 12h à 1h</p>
                    <p>Samedi et dimanche 12h à 2h</p>
                </div>

                <p class="copyright">© Patricia Massie</p>
            </div>

        </section>

    </footer>
</body>
</html>