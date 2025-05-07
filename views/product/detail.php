<?php $data['title'] = 'Detail Produk'; ?>
<?php require '../views/layouts/main_layout.php'; ?>

<?php function content() { ?>
    <?php if (isset($data['product'])): ?>
        <div class="row">
            <div class="col-md-6">
                <img src="<?= BASE_URL ?>/assets/images/<?= htmlspecialchars($data['product']['gambar'] ?: 'default.jpg') ?>" class="img-fluid" alt="<?= htmlspecialchars($data['product']['nama']) ?>">
            </div>
            <div class="col-md-6">
                <h2><?= htmlspecialchars($data['product']['nama']) ?></h2>
                <p><strong>Harga:</strong> Rp <?= number_format($data['product']['harga'], 0, ',', '.') ?></p>
                <p><strong>Stok:</strong> <?= $data['product']['stok'] > 0 ? htmlspecialchars($data['product']['stok']) . ' tersedia' : '<span class="text-danger">Stok habis</span>' ?></p>
                <p><strong>Deskripsi:</strong> <?= htmlspecialchars($data['product']['deskripsi']) ?></p>
                <?php if ($data['product']['stok'] > 0): ?>
                    <form action="<?= BASE_URL ?>/cart/add/<?= $data['product']['id'] ?>" method="get">
                        <div class="form-group">
                            <label for="quantity">Jumlah:</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="<?= htmlspecialchars($data['product']['stok']) ?>">
                        </div>
                        <button type="submit" class="btn btn-success">Tambah ke Keranjang</button>
                    </form>
                <?php else: ?>
                    <button class="btn btn-secondary" disabled>Stok Habis</button>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <p>Produk tidak ditemukan.</p>
    <?php endif; ?>
<?php } ?>
