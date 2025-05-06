<?php include 'views/layouts/main_layout.php'; ?>

<?php $this->start('content'); ?>
    <h2>Riwayat Pesanan Anda</h2>

    <?php if (empty($orders)): ?>
        <p>Anda belum memiliki riwayat pesanan.</p>
        <a href="/products" class="btn btn-primary">Lanjutkan Belanja</a>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= date('d-m-Y H:i:s', strtotime($order['created_at'])) ?></td>
                        <td>Rp <?= number_format($order['total_amount']) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td>
                            <a href="/orders/<?= $order['id'] ?>" class="btn btn-info btn-sm">Lihat Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

<?php $this->end(); ?>
