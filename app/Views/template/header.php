<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?? 'CI4 App'; ?>
    </title>
    <link rel="stylesheet" href="<?= base_url('style.css'); ?>">
</head>

<body>
    <header>
        <div class="container">
            <nav>
                <a href="<?= base_url('/'); ?>" class="brand">My App</a>
                <ul>
                    <li><a href="<?= base_url('/'); ?>">Home</a></li>
                    <li><a href="<?= base_url('/artikel'); ?>">Artikel</a></li>
                    <li><a href="<?= base_url('/about'); ?>">About</a></li>
                    <li><a href="<?= base_url('/contact'); ?>">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <main>