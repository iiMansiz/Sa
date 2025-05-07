<?php $data['title'] = 'Tambah Penjual Baru'; ?>
<?php require '../views/layouts/main_layout.php'; ?>

<?php function content() { ?>
    <h2><?= $data['title'] ?></h2>
    <?php if (isset($data['errors'])): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($data['errors'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if (isset($data['error_message'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($data['error_message']) ?></div>
    <?php endif; ?>
    <form action="<?= BASE_URL ?>/admin/users/create/seller" method="post">
        <div>
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="nama_toko">Nama Toko:</label>
            <input type="text" id="nama_toko" name="nama_toko" required>
        </div>
        <button type="submit">Simpan</button>
    </form>
<?php } ?>
