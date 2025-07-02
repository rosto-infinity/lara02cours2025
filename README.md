# Gestion de Produits & Sauvegarde de Base de Données (Laravel)

Ce projet est une application Laravel permettant la gestion complète d’un catalogue de produits avec des fonctionnalités avancées de sauvegarde et restauration de la base de données.

## Fonctionnalités principales

### Gestion des produits (CRUD)
- **Lister** les produits avec pagination et total dynamique.
- **Ajouter** un nouveau produit (titre, catégorie, prix).
- **Modifier** un produit existant.
- **Supprimer** un produit.
- **Afficher** le détail d’un produit.
- **Validation** des champs côté serveur.
- **Interface utilisateur** moderne (Blade, TailwindCSS).

### Sauvegarde & restauration de la base de données
- **Lister** les sauvegardes existantes (nom, taille, date).
- **Créer** une nouvelle sauvegarde (commande artisan personnalisée).
- **Télécharger** une sauvegarde.
- **Importer** une sauvegarde (upload .gz).
- **Supprimer** une sauvegarde.
- **Restaurer** une sauvegarde.

## Technologies utilisées
- **Laravel 10+** (MVC, Eloquent, Migrations, Seeders)
- **Vite**, **TailwindCSS**, **Axios** pour le front-end
- **SQLite** (par défaut, modifiable)
- **Tests** unitaires et fonctionnels (structure prête)

## Installation

1. Cloner le dépôt :
   ```bash
   git clone <url-du-repo>
   cd b-lara02cours-crud-2025
   ```
2. Installer les dépendances PHP :
   ```bash
   composer install
   ```
3. Installer les dépendances front-end :
   ```bash
   npm install
   ```
4. Copier le fichier `.env.example` en `.env` et configurer la base de données si besoin.
5. Générer la clé d’application :
   ```bash
   php artisan key:generate
   ```
6. Lancer les migrations et seeders :
   ```bash
   php artisan migrate --seed
   ```
7. Démarrer le serveur :
   ```bash
   php artisan serve
   npm run dev
   ```

## Roadmap (fonctionnalités futures)
- **Expert Excel** : export/import des produits au format Excel (.xlsx), génération de rapports avancés.
- **Expert PDF** : export PDF des listes de produits, factures, rapports, etc.

## Structure du projet
- `app/Http/Controllers/Crud/ProductController.php` : logique CRUD produits
- `app/Http/Controllers/DBBackupController.php` : gestion des sauvegardes/restaurations
- `resources/views/pages/` : vues Blade (produits, sauvegardes)
- `public/template-products/` : templates HTML statiques
- `database/migrations/` : structure de la base de données

## Tests
Lancez les tests avec :
```bash
php artisan test
```

## Auteur
-  Prof Waffo lele Rostand

---
