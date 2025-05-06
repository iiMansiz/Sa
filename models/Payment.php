<?php
require_once 'core/Model.php';

class Payment extends Model {
    protected $table = 'payments';

    // Metode untuk mencatat transaksi pembayaran
    public function recordPayment($orderId, $paymentMethod, $amount, $status = 'pending', $transactionId = null) {
        $data = [
            'order_id' => $orderId,
            'payment_method' => $paymentMethod,
            'amount' => $amount,
            'status' => $status,
            'transaction_id' => $transactionId,
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->insert($data);
    }

    // Metode untuk memperbarui status pembayaran
    public function updatePaymentStatus($paymentId, $status, $transactionId = null) {
        $data = ['status' => $status];
        if ($transactionId) {
            $data['transaction_id'] = $transactionId;
        }
        return $this->update($paymentId, $data);
    }

    // Metode untuk mendapatkan informasi pembayaran berdasarkan order ID
    public function getPaymentByOrder($orderId) {
        return $this->where('order_id', $orderId);
    }
}
?>
