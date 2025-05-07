<?php $data['title'] = 'Riwayat Pesanan'; ?>
<?php require '../views/layouts/main_layout.php'; ?>

<?php function content() { ?>
    <h2><?= $data['title'] ?></h2>

    <?php if (!empty($data['orders'])): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Total Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Status Pesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['orders'] as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= $order['order_date'] ?></td>
                        <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($order['payment_status']) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/orders/<?= $order['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Belum ada riwayat pesanan.</p>
    <?php endif; ?>
<?php } ?>
