<?php include 'views/layouts/main_layout.php'; ?>

<?php $this->start('content'); ?>
    <h2>Daftar Produk</h2>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['nama']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars(substr($product['deskripsi'], 0, 100)) ?>...</p>
                        <p class="card-text">Harga: Rp <?= number_format($product['harga']) ?></p>
                        <a href="/product/<?= $product['id'] ?>" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php $this->end(); ?>
