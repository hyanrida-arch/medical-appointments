# 🩺 MediCare+ — Système de Gestion de Rendez-vous Médicaux

Plateforme web complète de gestion de rendez-vous médicaux développée avec **Laravel 12**, permettant aux patients de prendre rendez-vous avec des médecins, communiquer via messagerie sécurisée, et gérer leurs consultations en ligne.

🔗 **Démo en ligne** : https://medical-appointments-production-53de.up.railway.app
📦 **Code source** : https://github.com/VOTRE-USERNAME/medical-appointments

---

## 📋 Table des matières

- [Aperçu](#-aperçu)
- [Fonctionnalités](#-fonctionnalités)
- [Technologies utilisées](#%EF%B8%8F-technologies-utilisées)
- [Modèle Physique de Données (MPD)](#-modèle-physique-de-données-mpd)
- [Installation locale](#-installation-locale)
- [Comptes de test](#-comptes-de-test)
- [Structure du projet](#%EF%B8%8F-structure-du-projet)
- [Auteur](#-auteur)

## 🌟 Aperçu

**MediCare+** est une application web médicale moderne offrant deux espaces dédiés :
- 🩺 **Espace Patient** : prendre rendez-vous, consulter ses médecins, noter ses consultations
- 👨‍⚕️ **Espace Médecin** : gérer son agenda, ses patients et son profil

## ✨ Fonctionnalités

### 👤 Authentification & Profils
- Inscription avec choix du rôle (patient ou médecin)
- Connexion sécurisée
- Profil personnalisable avec photo (upload + suppression)
- Profil médecin enrichi (spécialisation, tarif, biographie)

### 🩺 Espace Patient
- Recherche de médecins avec filtres avancés (nom, spécialisation, fourchette de prix)
- Tri par nom, prix ou note (top rated)
- Consultation des profils détaillés avec avis des autres patients
- Prise de rendez-vous en ligne
- Annulation de rendez-vous
- Historique des consultations (passés / à venir / tous)
- **Notation** des médecins après consultation (étoiles + commentaire)
- **Export PDF** de tous ses rendez-vous

### 👨‍⚕️ Espace Médecin
- Tableau de bord avec statistiques (pending / accepted / completed / total)
- Gestion des rendez-vous (accepter / refuser / compléter avec notes)
- Affichage des avis reçus avec note moyenne
- **Export PDF** de tous ses patients et consultations
- Filtres par statut et par date

### 💬 Messagerie
- Conversations privées entre médecin et patient
- Indicateur de messages non lus
- Suppression de conversations

### 🌍 Multilingue & Accessibilité
- **3 langues** : Anglais 🇬🇧, Français 🇫🇷, Arabe 🇲🇦 (avec support RTL)
- **Mode sombre** (Dark Mode) persistant
- Interface responsive (mobile, tablette, desktop)
- Toast notifications

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

## 🗄️ Modèle Physique de Données (MPD)

L'application repose sur 6 tables principales :

### Table `users`
Stocke tous les utilisateurs (patients et médecins).

| Colonne | Type | Contrainte |
|---|---|---|
| **id** | BIGINT | PK, AUTO_INCREMENT |
| first_name | VARCHAR(255) | NOT NULL |
| last_name | VARCHAR(255) | NOT NULL |
| email | VARCHAR(255) | UNIQUE, NOT NULL |
| password | VARCHAR(255) | NOT NULL |
| role | ENUM('doctor','patient') | NOT NULL |
| profile_photo | VARCHAR(255) | NULL |
| phone | VARCHAR(255) | NULL |
| email_verified_at | TIMESTAMP | NULL |
| remember_token | VARCHAR(100) | NULL |
| created_at, updated_at | TIMESTAMP | |

### Table `doctor_profiles`
Détails supplémentaires pour les utilisateurs médecins.

| Colonne | Type | Contrainte |
|---|---|---|
| **id** | BIGINT | PK |
| *user_id* | BIGINT | FK → users.id (cascade) |
| specialization | VARCHAR(255) | NOT NULL |
| consultation_fee | DECIMAL(8,2) | NOT NULL |
| biography | TEXT | NULL |
| created_at, updated_at | TIMESTAMP | |

### Table `appointments`
Rendez-vous entre patient et médecin.

| Colonne | Type | Contrainte |
|---|---|---|
| **id** | BIGINT | PK |
| *patient_id* | BIGINT | FK → users.id |
| *doctor_id* | BIGINT | FK → users.id |
| appointment_date | DATETIME | NOT NULL |
| status | ENUM | pending/accepted/refused/completed/cancelled |
| reason | TEXT | NULL |
| consultation_notes | TEXT | NULL |
| created_at, updated_at | TIMESTAMP | |

### Table `conversations`
Conversations entre patient et médecin.

| Colonne | Type | Contrainte |
|---|---|---|
| **id** | BIGINT | PK |
| *patient_id* | BIGINT | FK → users.id |
| *doctor_id* | BIGINT | FK → users.id |
| created_at, updated_at | TIMESTAMP | UNIQUE(patient_id, doctor_id) |

### Table `messages`
Messages échangés dans une conversation.

| Colonne | Type | Contrainte |
|---|---|---|
| **id** | BIGINT | PK |
| *conversation_id* | BIGINT | FK → conversations.id |
| *sender_id* | BIGINT | FK → users.id |
| body | TEXT | NOT NULL |
| read_at | TIMESTAMP | NULL |
| created_at, updated_at | TIMESTAMP | |

### Table `ratings`
Notations des patients sur les médecins après consultation.

| Colonne | Type | Contrainte |
|---|---|---|
| **id** | BIGINT | PK |
| *patient_id* | BIGINT | FK → users.id |
| *doctor_id* | BIGINT | FK → users.id |
| *appointment_id* | BIGINT | FK → appointments.id, UNIQUE |
| stars | TINYINT | 1-5 |
| comment | TEXT | NULL |
| created_at, updated_at | TIMESTAMP | |

### 🔗 Relations
- 1 `user` (doctor) — 1 `doctor_profile`
- 1 `user` (patient) — N `appointments` (en tant que patient)
- 1 `user` (doctor) — N `appointments` (en tant que médecin)
- 1 `conversation` — N `messages`
- 1 `appointment` — 0 ou 1 `rating`

📎 Le schéma visuel complet du MPD est disponible dans `docs/MPD.pdf`.

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

# 8. Lancer le seeder pour avoir 8 médecins de test
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

### Patient
Inscrivez-vous comme patient via `/register` pour tester l'application.

## 🗂️ Structure du projet
medical-appointments/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/             (Login, Register)
│   │   │   ├── Doctor/           (Dashboard, Appointments)
│   │   │   ├── Patient/          (Dashboard, Doctors, Appointments)
│   │   │   ├── MessageController.php
│   │   │   ├── PdfController.php
│   │   │   ├── RatingController.php
│   │   │   ├── ProfileController.php
│   │   │   └── LocaleController.php
│   │   └── Middleware/
│   │       ├── DoctorMiddleware.php
│   │       ├── PatientMiddleware.php
│   │       └── SetLocale.php
│   └── Models/
│       ├── User.php
│       ├── DoctorProfile.php
│       ├── Appointment.php
│       ├── Conversation.php
│       ├── Message.php
│       └── Rating.php
├── database/
│   ├── migrations/               (6 tables)
│   └── seeders/
│       └── DoctorsSeeder.php
├── lang/
│   ├── en/messages.php
│   ├── fr/messages.php
│   └── ar/messages.php
├── resources/
│   └── views/
│       ├── auth/                 (login, register)
│       ├── doctor/               (dashboard, appointments)
│       ├── patient/              (dashboard, doctors, appointments)
│       ├── messages/             (index, show)
│       ├── profile/              (edit + partials)
│       ├── pdf/                  (PDF templates)
│       ├── components/
│       └── layouts/
├── routes/
│   └── web.php
└── public/
└── build/                    (compiled assets)

## 🎯 Cahier des charges respecté

✅ Authentification multi-rôles (patient / médecin)
✅ Gestion CRUD des rendez-vous
✅ Recherche et filtres avancés
✅ Messagerie sécurisée
✅ Système de notation (bonus)
✅ Export PDF (bonus)
✅ Multilingue 3 langues + RTL (bonus)
✅ Mode sombre (bonus)
✅ Interface responsive
✅ Déploiement en ligne sur Railway

## 👨‍💻 Auteur

**Hyan Rida**
3e année IISI

## 📜 Licence

Projet académique réalisé dans le cadre de la formation IISI.
