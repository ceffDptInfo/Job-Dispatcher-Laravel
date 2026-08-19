## À propos de JobDispatcher
Application web qui permet la gestion automatisé d'impressions 3D au format .stl sous forme de file d'attente.

# Installation 
## Prérequis
Voici ce qu'il faut avoir d'installé :

1. [VScode](https://code.visualstudio.com/download)
2. [NodeJS](https://nodejs.org/fr/download) (Version recommandé v24.15.0)
3. [WampServer](https://wampserver.aviatechno.net/?lang=en=) (Version php 8.4.15)
4. [Composer](https://getcomposer.org/download/) (Version recommandé 2.9.5)
5. [MySQL Workbench](https://dev.mysql.com/downloads/file/?id=552199)
6. [Git](https://git-scm.com/install/)

Il faut aussi avoir suivit ces différentes docs au préalable :
  * [Mock](https://github.com/ceffDptInfo/Job-Dispatcher-Core/blob/main/docs/mock.md)
  * [Core](https://github.com/ceffDptInfo/Job-Dispatcher-Core)
  * [Slicer](https://github.com/ceffDptInfo/Job-Dispatcher-Slicer)
  * [MySQL](https://github.com/ceffDptInfo/Job-Dispatcher-Core/blob/main/docs/mysql.md)
  * [Dossier partagé (NFS)](https://github.com/ceffDptInfo/Job-Dispatcher-Core/blob/main/docs/nfs.md)

## Extension à installer dans Visual Studio Code
- Laravel Blade Snippets
- Laravel Blade Formatter
- Laravel Snippets
- PHP Intelephense
- PHP Namespace Resolver
- Composer
- Docker
 
## WampServer
1. Installer les fichiers C++ : https://www.techpowerup.com/download/visual-c-redistributable-runtime-package-all-in-one/
2. Cliquer sur un des serveur US pour télécharger le pack de fichier c++
3. Extraire le zip téléchargé, dans un dossier et exécuter le fichier install_all une fois fini
télécharger WampServer : https://wampserver.aviatechno.net/files/install/wampserver3.4.0_x64.exe
4. Exécuter l'exe et suivez les instructions
5. Une fois Wamp lancé faire un `clique gauche` dessus, séléctionner `php`, puis `version` et enfin séléctionner la version `8.4.15`.
5. Rendez-vous dans le dossier ou se trouve WampServer puis aller dans bin/php/8.4.15 et copier le chemin d'accès.
6. Coller le chemin d'accès dans le PATH de vos variables d'environnement système (Rechercher sur window : modifier les variable d'environnement).
7. Fermer les invites de commandes puis rouvrez en une pour valider l'installation avec `php -v`

## Composer
1. Fermer le projet s'il est ouvert avant de lancer le .exe
2. Lancer le .exe d'installation de composer.
3. Suivre les instructions et attendre la fin de l'installation.

## Cloner le projet
  1. Commencer par vous rendre dans un répertoire ou vous souhaitez mettre le projet (depuis l'invite de commande) puis cloner le avec :
    `git clone https://github.com/ceffDptInfo/Job-Dispatcher-Laravel.git`
  2. Taper ensuite `cd Job-Dispatcher-Laravel` et faites ensuite `code .`
  3. Ouvrez le projet dans VScode et ouvrez un terminal de commande puis installer les dépendances via le terminal du projet :
    `npm install` et un `npm audit fix`
  4. Executer depuis le cmd `composer install`.
  5. Ensuite faites : `composer global require laravel/installer`.
  8. Dans le terminal faire `cp .env.example .env` depuis la racine du projet, puis y modifier ces variables :
 
  ```
  DB_CONNECTION=mysql
  DB_HOST=ipDeLaVmMySQL
  DB_PORT=3306
  DB_DATABASE=printer_db
  DB_PASSWORD=dispatcher1234
 
  NFS_SHARE_PATH="\\\\NOM-D-LA-MACHINE\\NOM-DOSSIER-PARTAGÉ\\Users\\"

  MAIL_MAILER=smtp
  MAIL_HOST=smtp-relay.intra.ceff.ch
  MAIL_PORT=25
  MAIL_FROM_ADDRESS=no-reply@ceff.ch
  MAIL_FROM_NAME="JobDispatcher"
  MAIL_USERNAME=null
  MAIL_PASSWORD=null
  MAIL_ENCRYPTION=null

```
 
  10. exécuter la commande depuis le terminal du projet :
    `php artisan migrate:fresh --seed` cela met en place les tables dans la base de donnée. Attention il faut vous placer dans la racine du projet.
  11. lancer la commande `php artisan key:generate`
  12. Executer depuis le cmd la commande `composer run dev` afin de lancer le projet.
 
 ##  MySQL Workbench
Créez une nouvelle connexion depuis MySQL Workbench et entrez les informations suivantes :
 
- Connection Name : printer_db
- Host : IP du serveur MySQL
- Port : 3306
- User : root
- Password : dispatcher1234
 
Tester la connexion si c'est ok.

# Crédits
Les 4 informaticiens ayant participé au projet :
- Urfer Leila
- Golay Simon
- Gane Gyan
- Curty Gwendoline