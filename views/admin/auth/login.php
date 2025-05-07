<?php $data['title'] = 'Login'; ?>
<?php require '../views/layouts/main_layout.php'; ?>

<?php function content() { ?>
    <h2><?= $data['title'] ?></h2>
    <?php if (Session::get('success_message')): ?>
        <div class="alert alert-success"><?= Session::get('success_message') ?></div>
        <?php Session::delete('success_message'); ?>
    <?php endif; ?>
    <?php if (Session::get('error_message')): ?>
        <div class="alert alert-danger"><?= Session::get('error_message') ?></div>
        <?php Session::delete('error_message'); ?>
    <?php endif; ?>
    <?php if (Session::get('info_message')): ?>
        <div class="alert alert-info"><?= Session::get('info_message') ?></div>
        <?php Session::delete('info_message'); ?>
    <?php endif; ?>
    <form action="<?= BASE_URL ?>/auth/login" method="post">
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
        <p>Belum punya akun? <a href="<?= BASE_URL ?>/auth/register/buyer">Daftar sebagai Pembeli</a> | <a href="<?= BASE_URL ?>/auth/register/seller">Daftar sebagai Penjual</a></p>
    </form>
<?php } ?>
