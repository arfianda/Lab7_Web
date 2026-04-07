<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h2><?= $title ?></h2>
<hr>

<?php if (empty($articles)): ?>
    <div class="no-data">Belum ada artikel yang dipublikasikan.</div>
<?php else: ?>
    <div class="articles-list">
        <?php foreach ($articles as $article): ?>
            <div class="article-card">
                <div class="article-header">
                    <h3><?= esc($article['judul']) ?></h3>
                    <small class="article-date"><?= date('d/m/Y', strtotime($article['created_at'])) ?></small>
                </div>

                <?php if ($article['gambar']): ?>
                    <div class="article-image">
                        <img src="<?= base_url('uploads/artikel/' . esc($article['gambar'])) ?>" alt="<?= esc($article['judul']) ?>">
                    </div>
                <?php endif; ?>

                <div class="article-body">
                    <p><?= substr(strip_tags($article['isi']), 0, 250) . (strlen(strip_tags($article['isi'])) > 250 ? '...' : '') ?></p>
                </div>

                <div class="article-footer">
                    <?php if ($article['author']): ?>
                        <span class="article-author">By: <?= esc($article['author']) ?></span>
                    <?php endif; ?>
                    <a href="<?= base_url('artikel/' . esc($article['slug'])) ?>" class="btn-readmore">Baca Selengkapnya →</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
    .articles-list {
        display: grid;
        gap: 20px;
    }

    .article-card {
        border: 1px solid #ddd;
        background: white;
        padding: 15px;
        border-radius: 5px;
    }

    .article-header h3 {
        margin: 0 0 8px 0;
        color: #0066cc;
    }

    .article-date {
        color: #999;
        font-size: 12px;
    }

    .article-image {
        margin: 10px 0;
    }

    .article-image img {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }

    .article-body {
        margin: 10px 0;
        line-height: 1.6;
    }

    .article-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #eee;
    }

    .article-author {
        font-size: 12px;
        color: #666;
    }

    .btn-readmore {
        color: #0066cc;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-readmore:hover {
        text-decoration: underline;
    }
</style>
<?= $this->endSection() ?>