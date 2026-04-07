<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Daftar User') ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
</head>

<body>
    <div style="max-width: 920px; margin: 30px auto; background: #fff; padding: 24px;">
        <h1><?= esc($title ?? 'Daftar User') ?></h1>
        <table style="width:100%; border-collapse: collapse; margin-top:16px;">
            <thead>
                <tr>
                    <th style="border:1px solid #ddd; padding:8px;">ID</th>
                    <th style="border:1px solid #ddd; padding:8px;">Username</th>
                    <th style="border:1px solid #ddd; padding:8px;">Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td style="border:1px solid #ddd; padding:8px;"><?= esc($user['id']) ?></td>
                        <td style="border:1px solid #ddd; padding:8px;"><?= esc($user['username']) ?></td>
                        <td style="border:1px solid #ddd; padding:8px;"><?= esc($user['useremail']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
