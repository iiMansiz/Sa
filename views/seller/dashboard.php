<?php $data['title'] = 'Dasbor Penjual'; ?>
<?php require '../views/layouts/seller_layout.php'; ?>

<?php function content() { ?>
    <h2><?= $data['title'] ?></h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Penjualan</h5>
                    <p class="card-text">Rp <?= number_format($data['total_sales'] ?? 0, 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pesanan Selesai</h5>
                    <p class="card-text"><?= $data['completed_orders'] ?? 0 ?> Pesanan</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white mb-3">
                <div class="card-body">
                    <h5 class="card-title">Pesanan Tertunda</h5>
                    <p class="card-text"><?= $data['pending_orders'] ?? 0 ?> Pesanan</p>
                </div>
            </div>
        </div>
    </div>

    <h3>Pesanan Terbaru</h3>
    <?php if (!empty($data['latest_orders'])): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['latest_orders'] as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= $order['order_date'] ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                        <td><a href="<?= BASE_URL ?>/seller/orders/<?= $order['id'] ?>" class="btn btn-sm btn-info">Detail</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada pesanan terbaru.</p>
    <?php endif; ?>
<?php } ?>
