# SISTEM INFORMASI PERUMAHAN PESAWARAN (SIPERPES)

SIPERPES adalah sebuah web GIS (Geographic Information System) yang memberikan informasi mengenai perumahan-perumahan yang ada di Kabupaten Pesawaran, Provinsi Lampung. Sistem ini bertujuan untuk mempermudah masyarakat dalam mencari informasi tentang perumahan yang tersedia di daerah tersebut.

![image](./public/asset/img/img-3.jpg)
![image](./public/asset/img/img-4.jpg)
![image](./public/asset/img/img-5.jpg)
![image](./public/asset/img/img-1.png)
![image](./public/asset/img/img-2.png)

## Fitur

Website ini dilengkapi dengan beberapa fitur utama sebagai berikut:

- **Fitur Pencarian**: Memungkinkan pengguna untuk mencari perumahan berdasarkan nama perumahan, kecamatan, dan desa.
- **Fitur Rute**: Memberikan informasi rute menuju perumahan yang dipilih dari lokasi terkini pengguna.
- **Fitur Informasi Perumahan**: Menyediakan informasi terkait perumahan yang dicari, termasuk lokasi, pengembang, jumlah unit, dan tahun berdiri.
- **Fitur Tambah Perumahan (ADMIN)**: Admin dapat menambahkan data perumahan baru ke dalam sistem.
- **Fitur Tambah Polygon (ADMIN)**: Admin dapat menambahkan polygon yang menggambarkan area perumahan berdasarkan Siteplan yang ada.

## Teknologi yang Digunakan

Website ini dibangun menggunakan berbagai teknologi terkini untuk memberikan pengalaman pengguna yang optimal:

- **Laravel**:
  Laravel adalah framework PHP yang digunakan untuk membangun aplikasi web dengan cepat dan efisien. Dengan menggunakan Laravel, pengembangan backend menjadi lebih terstruktur dan mudah dikelola. Laravel menyediakan berbagai fitur seperti routing, middleware, ORM (Eloquent), autentikasi, dan lainnya yang mempermudah pembuatan aplikasi web.

- **MapBox**:
  Mapbox adalah platform untuk pembuatan peta interaktif dan kustom. Mapbox memungkinkan pengguna untuk membuat tampilan peta yang dapat disesuaikan sesuai dengan kebutuhan aplikasi, termasuk penambahan marker, garis, dan poligon. Peta ini digunakan untuk menampilkan lokasi perumahan serta memberikan informasi rute dari lokasi pengguna.

- **Supabase**:
  Supabase adalah platform backend-as-a-service yang menyediakan layanan seperti database, autentikasi, dan penyimpanan file. Supabase menggunakan PostgreSQL sebagai database relasional yang kuat untuk menyimpan data perumahan. Supabase juga menyediakan API untuk berinteraksi langsung dengan data di database, yang mempermudah integrasi frontend dengan backend.

- **jQuery & JavaScript**:
  jQuery digunakan untuk menangani event pengguna dan interaksi dengan elemen-elemen di halaman, seperti klik tombol dan pengambilan data dari API. JavaScript digunakan untuk menampilkan informasi dinamis di frontend, termasuk pengambilan data perumahan, penambahan marker pada peta, dan interaksi lainnya yang memerlukan perubahan tampilan halaman secara real-time.

## Cara Menjalankan Aplikasi

### Persyaratan

Sebelum menjalankan aplikasi, pastikan bahwa Anda telah menginstal beberapa persyaratan berikut:

- PHP >= 8.1
- Composer (untuk mengelola dependensi PHP)
- PHP Artisan
- Database PostgreSQL

### Langkah-langkah

Clone repositori ke dalam mesin lokal Anda:

```sh

git clone https://github.com/vincentiusyudha23/siperpes.git
cd siperpes

```
Install Depedencies

    ```bash
    composer install
    ```

