<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<article class="article-detail">
    <h1><?= esc($article['judul']) ?></h1>

    <div class="article-meta">
        <?php if ($article['author']): ?>
            <span class="author">By: <?= esc($article['author']) ?></span>
        <?php endif; ?>
        <span class="date"><?= date('d F Y', strtotime($article['created_at'])) ?></span>
    </div>

    <?php if ($article['gambar']): ?>
        <div class="article-featured-image">
            <img src="<?= base_url('uploads/artikel/' . esc($article['gambar'])) ?>" alt="<?= esc($article['judul']) ?>">
        </div>
    <?php endif; ?>

    <div class="article-content">
        <?= $article['isi'] ?>
    </div>

    <div class="article-navigation">
        <a href="<?= base_url('artikel') ?>" class="btn-back">← Kembali ke Daftar Artikel</a>
    </div>
</article>

<style>
    .article-detail {
        max-width: 800px;
        background: white;
        padding: 20px;
    }

    .article-detail h1 {
        color: #333;
        margin-bottom: 15px;
        font-size: 2em;
    }

    .article-meta {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #ddd;
        font-size: 14px;
        color: #666;
    }

    .article-meta span {
        margin-right: 15px;
    }

    .article-featured-image {
        margin: 20px 0;
    }

    .article-featured-image img {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }

    .article-content {
        font-size: 16px;
        line-height: 1.8;
        color: #333;
        margin: 20px 0;
    }

    .article-content p {
        margin-bottom: 15px;
    }

    .article-navigation {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #ddd;
    }

    .btn-back {
        color: #0066cc;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-back:hover {
        text-decoration: underline;
    }
</style>
<?= $this->endSection() ?>