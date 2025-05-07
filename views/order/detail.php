<?php $data['title'] = 'Detail Pesanan'; ?>
<?php require '../views/layouts/main_layout.php'; ?>

<?php function content() { ?>
    <h2><?= $data['title'] ?></h2>

    <?php if (isset($data['order'])): ?>
        <p><strong>ID Pesanan:</strong> <?= $data['order']['id'] ?></p>
        <p><strong>Tanggal Pemesanan:</strong> <?= $data['order']['order_date'] ?></p>
        <p><strong>Alamat Pengiriman:</strong> <?= htmlspecialchars($data['order']['shipping_address']) ?></p>
        <p><strong>Status Pembayaran:</strong> <?= htmlspecialchars($data['order']['payment_status']) ?></p>
        <p><strong>Status Pesanan:</strong> <?= htmlspecialchars($data['order']['status']) ?></p>

        <h3>Rincian Pesanan</h3>
        <?php if (!empty($data['order_items'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $totalAmount = 0; ?>
                    <?php foreach ($data['order_items'] as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama_produk']) ?></td>
                            <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></td>
                        </tr>
                        <?php $totalAmount += $item['price'] * $item['quantity']; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="right"><strong>Total Harga Produk:</strong></td>
                        <td>Rp <?= number_format($totalAmount, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><strong>Biaya Pengiriman:</strong></td>
                        <td>Rp <?= number_format($data['order']['total_amount'] - $totalAmount, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right"><strong>Total Pembayaran:</strong></td>
                        <td><strong>Rp <?= number_format($data['order']['total_amount'], 0, ',', '.') ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        <?php else: ?>
            <p>Tidak ada item dalam pesanan ini.</p>
        <?php endif; ?>

        <?php if ($data['order']['payment_status'] === 'cod_pending' && Session::get('user_role') === 'seller'): ?>
            <form action="<?= BASE_URL ?>/orders/status/<?= $data['order']['id'] ?>" method="post">
                <input type="hidden" name="status" value="processing">
                <button type="submit" class="btn btn-success">Konfirmasi COD</button>
            </form>
        <?php endif; ?>

    <?php else: ?>
        <p>Pesanan tidak ditemukan.</p>
    <?php endif; ?>
<?php } ?>
