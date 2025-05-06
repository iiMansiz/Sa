<?php include 'views/layouts/main_layout.php'; ?>

<?php $this->start('content'); ?>
    <h2>Detail Pesanan #<?= $order['id'] ?></h2>

    <p><strong>Tanggal Pemesanan:</strong> <?= date('d-m-Y H:i:s', strtotime($order['created_at'])) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    <p><strong>Total Harga:</strong> Rp <?= number_format($order['total_amount']) ?></p>

    <h3>Item Pesanan:</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga Satuan</th>
                <th>Kuantitas</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderItems as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td>Rp <?= number_format($item['product_price']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>Rp <?= number_format($item['price_per_item'] * $item['quantity']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="/orders" class="btn btn-secondary">Kembali ke Riwayat Pesanan</a>

<?php $this->end(); ?>
