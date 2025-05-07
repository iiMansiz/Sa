<?php $data['title'] = 'Checkout'; ?>
<?php require '../views/layouts/main_layout.php'; ?>

<?php function content() { ?>
    <h2><?= $data['title'] ?></h2>
    <?php if (Session::get('error_message')): ?>
        <div class="alert alert-danger"><?= Session::get('error_message') ?></div>
        <?php Session::delete('error_message'); ?>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/checkout/processOrder" method="post">
        <div>
            <h3>Alamat Pengiriman</h3>
            <textarea name="shipping_address" rows="4" placeholder="Alamat lengkap pengiriman" required></textarea>
        </div>

        <div>
            <h3>Metode Pengiriman</h3>
            <?php if (!empty($data['shipping_methods'])): ?>
                <select name="shipping_method_id" required>
                    <option value="">Pilih Metode Pengiriman</option>
                    <?php foreach ($data['shipping_methods'] as $sm): ?>
                        <option value="<?= $sm['id'] ?>">
                            <?= htmlspecialchars($sm['nama']) ?> - Rp <?= number_format($sm['biaya'], 0, ',', '.') ?>
                            <?= $sm['is_cod_available'] ? '(COD Tersedia)' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <p>Tidak ada metode pengiriman yang tersedia.</p>
            <?php endif; ?>
        </div>

        <div>
            <h3>Metode Pembayaran</h3>
            <?php if (!empty($data['payment_methods'])): ?>
                <select name="payment_method_id" required>
                    <option value="">Pilih Metode Pembayaran</option>
                    <?php foreach ($data['payment_methods'] as $pm): ?>
                        <option value="<?= $pm['id'] ?>">
                            <?= htmlspecialchars($pm['nama']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <p>Tidak ada metode pembayaran yang tersedia.</p>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Proses Pesanan</button>
    </form>

    <h3>Ringkasan Belanja</h3>
    <?php if (Session::has('cart') && !empty(Session::get('cart'))): ?>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach (Session::get('cart') as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
                    </tr>
                    <?php $total += $item['price'] * $item['quantity']; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" align="right"><strong>Subtotal:</strong></td>
                    <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td colspan="3" align="right"><strong>Biaya Pengiriman:</strong></td>
                    <td><span id="shipping_cost"></span></td>
                </tr>
                <tr>
                    <td colspan="3" align="right"><strong>Total:</strong></td>
                    <td><span id="grand_total"></span></td>
                </tr>
            </tfoot>
        </table>
        <script>
            document.querySelector('select[name="shipping_method_id"]').addEventListener('change', function() {
                const shippingMethodId = this.value;
                const shippingMethods = <?= json_encode($data['shipping_methods']) ?>;
                const subtotal = <?= $total ?>;
                let shippingCost = 0;

                const selectedMethod = shippingMethods.find(sm => sm.id == shippingMethodId);
                if (selectedMethod) {
                    shippingCost = selectedMethod.biaya;
                }

                document.getElementById('shipping_cost').textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
                document.getElementById('grand_total').textContent = 'Rp ' + (subtotal + shippingCost).toLocaleString('id-ID');
            });
        </script>
    <?php else: ?>
        <p>Keranjang belanja Anda kosong.</p>
    <?php endif; ?>
<?php } ?>
