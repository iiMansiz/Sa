<?php include 'views/layouts/main_layout.php'; ?>

<?php $this->start('content'); ?>
    <h2>Keranjang Belanja Anda</h2>

    <?php if (empty($cartItems)): ?>
        <p>Keranjang belanja Anda kosong.</p>
        <a href="/products" class="btn btn-primary">Lanjutkan Belanja</a>
    <?php else: ?>
        <form method="post" action="/cart/update">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Kuantitas</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama']) ?></td>
                            <td>Rp <?= number_format($item['harga']) ?></td>
                            <td>
                                <input type="number" name="quantity[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control form-control-sm" style="width: 80px;">
                            </td>
                            <td>Rp <?= number_format($item['harga'] * $item['quantity']) ?></td>
                            <td>
                                <a href="/cart/remove/<?= $item['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total Harga:</strong></td>
                        <td><strong>Rp <?= number_format($totalPrice) ?></strong></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">
                            <button type="submit" class="btn btn-info">Update Keranjang</button>
                            <a href="/checkout" class="btn btn-success">Checkout</a>
                            <a href="/cart/clear" class="btn btn-warning">Kosongkan Keranjang</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    <?php endif; ?>

<?php $this->end(); ?>
