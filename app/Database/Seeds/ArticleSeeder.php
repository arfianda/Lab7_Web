<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul'      => 'Selamat Datang di Portal Berita',
                'isi'        => '<p>Ini adalah artikel pertama di Portal Berita kami. Kami menyediakan informasi terkini dan berkualitas untuk Anda.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
                'slug'       => 'selamat-datang-di-portal-berita',
                'gambar'     => null,
                'status'     => 1,
                'author'     => 'Admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul'      => 'Panduan Menggunakan Portal Berita',
                'isi'        => '<p>Pelajari cara menggunakan semua fitur dalam Portal Berita kami dengan mudah.</p><p>Anda dapat membaca artikel, mencari berita, dan berlangganan update terbaru dari kami.</p>',
                'slug'       => 'panduan-menggunakan-portal-berita',
                'gambar'     => null,
                'status'     => 1,
                'author'     => 'Editor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul'      => 'Tips Menulis Artikel yang Baik',
                'isi'        => '<p>Menulis artikel yang baik membutuhkan persiapan dan struktur yang tepat.</p><p>Pastikan artikel Anda memiliki judul yang menarik, pembukaan yang kuat, isi yang informatif, dan kesimpulan yang jelas.</p>',
                'slug'       => 'tips-menulis-artikel-yang-baik',
                'gambar'     => null,
                'status'     => 1,
                'author'     => 'Penulis',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('articles')->insertBatch($data);
    }
}
