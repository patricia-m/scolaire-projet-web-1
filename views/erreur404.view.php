<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titre ?? "Administration" ?></title>
    <link rel="stylesheet" href="public/css/administration/style.css">
</head>
<body id="admin_connexion">
    
    <div class="container">
        
        <header>
            <img class="logo" src="public/img/logo-pub-g4.svg" alt="Logo du Pub G4">

            <div class="section_bouton">

                <?php if (isset($_SESSION["utilisateur_id"])) : ?>
                    <a href="administration" class="bouton-plein">Retour à l'accueil de l'administration</a>
                <?php endif; ?>

                <a href="index" class="bouton-plein">Retour au site Web</a>

            </div>
            
        </header>

        <h1 class="erreur">Erreur 404</h1>

    </div>

</body>
</html>