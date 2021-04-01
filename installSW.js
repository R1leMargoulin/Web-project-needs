$(function(){
    if('serviceWorker' in navigator){
        navigator.serviceWorker.register("/ServiceWorker.js")
        .then( (sw) => console.log('Le Service Worker a été enregistrer', sw))
        .catch((err) => console.error('Le Service Worker est introuvable !!!', err));
    }
})