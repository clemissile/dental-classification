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
  `DATE` date DEFAULT NULL,
  `DIAGNOSE_TYPE` varchar(255) DEFAULT NULL,
  `PATIENT_NAME` varchar(255) DEFAULT NULL,
  `PATIENT_AGE` int(11) DEFAULT NULL,
  `IMAGE` varchar(255) DEFAULT NULL,
  `DENTIST_NAME` varchar(255) DEFAULT NULL,
  `OBSERVATIONS` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
)
```
