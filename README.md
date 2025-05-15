# Post-it

Post-it est une application web permettant de créer, gérer, partager et afficher des post-it, de manière simple et intuitive. Développée en PHP avec une base de données MySQL, elle propose une interface responsive et des fonctionnalités de gestion utilisateur sécurisées.

---

---

## Structure du projet

Les fichiers sont organisés par dossier fonctionnel :

Dossier connexion/ -> Fichiers PHP, CSS et JS pour la page de connexion
Dossier inscription/ -> Fichiers PHP, CSS et JS pour l'inscription
Dossier Creation_edition/ -> Fichier PHP, CSS et JS pour la Création/édition des post-its + API d'autocomplétion
Dossier img/ -> Contient les images du projet
Fichier .sql/ -> Script SQL pour initialiser la base de données
fonctions.php -> fonctions PHP
index.php -> Page d'accueil
config.php -> Connexion à la base de données
styles.css -> Fichier CSS pour le style de la page index



---

## Connexion à la base de données

1. Importer le fichier `sql/app_post_it.sql` dans phpMyAdmin pour recuperer toute la structure de la base de données ainsi que les données enregistrées
2. La connexion utilise PDO :

   - Sécurisée grâce aux requêtes préparées
   - Moderne et orientée objet
   - Gestion centralisée des erreurs avec `try/catch`
3. La base de données est composée de 3 tables : 
      - Utilisateur : qui inclue tous les utilisateurs inscrits avec le nom prenom, date de naissance, email, pseudo, le mot de passe et le token permettant de verifié si le cookie pour se souvenir de l'utilisateur est toujours valide.
      - Postit : Qui regroupe l'ensemble des postit avec leur information tel que le titre le contenu la date de creation et modification et la couleur
      -  et Post_it_partge : qui regroupe les information concernant les postit partgé (Id_postit et id_utilisateur) 


## Fonctionnalités principales

- Création de post-its personnalisés
- Modification et suppression des post-it 
- Partage des post-it avec d'autres utilisateurs (en lecture seule)
- Choix de la couleur du postit par le propriétaire
- Interface responsive (adaptée aux mobiles et tablettes)
- Système d'authentification sécurisé 
- Connexion automatique via token (option "Se souvenir de moi")

---

## Technologies utilisées

- PHP
- MySQL
- HTML/CSS
- JavaScript (avec jQuery pour l'autocomplétion)
- PDO (connexion sécurisée à la base de données)

---


## Sécurité et bonnes pratiques

- Utilisation de requêtes préparées avec PDO pour se protéger contre les injections SQL
- Encodage des données avec `htmlspecialchars()` pour éviter les attaques XSS et injection SQL
- Démarrage des sessions via `session_start()` pour la gestion utilisateur
- Vérification de l’état de connexion sur chaque page (redirection si non connecté)
- Gestion d’un token sécurisé pour la fonctionnalité "Se souvenir de moi"
- Fonction `verifAlreadyConnected()` pour rediriger l’utilisateur connecté vers l’accueil
- Hachage sécurisé des mots de passe avec l’algorithme Argon2 :
   
   Utilisation de la fonction password_hash() avec PASSWORD_ARGON2ID, qui est l’un des algorithmes les plus robustes et recommandés actuellement pour le stockage des mots de passe. 

   Lors de la connexion, la fonction password_verify() permet de comparer de manière sécurisée le mot de passe saisi avec le hash stocké. 
   Cela garantit que les mots de passe ne sont jamais enregistrés en clair en base de données, réduisant fortement les risques en cas de fuite de données.



---

## Pages principales

### Connexion

- Permet aux utilisateurs de se connecter à leur compte
- Vérification des identifiants avec `password_verify`
- Vérification JavaScript côté client (champs requis)
- Verification PHP coté serveur des champs requis (au cas où le JavaScript serait désactivé par un utilisateur malveillant)
- Option « Se souvenir de moi » : mécanisme de connexion persistante via token. Pour permettre à un utilisateur de rester connecté pendant 30 jours, un token sécurisé est généré à la connexion (via bin2hex(random_bytes(32))) et enregistré en base de données avec les informations suivantes dans la table utilisateur :

   remember_token : contient le token unique généré.

   token_expire : enregistre la date d’expiration du token, fixée à 30 jours après sa création.

   remember_ip : stocke l’adresse IP de l’utilisateur au moment de la connexion, pour ajouter une couche de sécurité.

   remember_user_agent : enregistre l’agent utilisateur (navigateur + OS), afin de renforcer la vérification lors de la reconnexion automatique.

   Ce système permet une reconnexion automatique sécurisée tout en réduisant les risques en cas de vol de cookie.



### Inscription

- Création d’un compte utilisateur
- Hachage des mots de passe avec l’algorithme Argon2
- Vérifications côté client en JavaScript
- Contrôle côté serveur : pseudo/email uniques, si les champs requis ont bien été renseignés et la date de naissance renseignée est correcte (Ex: 31 févrié est incorect)
- Le champ pseudo a été ajouté afin de différencier les utilisateurs ayant un prénom et un nom identiques.
- Acceptation obligatoire des conditions d'utilisation

### Accueil (index.php)

- Affichage des post-its possédés ou partagés
- Tri par date de dernière modification (les plus récents en premier)
- Utilisation d’une boucle `foreach` pour afficher chaque post-it de manière uniforme

### Création / Édition

- Création ou modification d’un post-it (en fonction de la présence d’un ID dans l’URL)
- Sélection de la couleur du post-it (jaune, rouge, vert, bleu, orange, rose)
- Vérification des champs côté client et côté serveur
- Fonctionnalité de partage avec autocomplétion utilisateur : L'utilisateur peut saisir les premières lettres du prénom, du nom, du pseudo ou de l’adresse e-mail d’un autre utilisateur. Grâce au système d’autocomplétion, tous les utilisateurs correspondant à ce début de saisie s’affichent automatiquement.
Par exemple, en tapant "JE", les suggestions peuvent inclure "Jean", "Jérôme", etc.
Chaque suggestion affiche les informations suivantes : nom, prénom, e-mail et pseudo de l’utilisateur correspondant.
- API appelée en AJAX (fichier `API_search_user.php`) pour récupérer les utilisateurs au format JSON
- Script `search_user.js` pour gérer l’autocomplétion dynamique

### Visualisation

- Affichage détaillé d’un post-it en fonction de son ID
- Vérification que l’utilisateur est autorisé à voir le post-it (propriétaire ou utilisateur avec qui il a été partagé)


---

## Fonctionnalités bonus

- Le champ pseudo a été ajouté afin de différencier les utilisateurs ayant un prénom et un nom identiques.
- Choix de la couleur du post-it lors de la création ou de l'édition
- Accès au profil utilisateur pour modifier pseudo, email, prénom, nom, date de naissance
- Possibilité de modifier ou supprimer son mot de passe
- Fonction "Se souvenir de moi" pour une reconnexion automatique


---

## Auteur


[olivergrt](https://github.com/olivergrt)

Avec la participation de: 
Oliver GRANT
Letissia FETISSI
Yanis AGGOUN
Katia BELHADI 
---

## Licence

Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus d'informations.
