import { createApp, ref } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js'

// propriétés ------------------------------------------------------------------------------------------------
const actif = ref(false)

// méthodes --------------------------------------------------------------------------------------------------

function voirMenu() {
    if (actif.value == true) {
        actif.value = false
    } else {
        actif.value = true
    }
}

// -------------------------------------------------------------------------------------------------------------
const root = {
    setup() {
        return {
            actif,

            voirMenu,
        }
    }
}

createApp(root).mount("#navigation")