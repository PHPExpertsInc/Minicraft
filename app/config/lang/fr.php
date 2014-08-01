<?php

/*
 * %m1% and %m2% are dymamic markers which are replaced at run time by the relevant word.
 * They must not be edited.
 */

$lang = array();

// Model
$lang = array_merge($lang, array(
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => ''
));

// General
$lang = array_merge($lang, array(
  'TOGGLE_NAVIGATION' => 'Afficher la navigation',
  'SEARCH_PLAYER' => 'Rechercher un joueur',
  'PREVIOUS' => 'Précédent',
  'NEXT' => 'Suivant',
  'BACK_TO_TOP' => 'Retour en haut',
  'USER_INFOS' => 'Vos informations',
  'ACCOUNT_INFOS' => 'Informations du compte',
  'GENERAL_INFOS' => 'Informations générales',
  'BIRTHDATE_PLACEHOLDER' => 'jj-mm-aaaa',
  'RESET_YOUR_PASSWORD' => 'Réinitialiser votre mot de passe',
  'IMAGE_RECOMMENDED_SIZE' => 'Taille recommandée : %m1% x %m2%'
));

// Buttons
$lang = array_merge($lang, array(
  'BTN_SEARCH' => 'Rechercher',
  'BTN_CANCEL' => 'Annuler',
  'BTN_REGISTER' => 'S\'inscrire',
  'BTN_LOGIN' => 'Se connecter',
  'BTN_REMEMBER' => 'Rester connecté',
  'BTN_RESET' => 'Réinitialiser le mot de passe',
  'BTN_EDIT' => 'Modifier',
  'BTN_REMOVE' => 'Supprimer',
  'BTN_CLOSE' => 'Fermer',
  'BTN_SAVE' => 'Enregistrer',
  'BTN_NO' => 'Non',
  'BTN_YES' => 'Oui',
  'BTN_I_REMEMBER' => 'Finalement je m\'en souviens !',
  'BTN_BAN' => 'Bannir',
  'BTN_ADD_RANK' => 'Ajouter un rang',
  'BTN_FORGOT_PASSWORD' => 'Mot de passe oublié ?'
));

// URL
$lang = array_merge($lang, array(
  'URL_ADMIN' => 'admin',
  'URL_MANAGE' => 'manage',
  'URL_SIGN_IN' => 'connexion',
  'URL_SIGN_OUT' => 'deconnexion',
  'URL_REGISTER' => 'inscription',
  'URL_VERIFY' => 'confirmation',
  'URL_RESEND' => 'renvoyer',
  'URL_RESET' => 'reinitialiser-mot-de-passe',
  'URL_PROFILE' => 'profil',
  'URL_PLAYER' => 'joueur',
  'URL_ARTICLE' => 'article',
  'URL_OUT' => 'lien'
));

// Email
$lang = array_merge($lang, array(
  'EMAIL_CONFIRMATION_SUBJECT' => 'Activer votre compte',
  'EMAIL_CONFIRMATION_BTN' => 'Activer',
  'EMAIL_CONFIRMATION_INSTRUCTIONS' => 'Cliquez ici pour activer votre compte',
  'EMAIL_CONFIRMATION_HEADLINE' => 'Encore un petit effort…',
  'EMAIL_RESET_SUBJECT' => 'Réinitialiser votre mot de passe',
  'EMAIL_RESET_INSTRUCTIONS' => 'Cliquez ici pour réinitialiser votre mot de passe',
  'EMAIL_RESET_INSTRUCTIONS_TXT' => 'Copiez/collez le lien dans votre navigateur pour réinitialiser votre mot de passe.',
  'EMAIL_RESET_HEADLINE' => 'Encore un petit effort…',
  'EMAIL_RESET_BTN' => 'Réinitialiser'
));

// Short titles
$lang = array_merge($lang, array(
  'INDEX' => 'Index',
  'FORUM' => 'Forum',
  'STORE' => 'Boutique',
  'BLOG' => 'Blog',
  'VAULT' => 'Coffre',
  'HOME' => 'Accueil',
  'REGISTER' => 'Inscription',
  'LOGIN' => 'Connexion',
  'PROFILE' => 'Profil',
  'LOGOUT' => 'Déconnexion',
  'MY_ACCOUNT' => 'Mon compte',
  'ADMIN_PANEL' => 'Panneau d\'administration',
  'TITLE' => 'Titre',
  'EDIT' => 'Modifier',
  'REMOVE' => 'Supprimer',
  'CATEGORY' => 'Catégorie',
  'SERVER' => 'Serveur',
  'MINUTES' => 'Minutes',
  'HOURS' => 'Hours',
  'DAYS' => 'Jours',
  'MONTHS' => 'Mois',
  'YEARS' => 'Années'
));

