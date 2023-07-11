window.onload = () => {
// window : fait référence au navigateur
// onload : une fois que le navigateur a complètement fini de charger la page
    const switchs = document.querySelectorAll('.switch-actif'); // s'il ne trouve pas -> renvoie undefined~null

    if(switchs) {
        switchs.forEach((input) => {
            input.addEventListener('change', (e) => {  // e = évènement (event)
                sendRequest(e.target);  // e.target = la cible de l'évènement  == l'input
            });
        });
    }
}

async function sendRequest(input) {  // async : on peut utiliser la fonction n'importe quand
    const response = await fetch(`/admin/articles/switch/${input.dataset.id}`) 
    
    if(response.status >= 200 && response.status <= 300) {
        const card = input.closest('.card');
        const text = card.querySelector('.text-actif-article');
        const data = (await response.json()).data;
        console.error(data);

        if(data.actif) {
            card.classList.remove('border-danger'); // classList -> récupère toutes les class  - remove -> enlève 1 classe
            card.classList.add('border-success'); // classList -> récupère toutes les class  - remove -> enlève 1 classe
            
            text.classList.remove('text-danger'); 
            text.classList.add('text-success');
            text.innerHTML = 'Actif';
        } else {
            card.classList.remove('border-success');
            card.classList.add('border-danger');

            text.classList.remove('text-success');
            text.classList.add('text-danger');
            text.innerHTML = 'Inactif';
        }

        // console.error(card,text);
    }
    // await : on attend la réponse
    /**
     * back-tick -> on ouvre une chaine de caractère 
     * -> on peut repasser à la ligne sans fermer la chaine de caractères
     * -> on a accès à une variable avec ${}
     * ${input.dataset.id} pour "data-id"
     *  
     */ 
}
