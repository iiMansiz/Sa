<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['title'] ?? 'Toko Online Sederhana') ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/script.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="<?= BASE_URL ?>/">TokoKita</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= BASE_URL ?>/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/products">Produk</a>
                    </li>
                    <?php if (Session::get('user_role') === 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Admin
                            </a>
                            <div class="dropdown-menu" aria-labelledby="adminDropdown">
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/users">Manajemen Pengguna</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/sellers">Persetujuan Penjual</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/payment">Metode Pembayaran</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/shipping">Metode Pengiriman</a>
                            </div>
                        </li>
                    <?php elseif (Session::get('user_role') === 'seller'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="sellerDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Penjual
                            </a>
                            <div class="dropdown-menu" aria-labelledby="sellerDropdown">
                                <a class="dropdown-item" href="<?= BASE_URL ?>/seller/dashboard">Dasbor</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/seller/products">Produk Saya</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/seller/orders">Pesanan</a>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if (Session::get('user_id')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/orders">Pesanan Saya</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/auth/logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/auth/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/auth/register/buyer">Daftar</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/cart">Keranjang</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container mt-4">
        <?php include '../views/partials/flash_messages.php'; ?>
        <?php if (function_exists('content')) content(); ?>
    </div>

    <footer>
        <div class="container text-center py-3">
            <p>&copy; <?= date('Y') ?> TokoKita. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
