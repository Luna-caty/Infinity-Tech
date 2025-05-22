# Infinity-Tech 🖥️📱

**Infinity-Tech** est un site web e-commerce dédié à la vente de matériel informatique. Ce projet a été développé dans le cadre d’un projet universitaire à l’Université des Sciences et de la Technologie Houari Boumediene, Faculté d’Informatique.

## 🛒 Présentation du projet

Infinity-Tech propose une large gamme de produits technologiques :

- PC portables et de bureau
- Smartphones
- Accessoires (claviers, souris, casques...)
- Composants de stockage (HDD, SSD)
- Composants performants (cartes graphiques, processeurs)

## 🚀 Fonctionnalités principales

- Page d’accueil avec produits mis en avant
- Fiches produits détaillées avec description, caractéristiques, prix et image
- Recherche avec filtres (catégories, prix)
- Authentification des utilisateurs (connexion/déconnexion)
- Panier virtuel (ajout, suppression, consultation)
- Sessions et cookies pour suivre l’utilisateur
- Espace administrateur :
  - Ajout, modification et suppression de produits
- Système de commande :
  - Historique, validation, annulation
- Intégration complète avec la base de données

## 🗄️ Base de données

La base de données relationnelle contient plusieurs tables interconnectées pour gérer les produits, utilisateurs, commandes, stocks, etc.

### 📦 Procédures stockées

- Affichage des détails d’une commande avec calcul du total
- Finalisation d’une commande
- Historique des commandes par utilisateur

### ⚙️ Triggers

- Mise à jour du stock après validation
- Blocage des commandes si le stock est insuffisant
- Restauration du stock lors d’une annulation
- Archivage des commandes annulées


