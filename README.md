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


