

# 🍽️ CityLunch — Application de commande de repas

**Application web développée avec Symfony 7.4** permettant la gestion de produits, de paniers et d'utilisateurs (gérants, livreurs, clients).
Ce projet s’inscrit dans le cadre de la formation **Bachelor Développeur Full Stack** en alternance.

---

## 🛠 Stack Technique & Composants
   **Composant**         | **Technologie**                     |
 |-----------------------|-------------------------------------|
 | **Backend**           | PHP 8.2 + Symfony 7.4               |
 | **Base de données**   | MySQL 8.0 (Données relationnelles) |
 | **Cache / Session**   | Redis 7 (Performance & paniers)     |
 | **ORM**               | Doctrine ORM 3                      |
 | **Frontend**          | Twig + Asset Mapper (JS moderne)    |
 | **Conteneurs**        | Docker + Docker Compose             |
 | **Outils**            | Symfony CLI, Composer 2.6+          |

---

## 📋 Prérequis

Pour exécuter ce projet localement, assurez-vous d’avoir installé :
- **Docker Desktop** (version 20.10+)
- **PHP 8.2+** (pour les commandes Symfony/Composer en local)
- **Composer 2.6+**
- **Symfony CLI** (recommandé pour le serveur local et TLS)

---

## 🚀 Initialisation du projet

Pour démarrer rapidement, suivez ces étapes :

### 1. Clonage et installation
```bash
git clone https://github.com/niicolavic94/EC03_citylunch.git
cd EC03_citylunch
composer install



2. Configuration de l’environnement
bash
Copy

cp .env .env.local



⚠️ Vérifiez les variables suivantes dans .env.local :

DATABASE_URL (ex: mysql://db_user:db_password@mysql:3306/citylunch?serverVersion=8.0)
REDIS_URL (ex: redis://redis:6379)
3. Lancement de l’infrastructure (Docker)
bash
Copy

docker-compose up -d



4. Initialisation de la base de données
bash
Copy

php bin/console doctrine\:database\:create
php bin/console doctrine\:migrations\:migrate --no-interaction
php bin/console doctrine\:fixtures\:load --no-interaction



5. Démarrage du serveur Symfony
bash
Copy

symfony server\:start



Accédez à l’application : http://localhost:8000

💻 Configuration de l’IDE (Recommandations)
Pour un développement optimal :

PHPStorm :

Installer les plugins Symfony Support et PHP Annotations.
Configurer l’interpréteur distant via Docker.

VS Code :

Extensions recommandées : PHP Intelephense, Symfony Extension, Twig Language 2.

Formatage : Le projet suit les normes PSR-12. Activez le Format on Save.

🗄️ Architecture des données

MySQL : Stockage persistant des données relationnelles (utilisateurs, commandes, produits).
Redis : Gestion des sessions et du cache pour les paniers (réactivité accrue).

🔐 Sécurité & SSL 

Certificat : Utiliser Let’s Encrypt (gratuit et automatisé).
Reverse-Proxy : Configurer Nginx ou Traefik pour la terminaison TLS (HTTPS → port 8000).
Headers : Activer HSTS (Strict-Transport-Security) pour forcer HTTPS.

📁 Structure du projet


src/
├── Controller/       # Logique de routage (Cart, Product, Security, etc.)
├── Entity/           # Modèles Doctrine (User, Product, Order, Stock...)
├── Security/         # Authentification & AppAuthenticator
├── Repository/       # Requêtes personnalisées
├── Service/          # Logique métier (ex: gestion du panier)
└── DataFixtures/     # Données de test (Admin: gerant@citylunch.fr / admin123)




🔗 Lien du dépôt:  https://github.com/niicolavic94/EC03_citylunch
