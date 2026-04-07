<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<h2><?= $title ?></h2>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <strong>Validasi Error:</strong>
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="<?= base_url('admin/artikel/update/' . $article['id']) ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" id="judul" name="judul" value="<?= old('judul', $article['judul']) ?>" class="form-control" required>
        <?php if (isset($validation) && $validation->hasError('judul')): ?>
            <small class="error"><?= $validation->getError('judul') ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="slug">Slug (otomatis terisi jika kosong)</label>
        <input type="text" id="slug" name="slug" value="<?= old('slug', $article['slug']) ?>" class="form-control">
        <?php if (isset($validation) && $validation->hasError('slug')): ?>
            <small class="error"><?= $validation->getError('slug') ?></small>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="isi">Isi Artikel</label>
        <textarea id="isi" name="isi" class="form-control" rows="10" required><?= old('isi', $article['isi']) ?></textarea>
        <?php if (isset($validation) && $validation->hasError('isi')): ?>
            <small class="error"><?= $validation->getError('isi') ?></small>
        <?php endif; ?>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" id="author" name="author" value="<?= old('author', $article['author']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="gambar">Gambar</label>
            <?php if ($article['gambar']): ?>
                <div class="current-image">
                    <img src="<?= base_url('uploads/artikel/' . esc($article['gambar'])) ?>" alt="<?= esc($article['judul']) ?>">
                    <p>Gambar saat ini: <?= esc($article['gambar']) ?></p>
                </div>
            <?php endif; ?>
            <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*">
            <small>Biarkan kosong jika tidak ingin mengubah gambar. Max 2MB, format: JPG, JPEG, PNG, GIF</small>
            <?php if (isset($validation) && $validation->hasError('gambar')): ?>
                <small class="error"><?= $validation->getError('gambar') ?></small>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status" class="form-control">
            <option value="0" <?= old('status', $article['status']) == 0 ? 'selected' : '' ?>>Draft</option>
            <option value="1" <?= old('status', $article['status']) == 1 ? 'selected' : '' ?>>Publish</option>
        </select>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('admin/artikel') ?>" class="btn btn-secondary">Batal</a>
    </div>
</form>

<style>
    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-family: Arial, sans-serif;
    }

    .form-control:focus {
        outline: none;
        border-color: #0066cc;
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
    }

    small {
        display: block;
        margin-top: 5px;
        color: #666;
    }

    .error {
        color: #dc3545;
    }

    .current-image {
        margin-bottom: 15px;
        padding: 10px;
        background: #f5f5f5;
        border-radius: 4px;
    }

    .current-image img {
        max-width: 200px;
        height: auto;
        border-radius: 4px;
        margin-bottom: 10px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
        display: inline-block;
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

    .alert {
        padding: 12px 16px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert ul {
        margin: 10px 0 0 20px;
    }

    .alert ul li {
        margin: 5px 0;
    }
</style>
<?= $this->endSection() ?>