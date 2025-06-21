# Application de Gestion des Offres de Stage

## Table des matières
- [Description](#description)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Configuration](#configuration)
- [Fonctionnalités](#fonctionnalités)
  - [Administration](#administration)
  - [Utilisateur](#utilisateur)
- [Utilisation](#utilisation)
- [Structure du Projet](#structure-du-projet)
- [Dépendances](#dépendances)
- [Contributeurs](#contributeurs)
- [Licence](#licence)
- [Contact](#contact)

---

## Description

Ce projet est une application web développée avec **Symfony 6.x** pour faciliter la gestion des offres de stage.  
Elle permet aux administrateurs de créer, modifier, valider et supprimer des offres de stage, tandis que les utilisateurs peuvent consulter les détails des offres et postuler en soumettant un CV.  
L'application intègre une authentification sécurisée et des relations entre les entités `OffreStage`, `Candidature`, et `User`, gérées via Doctrine ORM.

- **Date de création**: Juin 2025  
- **Dernière mise à jour**: 21 Juin 2025  
- **Développé par**: [Votre Nom]

---

## Prérequis

Assurez-vous d'avoir les outils suivants installés :

- **PHP 8.1 ou supérieur** avec les extensions `pdo_mysql` et `mbstring`
- **Composer**
- **Symfony CLI** (optionnel mais recommandé)
- **Serveur web** (PHP intégré, Apache ou Nginx)
- **Base de données** : MySQL 8.0+ ou SQLite
- **Git**

---

## Installation

1. **Cloner le dépôt :**
   ```bash
   git clone https://github.com/votre-utilisateur/projet-symfony.git
   cd projet-symfony

    Installer les dépendances :

composer install

Configurer la base de données :

Copier .env en .env.local et ajuster la configuration :

Pour MySQL :

DATABASE_URL="mysql://utilisateur:mot_de_passe@127.0.0.1:3306/nom_de_la_base?serverVersion=8.0"

Pour SQLite :

DATABASE_URL="sqlite:///db.sqlite"

Créer la base de données :

php bin/console doctrine:database:create

Générer les tables :

php bin/console doctrine:schema:update --force

Lancer le serveur :

Avec Symfony CLI :

symfony server:start

Ou avec PHP intégré :

php -S 127.0.0.1:8000 -t public
