<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Portal Berita' ?></title>
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
        }

        .header {
            background: #f4f4f4;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .header h1 {
            color: #333;
            font-size: 2em;
            margin-bottom: 10px;
        }

        nav {
            background: #0066cc;
            overflow: hidden;
        }

        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
        }

        nav a:hover,
        nav a.active {
            background-color: #004ba3;
        }

        .container {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            gap: 20px;
            padding: 20px;
        }

        .main-content {
            flex: 1;
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .sidebar {
            width: 250px;
        }

        .widget {
            background: white;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .widget-header {
            background: #0066cc;
            color: white;
            padding: 10px 15px;
            font-weight: bold;
        }

        .widget-body {
            padding: 15px;
        }

        .widget-link a {
            display: block;
            color: #0066cc;
            text-decoration: none;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .widget-link a:last-child {
            border-bottom: none;
        }

        .widget-link a:hover {
            text-decoration: underline;
        }

        .widget-text {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .article-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            background: #fafafa;
        }

        .article-item:last-child {
            border-bottom: none;
        }

        .article-item h3 {
            color: #0066cc;
            margin-bottom: 8px;
        }

        .article-item p {
            font-size: 14px;
            color: #666;
        }

        .article-meta {
            font-size: 12px;
            color: #999;
            margin-top: 8px;
        }

        .no-data {
            padding: 20px;
            text-align: center;
            color: #999;
            font-style: italic;
        }

        footer {
            background: #f4f4f4;
            text-align: center;
            padding: 20px;
            margin-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Portal Berita</h1>
    </div>

    <nav>
        <a href="<?= base_url('/') ?>" class="<?= uri_string() === '' ? 'active' : '' ?>">Home</a>
        <a href="<?= base_url('/artikel') ?>" class="<?= uri_string() === 'artikel' ? 'active' : '' ?>">Artikel</a>
        <a href="<?= base_url('/about') ?>" class="<?= uri_string() === 'about' ? 'active' : '' ?>">About</a>
        <a href="<?= base_url('/contact') ?>" class="<?= uri_string() === 'contact' ? 'active' : '' ?>">Kontak</a>
    </nav>

    <div class="container">
        <div class="main-content">
            <?= $this->renderSection('content') ?>
        </div>

        <div class="sidebar">
            <div class="widget">
                <div class="widget-header">Widget Header</div>
                <div class="widget-body widget-link">
                    <a href="<?= base_url('/') ?>">Widget Link</a>
                    <a href="<?= base_url('/artikel') ?>">Widget Link</a>
                </div>
            </div>

            <div class="widget">
                <div class="widget-header">Widget Text</div>
                <div class="widget-body widget-text">
                    Vestibulum lorem elit, acaulis in nisl voluptat, malesuada tincidunt arcu. Proin in leo fringilla, vestibulum mi porta, faucibus felis. Integer pharetra est nunc, nec pretium nunc pretium ac.
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 Portal Berita. All rights reserved.</p>
    </footer>
</body>

</html>