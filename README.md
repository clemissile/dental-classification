# dental-classification

## Présentation du projet
Le domaine d'application de ce projet est le diagnostic de maladies dentaires : un dentiste doit pouvoir ajouter des photos et renseigner des informations qu'il estime pertinentes comme par exemple le nom du patient, le diagnostic, les symptomes, les dents touchées, etc.

Ce projet prendra la forme d'une interface web, sur laquelle le praticien pourra naviguer au travers d'un dashboard.

Projet annuel de Master 2, réalisé par Clément GANIVET et Yohann JACQUIER, supervisé par Monsieur François RIOULT.

Réalisé avec le framework PHP Symfony (version 4) et le framework CSS Bootstrap (version 4).

## Installer les dépendances du projet
```
composer install
```

## Lancer le serveur de développement local
```
php bin/console serve:run
```

## Créer la base de données
```
CREATE TABLE `DIAGNOSE` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DIAG_DATE` varchar(255) DEFAULT NULL,
  `DIAG_PATIENT_NAME` varchar(255) DEFAULT NULL,
  `DIAG_PATIENT_AGE` int(11) DEFAULT NULL,
  `DIAG_IMAGE` varchar(255) DEFAULT NULL,
  `DIAG_DENTIST_NAME` varchar(255) DEFAULT NULL,
  `DIAG_OBS` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
)
```
