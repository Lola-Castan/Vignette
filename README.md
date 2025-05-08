# Vignette

## À propos du projet

Vignette est une application web inspirée de Pinterest, conçue pour présenter et promouvoir les travaux graphiques et visuels des étudiants. L'application affiche des médias (images, sons, vidéos) sous forme de vignettes, filtrables par catégories. Pour préserver l'anonymat des créateurs, les noms des étudiants ne sont pas affichés, mais chaque œuvre est associée à un numéro unique identifiant son créateur.

## Fonctionnalités principales

### Pour les visiteurs
- Visualisation des vignettes dans un dashboard interactif
- Filtrage des vignettes par catégorie ou par numéro de créateur
- Affichage détaillé d'une vignette en plein écran
- Lecture automatique des médias (son/vidéo) lors de l'ouverture d'une vignette
- Interface responsive adaptée à tous les appareils

### Pour les utilisateurs (rôle USER)
- Authentification par email et mot de passe
- Ajout de contenu avec:
  - Images
  - Sons (optionnel)
  - Vidéos (exclusif avec son)
  - Titre (obligatoire)
  - Description
  - Catégorie (obligatoire)
- Consultation de leur numéro unique de créateur

### Pour les administrateurs (rôle ADMIN)
- Toutes les fonctionnalités des utilisateurs standard
- Gestion des catégories (ajout, modification, désactivation, suppression)
- Gestion des comptes utilisateurs (ajout, modification, désactivation)
- Modération du contenu (désactivation, changement de taille d'affichage)
- Configuration des thèmes:
  - Fond noir
  - Fond blanc
  - Fond avec image personnalisée
  - Réglage de l'opacité de l'image de fond

## Types de formats de vignettes

Les vignettes peuvent être affichées selon trois formats prédéfinis:
- **Petit** (1 x 1) - Format par défaut
- **Large** (2 x 1)
- **Grand** (2 x 2)

Seuls les administrateurs peuvent modifier le format d'affichage des vignettes.

## Sécurité

L'application assure la sécurité des données et des utilisateurs grâce à:
- Une communication sécurisée avec la base de données
- L'implémentation de jetons CSRF
- Une gestion sécurisée de l'inclusion de fichiers
- Des tests unitaires pour vérifier la robustesse du code

## Installation

### Prérequis
- PHP 8.2 ou supérieur
- Composer
- Node.js et npm
- Serveur de base de données (MySQL, PostgreSQL)

### Étapes d'installation

1. Cloner le dépôt
```bash
git clone https://github.com/Lola-Castan/Vignette.git
cd Vignette
```

2. Installer les dépendances
```bash
composer install
npm install
```

3. Configurer l'environnement
```bash
cp .env.example .env
php artisan key:generate
```

4. Créer le lien avec le dossier storage
```bash
php artisan storage:link
```

5. Configurer la base de données dans le fichier .env

6. Exécuter les migrations et les seeders
```bash
php artisan migrate --seed
```

7. Compiler les assets
```bash
npm run dev
```

8. Lancer le serveur
```bash
php artisan serve
```

## Déploiement

Le site est accessible à l'adresse: [URL_DU_SITE_DÉPLOYÉ]

## Informations de connexion par défaut

Un compte administrateur est créé par défaut avec les identifiants suivants:
- Email: admin@example.com
- Mot de passe: password

**Important**: Changez ces identifiants après la première connexion.

## Licence

Ce projet est développé dans un contexte éducatif.

## Contributeurs
- [Benjamin BOUTROIS](https://github.com/benjamin-bou) - Développeur
- [Lola CASTAN](https://github.com/Lola-Castan) - Développeuse