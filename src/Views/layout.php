<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (isset($data['meta']['title'])) ? $data['meta']['title'] . ' | Książką adresowa' : 'Książką adresowa'; ?></title>
</head>

<body>
    <?php require_once __DIR__ . '/' . $viewPath . '.php'; ?>
</body>

</html>