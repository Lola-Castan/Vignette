/**
 * Gestionnaire de thème clair/foncé
 * Script permettant de basculer entre un thème clair et un thème foncé
 */

// Définition des couleurs pour chaque thème
const themes = {
    light: {
        '--bg-color': '#ffffff',
        '--text-color': '#333333',
        '--navbar-bg': '#ffffff',
        '--navbar-text': '#333333',
        '--navbar-shadow': '0 2px 4px rgba(0,0,0,0.1)',
        '--navbar-toggler-filter': 'none',
        '--card-bg': '#ffffff',
        '--card-shadow': '0 2px 4px rgba(0,0,0,0.1)',
        '--input-bg': '#f8f9fa',
        '--input-border': '#ced4da',
        '--button-primary-bg': '#3490dc',
        '--button-primary-text': '#ffffff',
        '--dropdown-bg': '#ffffff',
        '--dropdown-text': '#333333',
        '--dropdown-hover-bg': '#f8f9fa',
        '--main-bg-image': 'none',
        '--main-bg-opacity': '1',
        '--main-bg-color': '#ffffff'
    },
    dark: {
        '--bg-color': '#121212',
        '--text-color': '#e1e1e1',
        '--navbar-bg': '#1e1e1e',
        '--navbar-text': '#ffffff',
        '--navbar-shadow': '0 2px 4px rgba(0,0,0,0.3)',
        '--navbar-toggler-filter': 'invert(1)',
        '--card-bg': '#1e1e1e',
        '--card-shadow': '0 2px 4px rgba(0,0,0,0.3)',
        '--input-bg': '#2a2a2a',
        '--input-border': '#444444',
        '--button-primary-bg': '#2779bd',
        '--button-primary-text': '#ffffff',
        '--dropdown-bg': '#2a2a2a',
        '--dropdown-text': '#e1e1e1',
        '--dropdown-hover-bg': '#3a3a3a',
        '--main-bg-image': 'none',
        '--main-bg-opacity': '1',
        '--main-bg-color': '#121212'
    },
    image: {
        '--bg-color': '#ffffff',
        '--text-color': '#333333',
        '--navbar-bg': '#ffffff',
        '--navbar-text': '#333333',
        '--navbar-shadow': '0 2px 4px rgba(0,0,0,0.1)',
        '--navbar-toggler-filter': 'none',
        '--card-bg': '#ffffff',
        '--card-shadow': '0 2px 4px rgba(0,0,0,0.1)',
        '--input-bg': '#f8f9fa',
        '--input-border': '#ced4da',
        '--button-primary-bg': '#3490dc',
        '--button-primary-text': '#ffffff',
        '--dropdown-bg': '#ffffff',
        '--dropdown-text': '#333333',
        '--dropdown-hover-bg': '#f8f9fa',
        '--main-bg-image': 'url("/storage/backgrounds/backgroundcitron.jpg")',
        '--main-bg-opacity': '0.5',
        '--main-bg-color': 'transparent'
    }
};

// Fonction pour définir le thème
function setTheme(themeName) {
    // Appliquer les variables CSS du thème sélectionné
    const selectedTheme = themes[themeName];
    for (const property in selectedTheme) {
        document.documentElement.style.setProperty(property, selectedTheme[property]);
    }
    
    // Définir l'attribut data-theme sur l'élément HTML
    document.documentElement.setAttribute('data-theme', themeName);
    
    // Gérer spécifiquement l'image de fond si on est en thème "image"
    const backgroundContainer = document.getElementById('background-container');
    if (backgroundContainer) {
        if (themeName === 'image') {
            // Extrait l'URL de l'image de la variable CSS
            const bgImageValue = selectedTheme['--main-bg-image'];
            const urlMatch = bgImageValue.match(/url\(['"]?([^'"]+)['"]?\)/);
            if (urlMatch && urlMatch[1]) {
                backgroundContainer.style.backgroundImage = `url(${urlMatch[1]})`;
            }
        } else {
            backgroundContainer.style.backgroundImage = 'none';
        }
    }
    
    // Sauvegarder le thème choisi dans localStorage
    localStorage.setItem('theme', themeName);
    
    // Mettre à jour l'icône du bouton de thème
    updateThemeIcon(themeName);
}

function toggleTheme() {
    const currentTheme = localStorage.getItem('theme') || 'light';
    let newTheme;
    
    if (currentTheme === 'light') {
        newTheme = 'dark';
    } else if (currentTheme === 'dark') {
        newTheme = 'image';
    } else {
        newTheme = 'light';
    }
    
    setTheme(newTheme);
}

function updateThemeIcon(themeName) {
    const themeIcon = document.getElementById('theme-icon');
    if (themeIcon) {
        if (themeName === 'dark') {
            themeIcon.className = 'fas fa-image';
            themeIcon.title = 'Passer au thème avec image';
        } else if (themeName === 'image') {
            themeIcon.className = 'fas fa-sun';
            themeIcon.title = 'Passer au thème clair';
        } else {
            themeIcon.className = 'fas fa-moon';
            themeIcon.title = 'Passer au thème sombre';
        }
    }
}

// Initialiser le thème au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    // Vérifier si l'utilisateur a déjà choisi un thème
    const savedTheme = localStorage.getItem('theme');
    
    // Si aucun thème n'est enregistré, vérifier les préférences du système
    if (!savedTheme) {
        const prefersDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        setTheme(prefersDarkMode ? 'dark' : 'light');
    } else {
        // Sinon, appliquer le thème sauvegardé
        setTheme(savedTheme);
    }
    
    // Ajouter l'écouteur d'événement pour le bouton de changement de thème
    const themeToggleBtn = document.getElementById('theme-toggle');
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', toggleTheme);
    }
    
    // Gestionnaire du menu utilisateur
    setupUserMenu();
});

// Fonction pour gérer le menu utilisateur
function setupUserMenu() {
    const navbarDropdown = document.getElementById('navbarDropdown');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    
    if (navbarDropdown && dropdownMenu) {
        // Ajouter l'événement click manuellement pour desktop
        navbarDropdown.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Toggler la classe show pour afficher/masquer le menu
            const isOpen = dropdownMenu.classList.contains('show');
            if (isOpen) {
                dropdownMenu.classList.remove('show');
                navbarDropdown.setAttribute('aria-expanded', 'false');
            } else {
                dropdownMenu.classList.add('show');
                navbarDropdown.setAttribute('aria-expanded', 'true');
            }
        });
        
        // Fermer le menu si on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!navbarDropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
                navbarDropdown.setAttribute('aria-expanded', 'false');
            }
        });
    }
}