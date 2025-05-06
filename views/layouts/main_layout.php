<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <?php include 'views/components/navbar.php'; ?>

    <div class="container mt-4">
        <?php if (Session::get('success_message')): ?>
            <div class="alert alert-success"><?= Session::get('success_message'); Session::delete('success_message'); ?></div>
        <?php endif; ?>
        <?php if (Session::get('error_message')): ?>
            <div class="alert alert-danger"><?= Session::get('error_message'); Session::delete('error_message'); ?></div>
        <?php endif; ?>

        <?= $this->render('content') ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/assets/js/script.js"></script>
</body>
</html>
