<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h2><?= $title ?? 'Home' ?></h2>
<hr>
<p>Selamat datang di Portal Berita. Portal berita adalah platform untuk membaca berita dan informasi terkini.</p>
<?= $this->endSection() ?>