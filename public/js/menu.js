import { createApp, ref } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

// propriétés ------------------------------------------------------------------------------------------------

const image = ref("public/uploads/chin-chin.jpg")
const est_selectionnee = ref(false)

// méthodes --------------------------------------------------------------------------------------------------

function changerImage(chemin_image, id) {
    image.value = chemin_image || "public/uploads/chin-chin.jpg"
    est_selectionnee.value = id
}

// -------------------------------------------------------------------------------------------------------------
const root = {
    setup() {
        return {
            image,
            est_selectionnee,

            changerImage,
        }
    }
}

createApp(root).mount("#app")