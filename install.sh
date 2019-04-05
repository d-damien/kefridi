#!/bin/bash

[ ! -f .env ] && echo "Edit .env file first." && exit 1

function log() {
  echo -e "####### $* \n#######\n"
}

log "Installation des dépendances. Patience..."
composer install --no-dev
composer require paragonie/random_compat=2.* # erreur dép.
composer dump-autoload
npm install

log "Compilation js et sass"
npm run prod

log "Création de la base de données"
> database/database.sqlite
./artisan migrate
./artisan db:seed

log "Génération des clefs de chiffrement"
./artisan key:generate
./artisan passport:keys
