## Pré-requis

Ce qu'il est requis pour commencer avec Projecteur

- PHP Version 8.0.2
- MySQL
- Symfony version 6.0 minimum
- Composer

## Installation

Après avoir cloné le projet avec `git clone https://github.com/Davvvvvvv/CuisineDeChezVous.git`

Ensuite tapez la commande `composer install` afin d'installer toutes les dépendances composer du projet.

Puis exécuter la création de la base de donnée avec la commande : `symfony console doctrine:database:create`

Exécuter la migration en base de donnée : `symfony console doctrine:migration:migrate`

Après importer les données grâce au fichier .sql pour remplir votre base avec mes données.

## Update

Toutes les fonctionnalités back-end de la version sont opérationnnels manque plus qu'à revoir le front avec un framework.

Puis après on se penchera sur le côté social .

## Infos

Se rajouter manuellement dans phpMyAdmin le ROLE_ADMIN dans le tableau json (ROLES). Pour pouvoir accéder au tableau de bord de l'administrateur accesible en utilisant la route (/admin).

Lorsque l'on s'inscrit normallement on devrait vérifier notre compte en cliquant sur un lien qui nous serait envoyer dans notre mail mais sur symfony 6 je sais pas pourquoi mais ça veut pas marcher mais y a moyen que je trouve la solution dans pas très longtemps mais ça ne gache en rien l'expérience utilisateur.
