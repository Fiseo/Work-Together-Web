# Work-Together

Projet conçut pour l'épreuve E6 du BTS SIO option SLAM en utilisant le Framework Symfony
---

# Features

Le projet Web est disponible uniquement au client de l'entreprise.
Le client est capable de passer commande ainsi que de consulter les informations des ses commandes passées et en cours.

---

# Quick start

## Clonez le dépot
```ps1
git clone https://github.com/Fiseo/Work-Together-Web
```

## Récupérez les packages nécéssaires
```ps1
composer install
```

## Configurez la chaine de connexion à votre base de donnée dans votre .env
```
DATABASE_URL="mysql://nom_utilisateur:_mot_de_passe@adresse_du_serveur/nom_base_donnée?serverVersion=8.0&charset=utf8mb4"
```
## Créez la base de donnée, appliquez les migrations et créez le jeu de donnée
```ps1
php .\bin\console d:d:c
php .\bin\console d:m:m
php .\bin\console d:f:l
```

