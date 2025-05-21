# 🚀 Laravel Project Setup Guide

Panduan ini menjelaskan langkah-langkah untuk mengkloning dan menjalankan proyek Laravel dari GitHub.

## 📦 Persyaratan

Pastikan kamu telah menginstal:
- PHP >= 8.3
- Composer
- SQLite
- Node.js & NPM
- Git

## 🧪 Langkah-langkah Instalasi

### 1. Clone Repositori

```bash
git clone https://github.com/Ashandrea/Tomas.git
cd Tomas
````

---

### 2. Install Dependency PHP

```bash
composer install
```

---

### 3. Salin dan Konfigurasi File Environment

```bash
cp .env.example .env
```


---

### 4. Generate Application Key

```bash
php artisan key:generate
```

---

### 5. Jalankan Migrasi & Seeder (Opsional)

```bash
php artisan migrate --seed
```


---

### 6. Install Dependency Front-End

```bash
npm install && npm run dev
```

---

### 7. Jalankan Laravel Development Server

```bash
php artisan serve
```

Akses proyek di browser melalui:

```
http://127.0.0.1:8000
```
