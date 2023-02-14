<?php

// https://www.php.net/manual/en/features.file-upload.post-method.php

class Upload
{
    const UPLOAD_TYPE_ERROR = 1000;

    // Le nom original du fichier sur la machine client.
    private $name;

    // Le type 'mime' du fichier, si le navigateur a fourni cette information. Un exemple serait 'image/gif'.
    private $type;

    // La taille, en octets, du fichier téléversé.
    private $size;

    // Le nom temporaire du fichier sur le serveur
    private $tmp_name;

    // Le code d'erreur associé au téléversement du fichier
    // https://www.php.net/manual/en/features.file-upload.errors.php
    private $error;

    /**
     * Constructeur
     * 
     * @param string $name L'attribut name="" de la balise <input type="file">
     * @param array|null $typeValides (facultatif) Un tableau contenant la liste des extensions possibles.
     */
    public function __construct($name, $typesValides = null)
    {

        if (!isset($_FILES[$name])) {
            echo '<div php-debug style="color: red;">';
            echo '<strong>Erreur Upload :</strong> Aucun input de type="file" avec le name="' . $name . '" détecté ou le form n\'a pas enctype="multipart/form-data".';
            echo "<br><br>";
            debug_print_backtrace();
            echo "</div>";
            exit();
        }

        $this->name = $_FILES[$name]["name"];
        $this->type = $_FILES[$name]["type"];
        $this->size = $_FILES[$name]["size"];
        $this->tmp_name = $_FILES[$name]["tmp_name"];
        $this->error = $_FILES[$name]["error"];

        if ($this->error == UPLOAD_ERR_OK && $typesValides != null) {
            $separation_fichier = explode(".", $this->name);
            $extension = end($separation_fichier);
            if (in_array($extension, $typesValides) == false) {
                $this->error = $this::UPLOAD_TYPE_ERROR;
            }
        }
    }

    /**
     * Permet de déplacer le fichier téléversé dans un dossier spécifique
     * 
     * @param string $dossier Dans quel dossier déplacer le fichier. Ex: "uploads"
     * @param string $nouveau_nom (facultatif) Écrase le nom initial du fichier. Ne pas inclure l'extension du fichier (ex: "une_image")
     */
    public function placerDans($dossier, $nouveau_nom = null)
    {
        if ($this->estValide() == false) {
            return false;
        }

        if (is_dir($dossier) == false) {
            throw new Exception("Le dossier '$dossier' n'existe pas.");
            return false;
        }

        if (is_writable($dossier) == false) {
            throw new Exception("Le dossier '$dossier' n'a pas les permissions d'écriture.");
            return false;
        }

        // à des fins de sécurité
        $nom_fichier = basename($this->name); 

        if ($nouveau_nom != null) {
            $separation_fichier = explode(".", $this->name);
            $extension = end($separation_fichier);
            $nom_fichier = $nouveau_nom . '.' . $extension;
        }

        $cible = $dossier . "/" . $nom_fichier;

        $success = move_uploaded_file($this->tmp_name, $cible);

        if (!$success) {
            return false;
        }

        return $cible;
    }

    /**
     * Indique si le téléversement s'est bien passé
     * 
     * @return bool
     */
    public function estValide()
    {
        return $this->error == UPLOAD_ERR_OK;
    }

    /**
     * Retourne le message d'erreur
     * 
     * @return string|null
     */
    public function getErreur()
    {
        if ($this->erreur == UPLOAD_ERR_OK) {
            return null;
        }

        $messages = [
            UPLOAD_ERR_OK => 'There is no error, the file uploaded with success',
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
            $this::UPLOAD_TYPE_ERROR => 'Type incorrect',
        ];

        return $messages[$this->error];
    }
}
