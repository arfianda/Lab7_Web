<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h2><?= $title ?? 'About' ?></h2>
<hr>
<p><?= $content ?? 'Ini adalah halaman about. Informasi tentang portal berita kami dapat ditemukan di sini.' ?></p>
<?= $this->endSection() ?>