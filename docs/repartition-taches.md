# 📋 Document de Répartition des Tâches

## Projet : MediCare+ — Système de Gestion de Rendez-vous Médicaux

| Information | Détail |
|---|---|
| **Étudiant** | Hyan Rida |
| **Formation** | 3e année IISI |
| **Type de projet** | Projet individuel |
| **Date de remise** | 16 mai 2026 |
| **Technologies** | Laravel 12, MySQL, Tailwind CSS, Alpine.js |
| **Hébergement** | Railway |

---

## 🎯 Répartition des tâches

Ce projet ayant été réalisé **individuellement**, l'ensemble des tâches a été conçu, développé, testé et déployé par **Hyan Rida**.

### 📊 Vue d'ensemble par phase

| Phase | Description | Durée estimée | Réalisé par |
|---|---|---|---|
| 1. Analyse | Analyse du cahier des charges, conception MPD, MCD | 3 jours | Hyan Rida |
| 2. Setup | Installation Laravel, configuration MySQL, Tailwind | 1 jour | Hyan Rida |
| 3. Base de données | Migrations, modèles Eloquent, relations | 2 jours | Hyan Rida |
| 4. Authentification | Breeze, rôles patient/docteur, middleware | 2 jours | Hyan Rida |
| 5. Espace Patient | Dashboard, recherche docteur, prise de RDV | 3 jours | Hyan Rida |
| 6. Espace Médecin | Dashboard, gestion RDV, notes consultation | 2 jours | Hyan Rida |
| 7. Messagerie | Conversations, messages, lecture, suppression | 2 jours | Hyan Rida |
| 8. Fonctionnalités bonus | Notation, PDF, multilingue, dark mode | 4 jours | Hyan Rida |
| 9. Tests | Tests fonctionnels, debug, corrections UI | 2 jours | Hyan Rida |
| 10. Déploiement | GitHub, Railway, README, documentation | 2 jours | Hyan Rida |

---

## 🔧 Détail des tâches techniques

### Backend (Laravel)

| Module | Tâches | Fichiers principaux |
|---|---|---|
| **Modèles** | User, DoctorProfile, Appointment, Conversation, Message, Rating | `app/Models/` |
| **Migrations** | 6 tables avec relations FK | `database/migrations/` |
| **Contrôleurs Auth** | Inscription customisée avec choix de rôle | `app/Http/Controllers/Auth/` |
| **Contrôleurs Patient** | Dashboard, recherche docteur, RDV, notation | `app/Http/Controllers/Patient/` |
| **Contrôleurs Doctor** | Dashboard, gestion RDV avec stats | `app/Http/Controllers/Doctor/` |
| **MessageController** | Conversations, marquage lu, suppression | `app/Http/Controllers/` |
| **PdfController** | Export PDF patient + docteur | `app/Http/Controllers/` |
| **RatingController** | Notation post-consultation | `app/Http/Controllers/` |
| **LocaleController** | Bascule de langue avec session | `app/Http/Controllers/` |
| **Middleware** | DoctorMiddleware, PatientMiddleware, SetLocale | `app/Http/Middleware/` |
| **Seeders** | DoctorsSeeder (8 médecins fictifs) | `database/seeders/` |

### Frontend (Blade + Tailwind)

| Module | Tâches | Fichiers principaux |
|---|---|---|
| **Layouts** | app.blade, guest.blade, navigation avec dark mode | `resources/views/layouts/` |
| **Auth views** | Login, Register avec rôles | `resources/views/auth/` |
| **Patient views** | Dashboard, doctors index/show, appointments | `resources/views/patient/` |
| **Doctor views** | Dashboard avec reviews, appointments avec actions | `resources/views/doctor/` |
| **Messages views** | Inbox, conversation thread | `resources/views/messages/` |
| **Profile views** | Édition avec photo upload + suppression | `resources/views/profile/` |
| **PDF templates** | Templates patient + docteur | `resources/views/pdf/` |
| **Components** | Star rating, toast notifications | `resources/views/components/` |

### Style et UX

| Tâche | Description |
|---|---|
| Palette personnalisée | Brand blue medical (50-950), health teal |
| Mode sombre | Vanilla JS + localStorage, classe dark |
| Responsive | Mobile, tablette, desktop |
| RTL | Support arabe (dir="rtl") |
| Animations | Slide-in, fade-in, transitions |
| Toast notifications | Alpine.js, auto-dismiss 4.5s |

### Internationalisation

| Langue | Fichier | Lignes |
|---|---|---|
| Anglais | `lang/en/messages.php` | ~150 clés |
| Français | `lang/fr/messages.php` | ~150 clés |
| Arabe (RTL) | `lang/ar/messages.php` | ~150 clés |

### DevOps

| Tâche | Description |
|---|---|
| Versioning | Git local + GitHub remote |
| Branches | `master` (main branch) |
| Hébergement | Railway (Nixpacks) |
| Base de données | MySQL Railway |
| Variables d'environnement | APP_KEY, DB_*, APP_URL, LOG_CHANNEL |
| Build assets | Vite production build |
| Stockage | Symbolic link storage/app/public |

---

## ⏱️ Estimation des heures totales

| Activité | Heures |
|---|---|
| Conception et analyse | ~15h |
| Développement backend | ~50h |
| Développement frontend | ~40h |
| Tests et débogage | ~15h |
| Déploiement et documentation | ~10h |
| **TOTAL** | **~130h** |

---

## 📌 Points clés du projet

✅ **Conformité au cahier des charges** : toutes les fonctionnalités requises implémentées
✅ **Fonctionnalités bonus** ajoutées :
- Système de notation des médecins avec étoiles
- Export PDF (patient et docteur)
- Multilingue 3 langues + RTL
- Mode sombre persistant
- Filtres avancés (prix, spécialisation, top rated)
- Suppression photo de profil
✅ **Déployé en production** sur Railway
✅ **Code versionné** sur GitHub

---

## 🔗 Liens utiles

- **Code source** : https://github.com/hyanrida-arch/medical-appointments
- **Application en ligne** : https://medical-appointments-production-53de.up.railway.app/login
- **MPD** : `docs/MPD.pdf`

---

## ✍️ Signature

**Étudiant** : Hyan Rida
**Date** : ____ / ____ / 2026
**Signature** : ____________________