// Forms
$lang = array_merge($lang, array(
  'THERE_ARE_ERRORS' => 'Il y a des erreurs',
  'USERNAME' => 'Nom d\'utilisateur',
  'PASSWORD' => 'Mot de passe',
  'EMAIL' => 'Adresse email',
  'USERNAME_OR_EMAIL' => 'Nom d\'utilisateur ou adresse email',
  'GENRE' => 'Genre',
  'UNSPECIFIED' => 'Non spécifié',
  'FEMALE' => 'Femme',
  'MALE' => 'Homme',
  'BIRTHDATE' => 'Date de naissance',
  'COUNTRY' => 'Pays',
  'CITY' => 'Ville',
  'STAY_LOGGED_IN' => 'Rester connecté',
  'RESET_PASSWORD' => 'Réinitialiser le mot de passe',
  'NEW_PASSWORD' => 'Nouveau mot de passe',
  'CONFIRM_PASSWORD' => 'Confirmer le mot de passe',
  'LEAVE_EMPTY_NO_CHANGE_PASSWORD' => 'Laissez ce champ vide si vous ne souhaitez pas modifier votre mot de passe.'
));

// Punctuations
$lang = array_merge($lang, array(
  'COLON' => '&nbsp;:'
));

// Server
$lang = array_merge($lang, array(
  'SERVER_STATUS' => 'Status des serveurs',
  'ONLINE' => 'En ligne',
  'OFFLINE' => 'Hors ligne',
  'VOTE_FOR' => 'Voter',
  'NO_PLAYER_ONLINE' => 'Aucun joueur en ligne',
  'ADD_SERVER' => 'Ajouter un serveur',
  'EDIT_SERVER' => 'Modifier le serveur',
  'SERVER_NAME' => 'Nom du serveur',
  'IP_OR_URL' => 'Adresse IP ou URL',
  'SERVER_DESCRIPTION' => 'Description du serveur',
  'SERVER_TYPE' => 'Type du serveur',
  'JSONAPI_PORT' => 'Port JSONAPI',
  'JSONAPI_USERNAME' => 'Identifiant JSONAPI',
  'JSONAPI_PASSWORD' => 'Mot de passe JSONAPI',
  'REMOVE_SERVER' => 'Supprimer ce serveur'
));

// Admin
$lang = array_merge($lang, array(
  'MANAGE_USERS' => 'Gérer les membres',
  'MANAGE_RANKS' => 'Gérer les rangs',
  'MANAGE_THEME' => 'Configurer le thème',
  'MANAGE_SERVERS' => 'Gérer les serveurs',
  'MANAGE_VOTES' => 'Gérer les votes',
  'MANAGE_BUNDLE' => 'Gérer le Bundle %m1%',
  'REMOVE_CONFIRMATION' => 'Êtes-vous sûr de vouloir supprimer <strong>%m1%</strong> ?',
  'CONFIRM_EMAIL' => 'Confirmer l\'adresse email',
  'BAN' => 'Bannir',
  'EDIT_USER' => 'Modifier le membre',
  'BAN_USER' => 'Bannir le membre',
  'DURATION' => 'Durée',
  'DURATION_TYPE' => 'Type de durée',
  'BAN_REASON' => 'Motif',
  'BAN_IN_GAME_TOO' => 'Bannir aussi en jeu',
  'RANK_NAME' => 'Nom du rang',
  'RANK_FORCE' => 'Force du rang',
  'EDIT_RANK' => 'Modifier le rang',
  'ADD_RANK' => 'Ajouter un rang',
  'REMOVE_RANK' => 'Supprimer ce rang',
  'EDIT_ARTICLE_CATEGORY' => 'Modifier cette catégorie',
  'CREATE_ARTICLE_CATEGORY' => 'Créer une catégorie'
));

