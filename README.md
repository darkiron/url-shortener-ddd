# URL Shortener 📏
URL Shortener est une application qui permet de raccourcir des URLs longues en des liens courts et facilement partageables. Le projet utilise Symfony comme framework PHP et adopte une architecture DDD (Domain-Driven Design) pour une structure claire et évolutive. La solution est également Dockerisée pour faciliter le déploiement.

## 🚀 Fonctionnalités
Raccourcir des URLs longues.
Rediriger automatiquement vers l'URL d'origine via un lien court.
Lister et gérer les redirections existantes.
## 🛠️ Technologies utilisées
* PHP 8.2+
* Symfony 6.x
* Doctrine ORM
* Docker & Docker Compose
* SQLite (base de données légère)
* Symfony Messenger (pour le CQRS avec des handlers de commandes)
## 🧱 Architecture
Le projet suit les principes Domain-Driven Design (DDD) et CQRS. Voici la structure principale :

```bash 
Copier le code
src/
├── Application/           # Cas d'utilisation et logique applicative
├── Domain/                # Logique métier (entités, value objects, services de domaine)
├── Infrastructure/        # Repositories, services techniques, implémentations Doctrine
├── Controller/            # Points d'entrée (HTTP)
└── ...
```
## 🚀 Installation et exécution
1. Prérequis
   Assurez-vous d'avoir les outils suivants installés :

Docker
Docker Compose
2. Cloner le projet
```bash 
   Copier le code
   git clone git@github.com:darkiron/url-shortener-ddd.git
   cd url-shortener
```
3. Lancer le projet avec Docker
```bash 
   Copier le code
   docker-compose up --build
```
4. Accéder au projet
   Frontend : http://localhost:80

   La base de données SQLite est stockée dans var/app.db.
## 📄 Routes principales
| Méthode | URL         | Description                         |
|---------|-------------|-------------------------------------|
| GET     | `/api/all`  | Liste toutes les redirections en json. |
| GET     | `/{linkId}` | Redirige vers l'URL raccourcie.     |
| GET     | `/all`      | iste toutes les redirections .     |

## 🧪 Tests
   Pour exécuter les tests (unitaires ou fonctionnels), lancez la commande suivante :

```bash 
docker-compose exec php bin/phpunit
```
## 🛠️ Contribution
Les contributions sont les bienvenues ! Voici comment participer :


1. Forker le projet.
2. Créer une branche pour votre fonctionnalité (`git checkout -b feature/ma-fonctionnalite`).
3. Committez vos changements (`git commit -m "feat: ajout de la fonctionnalité X"`).
4. Poussez vos modifications (`git push origin feature/ma-fonctionnalite`).
5. Ouvrez une Pull Request 🎉.

##📜 Licence
Ce projet est sous licence MIT. Consultez le fichier LICENSE pour plus d'informations.

## ✨ Auteur
Développé à la base par Pierre Miniggio.
Mise à jour Darkiron

