# 🩺 MediCare+ — Système de Gestion de Rendez-vous Médicaux

Plateforme web complète de gestion de rendez-vous médicaux développée avec **Laravel 12**, permettant aux patients de prendre rendez-vous avec des médecins, communiquer via messagerie sécurisée, et gérer leurs consultations en ligne.

## 📋 Table des matières

- [Aperçu](#aperçu)
- [Fonctionnalités](#fonctionnalités)
- [Technologies utilisées](#technologies-utilisées)
- [Installation locale](#installation-locale)
- [Comptes de test](#comptes-de-test)
- [Captures d'écran](#captures-décran)
- [Structure du projet](#structure-du-projet)
- [Auteur](#auteur)

## 🌟 Aperçu

**MediCare+** est une application web médicale moderne offrant deux espaces dédiés : un espace patient pour prendre rendez-vous, consulter ses médecins et noter ses consultations, et un espace médecin pour gérer son agenda, ses patients et son profil.

🔗 **URL en ligne** : [À ajouter après déploiement]

## ✨ Fonctionnalités

### 👤 Authentification & Profils
- Inscription avec choix du rôle (patient ou médecin)
- Connexion sécurisée
- Profil personnalisable avec photo
- Profil médecin enrichi (spécialisation, tarif, biographie)

### 🩺 Espace Patient
- Recherche de médecins avec filtres avancés (nom, spécialisation, fourchette de prix)
- Tri par nom, prix ou note (top rated)
- Consultation des profils détaillés avec avis
- Prise de rendez-vous en ligne
- Annulation de rendez-vous
- Historique des consultations
- **Notation** des médecins après consultation (étoiles + commentaire)
- **Export PDF** de tous ses rendez-vous

### 👨‍⚕️ Espace Médecin
- Tableau de bord avec statistiques
- Gestion des rendez-vous (accepter / refuser / compléter)
- Notes de consultation
- Affichage des avis reçus avec note moyenne
- **Export PDF** de tous ses patients et consultations

### 💬 Messagerie
- Conversations privées entre médecin et patient
- Indicateur de messages non lus
- Suppression de conversations

### 🌍 Multilingue & Accessibilité
- 3 langues : Anglais 🇬🇧, Français 🇫🇷, Arabe 🇲🇦 (avec support RTL)
- Mode sombre (Dark Mode) persistant
- Interface responsive (mobile, tablette, desktop)

## 🛠️ Technologies utilisées

### Backend
- **PHP** 8.2
- **Laravel** 12.57
- **MySQL** 8.0
- **Laravel Breeze** (authentification)
- **DomPDF** (génération de PDF)

### Frontend
- **Tailwind CSS** 3.4 (avec mode sombre + RTL)
- **Alpine.js** (interactions UI)
- **Vite** (build tool)
- **Blade** (templates)

### DevOps
- **Git / GitHub** (versioning)
- **Railway** (hébergement)
- **Composer** (gestion des dépendances PHP)
- **NPM** (gestion des dépendances JS)

## 📦 Installation locale

### Prérequis

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL ou MariaDB
- Git

### Étapes

```bash
# 1. Cloner le dépôt
git clone https://github.com/VOTRE-USERNAME/medical-appointments.git
cd medical-appointments

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JS
npm install

# 4. Copier le fichier d'environnement
cp .env.example .env

# 5. Générer la clé d'application
php artisan key:generate

# 6. Configurer la base de données dans .env
# DB_DATABASE=medical_appointments
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Lancer les migrations
php artisan migrate

# 8. (Optionnel) Lancer le seeder pour avoir 8 médecins de test
php artisan db:seed --class=DoctorsSeeder

# 9. Créer le lien symbolique pour le storage
php artisan storage:link

# 10. Compiler les assets frontend
npm run build

# 11. Démarrer le serveur
php artisan serve
```

L'application sera accessible sur `http://127.0.0.1:8000`

## 👥 Comptes de test

Après avoir lancé le seeder, vous pouvez utiliser ces comptes :

### Médecins (mot de passe : `password123`)

| Email | Spécialisation | Tarif |
|---|---|---|
| `karim.benjelloun@medic.ma` | Cardiologie | 400 MAD |
| `salma.elidrissi@medic.ma` | Pédiatrie | 250 MAD |
| `mohammed.tazi@medic.ma` | Dermatologie | 300 MAD |
| `nadia.berrada@medic.ma` | Gynécologie | 350 MAD |
| `youssef.alaoui@medic.ma` | Orthopédie | 380 MAD |
| `laila.chraibi@medic.ma` | Ophtalmologie | 280 MAD |
| `omar.benkirane@medic.ma` | Médecine générale | 200 MAD |
| `amina.saidi@medic.ma` | Psychiatrie | 500 MAD |

### Patient (à créer manuellement via /register)

Inscrivez-vous comme patient pour tester l'application complète.

## 📸 Captures d'écran

[À compléter avec vos screenshots après le déploiement]

## 🗂️ Structure du projet