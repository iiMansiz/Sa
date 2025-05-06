<?php
require_once 'core/Controller.php';
require_once 'core/Session.php';
require_once 'models/Ticket.php';
require_once 'models/User.php';

class AdminTicketController extends Controller {
    private $ticketModel;
    private $userModel;

    public function __construct() {
        Session::start();
        if (Session::get('user_role') !== 'admin') {
            $this->redirect('/admin/dashboard');
        }
        $this->ticketModel = $this->model('Ticket');
        $this->userModel = $this->model('User');
    }

    public function index() {
        $openTickets = $this->ticketModel->getOpenTickets();
        $this->view('admin/ticket/list', ['openTickets' => $openTickets]);
    }

    public function view($ticketId) {
        $ticketData = $this->ticketModel->getTicketWithMessages($ticketId);
        if ($ticketData) {
            $this->view('admin/ticket/view', ['ticketData' => $ticketData, 'ticketId' => $ticketId]);
        } else {
            $this->redirect('/admin/tickets');
        }
    }

    public function reply($ticketId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = $_POST['message'];
            if ($this->ticketModel->addMessage($ticketId, Session::get('user_id'), $message, true)) {
                $this->redirect('/admin/tickets/view/' . $ticketId);
            } else {
                $error = 'Gagal mengirim balasan.';
                $ticketData = $this->ticketModel->getTicketWithMessages($ticketId);
                $this->view('admin/ticket/view', ['ticketData' => $ticketData, 'ticketId' => $ticketId, 'error' => $error]);
            }
        } else {
            $this->redirect('/admin/tickets/view/' . $ticketId);
        }
    }

    public function close($ticketId) {
        if ($this->ticketModel->update($ticketId, ['status' => 'closed'])) {
            $this->redirect('/admin/tickets/view/' . $ticketId);
        } else {
            // Handle error
        }
    }
}
?>
