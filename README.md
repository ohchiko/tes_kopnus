# **MX100 Job Portal API (Laravel)**

API ini dikembangkan untuk proyek MX100, sebuah portal pekerjaan yang menghubungkan perusahaan dengan *freelancer* atau *part-timer*.

## **Fitur**

* **Autentikasi Pengguna:** *Login* untuk perusahaan (*client*) dan *freelancer* menggunakan Laravel Sanctum.  
* **Manajemen Pekerjaan (Perusahaan):**  
  * Membuat dan memposting lowongan pekerjaan.  
  * Menyimpan lowongan pekerjaan sebagai draf.  
  * Mempublish lowongan pekerjaan yang tersimpan sebagai draf.
  * Melihat daftar *CV* yang melamar untuk setiap pekerjaan.  
* **Aplikasi Pekerjaan (Freelancer):**  
  * Melihat daftar lowongan pekerjaan yang dipublikasikan.  
  * Mengirimkan aplikasi beserta *CV* untuk pekerjaan yang dipublikasikan.

## **Persyaratan Sistem**

* PHP \>= 8.3  
* Composer  
* SQLite

## **Instalasi**

Ikuti langkah-langkah di bawah ini untuk menginstal dan menjalankan proyek secara lokal:

1. Kloning Repositori:  
   `git clone https://github.com/ohchiko/tes_kopnus.git mx100-api`  
   `cd mx100-api`

2. **Instal Dependensi Composer:**  
   `composer install`

3. Konfigurasi Environment:  
   Salin file .env.example ke .env:  
   `cp .env.example .env`

   Buka file .env dan konfigurasikan sesuai environment Anda.

4. **Buat Kunci Aplikasi:**  
   `php artisan key:generate`

5. Jalankan Migrasi Database:  
   `php artisan migrate`

6. Isi Data Contoh (Opsional tapi Direkomendasikan):  
   `php artisan db:seed`

7. **Jalankan Server Pengembangan Laravel:**  
   `php artisan serve`

   API akan tersedia di http://127.0.0.1:8000.

## **Skema Database**

Berikut adalah representasi skema database yang digunakan dalam aplikasi ini:

### **users table**

| Kolom | Tipe Data | Keterangan |
| :---- | :---- | :---- |
| id | BIGINT UNSIGNED | Primary key, auto-increment |
| role_id | BIGINT UNSIGNED | Foreign key ke roles |
| name | VARCHAR(255) | Nama pengguna (perusahaan atau *freelancer*) |
| email | VARCHAR(255) UNIQUE | Alamat email |
| password | VARCHAR(255) | Kata sandi terenkripsi |
| email\_verified\_at | TIMESTAMP | Waktu verifikasi email (nullable) |
| remember\_token | VARCHAR(100) | Token "ingat saya" (nullable) |
| created\_at | TIMESTAMP | Waktu pembuatan record |
| updated\_at | TIMESTAMP | Waktu terakhir record diperbarui |

### **roles table**

| Kolom | Tipe Data | Keterangan |
| :---- | :---- | :---- |
| id | BIGINT UNSIGNED | Primary key, auto-increment |
| name | VARCHAR(255) UNIQUE | Nama role |
| created\_at | TIMESTAMP | Waktu pembuatan record |
| updated\_at | TIMESTAMP | Waktu terakhir record diperbarui |

### **job\_postings table**

| Kolom | Tipe Data | Keterangan |
| :---- | :---- | :---- |
| id | BIGINT UNSIGNED | Primary key, auto-increment |
| user\_id | BIGINT UNSIGNED | Foreign key ke users (perusahaan yang memposting) |
| title | VARCHAR(255) | Judul pekerjaan |
| description | TEXT NULLABLE | Deskripsi pekerjaan |
| salary | DECIMAL(10, 2\) | Gaji yang ditawarkan (nullable) |
| published\_at | TIMESTAMP | Waktu publish job |
| created\_at | TIMESTAMP | Waktu pembuatan record |
| updated\_at | TIMESTAMP | Waktu terakhir record diperbarui |

### **applications table**

| Kolom | Tipe Data | Keterangan |
| :---- | :---- | :---- |
| id | BIGINT UNSIGNED | Primary key, auto-increment |
| job\_posting\_id | BIGINT UNSIGNED | Foreign key ke job\_postings (pekerjaan yang dilamar) |
| user\_id | BIGINT UNSIGNED | Foreign key ke users (*freelancer* yang melamar) |
| cv\_path | VARCHAR(255) | File path *CV* (*freelancer*) |
| approved\_at | TIMESTAMP | Waktu approve job |
| completed\_at | TIMESTAMP | Waktu penyelesaian job |
| created\_at | TIMESTAMP | Waktu pembuatan record |
| updated\_at | TIMESTAMP | Waktu terakhir record diperbarui |
