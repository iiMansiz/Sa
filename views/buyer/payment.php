<?php include 'views/layouts/main_layout.php'; ?>

<?php $this->start('content'); ?>
    <h2>Pembayaran Pesanan #<?= $order['id'] ?></h2>
    <p>Total yang harus dibayar: <strong>Rp <?= number_format($order['total_amount']) ?></strong></p>

    <form action="/payment/process/<?= $order['id'] ?>" method="post">
        <div class="form-group">
            <label for="payment_method">Pilih Metode Pembayaran:</label>
            <select class="form-control" id="payment_method" name="payment_method" required>
                <option value="transfer_bank">Transfer Bank</option>
                <option value="credit_card">Kartu Kredit</option>
                <option value="e_wallet">E-Wallet</option>
                </select>
        </div>
        <button type="submit" class="btn btn-success">Bayar Sekarang</button>
        <a href="/orders/<?= $order['id'] ?>" class="btn btn-secondary">Batal</a>
    </form>

<?php $this->end(); ?>
