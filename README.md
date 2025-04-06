# Sistem Surat Kecamatan Masama

Aplikasi berbasis web untuk mencatat agenda surat masuk dan keluar di Kecamatan Masama, Kabupaten Banggai.

## Fitur Utama
- Pencatatan surat masuk dan keluar
- Validasi nomor surat unik
- Format tanggal dd/mm/yyyy
- Pencarian real-time
- Sistem login dengan password
- Tampilan responsif

## Persyaratan Sistem
- PHP 7.4+
- MySQL/MariaDB
- Web server (Apache/Nginx)

## Instalasi
1. Clone repository ini
2. Buat database baru dan import struktur dari `server/init_db.php`
3. Konfigurasi koneksi database di `server/db_connect.php`
4. Password default: `admin123`

## Menjalankan Aplikasi
Untuk development:
```bash
php -S localhost:8000 serve.php
```

Untuk production:
- Deploy ke web server (Apache/Nginx)
- Pastikan semua request diarahkan ke `index.php`

## Struktur Database
- incoming_letters: tabel untuk surat masuk
- outgoing_letters: tabel untuk surat keluar
- users: tabel untuk autentikasi

## Kontribusi
Silakan buka issue atau pull request untuk perbaikan atau fitur baru.