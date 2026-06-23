Sistem pencatatan pemasukan/pengeluaran uang dari berbagai bank berbasis website.

Fitur :
Koneksi database dengan mysql, input transaksi, menampilkan saldo dan riwayat transaksi pada dashboard

Langkah - langkah pengerjaan :
1. Menentukan konsep website cashflow
2. Membuat database 'cashflow' berisi tabel 'bank' dengan isi berupa id, nama bank, nomor rekening, tanggal pembuatan kemudian tabel 'transaksi' dengan isi berupa id, bank id, tipe (pemasukan/pengeluaran), jumlah uang, deskripsi/keterangan, tanggal input
3. Menambahkan isi database pada tabel 'bank'
4. Membuat file 'koneksi.php' untuk menyambungkan database dengan project php
5. Membuat dashboard pada 'index.php' menggunakan bootstrap 5
6. Membuat button input, pengkalkulasian saldo (total pemasukan - pengeluaran), dan mengambil 10 riwayat terakhir berdasarkan tanggal terbaru di tabel 'transaksi' pada dashboard
7. Membuat perintah untuk button input pada 'input.php' menggunakan html untuk memasukan data terbaru (memilih rekening dan nomor rekening, menentukan jenis transaksi, menginput nominal uang, dan menambahkan deskripsi/keterangan) serta menyimpan data terbaru ke database 'transaksi'
8. Melakukan pengujian pada localhost sampai dipastikan bahwa website dapat berjalan dengan baik
9. Mendownload dan buat akun git - github
10. Mengecek versi git pada terminal vscode
11. Menginput username dan email yang digunakan untuk git di terminal
12. Publish project cashflow (koneksi.php, index.php, input.php, cashflow.sql) secara public ke github melalui source control
13. Membuat file README.md untuk langkah-langkah pengerjaan
