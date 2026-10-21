# Portofolio Aziza Ony Badu

Portofolio PHP native dengan Tailwind CSS CLI dan data MySQL melalui PDO. File `assets/css/output.css` dipakai langsung oleh situs, sehingga hosting hanya membutuhkan PHP dan web server; Node.js dibutuhkan untuk mengubah styling.

## Persiapan

1. Instal PHP 8.1+ dengan ekstensi PDO MySQL dan mbstring, MySQL 8+, Node.js, dan npm.
2. Buat database, lalu impor skema dan data awal:

   ```sh
   mysql -u root -p < database/schema.sql
   mysql -u root -p aziza_portfolio < database/seed.sql
   ```

3. Salin `.env.example` menjadi `.env`, lalu sesuaikan `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, dan `DB_PASS`. Isi `PORTFOLIO_CONTACT_EMAIL` jika email kontak ingin dikirim melalui `mail()`.
4. Pasang dependency dan hasilkan CSS:

   ```sh
   npm install
   npm run build
   ```

   Untuk mengembangkan stylesheet sambil memantau perubahan:

   ```sh
   npm run dev
   ```

5. Jalankan situs dari direktori project:

   ```sh
   php -S localhost:8000
   ```

6. Buka `http://localhost:8000`.

Jika database belum tersedia atau koneksi gagal, halaman menggunakan data fallback dan mencatat detail kegagalan ke log PHP. Form kontak memerlukan database agar pesan dapat disimpan.

## Struktur data

`database/schema.sql` membuat tabel `profile`, `skills`, `projects`, `education`, `social_links`, dan `contact_messages`. `database/seed.sql` berisi konten awal dari portofolio. Jangan menjalankan seed berulang tanpa mengosongkan data terlebih dahulu karena entri selain profil dirancang untuk impor awal.

## Gambar

Simpan gambar portofolio di `assets/images/`. Untuk gambar proyek, isi kolom `image` pada tabel `projects` dengan nama file saja, misalnya `1-2.png`.

## Keamanan kontak

Form memakai sesi cookie `HttpOnly` dan `SameSite=Lax`, token CSRF kedaluwarsa, validasi server, honeypot, pembatasan 3 pesan per alamat IP dalam 10 menit, prepared statements, escape output, dan pola Post/Redirect/Get. Pastikan HTTPS aktif di hosting agar cookie sesi memakai atribut `Secure`.
