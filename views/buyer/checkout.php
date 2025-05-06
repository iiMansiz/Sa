<?php include 'views/layouts/main_layout.php'; ?>

<?php $this->start('content'); ?>
    <h2>Checkout</h2>

    <?php if (empty($cartItems)): ?>
        <p>Keranjang belanja Anda kosong. Tidak ada yang bisa di-checkout.</p>
        <a href="/products" class="btn btn-primary">Lanjutkan Belanja</a>
    <?php else: ?>
        <p>Mohon periksa kembali pesanan Anda sebelum melanjutkan:</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Kuantitas</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nama']) ?></td>
                        <td>Rp <?= number_format($item['harga']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>Rp <?= number_format($item['harga'] * $item['quantity']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total Harga:</strong></td>
                    <td><strong>Rp <?= number_format($totalPrice) ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <form action="/checkout/process" method="post">
            <button type="submit" class="btn btn-success btn-lg">Buat Pesanan</button>
        </form>
    <?php endif; ?>

<?php $this->end(); ?>
