# CityLunch — Application de commande de repas

Application web développée avec **Symfony 7.4** permettant la gestion de produits, d'un panier et d'utilisateurs (gérant / livreur).

---

## Stack technique

| Composant     | Technologie              |
|---------------|--------------------------|
| Backend       | PHP 8.2 + Symfony 7.4    |
| Base de données | MySQL 8.0              |
| Cache / Session | Redis 7                |
| ORM           | Doctrine ORM 3           |
| Frontend      | Twig + Asset Mapper      |
| Conteneurs    | Docker + Docker Compose  |

---

## Prérequis

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- PHP 8.2+
- Composer
- Symfony CLI (optionnel mais recommandé)

---

## Installation

### 1. Cloner le projet

```bash
git clone <url-du-repo>
cd EC03_REDON
```

### 2. Démarrer les conteneurs Docker

```bash
docker-compose up -d
```

Cela démarre :
- `citylunch_db` — MySQL sur le port `3306`
- `citylunch_redis` — Redis sur le port `6379`

### 3. Installer les dépendances PHP

```bash
composer install
```

### 4. Configurer l'environnement

Copier et adapter le fichier `.env` si nécessaire :

```bash
cp .env .env.local
```

Les variables importantes :

```dotenv
DATABASE_URL="mysql://root:root@127.0.0.1:3306/citylunch?serverVersion=8.0.32&charset=utf8mb4"
REDIS_URL=redis://127.0.0.1:6379
APP_SECRET=c1ty1unch$ecretK3y2024!
```

### 5. Créer la base de données et exécuter les migrations

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 6. Charger les données de test (fixtures)

```bash
php bin/console doctrine:fixtures:load
```

Cela crée :
- 1 compte gérant : `gerant@citylunch.fr` / `admin123`
- 2 comptes livreur : `livreur1@citylunch.fr` / `livreur123`, `livreur2@citylunch.fr` / `livreur123`
- 5 produits (plats + desserts)

### 7. Lancer le serveur de développement

```bash
symfony server:start
# ou
php -S localhost:8000 -t public/
```

L'application est accessible sur [http://localhost:8000](http://localhost:8000).

---

## Structure du projet

```
src/
├── Controller/
│   ├── CartController.php        # Gestion du panier (session)
│   ├── ProductController.php     # Liste des produits (page d'accueil)
│   ├── RegistrationController.php
│   └── SecurityController.php   # Login / Logout
├── Entity/
│   ├── User.php                  # Utilisateur (gérant, livreur)
│   ├── Product.php               # Produit (nom, prix, catégorie, stock)
│   ├── Order.php / OrderLine.php
│   ├── Customer.php
│   ├── Stock.php / Movement.php
├── Form/
│   └── RegistrationFormType.php
├── Security/
│   └── AppAuthenticator.php     # Authentification par formulaire
└── DataFixtures/
    └── AppFixtures.php
```

---

## Routes principales

| Méthode | URL            | Nom de route         | Description              |
|---------|----------------|----------------------|--------------------------|
| GET     | `/`            | `app_product_index`  | Liste des produits       |
| GET     | `/cart/add/{id}` | `cart_add`         | Ajouter un produit au panier |
| GET/POST | `/login`      | `app_login`          | Connexion                |
| GET     | `/logout`      | `app_logout`         | Déconnexion              |
| GET/POST | `/register`   | `app_register`       | Inscription              |

---

## Rôles utilisateurs

| Rôle           | Description                        |
|----------------|------------------------------------|
| `ROLE_USER`    | Attribué à tous les utilisateurs   |
| `ROLE_GERANT`  | Gérant de l'établissement          |
| `ROLE_LIVREUR` | Livreur                            |

---

## Commandes utiles

```bash
# Vider le cache
php bin/console cache:clear

# Créer une migration après modification d'une entité
php bin/console make:migration

# Appliquer les migrations
php bin/console doctrine:migrations:migrate

# Recharger les fixtures (supprime les données existantes)
php bin/console doctrine:fixtures:load --no-interaction

# Lancer les tests
php bin/phpunit
```

---

## Corrections apportées

- `ProductController` : remplacement de `getDoctrine()` (déprécié) par injection de `EntityManagerInterface`
- `CartController` : ajout du tag `<?php` manquant
- `doctrine.yaml` : correction de la plateforme (`PostgreSQLPlatform` → `MySQLPlatform`)
- `.env` : renseignement de `APP_SECRET` (requis pour les sessions et tokens CSRF)
- `docker-compose.yml` : suppression du service `database` PostgreSQL en doublon (généré par doctrine-bundle)
- `AppFixtures.php` : typage explicite de la propriété `$hasher`
