import { createApp, ref } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

// propriétés ------------------------------------------------------------------------------------------------
const temoignages = ref([])
const nouveauTableau = ref([])

// Récupérer les témoignages du fichier json
fetch("public/js/data/temoignages.json").then(resp => {
    resp.json().then(contenu_json => {
        temoignages.value = contenu_json

        creerTableau(temoignages.value)
    })
})

// méthodes --------------------------------------------------------------------------------------------------

// Création du tableau avec 3 témoignages aléatoires
function creerTableau(tableau) {
    for (let i = 0; i < 3; i++) {
        let index = indexAleatoire(tableau)
        nouveauTableau.value.push(tableau[index])
        tableau.splice(index, 1)
    }
}

// Retourne l'index aléatoire d'un tableau
function indexAleatoire(tableau) {
    return Math.floor(Math.random() * tableau.length)
}

// ------------------------------------------------------------------------------------------------------------
const root = {
    setup() {
        return {
            temoignages,

            nouveauTableau,
        }
    }
}

createApp(root).mount("#app")