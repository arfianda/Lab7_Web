<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul'     => 'Cara Menggunakan AJAX di CodeIgniter 4',
                'isi'       => 'AJAX adalah teknik pengembangan web yang memungkinkan aplikasi web bekerja secara asynchronous. Dengan AJAX, kita dapat memperbarui halaman tanpa perlu reload keseluruhan. Artikel ini menjelaskan cara mengimplementasikan AJAX di CodeIgniter 4.',
                'slug'      => 'cara-menggunakan-ajax-di-codeigniter-4',
                'status'    => 1,
                'author'    => 'Admin',
                'gambar'    => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul'     => 'Pemahaman REST API dengan CodeIgniter',
                'isi'       => 'REST API adalah arsitektur yang sangat populer untuk membangun web services. CodeIgniter 4 menyediakan fitur-fitur yang memudahkan dalam membuat REST API. Mari pelajari cara membuat REST API yang baik.',
                'slug'      => 'pemahaman-rest-api-dengan-codeigniter',
                'status'    => 1,
                'author'    => 'Developer',
                'gambar'    => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul'     => 'Database Migration di CodeIgniter 4',
                'isi'       => 'Migration membantu kita mengelola skema database dengan lebih terstruktur. Dengan migration, perubahan database dapat di-track dan di-version control. Pelajari cara menggunakan migration di CodeIgniter 4.',
                'slug'      => 'database-migration-di-codeigniter-4',
                'status'    => 1,
                'author'    => 'Admin',
                'gambar'    => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul'     => 'Artikel Draft - Belum Dipublikasikan',
                'isi'       => 'Ini adalah contoh artikel dengan status draft. Artikel ini tidak akan tampil di halaman publik tetapi akan tampil di halaman AJAX admin.',
                'slug'      => 'artikel-draft-belum-dipublikasikan',
                'status'    => 0,
                'author'    => 'Editor',
                'gambar'    => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('articles')->insertBatch($data);
    }
}
