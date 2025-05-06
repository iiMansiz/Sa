<?php include 'views/layouts/main_layout.php'; ?>

<?php $this->start('content'); ?>
    <h2>Detail Pesanan #<?= $order['id'] ?></h2>

    <?php
    $userModel = $this->model('User');
    $buyer = $userModel->find($order['buyer_id']);
    ?>
    <p><strong>Pembeli:</strong> <?= $buyer ? htmlspecialchars($buyer['nama']) : 'Pengguna Tidak Ditemukan' ?></p>
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
                <th>Penjual</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderItems as $item): ?>
                <?php
                $productModel = $this->model('Product');
                $product = $productModel->find($item['product_id']);
                $seller = $userModel->find($product['seller_id']);
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td>Rp <?= number_format($item['product_price']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>Rp <?= number_format($item['price_per_item'] * $item['quantity']) ?></td>
                    <td><?= $seller ? htmlspecialchars($seller['nama']) : 'Penjual Tidak Ditemukan' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form action="/orders/status/<?= $order['id'] ?>" method="post">
        <div class="form-group">
            <label for="status">Update Status Pesanan:</label>
            <select class="form-control" id="status" name="status">
                <option value="pending" <?= ($order['status'] == 'pending' ? 'selected' : '') ?>>Pending</option>
                <option value="processing" <?= ($order['status'] == 'processing' ? 'selected' : '') ?>>Processing</option>
                <option value="shipped" <?= ($order['status'] == 'shipped' ? 'selected' : '') ?>>Shipped</option>
                <option value="completed" <?= ($order['status'] == 'completed' ? 'selected' : '') ?>>Completed</option>
                <option value="cancelled" <?= ($order['status'] == 'cancelled' ? 'selected' : '') ?>>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>

    <a href="/admin/orders" class="btn btn-secondary mt-3">Kembali ke Daftar Pesanan</a>

<?php $this->end(); ?>
