<?php $data['title'] = 'Produk Saya'; ?>
<?php require '../../views/layouts/seller_layout.php'; ?>

<?php function content() { ?>
    <h2><?= $data['title'] ?></h2>
    <a href="<?= BASE_URL ?>/seller/products/add" class="btn btn-primary mb-3">Tambah Produk Baru</a>
    <?php if (!empty($data['products'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['products'] as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['nama']) ?></td>
                        <td>Rp <?= number_format($product['harga'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($product['stok']) ?></td>
                        <td><img src="<?= BASE_URL ?>/assets/images/<?= htmlspecialchars($product['gambar'] ?: 'default.jpg') ?>" alt="<?= htmlspecialchars($product['nama']) ?>" width="50"></td>
                        <td>
                            <a href="<?= BASE_URL ?>/seller/products/edit/<?= $product['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="<?= BASE_URL ?>/seller/products/delete/<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Anda belum menambahkan produk.</p>
    <?php endif; ?>
<?php } ?>
