<?php include 'views/layouts/main_layout.php'; ?>

<?php $this->start('content'); ?>
    <h2>Detail Pesanan #<?= $order['id'] ?></h2>

    <p><strong>Tanggal Pemesanan:</strong> <?= date('d-m-Y H:i:s', strtotime($order['created_at'])) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>

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

    <form action="/orders/status/<?= $order['id'] ?>" method="post">
        <div class="form-group">            <label for="status">Update Status Pesanan:</label>
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

    <a href="/seller/orders" class="btn btn-secondary mt-3">Kembali ke Daftar Pesanan</a>

<?php $this->end(); ?>

                      
