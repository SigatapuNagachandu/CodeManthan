# AegisProctor - AI-Powered Proctored Hackathon Screening Platform

AegisProctor is a premium, high-fidelity secure online screening platform designed for national and international hackathon organizers. It enables conduct of secured aptitude, multiple choice, and coding exams for shortlisting technical candidates fairly and efficiently.

Built with a modern minimalist aesthetic (inspired by clean premium interfaces, smooth animations, glassmorphism cards, and curated HSL palettes), it runs on **Laravel 12 + MongoDB Database** cluster.

---

## 🚀 Key Features Walkthrough

### 1. Ultra-Modern Landing Page
- Rich interactive mesh background, scrolling animations, and glassmorphic dashboards.
- Dynamic statistics widgets, FAQ accordions, and frictionless demo log-in options.

### 2. Multi-Role Dashboards & Authentications
- **Password Entry + 6-digit OTP Generation**: Generates verification PINs, progressively stored in MongoDB with 10-minute expirations.
- **Frictionless Google OAuth Mock Simulator**: Allows logging in immediately as any seeded role.
- **Role-Based Access Control**: Standardizes permissions for `super_admin`, `organizer`, `candidate`, and `proctor`.

### 3. Real-Time Proctored Exam Cockpit
- **Visual Webcam Stream**: Diagnostics request camera permissions and output live video.
- **Fullscreen Locking (Exit Alerts)**: Enforces fullscreen; exiting triggers proctor infractions.
- **Tab Swapping Prevention**: Monitors page visibility, logging blur shifts.
- **Clipboard & Right-click Blocking**: Intercepts keyboard copy-paste shortcuts and disables context menus.
- **Autosave Engine**: Progressively posts candidate answers to MongoDB every 10 seconds.
- **Monaco Code Editor**: Bundles VS Code-quality compilation in Python 3 and JavaScript, clearing functional public/hidden test sets.

### 4. Live Proctor Monitor Center
- Displays active streams, compliant ratings, stopwatch logs, and alert severity grids.
- Proctors can issue **live warn notifications** that flash instantly on candidate screens.
- **Leaderboards & Certificates**: Auto-calculates points, assesses compiler states, and attaches print-ready PDF/Excel audit reports.

---

## 🛠️ Technology Stack
- **Backend Framework**: Laravel 12
- **Database Engine**: MongoDB (configured via `mongodb/laravel-mongodb`)
- **Frontend Core**: Blade + Tailwind CSS (Tailwind v4) + Alpine.js
- **Charts & Graphs**: Chart.js
- **Editor**: Monaco Editor

---

## 📥 Platform Setup & Installation

### Prerequisite Checklist
1. **PHP 8.2+** (ZTS x64) is required.
2. **MongoDB Community Server** running locally on port `27017` (e.g. connected via MongoDB Compass).
3. **Composer** package manager.
4. **Node.js & npm** for compilation.

### Step 1: Install Dependencies
Open your shell terminal in this directory and execute:
```bash
composer install
npm install
```

### Step 2: Configure Environment `.env`
Your `.env` database block is configured as follows:
```ini
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=proctored_hackathon
DB_USERNAME=
DB_PASSWORD=

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

### Step 3: Run Database Seeders
Populate your MongoDB database with seed users, hackathons, and anti-cheating exams:
```bash
php artisan db:seed
```

### Step 4: Boot Local Development Servers
Run the Laravel application server and Vite asset bundler concurrently:
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```
Open **[http://127.0.0.1:8000](http://127.0.0.1:8000)** in your browser!

---

## 🔐 Predictable Sandbox Mock Accounts

For frictionless testing of all dashboards, use the following logins (password: `password`):

| User Role | Seeded Email | Dashboard Route | Direct Quick-Login |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@proctored.com` | `/organizer/dashboard` | Google Simulator |
| **Organizer** | `organizer@proctored.com` | `/organizer/dashboard` | Google Simulator |
| **Candidate** | `candidate@proctored.com` | `/candidate/dashboard` | Google Simulator |
| **Proctor** | `proctor@proctored.com` | `/proctor/dashboard` | Google Simulator |

---

## 🧬 DB Collection Model Mappings
MongoDB collections configured under `/app/Models`:
- `users`: User identity details, passwords, dynamic OTP states.
- `hackathons`: Active hackathon dates and headers.
- `exams`: Screenings, rules array, proctor configurations.
- `questions`: MCQ options arrays, Monaco templates, test-cases.
- `submissions`: Graded scores, autosave sheets, AI evaluation feedbacks.
- `proctor_logs`: Captures snapshot audits.
- `cheating_events`: Anti-cheat logs (visibility alerts, clipboard locks).
- `analytics`: Aggregated difficulty matrices and metrics.
- `notifications`: Simple dashboard alerts.
