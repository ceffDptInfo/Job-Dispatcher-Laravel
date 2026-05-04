## À propos de JobDispatcher
Application web qui permet la gestion des impressions 3D au format .STL sous forme de file d'attente. Ce site web est développé par des informaticiens CFC 3ème année du Ceff Industrie.

 # Installation
## Prérequis
1. [VScode](https://code.visualstudio.com/download)
2. [NodeJS](https://nodejs.org/fr/download) (Version recommandé v24.15.0)
3. [WampServer](https://www.wampserver.com/) (Version php inclus 8.4.15)
4. [Composer](https://getcomposer.org/download/) (Version recommandé 2.9.5)
5. [MySQL Workbench](https://dev.mysql.com/downloads/file/?id=552199)
6. [Docker desktop](https://docs.docker.com/desktop/setup/install/windows-install/) (Si erreur consulter sa section pour résoudre le soucis)
6. [Git](https://git-scm.com/install/)

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
5. Rendez-vous dans le dossier de WampServer puis aller dans bin/php/8.4.15 et copier le chemin d'accès
6. Coller le chemin d'accès dans le PATH de vos variables d'environnement système (Rechercher sur window : modifier les variable d'environnement).
7. Fermer les invites de commandes puis rouvrez en une pour valider l'installation avec php -v
 
## Docker
Après avoir installer docker Desktop, assurez-vous de créer un compte sur docker desktop valide et utilisable, après l'installation de docker l'installateur demande de redémarrer l'ordinateur, faites le. Une fois le redémarrage terminé, cliquer sur le petit icon >_ en bas à droite, puis sur Enable, ensuite lancer la commande wsl --update, puis cliquer sur Try Again et attender que docker démarre.

### Erreur : For scurity reasons... ---> Suivez ces étapes : 

1. Supprimer le dossier DockerDesktop s'il est présent (dans C:\ProgramData)
2. Exécuter l'installateur Docker en tant qu'admin (clic droit sur l'exe, exécuter en tant qu'admin).
3. L'installateur devrait maintenant fonctionner.
 
## Composer
1. Fermer le projet s'il est ouvert avant de débuter cette phase.
2. Suivre les instructions et attendre la fin de l'installation.
 
## NFS windows
1. Se rendre dans l'explorateur de fichier.
2. Créer un dossier (Fortement récommandé de le faire à la racine de votre C:).
3. Clique droit sur le dossier, et aller sur propriétés
4. Rendez-vous dans l'onglet partage et cliquez sur partage avancé.
5. Cocher la case partager son dossier, donner un nom.
6. Dans autorisations accordé le contrôle total et cliquer sur appliqué.
7. Se rendre dans le dossier partagé et créer à l'intérieur un dossier users et un dossier slicer_profiles.
8. Mettez en pause cette étape et revenez après avoir fini l'étape 3 de Cloner le projet.
9. Depuis le terminal du projet faites : `cp .env.example .env`.
10. Ensuite mettre dans le .env le chemin du dossier partagé comme sur l'exemple ci-dessous.

  ```
NFS_SHARE_PATH="\\\\VOTRE-NOM-DE-MACHINE\\NOM-DONNER-AU-DOSSIER-PARTAGÉ\\Users\\"
  ```
Attention ! Le chemin au début doit comporter 4 \ et entre chaque passage de dossier il doit en comporter 2, n'oublier pas d'enregistrer le fichier ! Et faites attention à ne pas mettre le chemin complet jusqu'au dossier mais bien son chemin de partage réseau.

## Cloner le projet
  1. Commencer par vous rendre dans un répertoire ou vous souhaitez mettre le projet (depuis l'invite de commande) puis cloner le avec :
    `git clone https://github.com/ceffDptInfo/Job-Dispatcher-Laravel.git`
  2. Taper ensuite `cd Job-Dispatcher-Laravel` et faites ensuite `code .`
  3. Ouvrez le projet dans VScode et ouvrez un terminal de commande puis installer les dépendances via le terminal du projet :
    `npm install` et un `npm audit fix`
  4. Executer depuis le cmd `composer install`.
  5. Ensuite faites : `composer global require laravel/installer`.
  6. Toujours dans la cmd, faites : `cd docker`
  7. Puis lancer : `docker compose up -d` cela va démarrer en arrière plan les containers contenant la base de donnée.
  8. Encore dans le projet, mettez vos variables de connexion à la DB dans le fichier **.env**
 
  ```
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=printer_db
  DB_PASSWORD=dispatcher1234
 
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
 
  9. Fermer et rouvrez à nouveau le projet.
  10. exécuter la commande depuis le terminal du projet :
    `php artisan migrate:fresh --seed` cela met en place les tables dans la base de donnée. Attention il faut vous placer dans la racine du projet.
  11. lancer la commande `php artisan key:generate`
  12. Executer depuis le cmd la commande `composer run dev` afin de lancer le projet.
 
 ##  MySQL Workbench
Créez une nouvelle connexion depuis MySQL Workbench et entrez les informations suivantes :
 
- Connection Name : printer_db
- Host : 127.0.0.1
- Port : 3306
- User : root
- Password : dispatcher1234
 
Tester la connexion si c'est ok.
 
## Gestions des containers docker
Pour gérer les containers utilisé dans le projet vous pouvez vous y rendre soit avec Docker Desktop ou avec Portainer via http://localhost:9000/ (Pensez à créer votre compte).

## Informations supplémentaires

### Base de donnée 
Vous avez deux possibilité de faire pour utiliser la base de donnée. Soit comme expliqué sur ce readMe, 
soit en suivant le readMe suivant : https://github.com/ceffDptInfo/Job-Dispatcher-Core ! 

La seule chose qui diffère est l'adresse IP le reste des opérations reste quasi-identique.  
 
# Crédits
Les 4 informaticiens ayant participé au projet :
- Urfer Leila
- Golay Simon
- Gane Gyan
- Curty Gwendoline