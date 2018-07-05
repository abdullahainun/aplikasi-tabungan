# Aplikasi
Aplikasi sederhana, untuk pencatatan tabungan siswa dibuat dengan Laravel.
100% offline!

## Instalasi
- Clone/download
```
$ git clone https://github.com/harkce/manajemen-tabungan.git
$ cd manajemen-tabungan
$ composer install
```
- Buat database untuk aplikasi
- Rename `.env.example` menjadi `.env`, kemudian set databasenya
```
...

DB_CONNECTION=mysql     # Jenis database
DB_HOST=127.0.0.1       # Databasenya dimana
DB_PORT=3306            # Port berapa
DB_DATABASE=homestead   # Nama db nya apa
DB_USERNAME=homestead   # Username anda
DB_PASSWORD=secret      # Passwordnyah

...
```
- Generate key untuk app nya
```
$ php artisan key:generate
```
- Terakhir, lakukan migration untuk menyambungkan app dengan database
```
$ php artisan migrate
```

## Cara Menggunakan
Masuk ke direktori program, kemudian jalankan `serve` nya artisan
```
$ cd manajemen-tabungan
$ php artisan serve
```
Secara default, aplikasi akan dijalankan di `http://localhost:8000`. Tinggal masuk ke alamat itu dari browser.

## Konfigurasi password pertama kali
Pertama program dijalankan, konfigurasi dulu passwordnya.
- Masuk ke `http://localhost:8000/register`
- Isi nama dan password
- Selesai

# Wilujeng~!
