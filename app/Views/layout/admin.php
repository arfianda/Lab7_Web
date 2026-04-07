<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?> - Portal Berita</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .admin-sidebar h2 {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .admin-sidebar ul {
            list-style: none;
        }

        .admin-sidebar li {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            transition: background 0.3s;
        }

        .admin-sidebar a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .admin-content {
            margin-left: 250px;
            flex: 1;
        }

        .admin-header {
            background: white;
            padding: 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-main {
            padding: 20px;
        }

        .admin-main>h2 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <div class="admin-sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="<?= base_url('admin/artikel') ?>">Kelola Artikel</a></li>
                <li><a href="<?= base_url('admin/artikel/add') ?>">Tambah Artikel</a></li>
                <li><a href="<?= base_url('user') ?>">Daftar User</a></li>
                <li><a href="<?= base_url('/') ?>">Kembali ke Website</a></li>
                <li><a href="<?= base_url('user/logout') ?>">Logout</a></li>
            </ul>
        </div>

        <div class="admin-content">
            <div class="admin-header">
                <h1><?= $title ?? 'Admin Panel' ?></h1>
                <span>Login: <?= esc(session('user_name') ?? 'Unknown') ?></span>
            </div>
            <div class="admin-main">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
</body>

</html>
