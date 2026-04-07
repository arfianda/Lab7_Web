<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="admin-header">
    <h2><?= $title ?></h2>
    <a href="<?= base_url('admin/artikel/add') ?>" class="btn btn-primary">+ Tambah Artikel</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="search-box">
    <form method="get" action="<?= base_url('admin/artikel/search') ?>">
        <input type="text" name="q" placeholder="Cari artikel..." value="<?= isset($keyword) ? esc($keyword) : '' ?>">
        <button type="submit" class="btn btn-secondary">Cari</button>
    </form>
</div>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Author</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($articles)): ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada artikel</td>
                </tr>
            <?php else: ?>
                <?php $no = 1;
                foreach ($articles as $article): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($article['judul']) ?></td>
                        <td><?= esc($article['author'] ?? '-') ?></td>
                        <td>
                            <span class="badge <?= $article['status'] == 1 ? 'badge-success' : 'badge-warning' ?>">
                                <?= $article['status'] == 1 ? 'Publish' : 'Draft' ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($article['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('admin/artikel/edit/' . $article['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= base_url('admin/artikel/delete/' . $article['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus artikel ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if (isset($pager)): ?>
    <div class="pagination">
        <?= $pager->links() ?>
    </div>
<?php endif; ?>

<style>
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .search-box {
        margin-bottom: 20px;
    }

    .search-box form {
        display: flex;
        gap: 10px;
    }

    .search-box input {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .table th {
        background: #f5f5f5;
        padding: 12px;
        text-align: left;
        border-bottom: 2px solid #ddd;
    }

    .table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
    }

    .table tr:hover {
        background: #f9f9f9;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 12px;
        color: white;
    }

    .badge-success {
        background: #28a745;
    }

    .badge-warning {
        background: #ffc107;
        color: #333;
    }

    .btn {
        display: inline-block;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-primary {
        background: #0066cc;
        color: white;
    }

    .btn-primary:hover {
        background: #004ba3;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-sm {
        padding: 4px 12px;
        font-size: 12px;
    }

    .btn-warning {
        background: #ffc107;
        color: #333;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .alert {
        padding: 12px 16px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
<?= $this->endSection() ?>