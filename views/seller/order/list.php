<?php include 'views/layouts/main_layout.php'; ?>

<?php $this->start('content'); ?>
    <h2>Daftar Semua Pesanan</h2>

    <?php if (empty($orders)): ?>
        <p>Belum ada pesanan.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Pembeli</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <?php
                    $userModel = $this->model('User');
                    $buyer = $userModel->find($order['buyer_id']);
                    ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= $buyer ? htmlspecialchars($buyer['nama']) : 'Pengguna Tidak Ditemukan' ?></td>
                        <td><?= date('d-m-Y H:i:s', strtotime($order['created_at'])) ?></td>
                        <td>Rp <?= number_format($order['total_amount']) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td>
                            <a href="/admin/orders/<?= $order['id'] ?>" class="btn btn-info btn-sm">Lihat Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

<?php $this->end(); ?>
