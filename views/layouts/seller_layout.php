<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['title'] ?? 'Dasbor Penjual') ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/seller_style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/script.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/seller_script.js"></script>
</head>
<body>
    <div class="seller-dashboard">
        <header class="seller-header">
            <h1>Dasbor Penjual</h1>
            <nav>
                <ul>
                    <li><a href="<?= BASE_URL ?>/seller/dashboard">Dasbor</a></li>
                    <li><a href="<?= BASE_URL ?>/seller/products">Produk Saya</a></li>
                    <li><a href="<?= BASE_URL ?>/seller/orders">Pesanan</a></li>
                    <li><a href="<?= BASE_URL ?>/auth/logout">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main class="seller-content">
            <div class="container mt-4">
                <?php include '../views/partials/flash_messages.php'; ?>
                <?php if (function_exists('content')) content(); ?>
            </div>
        </main>

        <footer class="seller-footer">
            <div class="container text-center py-3">
                <p>&copy; <?= date('Y') ?> TokoKita. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>
</html>
