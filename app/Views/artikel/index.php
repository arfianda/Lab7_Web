<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<?php if (empty($articles)): ?>
    <div class="no-data">Belum ada data.</div>
<?php else: ?>
    <?php foreach ($articles as $article): ?>
        <div class="article-item">
            <h3><?= esc($article['title']) ?></h3>
            <p><?= character_limiter(strip_tags($article['content']), 200) ?></p>
            <div class="article-meta">
                <?php if ($article['author']): ?>
                    <span>Oleh: <?= esc($article['author']) ?></span> |
                <?php endif; ?>
                <span><?= date('d/m/Y', strtotime($article['created_at'])) ?></span>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<?= $this->endSection() ?>