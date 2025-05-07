<?php $data['title'] = 'Keranjang Belanja'; ?>
<?php require '../views/layouts/main_layout.php'; ?>

<?php function content() { ?>
    <h2><?= $data['title'] ?></h2>

    <?php if (Session::has('cart') && !empty(Session::get('cart'))): ?>
        <form action="<?= BASE_URL ?>/cart/update" method="post">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $totalPrice = 0; ?>
                    <?php foreach (Session::get('cart') as $productId => $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td>
                                <input type="number" name="quantity[<?= $productId ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control form-control-sm" style="width: 60px;">
                            </td>
                            <td>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>/cart/remove/<?= $productId ?>" class="btn btn-sm btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <?php $totalPrice += $item['price'] * $item['quantity']; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="right"><strong>Total:</strong></td>
                        <td><strong>Rp <?= number_format($totalPrice, 0, ',', '.') ?></strong></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right">
                            <button type="submit" class="btn btn-primary">Update Keranjang</button>
                            <a href="<?= BASE_URL ?>/checkout" class="btn btn-success">Checkout</a>
                            <a href="<?= BASE_URL ?>/cart/clear" class="btn btn-warning" onclick="return confirm('Yakin ingin mengosongkan keranjang?')">Kosongkan Keranjang</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    <?php else: ?>
        <p>Keranjang belanja Anda kosong. Silakan tambahkan produk dari <a href="<?= BASE_URL ?>/products">daftar produk</a>.</p>
    <?php endif; ?>
<?php } ?>
