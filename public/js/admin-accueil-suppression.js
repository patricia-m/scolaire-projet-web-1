import { createApp, ref } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

// propriétés ------------------------------------------------------------------------------------------------
// catégorie
const modal_categorie = ref(null)
const categorie_id = ref(0)
const categorie_nom = ref("")

// utilisateur
const modal_utilisateur = ref(null)
const utilisateur_id = ref(0)
const utilisateur_nom = ref("")

// plat
const modal_plat = ref(null)
const plat_id = ref(0)
const plat_nom = ref("")

// méthodes --------------------------------------------------------------------------------------------------

// Modal de supression d'une catégorie
function ouvrirModalSuppressionCategorie($id, $nom) {
    modal_categorie.value.style.display = "block"
    categorie_id.value = $id
    categorie_nom.value = $nom
}

// Modal de supression d'un utilisateur
function ouvrirModalSuppressionUtilisateur($id, $nom) {
    modal_utilisateur.value.style.display = "block"
    utilisateur_id.value = $id
    utilisateur_nom.value = $nom
}

// Modal de supression d'un plat
function ouvrirModalSuppressionPlat($id, $nom) {
    modal_plat.value.style.display = "block"
    plat_id.value = $id
    plat_nom.value = $nom
}

// Fermer le modal
function fermerModal() {
    modal_categorie.value.style.display = "none"
    modal_utilisateur.value.style.display = "none"
    modal_plat.value.style.display = "none"
}

// -------------------------------------------------------------------------------------------------------------
const root = {
    setup() {
        return {
            // propriétés
            modal_categorie,
            categorie_id,
            categorie_nom,

            modal_utilisateur,
            utilisateur_id,
            utilisateur_nom,

            modal_plat,
            plat_id,
            plat_nom,

            // méthodes
            ouvrirModalSuppressionCategorie,
            ouvrirModalSuppressionUtilisateur,
            ouvrirModalSuppressionPlat,
            fermerModal,
        }
    }
}

createApp(root).mount("#app")