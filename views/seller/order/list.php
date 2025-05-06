<?php include 'views/layouts/main_layout.php'; ?>

<?php $this->start('content'); ?>
    <h2>Daftar Pesanan Anda</h2>

    <?php if (empty($orders)): ?>
        <p>Belum ada pesanan untuk produk Anda.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Total Produk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <?php
                    $sql = "SELECT COUNT(oi.id) AS total_items FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = " . $order['id'] . " AND p.seller_id = " . Session::get('user_id');
                    $result = $this->orderModel->query($sql);
                    $itemCount = $this->orderModel->fetch($result)['total_items'];
                    if ($itemCount > 0):
                    ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($order['created_at'])) ?></td>
                            <td><?= $itemCount ?></td>
                            <td><?= htmlspecialchars($order['status']) ?></td>
                            <td>
                                <a href="/seller/orders/<?= $order['id'] ?>" class="btn btn-info btn-sm">Lihat Detail</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

<?php $this->end(); ?>
