<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $user = \App\Models\User::create([
            'name' => 'Admin Library',
            'role' => 'admin',
            'email' => 'admin@library.com',
            'password' => bcrypt('password'),
        ]);

        // Create Staff User
        \App\Models\User::create([
            'name' => 'Staff Library',
            'role' => 'staff',
            'email' => 'staff@library.com',
            'password' => bcrypt('password'),
        ]);

        // Create Dummy Books
        \App\Models\Book::create([
            'title'                  => 'Laskar Pelangi',
            'author'                 => 'Andrea Hirata',
            'publisher'              => 'Bentang Pustaka',
            'place_of_publication'   => 'Yogyakarta',
            'year_of_publication'    => '2005',
            'item_code'              => 'LP001, LP002',
            'isbn_issn'              => '9789793062792',
            'language'               => 'Indonesia',
            'collation'              => 'xiv, 529 hlm.; 21 cm',
            'gmd_type'               => 'Teks',
            'classification'         => '813',
            'call_number'            => '813 AND l',
            'subject'                => 'Novel Indonesia',
            'abstract'               => 'Kisah persahabatan sepuluh anak Belitung yang berjuang mendapatkan pendidikan di sekolah sederhana.',
            'cover_image'            => 'https://images-na.ssl-images-amazon.com/images/I/51Ga5GuElyL.jpg',
            'total_items'            => 5,
            'edition'                => '1',
            'frequency_of_publication' => null,
            'series_title'           => null,
            'attachment'             => null,
            'is_featured'            => true,
        ]);

        \App\Models\Book::create([
            'title'                  => 'Bumi Manusia',
            'author'                 => 'Pramoedya Ananta Toer',
            'publisher'              => 'Hasta Mitra',
            'place_of_publication'   => 'Jakarta',
            'year_of_publication'    => '1980',
            'item_code'              => 'BM001',
            'isbn_issn'              => '9789799731234',
            'language'               => 'Indonesia',
            'collation'              => 'x, 352 hlm.; 21 cm',
            'gmd_type'               => 'Teks',
            'classification'         => '813',
            'call_number'            => '813 PRA b',
            'subject'                => 'Novel Sejarah Indonesia',
            'abstract'               => 'Novel pertama dari Tetralogi Buru karya Pramoedya Ananta Toer yang mengisahkan kehidupan Minke di era kolonial Belanda.',
            'cover_image'            => 'https://upload.wikimedia.org/wikipedia/id/thumb/7/7a/Bumi_Manusia.jpg/220px-Bumi_Manusia.jpg',
            'total_items'            => 3,
            'edition'                => '1',
            'frequency_of_publication' => null,
            'series_title'           => 'Tetralogi Buru',
            'attachment'             => null,
            'is_featured'            => true,
        ]);

        \App\Models\Book::create([
            'title'                  => 'Pemrograman Web dengan Laravel',
            'author'                 => 'Jubilee Enterprise',
            'publisher'              => 'Elex Media Komputindo',
            'place_of_publication'   => 'Jakarta',
            'year_of_publication'    => '2020',
            'isbn_issn'              => '9786020482491',
            'language'               => 'Indonesia',
            'collation'              => 'viii, 312 hlm.; 23 cm',
            'gmd_type'               => 'Teks',
            'classification'         => '005.133',
            'call_number'            => '005.133 JUB p',
            'subject'                => 'Pemrograman Web; Laravel; PHP',
            'abstract'               => 'Panduan lengkap membangun aplikasi web modern menggunakan framework Laravel berbasis PHP.',
            'cover_image'            => 'https://images-na.ssl-images-amazon.com/images/I/51Ga5GuElyL.jpg',
            'total_items'            => 4,
            'edition'                => '2',
            'frequency_of_publication' => null,
            'series_title'           => null,
            'attachment'             => null,
            'is_featured'            => false,
        ]);

        \App\Models\Book::create([
            'title'                  => 'Sapiens: Riwayat Singkat Umat Manusia',
            'author'                 => 'Yuval Noah Harari',
            'publisher'              => 'KPG (Kepustakaan Populer Gramedia)',
            'place_of_publication'   => 'Jakarta',
            'year_of_publication'    => '2017',
            'isbn_issn'              => '9786024244507',
            'language'               => 'Indonesia',
            'collation'              => 'xii, 508 hlm.; 23 cm',
            'gmd_type'               => 'Teks',
            'classification'         => '909',
            'call_number'            => '909 HAR s',
            'subject'                => 'Sejarah Dunia; Antropologi',
            'abstract'               => 'Buku yang menelusuri perjalanan umat manusia dari zaman batu hingga era modern dengan perspektif ilmiah yang menarik.',
            'cover_image'            => 'https://images-na.ssl-images-amazon.com/images/I/41+lolL9ZTL.jpg',
            'total_items'            => 6,
            'edition'                => '1',
            'frequency_of_publication' => null,
            'series_title'           => null,
            'attachment'             => null,
            'is_featured'            => true,
        ]);

        \App\Models\Book::create([
            'title'                  => 'Matematika Diskrit',
            'author'                 => 'Rinaldi Munir',
            'publisher'              => 'Informatika',
            'place_of_publication'   => 'Bandung',
            'year_of_publication'    => '2016',
            'isbn_issn'              => '9786023610457',
            'language'               => 'Indonesia',
            'collation'              => 'xvi, 480 hlm.; 24 cm',
            'gmd_type'               => 'Teks',
            'classification'         => '510',
            'call_number'            => '510 MUN m',
            'subject'                => 'Matematika; Matematika Diskrit',
            'abstract'               => 'Buku teks matematika diskrit yang membahas logika, himpunan, relasi, fungsi, graf, dan kombinatorika.',
            'cover_image'            => null,
            'total_items'            => 8,
            'edition'                => '5',
            'frequency_of_publication' => null,
            'series_title'           => null,
            'attachment'             => null,
            'is_featured'            => false,
        ]);

        \App\Models\Book::create([
            'title'                  => 'Kamus Besar Bahasa Indonesia',
            'author'                 => 'Tim Penyusun Kamus Pusat Bahasa',
            'publisher'              => 'Balai Pustaka',
            'place_of_publication'   => 'Jakarta',
            'year_of_publication'    => '2008',
            'isbn_issn'              => '9789790070646',
            'language'               => 'Indonesia',
            'collation'              => 'xlv, 1826 hlm.; 27 cm',
            'gmd_type'               => 'Referensi',
            'classification'         => '499.221 3',
            'call_number'            => 'R 499.221 3 TIM k',
            'subject'                => 'Bahasa Indonesia; Kamus',
            'abstract'               => 'Kamus resmi bahasa Indonesia edisi keempat yang memuat lebih dari 90.000 entri kata.',
            'cover_image'            => null,
            'total_items'            => 2,
            'edition'                => '4',
            'frequency_of_publication' => null,
            'series_title'           => null,
            'attachment'             => null,
            'is_featured'            => false,
        ]);

        \App\Models\Book::create([
            'title'                  => 'Struktur Data dan Algoritma dengan Python',
            'author'                 => 'Eko Prasetyo',
            'publisher'              => 'Andi',
            'place_of_publication'   => 'Yogyakarta',
            'year_of_publication'    => '2021',
            'isbn_issn'              => '9786230217845',
            'language'               => 'Indonesia',
            'collation'              => 'x, 280 hlm.; 23 cm',
            'gmd_type'               => 'Teks',
            'classification'         => '005.133',
            'call_number'            => '005.133 PRA s',
            'subject'                => 'Struktur Data; Algoritma; Python',
            'abstract'               => 'Panduan belajar struktur data dan algoritma menggunakan bahasa pemrograman Python secara praktis.',
            'cover_image'            => null,
            'total_items'            => 5,
            'edition'                => '1',
            'frequency_of_publication' => null,
            'series_title'           => null,
            'attachment'             => null,
            'is_featured'            => false,
        ]);
        
        // Stock opnames removed to start fresh
        
    }
}
