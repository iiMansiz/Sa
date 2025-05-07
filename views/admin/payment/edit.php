<?php $data['title'] = 'Edit Metode Pembayaran'; ?>
<?php require '../views/layouts/main_layout.php'; ?>

<?php function content() { ?>
    <h2><?= $data['title'] ?></h2>
    <form action="<?= BASE_URL ?>/admin/payment/update/<?= $data['payment_method']['id'] ?>" method="post">
        <div>
            <label for="nama">Nama Metode Pembayaran:</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($data['payment_method']['nama']) ?>" required>
        </div>
        <div>
            <label for="code">Kode Metode Pembayaran (untuk integrasi):</label>
            <input type="text" id="code" name="code" value="<?= htmlspecialchars($data['payment_method']['code']) ?>">
            <small>Digunakan untuk identifikasi sistem pembayaran otomatis.</small>
        </div>
        <div>
            <label for="is_automatic">Pembayaran Otomatis:</label>
            <select id="is_automatic" name="is_automatic">
                <option value="0" <?= !$data['payment_method']['is_automatic'] ? 'selected' : '' ?>>Tidak</option>
                <option value="1" <?= $data['payment_method']['is_automatic'] ? 'selected' : '' ?>>Ya</option>
            </select>
        </div>
        <div>
            <label for="config">Konfigurasi (JSON):</label>
            <textarea id="config" name="config" rows="3"><?= htmlspecialchars($data['payment_method']['config']) ?></textarea>
            <small>Konfigurasi tambahan untuk pembayaran otomatis (opsional).</small>
        </div>
        <div>
            <label for="is_active">Status:</label>
            <select id="is_active" name="is_active">
                <option value="1" <?= $data['payment_method']['is_active'] ? 'selected' : '' ?>>Aktif</option>
                <option value="0" <?= !$data['payment_method']['is_active'] ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
        </div>
        <button type="submit">Simpan</button>
    </form>
<?php } ?>
