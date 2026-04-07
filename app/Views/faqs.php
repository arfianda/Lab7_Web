<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Frequently Asked Questions</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        nav {
            margin-bottom: 20px;
        }

        nav a {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <nav>
        <a href="<?= base_url('/') ?>">Home</a>
        <a href="<?= base_url('/about') ?>">About</a>
        <a href="<?= base_url('/contact') ?>">Contact</a>
        <a href="<?= base_url('/faqs') ?>">FAQs</a>
    </nav>
    <h1>FAQs</h1>
    <ul>
        <li><strong>Question 1?</strong> Answer 1.</li>
        <li><strong>Question 2?</strong> Answer 2.</li>
    </ul>
</body>

</html>