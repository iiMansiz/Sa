<?php $data['title'] = 'Beranda'; ?>
<?php require 'layouts/main_layout.php'; ?>

<?php function content() { ?>
    <h2>Produk Terbaru</h2>
    <div class="row">
        <?php if (!empty($data['products'])): ?>
            <?php foreach ($data['products'] as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= BASE_URL ?>/assets/images/<?= htmlspecialchars($product['gambar'] ?: 'default.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($product['nama']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['nama']) ?></h5>
                            <p class="card-text">Rp <?= number_format($product['harga'], 0, ',', '.') ?></p>
                            <a href="<?= BASE_URL ?>/product/<?= $product['id'] ?>" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12">
                <p>Tidak ada produk yang tersedia saat ini.</p>
            </div>
        <?php endif; ?>
    </div>
<?php } ?>
