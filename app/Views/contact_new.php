<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h2><?= $title ?? 'Kontak' ?></h2>
<hr>
<p>Hubungi kami melalui formulir ini atau gunakan informasi kontak di bawah ini.</p>
<p><strong>Email:</strong> info@portalberita.com</p>
<p><strong>Telepon:</strong> (021) 1234-5678</p>
<?= $this->endSection() ?>