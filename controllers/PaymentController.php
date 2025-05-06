<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Order.php';
require_once 'models/Payment.php';
require_once 'models/Cart.php';

class PaymentController extends Controller {
    private $orderModel;
    private $paymentModel;

    public function __construct() {
        Session::start();
        if (!Session::get('user_id')) {
            $this->redirect('/auth/login');
        }
        $this->orderModel = $this->model('Order');
        $this->paymentModel = $this->model('Payment');
    }

    public function index($orderId) {
        $order = $this->orderModel->find($orderId);
        if (!$order || $order['buyer_id'] !== Session::get('user_id') || $order['status'] !== 'pending') {
            $this->redirect('/orders');
            return;
        }
        $this->view('buyer/payment', ['order' => $order]);
    }

    public function processPayment($orderId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order = $this->orderModel->find($orderId);
            if (!$order || $order['buyer_id'] !== Session::get('user_id') || $order['status'] !== 'pending') {
                $this->redirect('/orders');
                return;
            }

            $paymentMethod = $_POST['payment_method'];
            $amount = $order['total_amount'];

            // Simulasikan proses pembayaran berhasil
            // Dalam implementasi nyata, Anda akan berintegrasi dengan payment gateway

            $paymentId = $this->paymentModel->recordPayment($orderId, $paymentMethod, $amount, 'processing');

            // Setelah simulasi pembayaran berhasil
            $this->paymentModel->updatePaymentStatus($paymentId, 'completed', 'SIMULATED_TRANSACTION_' . time());
            $this->orderModel->update($orderId, ['status' => 'processing']); // Atau 'paid', tergantung alur

            Session::set('success_message', 'Pembayaran Anda berhasil diproses. Pesanan Anda sedang dipersiapkan.');
            $this->redirect('/orders/' . $orderId);

        } else {
            $this->redirect('/payment/' . $orderId);
        }
    }
}
?>
