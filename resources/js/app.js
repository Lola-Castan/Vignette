/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import { createApp } from 'vue';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Import des styles CSS pour le thème
import '../css/theme.css';

// Import du gestionnaire de thème
import './theme-switcher';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');

// Ajout d'un écouteur d'événements pour le clic sur les cartes pour éviter la surcharge du clic
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.card-clickable').forEach(function (card) {
        card.addEventListener('click', function (e) {
            const categoryLink = e.target.closest('.card__categories_category');
            // Si le clic est détecté sur une bulle de catégorie
            if (categoryLink) {
                window.location.href = categoryLink.getAttribute('href');
                return;
            }
            // Sinon, le clic est probablement sur la carte elle-même
            const modalId = card.getAttribute('data-modal-id');
            if (modalId) {
                const modalElement = document.getElementById(modalId);
                if (modalElement) {
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }
        });
    });
});

function pauseAllMedia() {
    document.querySelectorAll('audio, video').forEach(function (media) {
        if (!media.paused) media.pause();
    });
}

// Pause media on card click
window.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.card').forEach(function (card) {
        card.addEventListener('click', function (e) {
            pauseAllMedia();
        });
    });
    // Pause on modal open (if you use a modal with .modal or .card-modal)
    document.querySelectorAll('.modal, .card-modal').forEach(function (modal) {
        modal.addEventListener('click', function (e) {
            pauseAllMedia();
        });
    });
});
// Pause on page unload (navigation)
window.addEventListener('beforeunload', pauseAllMedia);