// Profile
$lang = array_merge($lang, array(
  'RANK' => 'Rang',
  'REGISTER_DATE' => 'Date d\'inscription',
  'VOTES_THIS_WEEK' => 'Votes cette semaine',
  'TOTAL_VOTES' => 'Total des votes',
  'ARRIVED_HERE' => 'Arrivée sur le serveur',
  'AGE' => 'Âge',
  'YEARS_OLD' => '%m1% ans'
));

$lang = array_merge($lang, array(
  'COUNTRIES' => array(
    'dz' => 'Algérie',
    'de' => 'Allemagne',
    'ad' => 'Andorre',
    'ag' => 'Antigua-et-Barbuda',
    'sa' => 'Arabie saoudite',
    'ar' => 'Argentine',
    'am' => 'Arménie',
    'au' => 'Australie',
    'at' => 'Autriche',
    
    'be' => 'Belgique',
    'mm' => 'Birmanie',
    'bo' => 'Bolivie',
    'br' => 'Brésil',
    'bg' => 'Bulgarie',
    'bf' => 'Burkina Faso',
    
    'cm' => 'Cameroun',
    'ca' => 'Canada',
    'cl' => 'Chili',
    'cn' => 'Chine',
    'co' => 'Colombie',
    'cg' => 'Congo',
    'cd' => 'Congo, République démocratique du',
    'kr' => 'Corée, République de',
    'kp' => 'Corée, République populaire démocratique de',
    
    'dk' => 'Danemark',
    'dj' => 'Djibouti',
    
    'eg' => 'Égypte',
    'ae' => 'Émirats arabes unis',
    'es' => 'Espagne',
    'ee' => 'Estonie',
    'us' => 'États-Unis',
    
    'fi' => 'Finlande',
    'fr' => 'France',
    
    'ga' => 'Gabon',
    'gm' => 'Gambie',
    'gt' => 'Guatemala',
    
    'ht' => 'Haïti',
    'hn' => 'Honduras',
    'hu' => 'Hungary',
    
    'in' => 'Inde',
    'id' => 'Indonésie',
    'ir' => 'Iran',
    'iq' => 'Irak',
    'ie' => 'Irelande',
    'il' => 'Israël',
    'it' => 'Italie',
    
    'jm' => 'Jamaïque',
    'jp' => 'Japon',
    'jo' => 'Jordanie',
    
    'kz' => 'Kazakhstan',
    'kg' => 'Kirghizistan',
    'kw' => 'Koweït',
    
    'la' => 'Laos',
    'ls' => 'Lesotho',
    'lv' => 'Lettonie',
    'lb' => 'Liban',
    'lu' => 'Luxembourg',
    
    'mk' => 'Macédoine',
    'mg' => 'Madagascar',
    'ml' => 'Mali',
    'mt' => 'Malte',
    'mx' => 'Mexique',
    
    'na' => 'Namibie',
    'nl' => 'Netherlands',
    'ni' => 'Nicaragua',
    'ne' => 'Niger',
    'ng' => 'Nigéria',
    'no' => 'Norvège',
    
    'om' => 'Oman',
    
    'pk' => 'Pakistan',
    'pa' => 'Panama',
    'pg' => 'Papouasie-Nouvelle-Guinée',
    'py' => 'Paraguay',
    'pe' => 'Pérou',
    'pl' => 'Pologne',
    'pt' => 'Portugal',
    
    'qa' => 'Qatar',
    
    'cz' => 'République tchèque',
    'ro' => 'Roumanie',
    'gb' => 'Royaume-Uni',
    'ru' => 'Russie',
    'rw' => 'Rwanda',
    
    'kn' => 'Saint-Christophe-et-Niévès',
    'lc' => 'Sainte-Lucie',
    'sv' => 'Salvador',
    'sn' => 'Sénégal',
    'sl' => 'Sierra Leone',
    'sg' => 'Singapour',
    'so' => 'Somalie',
    'se' => 'Suède',
    'ch' => 'Suisse',
    
    'tj' => 'Tadjikistan',
    'tz' => 'Tanzanie',
    'td' => 'Tchad',
    'tl' => 'Timor oriental',
    'tr' => 'Turquie',
    
    'ua' => 'Ukraine',
    
    've' => 'Venezuela',
    'vn' => 'Viêt Nam',
    
    'ye' => 'Yémen'
  )
));