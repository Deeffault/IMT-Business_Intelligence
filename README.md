# Plateforme d'Évaluation RSE - Guide de Démarrage

## Vue d'ensemble du Projet

Cette plateforme web permet d'évaluer et de comparer les performances RSE (Responsabilité Sociétale des Entreprises) des entreprises françaises, basée sur des données publiques fiables.

## Fonctionnalités Implémentées

### ✅ Structure de Base
- **Modèles de données** : Companies, RseScore, RseReport
- **Base de données** : Migrations et seeders avec données d'exemple
- **API REST** : Endpoints pour recherche et comparaison
- **Interface utilisateur** : Dashboard avec visualisations Chart.js

### ✅ Fonctionnalités RSE
1. **Recherche d'entreprises** par nom ou SIREN
2. **Affichage des scores** multi-critères (Environnement, Social, Gouvernance, Éthique)
3. **Visualisations** : graphiques en barres, camemberts, classements
4. **Système de notation** : A+ à E basé sur le score global
5. **Données d'exemple** : 13 entreprises françaises célèbres avec scores réalistes

### ✅ Architecture Technique
- **Backend** : Laravel 12 avec Eloquent ORM
- **Frontend** : Vue.js 3 + Inertia.js + Tailwind CSS
- **Graphiques** : Chart.js avec vue-chartjs
- **Services** : RseDataService pour l'intégration des APIs externes

## Lancement du Projet

### 1. Prérequis
- PHP 8.2+
- Node.js 18+
- Composer
- SQLite (déjà configuré)

### 2. Installation
```bash
# Dépendances PHP
composer install

# Dépendances JavaScript
npm install

# Configuration de la base de données
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
```

### 3. Lancement des serveurs
```bash
# Terminal 1 : Serveur Laravel
php artisan serve

# Terminal 2 : Serveur de développement Vite
npm run dev
```

### 4. Accès à l'application
- **Dashboard RSE** : http://localhost:8000/rse
- **Admin Laravel** : http://localhost:8000/dashboard (nécessite une authentification)

## Structure du Code

### Modèles (app/Models/)
- `Company.php` : Entreprises avec SIREN, secteur, taille
- `RseScore.php` : Scores RSE par thématique avec calculs automatiques
- `RseReport.php` : Rapports personnalisés payants

### Services (app/Services/)
- `RseDataService.php` : Intégration des APIs externes (Ademe, INSEE, Portail RSE)

### Contrôleurs (app/Http/Controllers/)
- `RseDashboardController.php` : API pour le dashboard RSE

### Pages Vue (resources/js/pages/)
- `RseDashboard.vue` : Interface principale avec métriques et graphiques

## Données d'Exemple

Le seeder `RseDataSeeder` inclut :
- **Grandes entreprises** : Danone, Schneider Electric, L'Oréal, Carrefour, etc.
- **PME/ETI** : EcoTech Solutions, Bio & Local, GreenBuild
- **Scores réalistes** : basés sur les performances RSE connues
- **Métriques détaillées** : CO2, consommation d'énergie, égalité H/F, certifications

## Prochaines Étapes à Implémenter

### Phase 1 : Interface Utilisateur Complète
- [ ] Page de détail d'entreprise avec graphiques radar
- [ ] Système de recherche avancée avec filtres
- [ ] Comparaison multi-entreprises
- [ ] Interface mobile responsive

### Phase 2 : Intégration des APIs Réelles
- [ ] Connecteur API Portail RSE du gouvernement
- [ ] Intégration ADEME pour les données environnementales
- [ ] API INSEE pour les données d'entreprises
- [ ] Système de cache pour optimiser les performances

### Phase 3 : Services Payants
- [ ] Génération de rapports personnalisés
- [ ] Système de paiement (Stripe)
- [ ] Recommandations d'amélioration RSE
- [ ] Tableau de bord pour les entreprises clientes

### Phase 4 : Monétisation
- [ ] Régie publicitaire pour annonces "bio/écolo"
- [ ] Système d'abonnement premium
- [ ] Partenariats avec des organismes de certification
- [ ] API payante pour développeurs tiers

## Technologies Utilisées

### Backend
- **Laravel 12** : Framework PHP moderne
- **SQLite** : Base de données légère pour développement
- **Eloquent ORM** : Mapping objet-relationnel
- **Inertia.js** : SPA sans API REST

### Frontend
- **Vue.js 3** : Framework JavaScript réactif
- **Composition API** : Style moderne de Vue.js
- **Tailwind CSS** : Framework CSS utilitaire
- **Chart.js** : Bibliothèque de graphiques
- **TypeScript** : Typage statique pour JavaScript

### Outils de Développement
- **Vite** : Build tool moderne et rapide
- **ESLint + Prettier** : Qualité de code
- **Pest** : Framework de tests PHP
- **Laravel Pint** : Formatage de code PHP

## Architecture Big Data (Prévue)

### Collecte de Données
- **ETL Pipelines** : Scripts automatisés pour récupérer les données
- **Cron Jobs** : Mise à jour quotidienne des scores
- **APIs Multiples** : Agrégation de sources diverses
- **Data Quality** : Scoring de la fiabilité des données

### Stockage et Performance
- **PostgreSQL** : Base de données relationnelle pour production
- **Redis** : Cache des requêtes fréquentes
- **Elasticsearch** : Recherche full-text avancée
- **AWS S3** : Stockage des rapports générés

### Analyse et Scoring
- **Algorithmes de Pondération** : Calcul des scores multi-critères
- **Machine Learning** : Prédiction des tendances RSE
- **Data Mining** : Extraction d'insights depuis les rapports
- **Benchmarking Sectoriel** : Comparaisons par industrie

## Business Model

### Sources de Revenus
1. **Publicité Ciblée** : Annonces d'entreprises éco-responsables
2. **Rapports Premium** : Analyses détaillées pour les entreprises
3. **Abonnements B2B** : Suivi continu des performances RSE
4. **Consulting** : Accompagnement pour améliorer les scores

### Avantages Concurrentiels
- **Données Publiques** : Transparence totale vs. solutions propriétaires
- **Gratuité de Base** : Démocratisation de l'information RSE
- **Temps Réel** : Mise à jour automatique via APIs
- **Compliance** : Respect RGPD et réglementations françaises

## Contribution

Ce projet étant à vocation éducative et d'intérêt général, les contributions sont les bienvenues :
- Amélioration des algorithmes de scoring
- Nouvelles sources de données
- Optimisations techniques
- Tests et documentation

---

**Note** : Ce projet est développé dans le cadre d'un cours de Business Intelligence à l'IMT. Il démontre l'application pratique des concepts Big Data aux enjeux de développement durable.
