<p align="center">
  <a href="http://handal-sekolah.test">
    <img src="public/img/Handal 8.png" alt="Logo Handal Sekolah Aman Digital" width="500">
  </a>
</p>

<h1 align="center">Handal Sekolah Aman Digital</h1>

<p align="center">
  Sistem asesmen mandiri untuk mengukur tingkat keamanan digital di lingkungan sekolah.
</p>

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  </a>
  <a href="https://tailwindcss.com" target="_blank">
    <img src="https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS 4.0">
  </a>
</p>

---

## 🚀 Tentang Aplikasi

**Handal Sekolah Aman Digital** adalah platform berbasis web yang dirancang untuk membantu institusi pendidikan (sekolah) melakukan evaluasi mandiri (*self-assessment*) terhadap infrastruktur, kebijakan, dan literasi keamanan digital mereka. Sistem ini memberikan penilaian terukur untuk membantu sekolah meningkatkan standar keamanan siber di lingkungan pendidikan.

## 🛠️ Teknologi Utama

Aplikasi ini dibangun menggunakan teknologi web modern untuk menjamin performa dan kemudahan pengembangan:

-   **Backend Framework:** [Laravel 12](https://laravel.com)
-   **Frontend Styling:** [Tailwind CSS v4.0](https://tailwindcss.com)

## ⚙️ Instalasi & Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/Zuhdiiipi/HANDALSekolahAmanDigital.git](https://github.com/Zuhdiiipi/HANDALSekolahAmanDigital.git)
    cd HANDALSekolahAmanDigital
    ```

2.  **Install Dependensi Backend**
    ```bash
    composer install
    ```

3.  **Install Dependensi Frontend & Build Aset**
    ```bash
    npm install && npm run build
    ```

4.  **Konfigurasi Environment**
    Salin file contoh konfigurasi dan sesuaikan dengan database lokal Anda.
    ```bash
    cp .env.example .env
    ```
    *(Jangan lupa buat database baru di MySQL/MariaDB dan sesuaikan DB_DATABASE di file .env)*

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Migrasi Database & Seeder**
    Jalankan migrasi untuk membuat tabel dan mengisi data awal (Admin, Validator, Soal Survei).
    ```bash
    php artisan migrate:fresh --seed
    ```

7.  **Jalankan Server Lokal**
    ```bash
    php artisan serve
    ```
    Akses aplikasi di `http://localhost:8000`.

## 👥 Kredit & Tim Pengembang

Proyek ini dikembangkan sebagai bagian dari program di **BBLSDM Komdigi Makassar**.

**Tim Pengembang:**
* Muhammad Zuhdi
* Muhammad Naufal. N
* Ainul Hayat. H
* Muh. Sugandi

**Pembimbing:**
* Muh. Andar Sugianto, S.T.

---

<p align="center">
  &copy; 2026 Handal Sekolah Aman Digital — BBLSDM Komdigi Makassar
</p>