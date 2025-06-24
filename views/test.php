<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body> 
    <?php foreach($session->getAllFlash() as $type => $message): ?>
        <li><?= $type ?>: <?= $message[0] ?></li>
    <?php endforeach; ?>
    <ul>
        <?php foreach($users as $user): ?>
            <li><?= $user->username ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>