# Installation
1. PHP 7 requis
1. `git clone git@github.com:d-damien/kefridi`
1. `cd kefridi; cp .env.example .env`
1. Éditer le fichier `.env` et lui donner les paramètres désirés.
Configurer notamment la connexion MySQL/MariaDB − le SQLite par défaut écrira dans `database/database.sqlite`.
On pourra laisser APP_KEY vide.
1. Lancer `./install.sh`
1. Servir frais.

# Utilisation
## Interface web
Deux comptes sont configurés par défaut dont les identifiants ont été envoyés par email.
Une fois connecté, l'onglet Tâches permet les actions CRUD avec une coloration dont la légende est affichée intuitivement dans le menu.
- Cliquer sur le titre d'une tâche permet de l'éditer
- Le lien optionel s'affiche dans un footer
- les boutons s'affichent en fonction du statut de la tâche

## API
Dans l'onglet compte, on peut générer un jeton pour authentifier les requêtes vers les routes de l'API JSON.
Exemple avec `curl` :
```
# liste les tâches de l'utilisateur
token=le_jeton
curl http://localhost:8000/api/tasks -H "Authorization: Bearer $token"
```

Routes disponibles :
- GET /api/user
- GET /api/tasks
- POST /api/tasks : créer une tâche
- GET /api/tasks/{id} : obtenir une tâche en particulier
- PUT/PATCH /api/tasks/{id} : Changer un ou plusieurs paramètres. Formater l'entrer en JSON.
- DELETE /api/tasks/{id} : supprimer
- GET /api/tasks/list/{action} : filtrer selon statut avec action parmi [todo, ongoing, done]
- PATCH /api/tasks/{id}/start : passer du statut "à faire" au statut "en cours"
- PATCH /api/tasks/{id}/end : passer du statut "en cours" au statut "terminée"

# Considération techniques
- On préfère ajouter un statut à l'objet Task avec une table supplémentaire
plutôt que d'utiliser directement les timestamps *_at* afin d'anticiper l'arrivée de nouveaux statuts
- La programmation dite "par garde" est privilégiée pour éviter de trop nombreux niveaux d'inclusion
- Les vues Laravel ont été préférées mais il serait trivial d'ajouter une interface Vue.js utilisant l'API sur la page d'accueil

## Sécurité
- XSS : empêchées par les doubles crochets `{{ }}` des vues Blade
- CSRF : un formulaire HTML avec un jeton de connexion pour toute action
- injections SQL : empêchées par l'ORM Eloquent
- 404 au lieu de 403 pour ne pas indiquer l'existence de la resource
aux utilisateurs non autorisés (Api\TaskController)

### Perspectives
- afficher la date de dernière connexion pour signaler au plus tôt une intrusion ?
- utiliser l'authentification à double facteur 2FA/OTP ?

