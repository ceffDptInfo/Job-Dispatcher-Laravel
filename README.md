## À propos de JobDispatcher
Application web qui permet la gestion des impressions 3D au format .STL sous forme de file d'attente. Ce site web est développer pour un projet d'automaticiens CFC du Ceff Industrie.
 # Installation
## Prérequis
1. [VScode](https://code.visualstudio.com/download)
2. [NodeJS](https://nodejs.org/fr/download) (Version recommandé v24.10.0)
3. [Composer](https://getcomposer.org/download/) (Version recommandé 2.9.5)
4. [WampServer](https://www.wampserver.com/) (Version php inclus 8.4.15)
5. [MySQL Workbench](https://dev.mysql.com/downloads/workbench/)
6. [Docker desktop](https://docs.docker.com/desktop/setup/install/windows-install/)

## Extension à installer dans Visual Studio Code
- Laravel Blade Snippets
- Laravel Blade Formatter
- Laravel Snippets
- PHP Intelephense
- PHP Namespace Resolver
- Composer
- Docker 

## WampServer
1. Installer les fichiers C++ : https://www.techpowerup.com/download visual-c-redistributable-runtime-package-all-in-one/
2. Cliquer sur un des serveur US pour télécharger le pack de fichier c++
3. Extraire le zip téléchargé, dans un dossier et exécuter le fichier .bat
télécharger WampServer : https://wampserver.aviatechno.net/files/install/wampserver3.4.0_x64.exe
4. Exécuter l'exe et suivez les instructions
5. Rendez-vous dans le dossier de WampServer puis aller dans bin/php/8.4.15 et copier le chemin d'accès
6. Coller le chemin d'accès dans le PATH de vos variables d'environnement système.
7. Fermer les invites de commandes puis rouvrez en une pour valider l'installation avec php -v

## Docker
Assurez-vous de créer un compte sur docker desktop valide et utilisable.

##  MySQL Workbench 
Créez une nouvelle connexion depuis MySQL Workbench et entrez les informations suivantes :

- Connection Name : printer_db
- Host : 127.0.0.1
- Port : 3306
- User : root
- Password : Pa$$w0rd

Tester la connexion si c'est ok confirmation la création de connection.

## Composer
1. Fermer le projet s'il est ouvert avant de débuter cette phase.
2. Suivre les instructions et attendre la fin de l'installation.

## NFS windows
1. Se rendre dans l'explorateur de fichier.
2. Créer un dossier. 
3. Clique droit sur le dossier, et aller sur autres options et accorder l'accès à. 
4. Cliquer sur partage avancé.
5. Après ouverture de la fenêtre cliquer à nouveau sur partage avancé.
6. Cocher la case partager son dossier, donner un nom.
7. Dans autorisations accordé le contrôle total et cliquer sur appliqué.
8. Se rendre dans le dossier partagé et créer à l'intérieur un dossier users et un dossier slicer_profiles.
9. Faites une copie du .env.example et renommer le .env.
10. Ensuite copier le chemin d'accès et le mettre dans le .env comme l'exemple ci-dessous.
  ```
NFS_SHARE_PATH="\\\\VOTRE-NOM-DE-MACHINE\\NOM-DONNER-AU-DOSSIER-PARTAGÉ\\Users\\"
  ```
## Cloner le projet
  1. Commencer par vous rendre dans un répertoire ou vous souhaitez mettre le projet (depuis l'invite de commande) puis cloner le avec :
    `git clone https://github.com/ceffDptInfo/Job-Dispatcher-Laravel.git`
  2. Ouvrez le projet dans VScode et ouvrez un terminal de commande puis installer les dépendances via le terminal du projet :
    `npm install`
  3. Executer depuis le cmd `composer install`. 
  4. Toujours dans la cmd, faites : cd docker 
  5. Puis lancer : docker compose up -d
  6. exécuter la commande depuis le terminal du projet :
    `php artisan migrate:fresh --seed` cela met en place les tables dans la base de donnée.
  7. Encore dans le projet, mettez vos variables de connexion à la DB dans le fichier **.env** 
  ```
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=printer_db 
  DB_USERNAME=root
  DB_PASSWORD=Pa$$w0rd

  MAIL_MAILER=smtp
  MAIL_HOST=smtp-relay.intra.ceff.ch
  MAIL_PORT=25
  MAIL_FROM_ADDRESS=no-reply@ceff.ch
  MAIL_FROM_NAME="JobDispatcher"
  MAIL_USERNAME=null
  MAIL_PASSWORD=null
  MAIL_ENCRYPTION=null

  // INFO : S'il y à d'autres éléments comme DB_, MAIL_ ne corresponde pas à ceux de dessus retirer les.
```
  8. Executer depuis le cmd la commande composer run dev afin de lancer le projet.

# Crédits 
Projet web développé dans le cadre d'un travaille commun avec les automaticiens :
- Urfer Leila
- Golay Simon
- Gane Gyan
- Curty Gwendoline
 