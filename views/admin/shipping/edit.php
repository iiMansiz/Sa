<?php $data['title'] = 'Edit Metode Pengiriman'; ?>
<?php require '../views/layouts/main_layout.php'; ?>

<?php function content() { ?>
    <h2><?= $data['title'] ?></h2>
    <form action="<?= BASE_URL ?>/admin/shipping/update/<?= $data['shipping_method']['id'] ?>" method="post">
        <div>
            <label for="nama">Nama Metode Pengiriman:</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['shipping_method']['nama']) ?>" required>
        </div>
        <div>
            <label for="biaya">Biaya Pengiriman:</label>
            <input type="number" id="biaya" name="biaya" min="0" value="<?= $data['shipping_method']['biaya'] ?>" required>
        </div>
        <div>
            <label for="is_cod_available">COD Tersedia:</label>
            <select id="is_cod_available" name="is_cod_available">
                <option value="0" <?= !$data['shipping_method']['is_cod_available'] ? 'selected' : '' ?>>Tidak</option>
                <option value="1" <?= $data['shipping_method']['is_cod_available'] ? 'selected' : '' ?>>Ya</option>
            </select>
        </div>
        <div>
            <label for="is_active">Status:</label>
            <select id="is_active" name="is_active">
                <option value="1" <?= $data['shipping_method']['is_active'] ? 'selected' : '' ?>>Aktif</option>
                <option value="0" <?= !$data['shipping_method']['is_active'] ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
        </div>
        <button type="submit">Simpan</button>
    </form>
<?php } ?>
