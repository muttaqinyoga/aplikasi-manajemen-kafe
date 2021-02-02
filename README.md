# Aplikasi Manajemen Kafe
Aplikasi sederhana berbasis web yang digunakan untuk memanajemen kafe. Aplikasi ini dibuat menggunakan framework laravel versi 5.6.
# Fitur Aplikasi
- Login Multiuser
    Ada dua jenis user yang ada pada aplikasi yaitu admin/owner dan waiter.
- Manage Data User (oleh Admin/Owner)
- Manage Menu Makanan & Minuman (oleh Admin/Owner)
- Manage Meja (oleh Admin/Owner)
- Manage Pesanan/Order (oleh Admin/Owner dan Waiter)
- Manage Pembayaran (oleh Admin/Owner)
# Update untuk menambahkan Captcha saat akan login
- Setelah menjalankan perintah composer install, buka file AuthenticatesUsers.php pada folder vendor/laravel/framework/src/Illuminate/Foundation/Auth/ lalu pada method validateLogin tambahkan rules validasi captcha dengan nilai required|captcha
